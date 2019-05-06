<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 23:07
 */

namespace app\bis\controller;
use think\Controller;

class Base extends Controller
{
    public $account;
    public function _initialize()
    {
        //判断用户是否登录
        $is_login = $this->isLogin();
        if(!$is_login){
            return $this->redirect(url('login/index'));
        }
    }

    public function isLogin()
    {
        $user = $this->getUserSession();
        if($user){
            return true;
        }

        return false;
    }

    public function getUserSession()
    {
        //获取session  优化  避免函数调用多次  实例化调用一次  使用的时候又调用一次
        if(!$this->account){
            $this->account = session('bisAccount', '', 'bis');

        }
        return $this->account;
    }
}