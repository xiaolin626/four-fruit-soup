<?php
namespace app\admin\controller;

use app\api\model\User as UserModel;
use app\api\model\Cash as Cashmodel;
class Myselfinfo extends Base
{

    public function all()
    {
        return view('myself');
    }

    public function adminInfo(){
		
        if(request()->isPost()){
            $params = request()->param();
            $list = db('admin')->where('id','=',\session('aid'))->limit($params['offset'],$params['limit'])->select();
            return ['code' => 200, 'msg' => 'ok', 'data' => compact('list')];
        }else
		{
			return view('myself');
		}

    }
    public function tocash(){
        if(request()->isPost()){
            $data = input('post.');
    
            //验证是否 该用户名存在
            $res = db('admin')->where('username',$data['username'])->find();
           if($res['money']<$data['money'])
		   {
			   return _json(300,'提现金额过大');
		   }
    
			$mobile=$data['tel'];
			$money=$data['money'];
			$id=\session('aid');
			$cash_order=$this->makeOrderNo();
			if($cash_order)
			{
			$cash = Cashmodel::create(
			    [
					'cash_order' => $cash_order,
					'uid'   =>$id,
					'mobile'=>$mobile,
					'money'=>$money,
					'isback'=>1
			    ]);	
			return _json(200,'申请成功');
			}
			else
			{
				return _json(400,'申请失败');
			}
			
    
        }
    
        $id = input('id');
        $datas = db('admin')->find($id);
        $this->assign('id',$id);
        $this->assign('datas',$datas);
        return view('editmyself');
    }
    

    public function editmyself(){
        if(request()->isPost()){
            $data = input('post.');
            $msg = $this->validate($data,'Admin');
            if($msg != 'true'){
                return _json(0,$msg);
            }

            //验证是否 该用户名存在
            $res = db('admin')->where('username',$data['username'])->find();
            if($res && $res['id'] != $data['id'])
                return _json(0,'该用户已存在');


            //是否需要改密码
            if($res['pwd'] != $data['pwd']){
                $data['pwd'] = _sha1md5($data['pwd']);
            }else{
                unset($data['pwd']);
            }
			unset($data['money']);
            db('admin')->update($data);
            return _json(200,'修改成功');
        }
		$id = input('id');
		$datas = db('admin')->find($id);
		$this->assign('id',$id);
		$this->assign('datas',$datas);
		return view('editmyself');

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