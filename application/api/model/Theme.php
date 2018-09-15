<?php 

namespace app\api\model;

use think\Model;
use app\api\model\BaseModel;

class Theme extends BaseModel{
	
	protected $hidden = ['update_time','delete_time'];
	//获取type=1的数据
	public function getInfo(){
		
		return $this->hasMany('Product','theme_id','id');

	}

	public static function getTypeInfo($id){
	    $theme = self::with('getInfo')->find($id);
	    return $theme;
    }

	
}

















 ?>