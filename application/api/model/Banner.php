<?php 

namespace app\api\model;



class Banner extends BaseModel{
	
	protected $hidden = ['create_time','update_time','description','listorder','from'];

	public function getBannerInfo(){
		$order = [
			'status' => 1,
		];
		return $this->where($order)->select();
	}
	/**
	* 获取器自动生成图片路径
    * @parm $value 数据库图片的存放路径
    * @BannerImage 是指该模型下banner_image表字段名称
	*/
	public function getBannerImageAttr($value,$data){
		return $this->imageUrl($value,$data);
	}
}



















 ?>