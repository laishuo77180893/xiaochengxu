<?php 

namespace app\api\model;

use think\Model;


class BaseModel extends Model{
	/*
	*  获取器自动生成图片路径
	*  @param $value 数据库图片的存放路径
	*/
	public function imageUrl($value,$data){
		if($data['from'] == 1) {
            return config('config.img') . $value;
        }else{
		    return $value;
        }
	}
}

















 ?>