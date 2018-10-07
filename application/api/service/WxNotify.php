<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/29
 * Time: 23:01
 */

namespace app\api\service;

use app\lib\enum\OrderStatusEnum;
use think\Exception;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\api\model\Product as ProductModel;
use think\Log;
use think\Db;

//手动加载微信SDK
Loader::import('Wxpay.WxPay',EXTEND_PATH,'.Api.php');

class WxNotify extends \WxPayNotify{

    public function NotifyProcess($data,&$msg){
        /**
         * 1.检测库存，超卖
         * 2.更新订单status状态
         * 3.减去库存
         * 4.处理成功返回给微信处理成功的信息，否则，返回没有成功处理结果
         */
        if($data['result_code'] == 'SUCCESS'){
            $orderSn = $data['out_trade_no'];
            Db::startTrans();
            try{
                $order = OrderModel::where('order_sn','=',$orderSn)->find();
                if($order->status == 1){
                   $orderService =  new OrderService();
                    /**
                     * checkOrderStock用于外部调用检验订单商品库存量
                     * @return $status
                     * $status = [
                     * 'pass' => true,
                     * 'orderPrice' => 0,
                     * 'totalCount'=> 0,
                     *  (productStatusArray为订单各类商品详细信息)
                     * 'productStatusArray' => [多个productStatus信息];
                     */
                   $stockStatus = $orderService->checkOrderStock($order->id);
                   if($stockStatus['pass']=true){
                        $this->updateOrderStatus($order->id,true);
                        $this->reduceStock($stockStatus);
                   }else{
                       $this->updateOrderStatus($order->id,false);
                   }
                }
                Db::commit();
                return true;
            }catch(Exception $ex){
            //如果出现异常没有处理成功,我们返回false,需要让微信服务器给我们继续发送支付结果
                Db::rollback();
                Log::error($ex);
                return false;
            }
        }else{
        //如果微信没有返回SUCCESS,说明支付失败,我们返回true表示接受到支付失败信息,信息不用再次发送支付结果
            return true;
        }

    }
    //更新status状态
    private function updateOrderStatus($orderID,$success){
        $status = $success?(OrderStatusEnum::PAID):(OrderStatusEnum::PAID_BUT_OUT_OF);
        OrderModel::where('id','=',$orderID)->update(['status'=>$status]);
    }

    //减去库存
    private function reduceStock($stockStatus){
        foreach ($stockStatus['productStatusArray'] as $productStatus) {
           ProductModel::where('id','=',$productStatus['id'])
               ->setDec('stock',$productStatus['count']);
        }
    }
}
