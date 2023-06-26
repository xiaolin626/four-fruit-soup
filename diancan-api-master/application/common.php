<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function array_only($array,$only){
    return array_intersect_key($array,array_flip((array) $only));
}

/**
 * @param $code
 * @param $data 可以是字符串，也可以是数组
 * @return json串
 */
if(!function_exists('_json'))
{
    function _json($code,$msg='操作失误',$data= ''){
        if(is_array($code)){
            if(!isset($code['data']))  $code['data'] = '';
            return json($code);
        }else{
            return json(array('code' => $code, 'msg' => $msg,'data'=>$data));
        }

    }
}

function ppd(){
    $arg_list = func_get_args(); //参数数组

    $numargs = func_num_args(); //参数数量

    echo "<pre>";
    for($i=0;$i<$numargs;$i++){
        print_r($arg_list[$i]);
        echo "</pre>";
        echo "<pre>";
    }
    echo "</pre>";
    die();
}
/**
 * 系统非常规MD5加密方法
 * @param $str
 * @param string $key
 * @return string
 */
function _sha1md5($str, $key = 'kevin'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function trace_log($log){
    //记录日志
    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $message = $url.'['.date('H:i:s',time()).']<br/>'.var_export($log,true).'<br/>';
    $dir = RUNTIME_PATH.'/tracelog/';
    if(!is_dir($dir)){
        mkdir($dir,0777,true);
    }
    $file = $dir.date('Y-m-d',time()).'.log';
    error_log($message, 3, $file);
}