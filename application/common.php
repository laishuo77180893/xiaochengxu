<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function apiReturn($code,$msg="",$data=array()){
  	$result = [
        'code' => intval($code),  
        'msg' => $msg, 
        'data' => $data   
    ];
    return $result;
}


/**
*@param string $url get请求地址
*@param int $httpCode 返回状态码
*@return mixed
*
*/


function curl_get($url,&$httpCode = 0 ){
    // 创建了一个curl会话资源
    $ch = curl_init();
    //设置URL传输选项
    curl_setopt($ch,CURLOPT_URL,$url);
    //设置是否将响应结果存入变量，1是存入，0是直接echo出
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    //不做证书校验，部署在linux环境下请改为true
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
    //执行一个curl会话
    $file_contents = curl_exec($ch);
    //获取一个curl连接资源句柄的信息
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    //输出前关闭资源，节省系统内存
    curl_close($ch);
    return $file_contents;

}

