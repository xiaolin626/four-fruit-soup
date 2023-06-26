<?php
/**
 * User : kevin.liu
 * Date : 2019/8/18 0018 下午 5:37
 * QQ ： 791845283@qq.com
 * wechat : hanyi7918
 * Descript:
 */

namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;

class Login extends Controller
{
    public function index(){
        $url = request()->domain();
        $this->assign('url',$url);
//        echo _sha1md5(123456);
        return view();
    }

    public function login(){
        $data = input('post.');
        //验证 验证码
        $captcha = new Captcha();
        $res =  $captcha->check($data['vercode']);
        if(!$res)
            return _json(0,'验证码错误！');
        //验证用户信息 并设置 session
        $admin = db('admin')->where('username',$data['username'])->find();
        if(empty($admin))
            return _json(0,'该用户不存在！');

        if($admin['is_use'] == 0)
            return _json(0,'该用户已禁用！');

        if($admin['pwd'] != _sha1md5($data['pwd'])){
            return _json(0,'密码错误！');
        }
        //记录session信息
        session('username',$admin['username']);
        session('aid',$admin['id']);
        session('admin_info',$admin);
		if($admin['group_id']==0)
		{
        return _json(200,'登录成功');
		}
		else if($admin['group_id']==1)
		{
			return _json(300,'登录成功');
		}
    }

    public function logout(){
        session(null);
        $this->redirect('login/index');
    }
}