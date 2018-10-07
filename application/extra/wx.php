<?php 
//微信登录接口调用

return [

	'app_id' => 'wx0cb7cbcc470b8f1e',
	
	'app_secret' => 'e2e5c73738070b1e6e42ba0369c87b23',

    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?"."appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

	'token_expire_in' => 7200,
    //支付回调地址
    'pay_back_url'=>'http://qw.com/api/v1/pay/receive',
];

// https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code

















 ?>