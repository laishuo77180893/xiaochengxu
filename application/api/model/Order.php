<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/26
 * Time: 10:32
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['use_id','delete_time','update_time'];
    protected $autoWriteTimestamp = true;

    //获取器自动把json字符串转换为json
    public function getSnapItemsAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid,$page=1,$size=10){
        $pageData = self::where('user_id','=',$uid)
            ->order('create_time desc')
            ->paginate($size,true,['page' => $page]);
        return $pageData;
    }
}