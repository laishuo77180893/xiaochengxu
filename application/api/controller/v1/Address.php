<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 2018/9/17
 * Time: 1:03
 */

namespace app\api\controller\v1;



use app\api\service\BaseToken;
use app\api\validate\AddressValidate;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Request;



class Address extends BaseController
{
    //前置方法，在调用createOrUpdateAddress接口之前需要调用checkPrimaryScope接口进行校验
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' =>'createOrUpdateAddress']
    ];

    /**
     * @url api/:version/address
     * 更新地址信息或者添加用户地址信息
     */
    public function createOrUpdateAddress(){

        $validate = new AddressValidate();
        $validate->jsonGoCheck();
        /**
         *  根据Token来获取uid
         *  根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常，
         *  获取用户从客户端提交上来的地址信息
         *  根据用户地址信息是否存在，从而判断用户是 添加地址还是更新地址
         */
        $uid = BaseToken::getCurrentUid();//根据Token来获取$uid
        $user = UserModel::get($uid);  //通过uid查询是否有该用户
       
        if(!$user){
            throw new UserException();
        }

        $params = Request::instance()->put();
        $data = $validate->getDataByRule($params);//校验数据合法性

        $userAddress = $user->address;//获取关联模型数据address是model里面的方法

        if(!$userAddress){
            $user->address()->save($data);//保存数据
        }else{
            $user->address->save($data);//更新数据
        }
        return json(new SuccessMessage(),201);
    }
}