<?php 
namespace app\api\validate;



class ThemeValidate extends BaseValidate{
	protected $rule = [
		'tpye' => 'num|in:1,2,3'
	];
}




















 ?>