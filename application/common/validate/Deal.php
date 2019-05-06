<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 11:32
 */

namespace app\common\validate;
use think\Validate;

class Deal extends Validate
{
    protected $rule = [
        'name' => 'require',
        'image' => 'image',
        'city_id' => 'require|integer',
        'se_city_id' => 'require|integer',
        'origin_price' => 'require|float',
        'current_price' => 'require|float',
        'total_count' => 'require|integer',
        'se_category_id' => 'array',
        'location_ids' => 'require|array',
        'start_time' => 'require|date',
        'end_time' => 'require|date',
        'coupons_begin_time' => 'date',
        'coupons_end_time' => 'date'
    ];

    protected $scene = [
        'add' => ['name', 'city_id', 'origin_price',
            'current_price', 'total_count', 'se_category_id', 'location_ids', 'start_time',
            'end_time', 'coupons_begin_time', 'coupons_end_time']
    ];
}