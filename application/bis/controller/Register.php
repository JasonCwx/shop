<?php
namespace app\bis\controller;
use think\Controller;

class Register extends Controller
{
    public function index()
    {
        //获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        return $this->fetch('', [
            'citys' => $citys,
            'categorys' => $categorys
        ]);
    }

    public function add()
    {
        if(!request()->isPost()){
            $this->error('请求错误!');
        }

        $data = input('post.');
        //校验数据
        $validate = Validate('Bis');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        //判断提交的用户是否已经存在
        $accountInfo = model('BisAccount')->get(['username' => $data['username']]);
        if($accountInfo){
            $this->error('该用户已存在,请重新填写用户信息!');
        }

        //商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . ',' . $data['se_city_id'],
            'logo' => $data['logo'],
            'lisence_logo' => $data['licence_logo'],
            'description' => empty($data['description'])? '': $data['description'],
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'owner' => $data['faren'],
            'owner_tel' => $data['faren_tel'],
            'email' => $data['email']
        ];
        $bisId = model('Bis')->add($bisData);

        //总店相关信息校验
        $validateLocation = Validate('BisLocation');
        if(!$validateLocation->scene('add')->check($data)){
            $this->error($validateLocation->getError());
        }

        //账户相关信息校验
        $validateAccount = Validate('BisAccount');
        if(!$validateAccount->scene('add')->check($data)){
            $this->error($validateAccount->getError());
        }



        //总店相关信息入库
        $data['cat'] = '';
        if(!empty($data['se_category_id'])){
            $data['cat'] = implode('|', $data['se_category_id']);
        }
        $locationData = [
            'bis_id' => $bisId,
            'name' => $data['name'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id']. ',' .$data['cat'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . ',' .$data['se_city_id'],
            'api_address' => $data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content'])? '': $data['content'],
            'is_main' => 1,//代表总店信息
        ];
        $locationId = model('BisLocation')->add($locationData);

        //账户相关信息入库
        //自动生成密码加严字符串
        $data['code'] = mt_rand(100, 10000);
        $accountDate = [
            'bis_id' => $bisId,
            'username' => $data['username'],
            'code' => $data['code'],
            'password' => md5($data['password'].$data['code']),
            'is_main' => 1,//代表总管理员
        ];

        $accountId = model('BisAccount')->add($accountDate);

        if(!$accountId){
            $this->error('申请失败！');
        }

        $url = request()->domain().url('bis/register/waiting', ['id' => $bisId]);

        $this->success('申请成功！', url('register/waiting', ['id'=>$bisId]));
    }

    public function waiting($id)
    {
        if(empty($id)){
            $this->error('error');
        }
        $detail = model('Bis')->get($id);
        return $this->fetch('', [
            'detail' => $detail
        ]);
    }
}