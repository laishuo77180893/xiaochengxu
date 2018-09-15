<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 16:11
 */

namespace  app\api\model;

use app\api\model\BaseModel;

class Category extends  BaseModel{
    protected $hidden = ['delete_time','update_time','description'];

    public  function  getCategory(){
        return $this->select();
    }
}