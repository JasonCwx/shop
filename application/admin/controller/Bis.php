<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 20:38
 */

namespace app\admin\controller;
use think\Controller;


class Bis extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Bis');
    }

    public function index()
    {
        $bis = $this->obj->getBisByStatus(1);
        return $this->fetch('', [
            'bis' => $bis
        ]);
    }

    //入驻申请列表
    public function apply()
    {
        $bisData = $this->obj->getBisByStatus();
        return  $this->fetch('', [
            'bisData' => $bisData
        ]);
    }

    public function dellist()
    {
        $bis = $this->obj->getBisByStatus(-1);
        return $this->fetch('', [
            'bis' => $bis
        ]);
    }

    public function detail()
    {
        //获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        //获取当前商户数据
        $id = input('get.id');
        if(empty($id)){
            $this->error('参数不合法！');
        }
        $bisData = model('Bis')->get($id);
        //总店信息  is_main为1
        $locationData = model('BisLocation')->get(['bis_id' => $id, 'is_main' => 1]);
        //总管理账号信息  is_main为1
        $accountData = model('BisAccount')->get(['bis_id' => $id, 'is_main' => 1]);
        return $this->fetch('', [
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData,
        ]);
    }

    public function status()
    {
        $data = input('get.');
        $validate = validate('Bis');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        $res = $this->obj->save(['status'=>$data['status']], ['id'=>$data['id']]);
        $location = model('BisLocation')->save(['status'=>$data['status']], ['id'=>$data['id']], ['is_main' => 1]);
        $account = model('BisAccount')->save(['status'=>$data['status']], ['id'=>$data['id']], ['is_main' => 1]);
        if($res && $location && $account){
            $this->success('更新状态成功！');
        }else{
            $this->error('更新状态失败！');
        }
    }
}