<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/24
 * Time: 0:33
 */

namespace app\api\validate;


class CategoryValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|between:2,7|isPositiveInteger'
    ];
}