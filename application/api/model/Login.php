<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/20
 * Time: 21:53
 */

namespace app\api\model;


use app\lib\exception\LoginException;
use app\lib\exception\RegisterException;
use app\api\service\UserToken;
use app\lib\exception\TokenException;

class Login extends BaseModel
{
    public function checkUsername($value){
        $user = $this->where('username','=',$value['username'])->find();
        if($user){
            throw new RegisterException([
                'msg'=>'用户名已存在'
            ]);
        }
    }

    public function saveRegister($value){
        unset($value['truePassword']);
        return $this->save($value);
    }

    public function checkLoginUsername($value){
        $user = $this->where('username','=',$value['username'])->find();
        if(!$user){
            throw new LoginException([
                'msg'=>'用户名不存在'
            ]);
        }else if(($user->password)!=$value['password']){
            throw new LoginException([
                'msg'=>'密码输入错误'
            ]);
        }
        return $this->saveCache($user);

    }

    //将数据写入缓存
    private function saveCache($cacheValue){
        //获取令牌(key)
        $key = UserToken::getSaveToken();
        //获取需要缓存的数据
        $value = json_encode($cacheValue);
        //有效时间
        $expire_in = config('wx.token_expire_in');
        //tp5自动缓存机制，写入缓存
        $request = cache($key,$value,$expire_in);

        if(!$request){
            throw new TokenException(['msg'=>'服务器缓存异常','errCode'=>10005]);
        }
        return $key;
    }
}