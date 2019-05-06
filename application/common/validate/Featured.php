<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 13:48
 */

namespace app\common\validate;
use think\Validate;

class Featured extends Validate
{
    protected $rule = [
        'type' => 'require|integer',
        'title' => 'require|max:30',
        'url' => 'require',
        'image' => 'require'
    ];

    protected $scene = [
        'add' => ['type', 'title', 'url', 'image']
    ];
}