<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{
    public function add($data)
    {
        $data['status'] = 1;
        return $this->save($data);
    }

    public function getNormalFirstCategory()
    {
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];

        $order = [
            'create_time' => 'desc',
        ];

        return $this->where($data)
            ->order($order)
            ->select();
    }

    public function getFirstCates($parentId = 0)
    {
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq', -1]
        ];

        $order = [
            'listorder' => 'desc',
            'create_time' => 'desc'
        ];

        $result = $this->where($data)
            ->order($order)
            ->paginate();

        //echo $this->getLastSql();

        return $result;
    }

    public function getNormalCategorysByParentId($parentId=0)
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

    public function getNormalRecommendCateByParentId($id=0, $count=5)
    {
        $data = [
            'parent_id' => $id,
            'status' => 1
        ];

        $order = [
            'create_time' => 'asc',
            'id' => 'asc'
        ];

        $result = $this->where($data)->order($order);
        if($count)
        {
            $result->limit($count);
        }
        return $result->select();
    }

    public function getNormalCateIdByParentId($ids)
    {
        $data = [
            'parent_id' => ['in', implode(',', $ids)],
            'status' => 1
        ];

        $order = [
            'create_time' => 'asc',
            'id' => 'asc'
        ];

        return $this->where($data)->order($order)->select();

    }
}