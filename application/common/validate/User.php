<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 14:58
 */

namespace app\common\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'user_name' => 'require|max:25',
        'password' => 'require|min:6',
        're_password' => 'require|min:6',
        'email' => 'require|email',
    ];

    protected $scene = [
        'register' => ['user_name', 'password', 're_password', 'email'],
        'login' => ['user_name', 'password']
    ];
}