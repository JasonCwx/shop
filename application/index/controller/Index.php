<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        //获取首页推荐位数据

        $bigFeatureds = model('Featured')->getNormalFeatureds(0);
        $rightFeatureds = model('Featured')->getNormalFeatureds(1);
        return $this->fetch('', [
            'bigFeatureds' => $bigFeatureds,
            'rightFeatureds' => $rightFeatureds
        ]);
    }
}
