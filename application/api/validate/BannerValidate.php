<?php 
namespace app\api\validate;

use app\api\validate\BaseValidate;

class BannerValidate extends BaseValidate{

	protected $rule =[
        'id'=>'isPositiveInteger|require',
	];
}



















 ?>