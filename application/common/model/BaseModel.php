<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 15:22
 */

namespace app\common\model;
use think\Model;

//公共的model层
class BaseModel extends Model
{
    public function add($data)
    {
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }
}