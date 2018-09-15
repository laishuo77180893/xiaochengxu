<?php 

namespace app\api\model;

use think\Model;
use app\api\model\BaseModel;

class Banner extends BaseModel{
	
	protected $hidden = ['create_time','update_time'];
	// 按照id取出轮播图数据
	public function getBannerByID($id){
		$order = [
			'status' => 1,
		];
		return $this->where($order)->find($id);
	}
	/*
	**	获取器自动生成图片路径
	**  @parm $value 数据库图片的存放路径
	**  @BannerImage 是指该模型下banner_image表字段名称
	*/
	public function getBannerImageAttr($value){
		return $this->imageUrl($value);
	}
}



















 ?>