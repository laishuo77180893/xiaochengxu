<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/21
 * Time: 0:28
 */

namespace app\lib\exception;


class LoginException extends BaseException
{
    public $code = 400;
    public $msg = '登录失败';
    public $errorCode = 888;
}