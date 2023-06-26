<?php
/**
 * Author: kevin
 * Date: 2017/2/23
 * Time: 2:56
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User;
use app\api\model\UserAddress;
use app\api\service\UserToken as UserTokenService;
use app\api\service\Token;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use app\lib\exception\MissException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\lib\exception\BaseException;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use think\Controller;
use think\Exception;

class Userinfo extends BaseController
{
	protected $code;
	protected $wxAppID;
	protected $wxAppSecret;
	
    protected $beforeActionList = [
		
        'checkPrimaryScope' => ['only' => 'getUserinfotoken']
    ];
    /**
     * 获取信息
     * @return UserAddress
     * @throws UserException
     */
    public function getUserinfo($id){
        $uid = $id;
        $user = User::where('mobile', $uid)->find();
        if(!$user){throw new UserException([
               'msg' => '用户不存在',
                'errorCode' => 60001]);}return $user;
    }
	public function getUserinfotoken(){
		$uid = Token::getCurrentUid();
	    $user = User::where('id', $uid)->find();
	    if(!$user){throw new UserException([
	           'msg' => '用户不存在',
	            'errorCode' => 60001]);}return $user;
	}
	public function getUserphone($callphone)
	{
		$uid = $callphone;
		$user = User::where('id', $uid)->value('mobile');
		if(!$user){throw new UserException([
		       'msg' => '用户不存在',
		        'errorCode' => 60001]);}return $user;
	}
	
	public function editUserinfo(){
		$uid = Token::getCurrentUid();
		$nickname=input('nickname');
		$password=input('password');
		if($nickname='')
		{
			throw new UserException([
	
			   'msg' => '修改账号不能为空',
			    'errorCode' => 10001
			]);
		}
		else if($password='')
		{
			throw new UserException([
			
			   'msg' => '修改密码不能为空',
			    'errorCode' => 10002
			]);
		}
		else
		{
		$nickname=input('nickname');
		$password=input('password');
		$sex=input('sex');
		$mobile=input('mobile');
		$dmobile=User::where('mobile',$mobile)
					->select('mobile');
		$did=User::where('id',$uid)
					->select('mobile');
		if(!empty($dmobile)&&$did!=$dmobile)
		{
			throw new UserException([
			   'msg' => '您的手机号就是这个',
			    'errorCode' => 70001
			]);
		}
		else{
			
			$user = User::where('id', $uid)
			    ->find();
			
			
			$user->nickname = $nickname;
			$user->password=\md5($password);
			$user->sex=$sex;
			$user->mobile = $mobile;
			$user->save();
			
		}
		}
		
		
	}
	public function createUser($usr,$password,$openid)
	{
	$mobile = $usr;
	$password = $password;
	$openids = $openid;
	$usermobile=User::where('mobile',$mobile)
				->find();
	$dopenid=User::where('openid',$openid)
				->find();
	if(!empty($usermobile))
	{throw new UserException([
		   'msg' => '用户已存在',
		    'errorCode' => 70001]);}
	else if(!empty($dopenid)){throw new UserException([
		   'msg' => '同一微信号不能注册两个账号',
		    'errorCode' => 90001]);}
	else{
	$user = User::create([
			'openid'     => $openids,
			'mobile'     => $mobile,
			'password'   => md5($password),
			'role' =>   0,
	        'headimgurl' => '',
	        'nickname'   =>  '',
	        'sex'        =>  0,]);}}
  
}