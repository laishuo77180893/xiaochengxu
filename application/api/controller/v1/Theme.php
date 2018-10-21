<?php

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use app\api\validate\ThemeValidate;
use app\api\model\Theme as ThemeModel;


class Theme extends BaseController{

    /**
     * @url /theme?ids = id1,id2,id3,...
     * @return theme一组模型
     */
    public function getSimpleList($ids = ''){
        (new ThemeValidate())->goCheck();
        $ids =explode(',',$ids);
        $result = ThemeModel::getTopicImg($ids);
        if($result->isEmpty()){
            throw new ThemeException();
        }else{
            return $result;
        }
    }

    /**
     * @url /theme/:id
     * @param string $id
     * 获取主题分类商品和对应的顶部图片
     */
    public function getThemeOne($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $result = ThemeModel::getThemeProductAndHeadImg($id);
        if(!$result){
            throw new ThemeException([
                'msg' => '获取主题图片和商品信息不存在'
            ]);
        }else{
            return $result;
        }
    }



}











