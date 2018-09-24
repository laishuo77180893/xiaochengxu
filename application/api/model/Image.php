<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/23
 * Time: 17:13
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['delete_time','update_time','from','id'];
    //获取器自动加载图片路径
    public function getUrlAttr($value,$data){
        return $this->imageUrl($value,$data);
    }
}