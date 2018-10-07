<?php 

namespace app\api\validate;



class TokenValidate extends BaseValidate{
	protected $rule = [
		'code'=>'require|isNotEmpty',
	];

	protected  $message = [
	    'code'=>'获取code码失败',
    ];

	
}















 ?>