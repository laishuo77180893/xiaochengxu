<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/21
 * Time: 0:39
 */

namespace app\api\validate;


class RegisterValidate extends BaseValidate
{

    protected $rule = [
        //用户名密码长度用length,传入参数值用between
        'username' => 'require|length:6,20',
        'password'=>'require|length:6,20',
        'truePassword'=>'require|length:6,20',
        'detail' => 'require|isNotEmpty',
        'email' => 'require|checkEmail',
        'profession' => 'require|isNotEmpty',
    ];

    public function checkEmail($value, $rule='', $data='', $field=''){
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        $result = preg_match($pattern, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}