<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 14:50
 */

namespace app\common\model;

class BisAccount extends BaseModel
{
    public function updateById($data, $id)
    {
        //过滤数组中不是数据表字段的数据
        return $this->allowField(true)->save($data, ['id'=>$id]);
    }
}