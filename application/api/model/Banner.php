<?php 

namespace app\api\model;



class Banner extends BaseModel{
	
	protected $hidden = ['delete_time','update_time','description','listorder','from'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
    /**
     * @param $id int banner所在位置
     * @return Banner
     */
    public static function getBannerById($id)
    {
        //TODO: 根据Banner ID号 获取Banner信息（关联items和img）
        $banner = self::with(['items','items.img'])
            ->find($id);
        return $banner;
    }
}



















 ?>