<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/13
 * Time: 22:05
 */

namespace app\lib\exception;


class TokenException extends  BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}