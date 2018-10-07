<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/20
 * Time: 2:51
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct as OrderProductModel;
use app\api\model\OrderProduct;
use app\api\model\Product as ProductModel;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Exception;
use think\Db;


class Order
{
    //客户端出传递过来的的订单商品信息参数
    protected $orderProducts;
    //数据库真实商品信息(包括库存量)
    protected $products;

    protected $uid;

    //检测订单库存和创建订单
    public function orderCheck($uid,$orderProducts){
        $this->orderProducts = $orderProducts;
        //根据订单的商品信息orderProducts去确定products数据库商品信息
        $this->products = $this->getProductsByOrder($orderProducts);
        $this->uid = $uid;
        $status = $this->getOrderProductsStatus();

        if(!$status['pass']){
            $status['order_id'] = -1;
            //创建订单失败也是要返回失败的信息
            return $status;
        }
        //开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }


    /**
     * @return $status
     * $status = [
     * 'pass' => true,
     * 'orderPrice' => 0,
     * 'totalCount'=> 0,
     *  (productStatusArray为订单各类商品详细信息)
     * 'productStatusArray' => [多个productStatus信息];
     * checkOrderStock用于外部调用检验订单商品库存量
     */
    public function checkOrderStock($orderID){
        $this->orderProducts = OrderProduct::where('order_id','=',$orderID)->select();
        $this->products = $this->getProductsByOrder($this->orderProducts);
        $status = $this->getOrderProductsStatus();
        return $status;
    }

    //订单写入数据库
    private function createOrder($snap){
        //开启事务
        Db::startTrans();
        try{
            $createOrderSn = $this->makeOrderSn();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_sn = $createOrderSn;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['productStatus']);

            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;

            foreach($this->orderProducts as &$p){
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProductModel();
            $orderProduct->saveAll($this->orderProducts);
            //结束事务
            Db::commit();
            return [
                'order_sn' => $createOrderSn,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        }catch(Exception $ex){
            //事务回滚
            Db::rollback();
            throw $ex;
        }
    }
    /**
     * 订单号生成规则
     * @return string
     */
    private static function makeOrderSn(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
    //生成订单快照
    private function snapOrder($status){
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'productStatus' => [],
            'snapAddress' => null,
            'snapName'=>'',
            'snapImg'=>'',
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['productStatus'] = $status['productStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        return $snap;
    }
    //检测用户是否填写地址信息
    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id','=',$this->uid)->find();
        if(!$userAddress){
            throw new UserException([
                'msg' =>'用户收货地址不存在，下单失败',
                'errorCode' => 60001,
            ]);
        }
        return $userAddress;
    }

    //orderProducts和products进行对比的方法,获取订单的真实状态,作为订单的返回结果
    private function getOrderProductsStatus(){
        //订单默认状态
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount'=> 0,
            //订单各类商品详细信息
            'productStatusArray' => []
        ];

        foreach($this->orderProducts as $orderProduct){
            $productStatus = $this->getOrderProductStatus($orderProduct['product_id'],
                $orderProduct['count'],$this->products);
            if(!$productStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $productStatus['oneProductTotalPrice'];
            $status['totalCount'] += $productStatus['count'];
            array_push($status['productStatusArray'],$productStatus);
        }
        return $status;
    }

    //getOrderProductStatus方法是验证数据库某类商品的库存是否充足，返回商品检测的状态结果
    private function getOrderProductStatus($orderProductID,$orderCount,$products){
        //订单传递过来的id，在$products中的序号
        $productIndex = -1;
        //订单某一商品的详细信息
        $productStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'oneProductTotalPrice' => 0,
        ];
        //查出对应的商品id号。
        for($i=0;$i<count($products);$i++){
            if($orderProductID == $products[$i]['id']){
                $productIndex = $i;
            }
        }
        //客户端传递的product_id有可能是不存在
        if($productIndex == -1){
            throw new OrderException([
                'msg' => 'id为'.$orderProductID.'商品不存在，创建订单失败'
            ]);
        }else {
            $product = $products[$productIndex];//某一个商品的信息
            $productStatus['id'] = $product['id'];
            $productStatus['name'] = $product['name'];
            $productStatus['count'] = $orderCount;
            $productStatus['oneProductTotalPrice'] = $product['price'] * $orderCount;

            if ($product['stock'] - $orderCount >= 0) {
                $productStatus['haveStock'] = true;
            }
        }
        return $productStatus;
    }

    //根据订单信息查询商品真实信息方法
    public function getProductsByOrder($orderProducts){

        $orderProductIDs = [];
        foreach($orderProducts as $items){
                array_push($orderProductIDs,$items['product_id']);
            }

        $products = ProductModel::all($orderProductIDs)->toArray();

        return $products;
    }


}