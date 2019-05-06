<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29 0029
 * Time: 22:05
 */

namespace app\admin\validate;
use think\Validate;

class Category extends Validate
{
    protected  $rule = [
        ['name', 'require|max:10', '分类名称必须填写|最大长度不能超过10个字'],
        ['parent_id', 'number'],
        ['id', 'number'],
        ['status', 'number|in:-1,0,1', '状态类型设置出错|状态范围设置出错'],
        ['listorder', 'number']
    ];

    //场景设置
    protected $scene = [
        'add' => ['name', 'parent_id', 'id'],//对add场景做validate设置，只针对这两个字段
        'listorder' => ['id', 'listorder'],//排序时做validate设置，只针对这两个字段
        'status' => ['id', 'status']
    ];
}