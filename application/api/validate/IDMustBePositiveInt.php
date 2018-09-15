<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 17:23
 */

namespace app\api\validate;

use app\api\validate\BaseValidate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id'=>'require|isPositiveInteger',
    ];
}