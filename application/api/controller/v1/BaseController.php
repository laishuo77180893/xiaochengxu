<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/19
 * Time: 22:29
 */

namespace app\api\controller\v1;


use app\api\service\BaseToken;
use think\Controller;

class BaseController extends  Controller
{
    //用户和管理员都可以访问的权限接口
    public function checkPrimaryScope(){
        BaseToken::needPrimaryScope();
    }

    //只有用户才能访问的接口权限
    public function checkExclusiveScope(){
        BaseToken::needExclusiveScope();
    }
}