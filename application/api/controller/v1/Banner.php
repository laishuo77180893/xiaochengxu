<?php

namespace app\api\controller\v1;



use app\lib\exception\BannerException;
use app\api\model\Banner as BannerModel;

class Banner extends BaseController
{
    

    /**
     * 获取指定id的banner信息
     * @url api/:version/banner
     * @http GET
     */
    public function getBanner()
    {
        $banner = new BannerModel();
        $data = $banner->getBannerInfo();

        if(!$data){
            throw new BannerException();
        }else{
            return show(1,'获取数据成功',$data);
        }

    }


}