<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 16:11
 */

namespace  app\api\model;



class Category extends  BaseModel{

    protected $hidden = ['delete_time','update_time','description','from','topic_img_id'];



    public function products()
    {
        return $this->hasMany('Product', 'category_id', 'id');
    }

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public static function getCategories($ids)
    {
        $categories = self::with('products')
            ->with('products.img')
            ->select($ids);
        return $categories;
    }


}