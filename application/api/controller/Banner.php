<?php

namespace app\api\controller;


use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerException;
use think\Controller;
use app\api\model\Banner as BannerModel;

class Banner extends Controller
{
    

    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     *
     */
    public function getBanner()
    {
        
        $id = input('get.id');
        (new IDMustBePositiveInt())->goCheck();
        $banner = new BannerModel();
        $data = $banner->getBannerByID($id);


        if(!$data){
            throw new BannerException();
        }else{
            return show(1,'获取数据成功',$data);
        }

    }


}