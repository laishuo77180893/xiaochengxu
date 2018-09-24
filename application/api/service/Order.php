<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/20
 * Time: 2:51
 */

namespace app\api\service;

use app\api\model\product;
use app\lib\exception\OrderException;


class Order
{
    //客户端出传递过来的的products参数
    protected $orderProducts;
    //数据库真实商品信息(包括库存量)
    protected $products;

    protected $uid;


    public function orderPlace($uid,$orderProducts){
        $this->orderProducts = $orderProducts;
        //根据订单的商品信息orderProducts去确定products数据库商品信息
        $this->products = $this->getProductsByOrder($orderProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单

    }

    //orderProducts和products进行对比的方法,获取订单的真实状态,作为订单的返回结果
    public function getOrderStatus(){
        //订单默认状态
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'productStatusArray' => []//订单各个商品详细信息
        ];

        foreach($this->orderProducts as $orderProduct){
            $productStatus = $this->getOrderProductStatus($orderProduct['product_id'],
                $orderProduct['count'],$this->products);
            if(!$productStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $productStatus['oneProductTotalPrice'];
            array_push($status['productStatusArray'],$productStatus);
        }
        return $status;
    }
    //getOrderProductStatus方法是验证数据库某类商品的库存是否充足，返回商品检测的状态结果
    private function getOrderProductStatus($orderProductID,$orderCount,$products){
        //订单传递过来的id，在$products中的序号
        //$productIndex客户端订单商品与数据库商品id的对应关系，-1表示不对等
        $productIndex = -1;
        //订单下某类商品的详细信息
        $productStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'oneProductTotalPrice' => 0,
        ];

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
        }else{
            $product = $products[$productIndex];//某一类商品的信息
            $productStatus['id'] = $product['id'];
            $productStatus['name'] = $product['name'];
            $productStatus['count'] = $orderCount;
            $productStatus['oneProductTotalPrice'] = $product['price'] * $orderCount;

            if($product['stock']-$orderCount>=0){
                $productStatus['haveStock'] =true;
            }
            return $productStatus;
        }
    }

    //根据订单信息查询商品真实信息方法
    public function getProductsByOrder($orderProducts){
        $orderProductID = [];
        foreach($orderProducts as $item){
            array_push($orderProductID,$item['product_id']);
        }
        $products = product::all($orderProductID)
            ->visible(['id','price','stock','name',' main_img_url'])
            ->toArray();
        return $products;
    }


}