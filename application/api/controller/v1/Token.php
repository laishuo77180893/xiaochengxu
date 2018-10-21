<?php

namespace app\api\controller\v1;


use app\api\service\BaseToken;
use app\api\validate\TokenValidate;
use app\api\service\UserToken;
use app\lib\exception\ParameterException;


class Token{
    /**
     * @param string $code
     * @url api/:version/token/user
     * @http GET
     * 微信授权登录成功返回token令牌
     */
	public function getToken($code = ''){
	    //校验code码
        (new TokenValidate())->goCheck();
        //实例化的时候，构造函数自动被调用，需要传入参数code码
        $usertoken = new UserToken($code);
		$token = $usertoken->get();
		return [
			'token' => $token,
		];
	}

	/**
     * 检验token令牌是否缓存在服务器内
     */
	public function verifyToken($token = ''){
	    if(!$token){
	        throw new ParameterException([
	            'token令牌不允许为空'
            ]);
        }
        $valid = BaseToken::verifyToken($token);
        return [
            'isValid' => $valid,
        ];
    }
}


























