<?php
/**
 * User : kevin.liu
 * Date : 2021/10/14 0014 下午 11:57
 * QQ : 791845283@qq.com
 * Descript :
 */
namespace app\admin\controller;
use think\Controller;
class Upfortxtfiles extends Controller
{
   public function index()
   {
       return view('upload_file');
   }
	public function uploadTxt(){
        //获取上传文件表单名
        $fileKey = array_keys(request()->file());

        //获取表单上传的文件
        $file = request()->file($fileKey['0']);

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH.'public'.DS.'uploads');
        if($info){

            $result['code'] = 200;
            $result['msg'] = '上传成功！';
            $path = str_replace('\\','/',$info->getSaveName());
            $result['url'] = '/uploads/'.$path;
            $result['path'] = '/uploads/'.$path;
            $result['savename'] = $info->getSaveName();
            $result['filename'] = $info->getFilename();
            $result['info'] = $info->getInfo();
        }else{
            $result['code'] = 0;
            $result['msg'] = $file->getError();
            $result['url'] = '';
        }
        return json_encode($result);
    }
}