<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29 0029
 * Time: 21:58
 */

namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Category');
    }

    public function index()
    {
        $parentId = input('get.parent_id', 0, 'intval');
        $firstCategorys = $this->obj->getFirstCates($parentId);
        return $this->fetch('', [
            'firstCates' => $firstCategorys
        ]);
    }

    public function add()
    {
        $firstCategorys = $this->obj->getNormalFirstCategory();
        return $this->fetch('', [
            'firstCates' => $firstCategorys
        ]);
    }

    public function save()
    {

        //做严格判断是否POST提交的数据
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = input('post.');
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        //如果存在ID值
        if(!empty($data['id'])){
            return $this->update($data);
        }

        //把data提交给model
        $res = $this->obj->add($data);
        if($res){
            $this->success('添加分类成功！');
        }else{
            $this->error('添加分类失败！');
        }
    }

    public function edit($id=0)
    {
        if(intval($id) <= 0){
            $this->error('参数不合法！');
        }

        $category = $this->obj->get($id);
        $firstCategorys = $this->obj->getNormalFirstCategory();
        return $this->fetch('', [
            'category' => $category,
            'firstCates' => $firstCategorys
        ]);
    }

    public function update($data)
    {
        $res = $this->obj->save($data, ['id' => intval($data['id'])]);
        if($res){
            $this->success('更新分类信息成功！');
        }else{
            $this->error('更新分类信息失败！');
        }
    }

    public function listorder($id, $listorder)
    {
        $res = $this->obj->save(['listorder'=>$listorder], ['id'=>$id]);
        if($res){
            $this->result($_SERVER['HTTP_REFERER'], 1, 'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'], 0, 'fail');
        }
    }

    public function status()
    {
        $data = input('get.');
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        $res = $this->obj->save(['status'=>$data['status']], ['id'=>$data['id']]);
        if($res){
            $this->success('更新状态成功！');
        }else{
            $this->error('更新状态失败！');
        }
    }
}