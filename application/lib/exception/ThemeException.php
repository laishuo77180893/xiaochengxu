<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/12
 * Time: 21:52
 */

namespace app\lib\exception;


class ThemeException extends  BaseException
{
    public $code = 404;
    public $msg = '请求主题不存在';
    public $errorCode = 30000;
}