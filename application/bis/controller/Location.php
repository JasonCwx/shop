<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 23:21
 */

namespace app\bis\controller;


class Location extends Base
{
    private $bisId;
    public function _initialize()
    {
        //获取商户ID信息
        $this->bisId = $this->getUserSession()->bis_id;
    }
    public function index()
    {
        $locations = model('BisLocation')->getNormalLocations($this->bisId, true);
        return $this->fetch('', [
            'locations' => $locations
        ]);
    }

    public function add()
    {
        //获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        if(request()->isPost()){
            //获取信息
            $data = input('post.');

            //总店信息校验
            $validateLocation = Validate('BisLocation');
            if(!$validateLocation->scene('add')->check($data)){
                $this->error($validateLocation->getError());
            }

            //门店数据入库操作
            $data['cat'] = '';
            if(!empty($data['se_category_id'])){
                $data['cat'] = implode(',', $data['se_category_id']);
            }

            $locationData = [
                'bis_id' => $this->bisId,
                'name' => $data['name'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id']. ',' .$data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . ',' .$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content'])? '': $data['content'],
                'is_main' => 0,//是否是总店
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId){
                return $this->success('门店申请成功!');
            }else{
                return $this->error('门店申请失败！');
            }
        }else{
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys
            ]);
        }
    }
}