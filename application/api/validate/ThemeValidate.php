<?php 
namespace app\api\validate;



class ThemeValidate extends BaseValidate{
	protected $rule = [
		'ids' => 'require|checkIDs'
	];

	protected $message = [
	    'ids' => 'ids必须是正整数'
    ];

	public function checkIDs($value){
	    $values = explode(',',$value);
	    if(empty($values)){
	        return false;
        }
        foreach($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}




















 ?>