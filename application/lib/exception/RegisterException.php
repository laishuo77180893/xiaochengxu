<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/21
 * Time: 0:35
 */

namespace app\lib\exception;


class RegisterException extends BaseException
{
    public $code = 400;
    public $msg = '注册失败';
    public $errorCode = 8888;
}