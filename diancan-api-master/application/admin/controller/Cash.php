<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/28
 * Time: 23:06
 */

namespace app\admin\controller;


use app\api\model\User;
use app\api\model\Cash as Cashmodel;

class Cash extends Base
{

    //未审核订单列表页面
    public function all()
    {
       
        return view('all');
    }
	
	//已审核订单列表页面
	public function other()
	{
	   
	    return view('other');
	}

    public function getRequestAll()
    {
        $params = request()->param();
        $where = [];
		$where['status'] = 0;
        if( $params['name'] ){
            $where['uid'] = ['like','%'.$params['name'].'%'];
        }
        $total = Cashmodel::where($where)->count();
        $list = Cashmodel::all(function ($query) use ($where,$params){
            $query->where($where);
            //$query->order('create_time desc');
            $query->limit($params['offset'],$params['limit']);
        });
	
        return ['code' => 200, 'msg' => 'ok' ,'data' => compact('total','list')];
    }
	public function getRequestOther()
	{
	    $params = request()->param();
	    $where = [];
		$where['status']=array('neq',0);
	    if( $params['name'] ){
	        $where['uid'] = ['like','%'.$params['name'].'%'];
			
	    }
	    $total = Cashmodel::where($where)->count();
	    $list =Cashmodel::all(function ($query) use ($where,$params){
	        $query->where($where);
	        
	        $query->limit($params['offset'],$params['limit']);
	    });
	
	    return ['code' => 200, 'msg' => 'ok' ,'data' => compact('total','list')];
	}


	public function accept()
    {	
		$id = request()->param('id');
		$uid = request()->param('uid');
		$isback=Cashmodel::where('id',$id)
						->find();
		if($isback['isback']==0)
		{
		
	    $user = User::where('id', $uid)
	         ->find();
		$money=\request()->param('money');
		if($money>$user->money)
		{
			return ['code' => 700,'msg' => '提现失败，请核对账户余额', 'data' => []];
		}
		else if($money<0)
		{
			return ['code' => 600,'msg' => '提现失败，金额有误，请核对', 'data' => []];
		}
		$user->money-=$money;
		 $user->save();	
		$status=Cashmodel::where('id',$id)
						->find();
		$status->status=1;
		$status->save();
		
		return ['code' => 200,'msg' => '同意操作成功', 'data' => []];
		
		}
		else if($isback['isback']==1)
		{
			$user = db('admin')->where('id', $uid)->find();
			$money=\request()->param('money');
			if($money>$user['money'])
			{
				return ['code' => 700,'msg' => '提现失败，请核对账户余额', 'data' => []];
			}
			else if($money<0)
			{
				return ['code' => 600,'msg' => '提现失败，金额有误，请核对', 'data' => []];
			}
			$user['money']-=$money;
			db('admin')->update($user);
			$status=Cashmodel::where('id',$id)->find();
			$status->status=1;
			$status->save();
			return ['code' => 200,'msg' => '同意操作成功', 'data' => []];
		}
		}
	
	public function reject()
	{
	    $id = request()->param('id');
		$uid = request()->param('uid');
		 $astatus=Cashmodel::where('id',$id)
		 					->find();
		 $astatus->status=2;
		 $astatus->save();
	    return ['code' => 200,'msg' => '拒绝操作成功', 'data' => []];
	}
    public function justfordelete()
    {
        $id = request()->param('id');
		$uid = request()->param('uid');
        $bdelete =Cashmodel::where('id',$id)->delete();
        return ['code' => 200,'msg' => '删除成功', 'data' => []];
    }
	public function delete()
    {
        $id = request()->param('id');
		$uid = request()->param('uid');
	    $bdelete =Cashmodel::where('id',$id)->delete();
		
        return ['code' => 200,'msg' => '删除成功', 'data' => []];
    }
    
}