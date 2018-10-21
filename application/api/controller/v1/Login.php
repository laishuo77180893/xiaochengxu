<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/20
 * Time: 21:31
 */

namespace app\api\controller\v1;


use app\api\validate\RegisterValidate;
use app\lib\exception\RegisterException;
use think\captcha\Captcha;
use think\Exception;
use think\Request;
use app\api\model\Login as LoginModel;
use app\lib\exception\SuccessMessage;


class Login extends BaseController
{
    //注册账号
    public function register(){
        $array = Request::instance()->put();
        //验证用户名是否存在数据库
        $login = new LoginModel();
        $login->checkUsername($array);
        //验证2次输入密码是否一致
        if($array['password']!=$array['truePassword']){
            throw new RegisterException(['msg'=>'输入密码不一致']);
        }
        (new RegisterValidate())->goCheck();
        $result = $login->saveRegister($array);
        if(!$result){
            throw new Exception('注册出现异常');
        }
        return json(new SuccessMessage(),201);
    }

    //账号登录
    public function userLogin(){
        $array = Request::instance()->put();
        //验证账号是否存在
        $login = new LoginModel();
        $token = $login->checkLoginUsername($array);
        return apiReturn(1,'用户登录成功',['token'=>$token]);
    }

    //生成验证码
//    public function checkCaptcha(){
//        $config =    [
//            // 验证码字体大小
//            'fontSize'=>  30,
//            // 验证码位数
//            'length' => 3,
//            // 关闭验证码杂点
//            'useNoise' => false,
//            //验证码字体
//            'fontttf' => '5.ttf',
//            //背景图片
//            'useImgBg' => true,
//            //验证码字符
//            'codeSet '=> '0123456789QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm'
//        ];
//        $captcha = new Captcha($config);
//        return $captcha->entry();
//    }

}