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



Route::get('api/:version/banner','api/:version.banner/getBanner');

Route::get('api/:version/category/all','api/:version.Category/getAllCategory');
Route::get('api/:version/category/:id','api/:version.Category/getProductByCategory');

Route::get('api/:version/product/recent','api/:version.Product/newProduct');
Route::get('api/:version/product/by_category','api/:version.Product/getAllProductInCategory');
Route::get('api/:version/product/:id','api/:version.Product/getProductDetailInfo');

Route::get('api/:version/theme','api/:version.Theme/getSimpleList');
Route::get('api/:version/theme/:id','api/:version.Theme/getThemeOne');


Route::post('api/:version/token/user','api/:version.Token/getToken');

Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order','api/:version.Order/placeOrder');
Route::get('api/:version/order/by_user','api/:version.Order/getSummaryByUser');

Route::post('api/:version/pay/pre_order','api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/receive','api/:version.Pay/receiveNotify');

Route::post('api/:version/cart/add','api/:version.Cart/addProductIntoCart');


