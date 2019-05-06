<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 14:44
 */

namespace app\common\model;

class BisLocation extends BaseModel
{
    public function getNormalLocations($id, $flag)
    {
        $data = [
            'bis_id' => $id,
            'status' => ['neq', '-1']
        ];

        $order = [
            'create_time' => 'desc'
        ];

        if($flag){
            return $this->where($data)->order($order)->paginate();
        }else{
            return $this->where($data)->order($order)->select();
        }


    }
}