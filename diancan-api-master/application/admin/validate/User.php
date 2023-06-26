<?php
/**
 * User : kevin.liu
 * Date : 2019/8/18 0018 下午 1:21
 * QQ ： 791845283@qq.com
 * Descript:
 */
namespace app\user\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        ['nickname', 'require|min:5', '用户名不能为空|用户名不能短于5个字符'],
        ['password', 'require|min:5', '密码不能为空|密码不能短于5个字符'],
        ['mobile', 'require|checkMobile', '手机不能为空|手机必须是11位']
    ];

    public function checkMobile($val){
        if(strlen($val)!= 11){
            return '手机必须是11位';
        }else{
            return true;
        }
    }
}