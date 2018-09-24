<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/19
 * Time: 20:06
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不足';
    public $errorCode = 10001;
}