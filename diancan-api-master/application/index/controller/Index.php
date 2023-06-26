<?php
/**
 * User : kevin.liu
 * Date : 2019/8/18 0018 下午 11:27
 * QQ : 791845283@qq.com
 * Descript :
 */
namespace app\index\controller;

use think\Controller;

class Index extends  Controller
{
    public function index(){

        //异步回调通知
        $content=file_get_contents('php://input');
        if(!empty($content)){
            $dir = RUNTIME_PATH.'/tracelog/';
            if(!is_dir($dir)){
                mkdir($dir,0777,true);
            }
            $file = $dir."call.log";
            file_put_contents($file,$content."\n",FILE_APPEND);
        }

        $this->redirect('admin/index/index');
    }
}
