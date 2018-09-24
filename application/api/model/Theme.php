<?php 

namespace app\api\model;



class Theme extends BaseModel{
	
	protected $hidden = ['update_time','delete_time','topic_img_id','head_img_id'];
	//关联Image表
	public function topicImg(){
	    return $this->belongsTo('Image','topic_img_id','id');
	}
    //关联Image表
    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }
    //关联product表
    public function themeProduct(){
	    return $this->hasMany('Product','theme_id','id');
    }
    //查询主题theme下对应的图片
    public static function getTopicImg($ids){
	    return self::with('topicImg')->select($ids);
    }

    //查询主题theme下对应的图片和商品
    public static function getThemeProductAndHeadImg($id){
	    return self::with('headImg,themeProduct')->select($id);
    }






	
}

















 ?>