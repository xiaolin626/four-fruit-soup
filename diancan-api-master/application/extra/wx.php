<?php
/**
 * Created by 七月
 * Author: 七月
 * 微信公号: 小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/22
 * Time: 13:49
 */

return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------

    // 小程序app_id
//    'app_id' => 'wx2b9672247683ed70',  //wx3fca350c954ae1a1
//    'app_secret' => 'dfd3020fabf0e1e9b64b02d34897be10',//7f3c7de3d36aff5fbdf443d97406db9d

    'app_id' => 'wx2b9672247683ed70',  //wx3fca350c954ae1a1
    'app_secret' => 'dfd3020fabf0e1e9b64b02d34897be10',//7f3c7de3d36aff5fbdf443d97406db9d

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",

    //微信通过access_token获取个人信息
    'user_info_url' => 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN' ,

    'img_prefix'=>''.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'] ,

    'pay_back_url'=> $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/api/v1/pay/redirectNotify/'

];
