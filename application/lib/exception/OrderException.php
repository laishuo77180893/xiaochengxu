<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/20
 * Time: 18:25
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}