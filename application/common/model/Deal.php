<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 12:09
 */

namespace app\common\model;


class Deal extends BaseModel
{
    public function getNormalDeals()
    {
        $data = [
            'status' => ['neq', -1]
        ];

        $order = [
            'create_time' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate();
    }
}