<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    public function __construct(){
        parent::__construct();
        //判断是否管理员登录
        if(!session('aid')){
            $this->redirect('login/index');
        }
    }
}