<?php

namespace app\api\service;

class Upload
{
    const that = [
        'topic_img' => 1,
        'main_img_url' => 2,
    ];

    const savePath = [
        self::that['topic_img'] => './uploads/',
        self::that['main_img_url'] => './uploads/'
    ];

    const size = [
        self::that['topic_img'] => 2*1024*1024,
        self::that['main_img_url'] => 2*1024*1024,
    ];

    const allowType = [
        self::that['topic_img'] => [
            'image/png','image/jpeg','image/jpg'
        ],
        self::that['main_img_url'] => [
            'image/png','image/jpeg','image/jpg'
        ],
    ];

    public static $files;

    public static function check($key)
    {
        $file = self::$files[$key];
        if( !in_array($file['type'],self::allowType[self::that[$key]]) ){
            return ['code' => 403,'msg' => '图片类型错误','data' => []];
        }
        if( $file['size'] > self::size[self::that[$key]] ){
            return ['code' => 403,'msg' => '图片超出指定大小','data' => []];
        }
        return ['code' => 200,'msg' => 'ok','data' => []];
    }

    public static function upload($files)
    {
        self::$files = $files;
        $dest = [];
        foreach ($files as $k=>$v){
            if( $v['error'] == 0 ){
                $check = self::check($k);
                if( $check['code'] != 200 ){
                    return $check;
                }
            }
        }

        foreach ($files as $k=>$v){
            $dir = self::savePath[self::that[$k]].date("Ym");
            $re_dir = str_replace('./','/',$dir);
            $fileName = '/'.md5($v['name'].rand(1000,9999));
            $ext = '.jpg';
            $dest[$k] = $dir.$fileName.$ext;
            move_uploaded_file($v['tmp_name'],$dest[$k]);
            $re_pic[$k] = $re_dir.$fileName.$ext;
        }

        return ['code' => 200,'msg' => '上传成功','data' => $re_pic];
    }

    public static function uploadBase64( $base64,$key = 'topic_img' )
    {

        $base64 = str_replace('data:image/jpeg;base64,','',$base64);
        $dir = self::savePath[self::that[$key]].date("Ym");
        $re_dir = str_replace('./','/',$dir);
        $fileName = '/'.md5(uniqid().rand(1000,9999));
        $ext = '.jpg';
        $dest = $fileName.$ext;
        file_put_contents($dir.$fileName.$ext,base64_decode($base64));
        $re_data = $re_dir.$dest;
        return ['code' => 200,'msg' => '上传成功','data' => $re_data];
    }

}