<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/10
 * Time: 22:10
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;


class Product extends BaseController{
    /**
     * 按时间先后顺序取出最新商品（限制取出商品条数）
     * @url api/:version/product/recent
     */
    public function newProduct($count=20){

        (new Count())->goCheck();
        $product = ProductModel::getNewProduct($count);
        if(!$product){
            throw new ProductException();
        }else{
            return $product;
        }
    }

    /**
     * 某一分类商品信息取出
     * @url api/:version/product/by_category
     */
    public function getAllProductInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if($products->isEmpty()){
            throw new ProductException();
        }else{
            return $products;
        }
    }

    /**
     * 获取某个商品详细信息
     * @url api/:version/product/:id
     */
    public function getProductDetailInfo($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::productDetailInfo($id);
        if(!$product){
            throw new ProductException();
        }else{
            return $product;
        }
    }


}
