<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 16:09
 */
namespace app\api\controller\v1;


 use app\api\model\Category as CategoryModel;
 use app\lib\exception\CategoryException;

 class Category{
     /**
      * @url api/:version/category/all
      * 取出商品分类类目和顶部图片
      */
     public function getAllCategories()
     {
         $categories = CategoryModel::all([], 'img');
         if(empty($categories)){
             throw new CategoryException([
                 'msg' => '还没有任何类目',
                 'errorCode' => 50000
             ]);
         }
         return $categories;
     }




 }