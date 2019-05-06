<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 13:23
 */

namespace app\api\controller;
use think\Controller;

class Category extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Category');
    }

    public function getSubCates()
    {
        $id = input('post.id', 0, 'intval');
        if(!$id){
            $this->error('ID不合法');
        }
        $cates = $this->obj->getNormalCategorysByParentId($id);
        if(!$cates){
            return show(0, 'error');
        }
        return show(1, 'success', $cates);
    }
}