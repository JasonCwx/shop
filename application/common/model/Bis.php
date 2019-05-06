<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 14:29
 */

namespace app\common\model;

class Bis extends BaseModel
{
    //根据状态获取商家申请数据
    public function getBisByStatus($status=0)
    {
        $order = [
            'create_time' => 'desc'
        ];

        $data = [
            'status' => $status
        ];

        return $this->where($data)->order($order)->paginate();
    }
}