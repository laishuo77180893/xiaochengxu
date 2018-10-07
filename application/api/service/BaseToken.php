<?php 


namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class BaseToken{
	//生成令牌规则
	public static function getSaveToken(){
		$str = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnm';
		//获取随机字符串
		$randonChars = substr(str_shuffle($str),0,32);
		//时间戳  获取当前时间戳
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		//盐  自定义的字符串
		$salt = 'uh6H9K7i3sUA5Q';

		return md5($randonChars.$timestamp.$salt);
	}

	//根据传入的key判断用户是需要获取wxResult,uid,scope中的哪个value值
    public static function getCurrentTokenVar($key){
       //从地址栏header头获取token令牌

        $token = Request::instance()->header('token');
        
        //查询缓存数据
        $vars = Cache::get($token);
        
        if(!$vars){
            throw new TokenException();
        }else{
        //redis缓存是直接返回数组形式，tp自带缓存是字符串，需要进行判断是否需要转换
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的Token变量不存在');
            }
        }

    }
	//获取uid的方法
    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }


    //用户和管理员都可以访问的权限接口
    public static function needPrimaryScope(){
        $scope =self::getCurrentTokenVar('scope');
        //$scope如果不存在说明token令牌无效或者过期
        if($scope){
            if($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    //只有用户才能访问的接口权限
    public static function needExclusiveScope(){
        $scope =self::getCurrentTokenVar('scope');
        //$scope如果不存在说明token令牌无效或者过期
        if($scope){
            if($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    //对比检验用户传过来的uid是否与缓存中的uid一致
    public static function isValidOperate($checkedUID){
        if(!$checkedUID){
            throw new Exception('必须传入一个被检测的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }



}






























 ?>