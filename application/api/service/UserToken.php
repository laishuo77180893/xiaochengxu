<?php 

namespace app\api\service;

use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\User;
use app\lib\exception\WeChatException;
use app\lib\enum\ScopeEnum;

class UserToken extends BaseToken{
	
	protected $code;
	protected $wxAppID;
	protected $wxAppSecret;
 	protected $wxLoginUrl;

    function __construct($code){
	 	$this->code = $code;
	 	$this->wxAppID = config('wx.app_id');
	 	$this->wxAppSecret = config('wx.app_secret');
	 	$this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);

    }

	public function get(){
        //返回为字符串
		$result = curl_get($this->wxLoginUrl);
        //获取微信传递回来的数据，将其转换为数组，加true是变成数组,没有加true是对象
		$wxResult = json_decode($result,true);
		if(empty($wxResult)){
			throw new Exception('发送请求失败');
		}else{
			$loginFail = array_key_exists('errcode', $wxResult);
			if($loginFail){
			    throw new WeChatException(['msg' => $wxResult['errmsg']],['errorCode' => $wxResult['errcode']]);
			}else{
			    //执行成功令牌返回客户端
				return $this->grantToken($wxResult);
			}
		}
	}

    /*
     * 拿到openid
     * 数据库查看，是否有该openid
     * 如果有，则不处理，如果不存在新增一条user记录
     * 生成令牌，准备缓存数据，写入缓存
     * 把令牌返回到客户端去
     * key:令牌 value:wxResult,uid,scope(权限身份级别)
     */
     
	private function grantToken($wxResult){
		$openid = $wxResult['openid'];
		$userdata = User::getByOpenID($openid);
		if($userdata){
			$uid = $userdata->id;
		}else{
			$uid = User::addByOpenID($openid);
		}
		$cacheValue = $this->prepareCachedValue($wxResult,$uid);
		return $this->saveToCache($cacheValue);
		
	}

	//将数据写入缓存
	private function saveToCache($cacheValue){
		//获取令牌(key)
		$key = self::getSaveToken();
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

	//准备需要缓存的数据的方法(value)
	private function prepareCachedValue($wxResult,$uid){
		$cacheValue = $wxResult;
		$cacheValue['uid'] = $uid;
		$cacheValue['scope'] = ScopeEnum::User;//scope(权限身份级别)

		return $cacheValue;
	}



}








 ?>