<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 17:23
 */

namespace app\api\validate;



class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id'=>'require|isPositiveInteger',
    ];
    protected $message = [
        'id'=>'id必须是正整数',
    ];
}