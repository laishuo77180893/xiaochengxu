<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 16:09
 */
namespace app\api\controller\v1;


 use app\api\model\Category as CategoryModel;
 use app\api\validate\CategoryValidate;
 use app\lib\exception\CategoryException;

 class Category{
     /**
      * @url api/:version/category/all
      * 取出商品分类类目和顶部图片
      */
     public function getAllCategory(){
         $res = (new CategoryModel())->getCategory();
         if(!$res){
             throw new CategoryException();
         }else{
             return show(1,'数据返回成功',$res);
         }
     }
     /**
      * @url api/:version/category/:id
      * 取出某一分类下的商品信息
      */
     public function getProductByCategory($id = ''){
         (new CategoryValidate())->goCheck();
         $result = CategoryModel::getProductInfo($id);
         if(!$result){
             throw new CategoryException();
         }else{
             return show(1,'数据返回成功',$result);
         }

     }
 }