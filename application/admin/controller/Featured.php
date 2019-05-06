<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 13:34
 */

namespace app\admin\controller;
use think\Controller;

class Featured extends Controller
{
    private $obj;

    public function _initialize()
    {
        $this->obj = model('Featured');
    }

    public function index()
    {
        //获取推荐位的配置信息
        $types = config('featured.featured_type');
        $data = input('get.type', 0, 'intval');
        $featureds = $this->obj->getNormalFeaturedByType($data);
        return $this->fetch('', [
            'featureds' => $featureds,
            'types' => $types,
            'type' => $data
        ]);
    }

    public function add()
    {
        //获取推荐位的配置信息
        $types = config('featured.featured_type');
        if(request()->isPost()){
            //获取对应数据 入库操作
            $data = input('post.');
            $validate = validate('Featured');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $featuredData = [
                'type' => $data['type'],
                'title' => $data['title'],
                'image' => $data['image'],
                'url' => $data['url'],
                'description' => $data['description']
            ];
            $featuredId = $this->obj->add($featuredData);
            if($featuredId){
                return $this->success('添加推荐位成功！', url('featured/index'));
            }else{
                return $this->error('添加推荐位失败！');
            }
        }else{
            return $this->fetch('', [
                'types' => $types
            ]);
        }
    }

    public function search()
    {
        if(request()->isGet()){
            $data = input('get.type');
            $featureds = $this->obj->getNormalFeaturedByType($data);
            return $this->redirect('featured/index', ['featureds' => $featureds]);
        }else{
            return $this->redirect('featured/index');
        }
    }
}