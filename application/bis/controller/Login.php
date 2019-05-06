<?php
namespace app\bis\controller;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()){
            //处理登录逻辑
            //获取数据
            $data = input('post.');
            //通过用户名获取用户相关信息
            //严格判断
            $result = model('BisAccount')->get(['username' => $data['username']]);
            //判断用户是否存在，能否取出对应数据，并且判断是否已经通过审核
            if(!$result || $result->status != 1){
                $this->error('该用户不存在或用户未被审核通过！');
            }
            if($result->password != md5($data['password'].$result->code)){
                $this->error('密码错误！');
            }
            model('BisAccount')->updateById(['last_login'=>date('Y-m-d H:i:s')], $result->id);

            //保存当前登录的商户账号信息  bis为作用域 规定session只能在当前作用域生效
            session('bisAccount', $result, 'bis');

            return $this->success('登录成功！', url('index/index'));
        }else{
            //获取session
            $account = session('bisAccount', '', 'bis');
            if($account && $account->id){
                return $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }

    public function logout()
    {
        //清除session
        session(null, 'bis');
        return $this->redirect(url('login/index'));
    }
}