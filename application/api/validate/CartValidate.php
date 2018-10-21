<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/15
 * Time: 12:45
 */

namespace app\api\validate;


class CartValidate extends BaseValidate
{
    protected $rule =[
        'product_id' => 'isPositiveInteger|require',
        'count' => 'isPositiveInteger|require'
    ];

}