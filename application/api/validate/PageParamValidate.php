<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/2
 * Time: 4:58
 */

namespace app\api\validate;


class PageParamValidate extends BaseValidate
{
    protected $rule = [
        'page' =>'isPositiveInteger',
        'size' =>'isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数'
    ];
}