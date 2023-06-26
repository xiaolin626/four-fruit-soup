<?php
/**
 * Author: kevin
 * Date: 2017/2/23
 * Time: 2:56
 */

namespace app\api\controller\v1;

use think\File;
use app\api\controller\BaseController;
use app\api\model\Application;
use app\api\model\User;
use app\api\model\UserAddress;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;
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

class Img extends BaseController
{
	
	// 上传图片
	 public function uploadimg()
	 {
	 $data = $_POST;
	$data['images'] =request()->file('images');
	 
	         
	//获取file对象
	$file =  $data['images']; 
	//文件信息验证与上传到服务器指定目录
	$info = $file->validate([
	             'size'=>5000000,  //文件大小
	             'ext'=>'jpg,jpeg,png,gif'  //文件拓展名
	])->move('uploads/weixin/');  //移动到public/uploads目录下
	 
	         //错误就报错
	if($info==false){
	 return ['status'=>-1,'message'=>$file->getError()];
	} 
	else
	{
	$file = $info->getSaveName();
	$res = ['errCode'=>0,'errMsg'=>'图片上传成功','file'=>$file];
	    return json($res); 
	}
	
}
public function askagain()
{
	$id=input('user_id');
	$bdelete =Application::where('id',$id)->delete();
	$user = User::where('id', $id)
	    ->find();
	$user->astatus = 0;
	$user->save();
}
// 上传图片
	 public function uploadtxt()
	 { 
	 $data = $_POST;
	$data['file'] =request()->file('file');	 
	//获取file对象
	$file =  $data['file'];
	$cArr=\str_replace(" ",'',$file);
	\var_dump($cArr);
	foreach($file as $Key=>$val){
	//分成的一维数组每遇到逗号’，‘自动划分
	$val=\explode('，',$val);
	//查询数据库是否有该值
	$bname=ProductModel::where('name',trim($val[0]))
				->find();
	if(!empty($bname)){continue;}
	else {
	if(!empty($val))
	{$data = [
	        'name' => trim($val[0]),
	        'price' =>trim($val[1]) ,
			'stock' =>trim($val[2]),
			'category_id'=>trim($val[3])
	];
	//插入数据库
	$inser = ProductModel::name('product')->insert($data);}              
	}
	}
	}
	
	
	

	
public function dispatcheruploadsubmit()
{
		 
		 $id=input('user_id');
		 $realname=input('name');
		 $mobile=input('phone');
		 $idfront=input('idfront');
		 $idback=input('idback');
		 $application = Application::create(
		     [
		 		'id'     => $id,
		 		'realname' => $realname,
		 		'mobile'   => $mobile,
		 		'idfront'=>$idfront,
				'idback'=>$idback
		     ]);
		 //把数据传到img表中
        //同时修改user表中审核状态
	   $user = User::where('id', $id)
	       ->find();
	   $user->astatus = 1;
	   $user->save();
		  
	 }
  
  public function boosuploadsubmit()
  	 {
  		 
  		 $id=input('user_id');
  		 		 $realname=input('name');
  		 		 $mobile=input('phone');
  		 		 $idfront=input('idfront');
  		 		 $idback=\input('idback');
				 $bslincense=input('bslicense');
  		 		 $application = Application::create(
  		 		     [
  		 		 		'id'     => $id,
  		 		 		'realname' => $realname,
  		 		 		'mobile'   => $mobile,
  		 		 		'idfront'=>$idfront,
  		 				'idback'=>$idback,
						'Bslicense'=>$bslincense
  		 		     ]);
  		 		 //把数据传到img表中
  		  //同时修改user表中审核状态
  		 $user = User::where('id', $id)
  		     ->find();
  		 $user->astatus = 1;
  		 $user->save();
  		 		  
  		  
  	 }
    }