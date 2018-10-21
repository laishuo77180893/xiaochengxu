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
	    //belongsToMany('关联模型名','中间表名','外键名','当前模型关联键名',['模型别名定义']);
	    return $this->belongsToMany('Product','theme_product',
            'product_id','theme_id');
    }
    //查询主题theme下对应的图片
    public static function getTopicImg($ids){
	    return self::with('topicImg,headImg')->select($ids);
    }

    //查询主题theme下对应的图片和商品
    public static function getThemeProductAndHeadImg($id){
	    return self::with('headImg,themeProduct')->find($id);
    }






	
}

















 ?>