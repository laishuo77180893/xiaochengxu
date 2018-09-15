<?php 


namespace app\api\service;

class BaseToken{
	//生成令牌
	public static function getSaveToken(){
		$str = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnm';
		//获取随机字符串
		$randonChars = substr(str_shuffle($str),0,32);
		//时间戳  获取当前时间戳
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		//盐  自定义的字符串
		$salt = 'uh6H9K7i3sUA5Q';

		return md5($randonChars.$timestamp.$salt);
	} 



}






























 ?>