<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/11
 * Time: 16:09
 */namespace app\api\controller;


 use app\api\model\Category as CategoryModel;
 use app\lib\exception\CategoryException;

 class Category{

     public function getAllCategory(){
         $category = new CategoryModel();
         $res = $category -> getCategory();

         if(!$res){
             throw new CategoryException();
         }else{
             return show(1,'数据返回成功',$res);
         }

     }
 }