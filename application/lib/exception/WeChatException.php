<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/13
 * Time: 16:43
 */

namespace app\lib\exception;

use app\lib\exception\BaseException;

class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}