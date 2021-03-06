<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/19
 * Time: 21:24
 */

namespace app\api\controller\v1;


use app\api\service\BaseToken;
use app\api\model\Order as OrderModel;
use app\api\validate\OrderPlaceValidate;
use app\api\validate\PageParamValidate;
use app\api\service\Order as OrderService;
use think\Request;


class Order extends BaseController
{
    /**
     *  用户在小程序客户端点击购买了商品，调用我们的下单接口，小程序发送一个下单商品的信息
     *  这时候检测一下服务器的库存，如果库存足够就保存订单，向小程序发送订单检测的相关信息，
     *  小程序收到检测结果，成功就调用我们的支付api接口，然后我们的api接口去调用微信服务器的预订单接口
     *  预订单目的就是微信返回给我们服务器一组支付参数，我们拿到支付参数后将支付参数返回给小程序
     *  小程序拿到支付参数后，调用小程序的内置支付api，小程序内置支付api在调用微信支付api
     */
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getSummaryByUser']
    ];
    //生成订单
    public function placeOrder()
    {
        (new OrderPlaceValidate())->goCheck();
        $products = Request::instance()->put();
        $products = $products['products'];
        // 获取uid，确认用户
        $uid = BaseToken::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    //订单简要信息分页接口
    public function getSummaryByUser($page=1,$size=5){
        (new pageParamValidate())->goCheck();
        $uid = BaseToken::getCurrentUid();

        $pageOrder = OrderModel::getSummaryByUser($uid,$page,$size);

        if($pageOrder->isEmpty()){
            return [
                'data'=>[],
                'current_page' => $pageOrder->currentPage()
            ];
        }else{
            return [
                'data'=> $pageOrder->toArray(),
                'current_page' => $pageOrder->currentPage()
            ];
        }

    }



}