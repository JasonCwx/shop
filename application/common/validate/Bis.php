<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 14:15
 */

namespace app\common\validate;
use think\Validate;

class Bis extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'email' => 'email',
        'logo' => 'require',
        'city_id' => 'require',
        'bank_info' => 'require',
        'bank_name' => 'require',
        'bank_user' => 'require',
        'faren' => 'require',
        'faren_tel' => 'require',
        'status' =>'require|in:-1,0,1,2',
        'id' => 'require',
    ];

    //场景设置
    protected $scene = [
        'add' => ['name', 'email', 'logo', 'city_id', 'bank_info',
            'bank_name', 'bank_user', 'faren', 'faren_tel'],
        'status' => ['id', 'status'],
    ];
}