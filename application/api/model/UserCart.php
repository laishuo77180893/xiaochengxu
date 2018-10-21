<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/10/14
 * Time: 20:00
 */

namespace app\api\model;

use app\api\model\Product as ProductModel;
use think\Exception;

class UserCart extends BaseModel
{


    public function addCart($product_id,$count,$uid){

        //查询商品具体信息
        $product = ProductModel::get($product_id);
        //获取商品价格
        $product_price = $product->price;
        //获取商品库存
        $stock = $product->stock;
        //检测某一商品库存数量
        if($stock<$count){
            throw new Exception($product_id .'商品库存不足');
        }

        //加入购物车新商品
        $list = [
            'product_id'=>$product_id,
            'user_id'=>$uid,
            'count'=>$count,
            'product_price'=> $product_price * $count
        ];
        $res = $this->where('product_id','=',$product_id)
                    ->where('user_id','=',$uid)
                    ->find();
        if(!$res){
            return self::create($list);
        }else{
            if($res['count']>0) {
                $res['count'] += $count;
                $res['product_price'] += $product_price * $count;
                $res = $res->toArray();
                return $this->save($res, ['user_id' => $uid]);
            }else{
                return $res;
            }
        }
    }

    public function deleteCart($product_id,$count,$uid){
        $res = $this->where('product_id','=',$product_id)
            ->where('user_id','=',$uid)
            ->find();
        if(!$res){
            throw new Exception('购物车内没有该商品无法减少');
        }else{

        }

    }
}