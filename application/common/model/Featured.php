<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 13:36
 */

namespace app\common\model;


class Featured extends BaseModel
{

    public function getNormalFeaturedByType($type)
    {
        $data = [
            'status' => ['neq', -1],
            'type' => $type
        ];

        $order = [
            'create_time' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate();
    }

    public function getNormalFeatureds($type)
    {
        $data = [
            'status' => ['neq', -1],
            'type' => $type
        ];

        $order = [
            'create_time' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }
}