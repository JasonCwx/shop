<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29 0029
 * Time: 21:46
 */

namespace app\index\controller;
use think\Controller;
use think\Exception;

class User extends Controller
{
    public function login()
    {
        if(session('user', '', 'index')){
            $this->redirect(url('index/index'));
        }
        return $this->fetch();
    }

    public function register()
    {
        if(request()->isPost()){
            $data = input('post.');
            if(!captcha_check($data['verify_code'])){
                //验证码校验失败
                $this->error('验证码错误!');
            }
            //判断两次密码输入是否一致
            if($data['password'] != $data['re_password']){
                $this->error('两次密码输入不一致!');
            }

            //判断用户名和邮箱是否存在
            $usernameData = model('User')->get(['username'=>$data['user_name']]);
            $emailData = model('User')->get(['email'=>$data['email']]);
            if($usernameData){
                $this->error('该用户名已被使用，请重新输入一个!');
            }
            if($emailData){
                $this->error('该邮箱已被注册，请重新输入一个!');
            }

            //校验数据信息
            $validate = validate('User');
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }

            //操作数据入库
            $data['code'] = mt_rand(100, 1000);
            $password = md5($data['password'] .$data['code']);
            $userData = [
                'username' => $data['user_name'],
                'password' => $password,
                'email' => $data['email'],
                'code' => $data['code']
            ];
            try{
                $userId = model('User')->add($userData);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if($userId){
                return $this->success('注册成功！', url('user/login'));
            }else{
                return $this->error('注册失败！');
            }
        }else{
            return $this->fetch();
        }
    }

    public function loginCheck()
    {
        if(!request()->isPost()){
            $this->error('非法提交方式!');
        }

        //获取数据
        $data = input('post.');
        //校验数据
        $validate = validate('User');
        if(!$validate->scene('login')->check($data)){
            $this->error($validate->getError());
        }
        //查询数据是否匹配
        try{
            $user = model('User')->getUserByUsername($data['user_name']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }

        if(!$user || $user->status != 1){
            $this->error('该用户不存在或者未被激活！');
        }

        //判断用户输入的密码是否匹配
        if(md5($data['password'].$user->code) != $user->password){
            $this->error('密码错误！');
        }

        //登录成功  写入session
        model('User')->updateById(['last_login' => date('Y-m-d H:i:s')], $user->id);
        session('user', $user, 'index');
        $this->success('登录成功!', url('index/index'));
    }

    public function logout()
    {
        session('user', null, 'index');
        $this->redirect(url('user/login'));
    }
}