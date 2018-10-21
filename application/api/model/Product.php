<?php 

namespace app\api\model;



class Product extends BaseModel{
	protected $hidden = ['create_time','update_time','delete_time',
                        'pivot','summary','img_id','theme_id'];

    //获取器自动加载图片路径
    public function getMainImgUrlAttr($value,$data){
        return $this->imageUrl($value,$data);
    }

	//按时间先后顺序取出最新商品
    public static function getNewProduct($count){
        $products =  self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    //取出某一分类的商品信息
    public static function getProductByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)->select();
        return $products;
    }

    //某个商品详细介绍图片关联信息
    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    //某个商品信息对应关联表的信息
    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    //获取某个商品详细信息
    public static function productDetailInfo($id){
        $product = self::with('imgs.productImg,properties')
            ->find($id);
        return $product;
    }




}











