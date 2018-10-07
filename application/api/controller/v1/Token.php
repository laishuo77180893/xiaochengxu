<?php

namespace app\api\controller\v1;


use app\api\validate\TokenValidate;
use app\api\service\UserToken;

class Token{
    /**
     * @param string $code
     * @url api/:version/token/user
     * @http POST
     * 微信授权登录成功返回token令牌
     */
	public function getToken($code = ''){
		//校验code码
        (new TokenValidate())->goCheck();
        //实例化的时候，构造函数自动被调用，需要传入参数code码
        $usertoken = new UserToken($code);
		$token = $usertoken->get();
		return json([
			'token' => $token,
		]);

	}
}


























