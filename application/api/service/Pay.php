<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/28
 * Time: 16:52
 */

namespace app\api\service;


use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use think\Loader;
use think\Log;

//手动加载微信SDK
Loader::import('Wxpay.WxPay',EXTEND_PATH,'.Api.php');

class Pay
{
    private $orderID;
    private $orderSn;

    function __construct($orderID)
    {
        if(!$orderID){
            throw new Exception('订单号不允许为null');
        }
        $this->orderID = $orderID;
    }
    //微信支付
    public function Pay(){
        /**
         * 订单号可能不存在
         * 订单号存在，但是与用户不匹配
         * 订单有可能被支付
         */
         $this->checkOrderValid();

        //库存校验
        $orderservice = new OrderService();
        $status = $orderservice->checkOrderStock($this->orderID);
        if(!$status['pass']){
            return $status;
        }
        //微信预订单返回结果
        return $this->makeWxPreOrder($status['orderPrice']);
    }


    //微信支付预订单
    private function makeWxPreOrder($totalPrice){
        //通过token令牌到缓存中获取openid
        $openid = BaseToken::getCurrentTokenVar('openid');
        if(!$openid){
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderSn);
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetNotify_url(config('Wx.pay_back_url'));

        return $this->getPaySignature($wxOrderData);
    }

    //向微信服务器发送支付请求，查看返回结果并记录日志
    private function getPaySignature($wxOrderData){
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code']!='SUCCESS'||$wxOrder['result_code']!='SUCCESS')
        {
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
            throw new Exception('获取预支付订单失败');
        }
        //请求成功后更新数据库订单表中prepay_id的值
        $this->recordPreOrder($wxOrder);
        //生成签名向小程序客户端返回签名
        return $this->sign($wxOrder);
    }

    //获取微信服务器返回的wxOrder结果，更新订单表prepay_id字段,无需返回客户端
    private function recordPreOrder($wxOrder){
        OrderModel::where('id','=',$this->orderID)->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    //生成签名
    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $randStr = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($randStr);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $jsApiPayData->SetTimeStamp((string)time());
        //$sign签名
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['sign'] = $sign;

        unset($rawValues['appId']);
        return $rawValues;
    }

    /**
     * 订单号可能不存在
     * 订单号存在，但是与用户不匹配
     * 订单有可能被支付
     */
    public function checkOrderValid(){
        $order = OrderModel::where('id','=',$this->orderID)->find();
        if(!$order){
            throw new OrderException();
        }
        if(!BaseToken::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException([
                'msg' => '订单已支付',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderSn = $order->order_sn;
        return true;
    }


}