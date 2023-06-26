<?php
/**
 * User : kevin.liu
 * Date : 2021/10/14 0014 下午 11:57
 * QQ : 791845283@qq.com
 * Descript :
 */
namespace app\admin\controller;
use think\Controller;
class Upfiles extends Controller
{
    public function upload(){
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

    public function uploadEditor(){
        //获取上传文件表单名
        $fileKey = array_keys(request()->file());

        //获取表单上传的文件
        $file = request()->file($fileKey['0']);

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH.'public'.DS.'uploads');
        if($info){
            $path = str_replace('\\','/',$info->getSaveName());
            $data = $info->getInfo();
            $result['originalName'] = $data['name'];
            $result['title'] = $data['name'];
            $result['original'] = $data['name'];
            $result['name'] = $data['name'];
            $result['url'] = '/uploads/'.$path;
            $result['size'] = $data['size'];
            $result['type'] = $data['type'];
            $result['state'] = 'SUCCESS';

        }else{
            $path = str_replace('\\','/',$info->getSaveName());
            $data = $info->getInfo();
            $result['originalName'] = $data['name'];
            $result['name'] = $data['name'];
            $result['url'] = '/uploads/'.$path;
            $result['size'] = $data['size'];
            $result['type'] = $data['type'];
            $result['state'] = $file->getError();
        }
        return json_encode($result,true);
    }

    public function layedit(){
        $file =  request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $result = $file->move(ROOT_PATH.'public'.DS.'uploads');
        if($result){
            $path = str_replace('\\','/',$result->getSaveName());

            $re_data = array(
                'src' => '/uploads/'.$path,
                'title'=> $result->getSaveName()
            );
            $data = array('code'=>0,'msg'=>'上传成功','data'=>$re_data);
        }else{
            $data = array('code'=>1,'msg'=>$result->getError());
        }
        return json_encode($data);
    }
}