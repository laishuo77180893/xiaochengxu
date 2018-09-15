<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 23:02
 */

namespace app\lib\exception;

use app\lib\exception\BaseException;

class BannerException extends BaseException
{
    public $code = 404;
    public $msg = 'banner资源请求不存在';
    public $errorCode = 40000;
}