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
        if(!$result){
            throw new ThemeException();
        }else{
            return show(1,'数据返回成功',$result);
        }
    }

    /**
     * @url /theme/:id
     * @param string $id
     *
     */
    public function getThemeOne($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $result = ThemeModel::getThemeProductAndHeadImg($id);
        if(!$result){
            throw new ThemeException([
                'msg' => '获取主题蹄片和商品信息不存在'
            ]);
        }else{
            return show(1,'数据加载成功',$result);
        }
    }



}











