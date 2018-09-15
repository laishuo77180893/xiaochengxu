<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/10
 * Time: 22:10
 */

namespace app\api\controller;

use think\Controller;
use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product extends Controller{

    public function NewProduct(){
        $count = input('get.count');
        (new Count())->goCheck();
        $product = ProductModel::getNewProduct($count);
        if(!$product){
            throw new ProductException();
        }else{
            return show(1,'获取商品信息成功',$product);
        }
    }

    //分类商品取出
    public function getAllInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if(!$products){
            throw new ProductException();
        }else{
            return show(1,'获取分类商品信息成功',$products);
        }
    }


}
