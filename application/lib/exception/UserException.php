<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/17
 * Time: 23:16
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}