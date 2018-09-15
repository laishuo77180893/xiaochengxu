<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 17:42
 */
namespace app\lib\exception;

use app\lib\exception\BaseException;

class ProductException extends BaseException{
    public $code = 404;
    public $msg = '请求商品不存在';
    public $errorCode = 20000;
}