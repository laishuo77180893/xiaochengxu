<?php

namespace app\api\controller\v1;



use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerException;

class Banner extends BaseController
{
    

    /**
     * 获取指定id的banner信息
     * @url api/:version/banner
     * @http GET
     */
    public function getBanner($id)
    {

        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        $banner = BannerModel::getBannerById($id);
//        隐藏模型字段 unset hidden visible
//        $banner->hidden(['update_time','delete_time']);
        if (!$banner) {
            throw new BannerException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
        }
        return $banner;

    }


}