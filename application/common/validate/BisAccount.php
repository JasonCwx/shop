<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 14:58
 */

namespace app\common\validate;
use think\Validate;

class BisAccount extends Validate
{
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|min:8',
    ];

    //场景设置
    protected $scene = [
        'add' => ['username', 'code', 'password'],

    ];
}