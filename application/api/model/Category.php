<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 16:11
 */

namespace  app\api\model;



class Category extends  BaseModel{
    protected $hidden = ['delete_time','update_time','description','from'];

    public function getCategory(){
        return $this->select();
    }
    /**
     * 获取器自动生成图片路径
     * @parm $value 数据库图片的存放路径
     * @CategoryImage 是指该模型下category_image表字段名称
     */
    public function getCategoryImgAttr($value,$data){
        return $this->imageUrl($value,$data);
    }

    public function ProductInfo(){
        return $this->hasMany('Product','category_id','id');
    }

    public static function getProductInfo($category_id){
        return self::with('ProductInfo')->select($category_id);
    }
}