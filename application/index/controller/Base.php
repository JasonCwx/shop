<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/3 0003
 * Time: 14:43
 */

namespace app\index\controller;
use think\Controller;

class Base extends Controller
{

    public $city;
    public $account;

    public function _initialize()
    {
        //获取城市数据
        $citys = model('City')->getNormalCitysByParentId();
        $this->getCitys($citys);
        //获取用户数据
        $this->assign('user', $this->getUserSession());
        $this->assign('citys', $citys);
        $this->assign('city', $this->city);

        //获取首页分类数据
        $cates = $this->getRecommendCates();
        $this->assign('cates', $cates);
    }

    public function getCitys($citys)
    {
        $default_uname = '';
        foreach($citys as $city){
            $city = $city->toArray();
            if($city['is_default'] == 1){
                $default_uname = $city['uname'];
                break;
            }
        }

        $default_uname = $default_uname ? $default_uname: 'guangzhou';
        if(session('city_uname', '', 'index') && !input('get.city')){
            $city_uname = session('city_uname', '', 'index');
        }else{
            $city_uname = input('get.city', $default_uname, 'trim');
            session('city_uname', $city_uname, 'index');
        }

        $this->city = model('City')->where(['uname'=>$city_uname])->find();
    }

    public function getUserSession()
    {
        //获取session  优化  避免函数调用多次  实例化调用一次  使用的时候又调用一次
        if(!$this->account){
            $this->account = session('user', '', 'index');
        }
        return $this->account;
    }

    //获取首页推荐当中的商品分类数据
    public function getRecommendCates()
    {
        $parentIds = [];
        $subCateArr = [];
        $firstCateArr = [];
        $cates = model('Category')->getNormalRecommendCateByParentId(0, 5);

        foreach($cates as $cate){
            $parentIds[] = $cate->id;

        }
        //获取二级分类数据
        $sub_cates = model('Category')->getNormalCateIdByParentId($parentIds);

        foreach($sub_cates as $sub_cate){
            $subCateArr[$sub_cate->parent_id][] = [
                'id' => $sub_cate->id,
                'name' => $sub_cate->name,
            ];
        }

        foreach($cates as $cate){
            $firstCateArr[$cate->id] = [
                $cate->name,
                empty($subCateArr[$cate->id])? []:$subCateArr[$cate->id]
            ];
        }
        return $firstCateArr;
    }
}