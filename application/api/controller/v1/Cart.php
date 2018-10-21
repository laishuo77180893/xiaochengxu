<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/6
 * Time: 16:09
 */

namespace app\api\controller\v1;

use app\api\service\BaseToken;
use app\api\validate\CartValidate;
use think\Exception;
use think\Request;
use app\api\model\UserCart;

class Cart extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' =>'addProductIntoCart']
    ];
    /**
     * param product_id
     * param count
     * 添加某个商品进入购物车，需要判断该商品是否存在
     * 如果存在增加商品数量，否则增加商品完整信息到购物车
     */
    public function addProductIntoCart(){

        (new CartValidate())->jsonGoCheck();
        $param = Request::instance()->put();
        $uid = BaseToken::getCurrentUid();

        $product_id = $param['product_id'];
        $count = $param['count'];
        $addCart = new UserCart();
        $add = $addCart->addCart($product_id,$count,$uid);
        if(!$add){
            throw new Exception('购物车加入异常');
        }else{
            return $add;
        }
    }

    /**
     * 减少购物车内某一商品数量
     */
    public function deleteProductCountInCart(){
        (new CartValidate())->jsonGoCheck();
        $param = Request::instance()->put();
        $uid = BaseToken::getCurrentUid();

        $product_id = $param['product_id'];
        $count = $param['count'];
        $addCart = new UserCart();
        $delete = $addCart->deleteCart($product_id,$count,$uid);
    }



    }