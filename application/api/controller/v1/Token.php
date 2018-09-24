<?php

namespace app\api\controller\v1;


use app\api\validate\TokenValidate;
use app\api\service\UserToken;

class Token{
	public function getToken($code = ''){
		//校验code码
        (new TokenValidate())->goCheck();
		$usertoken = new UserToken($code);//实例化的时候，构造韩式被调用，需要传入code码
		$token = $usertoken->get();
		return json([
			'token' => $token,
		]);

	}
}


























