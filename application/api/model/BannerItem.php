<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/9
 * Time: 0:34
 */

namespace app\api\model;



class BannerItem extends BaseModel
{
    protected $hidden = [ 'img_id', 'banner_id', 'delete_time','update_time'];

    public function img()
    {
        //定义关联关系 图片模型，外键，主键
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}