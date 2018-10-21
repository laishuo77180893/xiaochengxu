<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;



Route::get('api/:version/banner/:id','api/:version.banner/getBanner');

Route::get('api/:version/category/all','api/:version.Category/getAllCategories');

Route::get('api/:version/product/recent','api/:version.Product/newProduct');
Route::get('api/:version/product/by_category','api/:version.Product/getAllProductInCategory');
Route::get('api/:version/product/:id','api/:version.Product/getProductDetailInfo',[],['id'=>'\d+']);


Route::get('api/:version/theme','api/:version.Theme/getSimpleList');
Route::get('api/:version/theme/:id','api/:version.Theme/getThemeOne');


Route::get('api/:version/token/user','api/:version.Token/getToken');
Route::get('api/:version/token/verify','api/:version.Token/verifyToken');


Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/address','api/:version.Address/getUserAddress');


Route::post('api/:version/order','api/:version.Order/placeOrder');
Route::get('api/:version/order/by_user','api/:version.Order/getSummaryByUser');


Route::post('api/:version/pay/pre_order','api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/receive','api/:version.Pay/receiveNotify');


Route::post('api/:version/cart/add','api/:version.Cart/addProductIntoCart');


Route::post('api/:version/register','api/:version.Login/register');
Route::post('api/:version/login','api/:version.Login/userLogin');
