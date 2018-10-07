<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/28
 * Time: 20:08
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //待付款
    const UNPAID = 1;

    //已付款
    const PAID = 2;

    //已发货
    const DELIVERED = 3;

    //已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;

}