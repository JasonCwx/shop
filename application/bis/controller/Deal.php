<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 11:03
 */

namespace app\bis\controller;


class Deal extends Base
{
    public function index()
    {
        $deals = model('Deal')->getNormalDeals();
        return $this->fetch('', [
            'deals' => $deals
        ]);
    }

    public function add()
    {

        $bisId = $this->getUserSession()->id;
        //获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        if(request()->isPost()){
            //团购商品入库操作
            $data = input('post.');
            //校验数据
            $validate = validate('Deal');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }else{

                //入库操作
                $dealData = [
                    'name' => $data['name'],
                    'city_id' => $data['city_id'],
                    'category_id' => $data['category_id'],
                    'se_category_id' => empty($data['se_category_id'])? 0 : $data['se_category_id'],
                    'bis_id' => $bisId,
                    'location_ids' => empty($data['location_ids'])? '' : implode(',', $data['location_ids']),
                    'image' => $data['image'],
                    'description' => $data['description'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'origin_price' => $data['origin_price'],
                    'current_price' => $data['current_price'],
                    'total_count' => $data['total_count'],
                    'coupons_begin_time' => $data['coupons_begin_time'],
                    'coupons_end_time' => $data['coupons_end_time'],
                    'bis_account_id' => $this->getUserSession()->id,
                    'notes' => $data['notes'],
                ];
                $dealId = model('Deal')->add($dealData);
                if($dealId){
                    return $this->success('添加商品成功！', url('deal/index'));
                }else{
                    return $this->error('添加商品失败！');
                }
            }
        }else{
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
                'locations' => model('BisLocation')->getNormalLocations($bisId, false)
            ]);
        }
    }
}