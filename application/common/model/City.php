<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 12:24
 */

namespace app\common\model;
use think\Model;

class City extends Model
{
    public function getNormalCitysByParentId($parentId=0)
    {
        $data = [
            'status' => 1,
            'parent_id' => $parentId,
        ];

        $order = [
            'create_time' => 'desc',
        ];

        return $this->where($data)
            ->order($order)
            ->select();
    }
}