<?php 

namespace app\api\controller;

use think\Controller;
use app\api\validate\TokenValidate;
use app\api\service\UserToken;

class Token{
	public function getToken($code=''){
		
		//校验code码
        (new TokenValidate())->goCheck($code);
		$usertoken = new UserToken($code);
		$token = $usertoken->get();
		return json([
			'token' => $token,
		]);

	}
}


























