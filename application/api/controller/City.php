<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 13:08
 */

namespace app\api\controller;
use think\Controller;

class City extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('City');
    }

    public function getSubCitys()
    {
        $id = input('post.id', 0, 'intval');
        if(!$id){
            $this->error('ID不合法');
        }
        $citys = $this->obj->getNormalCitysByParentId($id);
        if(!$citys){
            return show(0, 'error');
        }
        return show(1, 'success', $citys);
    }
}