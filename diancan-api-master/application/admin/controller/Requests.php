<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/28
 * Time: 23:06
 */

namespace app\admin\controller;

use app\api\model\Application;
use app\api\model\User;

class Requests extends Base
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
            $where['realname'] = ['like','%'.$params['name'].'%'];
			
        }
        $total = Application::where($where)->count();
        $list = Application::all(function ($query) use ($where,$params){
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
	        $where['realname'] = ['like','%'.$params['name'].'%'];
			
	    }
	    $total = Application::where($where)->count();
	    $list = Application::all(function ($query) use ($where,$params){
	        $query->where($where);
	        //$query->order('create_time desc');
	        $query->limit($params['offset'],$params['limit']);
	    });
	
	    return ['code' => 200, 'msg' => 'ok' ,'data' => compact('total','list')];
	}


	public function accept()
    {
        $id = request()->param('id');
	    $brole =Application::where('id',$id)->find();
		if($brole['Bslicense'])
		{
		$user = User::where('id', $id)
  		     ->find();
  		 $user->astatus = 3;
		 $user->role=1;
  		 $user->save();	
		 
		 $astatus=Application::where('id',$id)
							->find();
		 $astatus->status=3;
		 $astatus->save();
		}
		else
		{
			$user = User::where('id', $id)
			    ->find();
			$user->astatus = 3;
			$user->role=2;
			$user->save();

			$astatus=Application::where('id',$id)
								->find();
			$astatus->status=3;
			$astatus->save();
		}
        return ['code' => 200,'msg' => '同意操作成功', 'data' => []];
    }
	
	public function reject()
	{
	    $id = request()->param('id');
		//删除订单的同时将该单的角色申请状态变成申请失败状态
		$user = User::where('id', $id)
		     ->find();
		 $user->astatus = 2;
		 $user->save();
		 $astatus=Application::where('id',$id)
		 					->find();
		 $astatus->status=2;
		 $astatus->save();
	    return ['code' => 200,'msg' => '拒绝操作成功', 'data' => []];
	}
    public function justfordelete()
    {
        $id = request()->param('id');
        $bdelete =Application::where('id',$id)->delete();
        return ['code' => 200,'msg' => '删除成功', 'data' => []];
    }
	public function delete()
    {
        $id = request()->param('id');
	    $bdelete =Application::where('id',$id)->delete();
		//删除订单的同时将该单的角色申请状态变成未申请
		$user = User::where('id', $id)
  		     ->find();
  		 $user->astatus = 0;
  		 $user->save();
        return ['code' => 200,'msg' => '删除成功', 'data' => []];
    }
    
}