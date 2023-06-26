<?php
namespace app\index\controller;

use think\Controller;

class ShowLog extends Controller
{
    public function index()
    {
        $show_log_path = RUNTIME_PATH.'tracelog/*.log';
        $data = glob($show_log_path);
        if(!empty($data)){
            foreach ($data as &$item){
                $item = pathinfo($item,PATHINFO_FILENAME);
            }
        }

        trace_log('11111');
        $this->assign('data',$data);
        return view();

    }

    public function read(){
       $file = input('file');
       if(empty($file)){
           ppd('参数必传');
       }
       if(request()->isPost()){
           $show_log_path = RUNTIME_PATH."tracelog/{$file}.log";
           $content = file_get_contents($show_log_path);
           return _json(200,$content);
       }

       $this->assign('file',$file);
        return view();
    }
}
