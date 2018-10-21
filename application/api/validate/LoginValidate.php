<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/20
 * Time: 21:34
 */

namespace app\api\validate;



class LoginValidate extends BaseValidate
{
    protected $rule = [

        'username' => 'require|isNotEmpty',
        'password'=>'require|isNotEmpty',


    ];

}