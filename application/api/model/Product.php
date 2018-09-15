<?php 

namespace app\api\model;


class Product extends BaseModel{
	protected $hidden = ['create_time','update_time','delete_time','summary','img_id','theme_id'];


    public static function getNewProduct($count){
        $products =  self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public function getMainImgUrlAttr($value){
        return $this->imageUrl($value);
    }

    public static function getProductByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)->select();
        return $products;
    }




}











