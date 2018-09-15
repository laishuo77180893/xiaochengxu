<?php 

namespace app\api\validate;

use app\api\validate\BaseValidate;

class TokenValidate extends BaseValidate{
	protected $rule = [
		'code'=>'require|isNotEmpty',
	];

	protected  $message = [
	    'code'=>'获取code码失败',
    ];

	
}















 ?>