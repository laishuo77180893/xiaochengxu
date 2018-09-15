<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 18:14
 */

namespace app\lib\exception;

use think\exception\Handle;
use think\Log;
use think\Request;
use think\Exception;

/*
 * 重写Handle的render方法，实现自定义异常消息
 */
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            //如果是自定义异常，则控制http状态码，不需要记录日志
            //因为这些通常是因为客户端传递参数错误或者是用户请求造成的异常
            //不应当记录日志

            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
                if(config('app_debug')) {
                    return parent::render($e);
                }else{
                    $this->code = 500;
                    $this->msg = 'sorry，we make a mistake.';
                    $this->errorCode = 999;
                    $this->recordErrorLog($e);
                 }
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request = $request->url()
        ];
        return json($result, $this->code);
    }

    /*
     * 将异常写入日志
     */
    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        //高于error级别的错误才会被记录
        Log::record($e->getMessage(), 'error');
    }
}