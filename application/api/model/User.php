<?php 

namespace app\api\model;



class User extends BaseModel{
	
	//查询openid是否存在数据库
	public static function getByOpenID($openid){
		$user = self::where('openid','=',$openid)->find();
		return $user;
	}

	//添加openid数据
	public static function addByOpenID($openid){
		$adduser = self::create(['openid' => $openid]);
		return $adduser->id;
	}

	//user表关联UserAddress表
    public function address(){
	    return $this->hasOne('UserAddress','user_id','id');
    }

}











 ?>