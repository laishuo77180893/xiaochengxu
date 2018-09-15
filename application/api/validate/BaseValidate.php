<?php 

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Validate;
use think\Request;



class BaseValidate extends Validate{


    public function goCheck()
    {
        /**
         * 获取http传入参数
         * 对参数进行校验
         */
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        }else {
            return true;
        }
    }

    /** 正整数验证
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

    protected function isNotEmpty($value, $rule='', $data='', $field=''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
}
















 ?>