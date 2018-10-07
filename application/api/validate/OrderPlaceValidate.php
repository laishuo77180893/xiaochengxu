<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/20
 * Time: 2:25
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;

class OrderPlaceValidate extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts',
    ];

    protected $singleRlue = [
        'product_id' =>'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values){
        if(!is_array($values)){
            throw new ParameterException([
                'msg' =>'商品参数不正确'
            ]);
        }
        if(empty($values)){
            throw new ParameterException([
                'msg' => '商品；列表不能为空'
            ]);
        }
        foreach($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    protected function checkProduct($value){
        $validate = new BaseValidate($this->singleRlue);
        $result = $validate->check($value);
        if(!$result){
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }


}