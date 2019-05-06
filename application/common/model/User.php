<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 15:07
 */

namespace app\common\model;


class User extends BaseModel
{
    public function add($data)
    {
        if(!is_array($data)){
            exception('传递了非指定数据导致错误!');
        }
        $data['status'] = 1;
        return $this->data($data)->allowField(true)->save();
    }

    public function getUserByUsername($username)
    {
        if(!$username){
            exception('非法用户名!');
        }
        $data = [
            'username' => $username
        ];
        return $this->where($data)->find();
    }

    public function updateById($data, $id)
    {
        return $this->allowField(true)->save($data, ['id'=>$id]);
    }
}