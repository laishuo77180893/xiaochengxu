<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/10
 * Time: 0:17
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['delete_time','img_id','product_id'];

    public function productImg(){
        return $this->belongsTo('Image','img_id','id');
    }
}