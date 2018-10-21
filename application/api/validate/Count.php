<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/10
 * Time: 22:15
 */
namespace  app\api\validate;



class Count extends BaseValidate{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,30',
    ];
}




