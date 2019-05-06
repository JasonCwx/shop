<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 14:53
 */

namespace app\common\validate;
use think\Validate;

class BisLocation extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'tel' => 'require',
        'contact' => 'require',
        'category_id' => 'require',
        'city_id' => 'require',
        'address' => 'require',
    ];

    //场景设置
    protected $scene = [
        'add' => ['name', 'tel', 'contact', 'category_id',
            'category_path', 'city_id', 'city_path', 'address'],

    ];
}