<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function status($status)
{
    if($status == 1){
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif($status == 0){
        $str = "<span class='label label-danger radius'>待审</span>";
    }else{
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

//商户入驻申请的文案
function bisRegister($status)
{
    if($status == 1){
        $str = '入驻申请成功！';
    }elseif($status == 0){
        $str = '入驻申请待审核。。。成功后会发送邮件，请注意查收!';
    }elseif($status == 2){
        $str = '非常抱歉，您提交的资料不符合条件，请重新提交资料!';
    }else{
        $str = '该申请已被删除。。。';
    }
    return $str;
}

//公用分页样式
function pagination($obj)
{
    if(!$obj){
        return '';
    }

    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-shop">'.$obj->render().'</div>';
}

function getSubCityName($path)
{
    if(empty($path)){
        return '';
    }

    if(preg_match('/,/', $path)){
        $cityPath = explode(',', $path);
        $subCityId = $cityPath[1];
    }else{
        $subCityId = $path;
    }

    return model('City')->get($subCityId)->name;
}

//获取子目录数据，只获取商户选择的子分类
function getSubCateName($path)
{
    if(empty($path)){
        return '';
    }
    $str = "";
    if(preg_match('/,/', $path)){
        $catePath = explode(',', $path);
        //将数组第一个元素除去就是子目录的id
        array_shift($catePath);
        foreach($catePath as $cateId){
            $cateName = model('Category')->get($cateId)->name;
            $str .= "<input name='se_category_id[]' type='checkbox' checked='checked' id='checkbox-moban' value=''>".$cateName;
            $str .= "<label for='checkbox-moban'>&nbsp;</label>";
        }
    }

    return $str;
}
