<?php

namespace app\api\controller;

use app\lib\exception\ThemeException;
use think\Controller;

use app\api\validate\ThemeValidate;
use app\api\model\Theme as ThemeModel;


class Theme extends Controller{
	//获取分类信息
	public function getTheme(){
		$id = input('get.id',1,'intval');
		(new ThemeValidate())->goCheck();
		$thememodel = ThemeModel::getTypeInfo($id);
		if(!$thememodel){
			throw new ThemeException();
		}else{
			return json(1,'获取相关数据',$thememodel);
		}

	}
}











