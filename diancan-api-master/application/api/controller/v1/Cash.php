<?php
/**
 * User: kevin
 * Date: 2017/2/15
 * Time: 13:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Cash as Cashmodel;
use app\api\model\User;

use think\Controller;
use think\Exception;

/**
 * Cash资源
 */ 
class Cash extends BaseController
{

    public function moneyApply()
    {
		$mobile=input('mobile');
		$money=input('money');
		$id=input('id');
		$cash_order=$this->makeOrderNo();
		if($cash_order)
		{
		$cash = Cashmodel::create(
		    [
				'cash_order' => $cash_order,
				'uid'   =>$id,
				'mobile'=>$mobile,
				'money'=>$money
		    ]);	
		$res = ['errCode'=>200,'errMsg'=>'申请成功'];
	    return json($res); 
		}
		else
		{
			$res = ['errCode'=>400,'errMsg'=>'申请失败'];
			return json($res); 
		}
		
	

    }
	
	
	
	public static function makeOrderNo()
	{
		//第一位是当前年份-2019年返回的下标对应英文字母，第二位是当前月份转十六进制
		//第三四位是当前天数，当前秒数5位，当前微秒5位 
		//0-99随机生成两位数
	    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K','L','M','N');
	    $orderSn =
	        $yCode[intval(date('Y')) - 2019] . strtoupper(dechex(date('m'))) . date(
	            'd') . substr(time(), -5) . substr(microtime(), 2, 3) . sprintf(
	            '%02d', rand(0, 99));
	    return $orderSn;
	}
}