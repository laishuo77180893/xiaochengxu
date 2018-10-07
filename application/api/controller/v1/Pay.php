<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/28
 * Time: 16:53
 */

namespace app\api\controller\v1;


use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;
use think\Request;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];
    /**
     * 微信支付api
     * 1.检验订单号是否存在，是否与用户身份匹配，是否已经支付。
     * 2.再次检验商品库存
     * 3.接收到客户端传过来的orderID,向微信服务器发送预订单支付请求,返回成功并且有perpay_id,更新数据表
     * 4.生成签名，返回给小程序客户端，拉起微信支付
     * 5.支付完成，微信服务器会自动调用我们一个接收支付结果的api
     */
    public function getPreOrder(){
        (new IDMustBePositiveInt())->jsonGoCheck();
        $id = Request::instance()->put();
        $id= $id['id'];

        $pay = new PayService($id);
        return $pay->pay();
    }

    /**
     * 微信支付回调api，接收处理微信返回的支付结果
     * 微信服务器会不间断调用我们的回调api,直到我们api响应成功
     * 调用频率15/15/30/180/1800/1800... 秒
     */
    public function receiveNotify(){
        $notify = new WxNotify();
        $notify->Handle();
    }
}