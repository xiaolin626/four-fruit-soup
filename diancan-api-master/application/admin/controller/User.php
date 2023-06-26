<?php
namespace app\admin\controller;

use app\api\model\User as UserModel;
class User extends Base
{

    public function all()
    {
        return view('all');
    }

    public function getAllUser()
    {
        $params = request()->param();
        $where = [];
        if( $params['nickname'] ){
            $where['nickname'] = ['like','%'.$params['nickname'].'%'];
        }
        $obj = UserModel::where($where);
        $list = $obj->limit($params['offset'],$params['limit'])->select()->toArray();
        $total = UserModel::where($where)->count();

        return ['code' => 200, 'msg' => 'ok', 'data' => compact('total','list')];
    }
	
	public function toUser()
	{
	    $params = request()->param();
	    $where = [];
	    if( $params['nickname'] ){
	        $where['nickname'] = ['like','%'.$params['nickname'].'%'];
	    }
	    $obj = UserModel::where($where);
	    $list = $obj->limit($params['offset'],$params['limit'])->select()->toArray();
	    $total = UserModel::where($where)->count();
	
	    return ['code' => 200, 'msg' => 'ok', 'data' => compact('total','list')];
	}

    public function admin(){
        if(request()->isPost()){
            $params = request()->param();
            //获取文章 分页处理
//            $page = input('offset')?input('offset'):1;
//            $pageSize = input('limit')?input('limit'):10;

//            $data = db('admin')
//                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
//                ->toArray();
            $list = db('admin')->limit($params['offset'],$params['limit'])->select();
            $total = db('admin')->count();
            return ['code' => 200, 'msg' => 'ok', 'data' => compact('total','list')];
        }else{
            return view('admin');
        }

    }
	
	public function user(){
	        if(request()->isPost()){
	            $params = request()->param();
	            //获取文章 分页处理
	//            $page = input('offset')?input('offset'):1;
	//            $pageSize = input('limit')?input('limit'):10;
	
	//            $data = db('admin')
	//                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
	//                ->toArray();
	            $list = db('user')->limit($params['offset'],$params['limit'])->select();
	            $total = db('user')->count();
	            return ['code' => 200, 'msg' => 'ok', 'data' => compact('total','list')];
	        }else{
	            return view('all');
	        }
	
	    }
	
	

    public function addAdmin(){
        if(request()->isPost()){
            $data = input('post.');
            unset($data['id']);
            $msg = $this->validate($data,'Admin');
            if($msg != 'true'){
                return _json(0,$msg);
            }
            //验证是否 该用户名存在
            $res = db('admin')->where('username',$data['username'])->find();
            if($res)
                return _json(0,'该用户已存在');
            $data['pwd'] = _sha1md5($data['pwd']);
            $data['ip'] = get_client_ip(0);
            $data['add_time'] = time();
            $data['last_time'] = time();
            $data['login'] = 0;
			$data['group_id'] =1;
            db('admin')->insert($data);
            return _json(200,'添加成功');
        }
        $this->assign('id',0);
        $this->assign('datas',array());
        return view('add_admin');
    }

    public function editAdmin(){
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

            db('admin')->update($data);
            return _json(200,'修改成功');
        }

        $id = input('id');
        $datas = db('admin')->find($id);
        $this->assign('id',$id);
        $this->assign('datas',$datas);
        return view('add_admin');
    }

    public function delAdmin(){
        $id = input('id');
        $status = input('status');
        db('admin')->where('id',$id)->update(['is_use'=>$status]);
        return _json(200,'操作成功！');
    }
	public function addUser(){
	    if(request()->isPost()){
	        $data = input('post.');
	        unset($data['id']);
	        // $msg = $this->validate($data,'User');
	        // if($msg != 'true'){
	        //     return _json(0,$msg);
	        // }
	
	        //验证是否 该用户名存在
	        $res = db('user')->where('nickname',$data['nickname'])->find();
	        if($res)
	            return _json(0,'该用户已存在');
	
	        $data['password'] = _sha1md5($data['password']);
	        db('user')->insert($data);
	        return _json(200,'添加成功');
	    }
	    $this->assign('id',0);
	    $this->assign('datas',array());
	    return view('add_user');
	}
	
	public function editUser(){
	    if(request()->isPost()){
	        $data = input('post.');
	        //验证是否 该用户名存在
	        $res = db('user')->where('nickname',$data['nickname'])->find();
	        if($res && $res['id'] != $data['id'])
	            return _json(0,'该用户已存在');
	        //是否需要改密码
	        if($res['password'] != $data['password']){
	            $data['password'] = _sha1md5($data['password']);
	        }else{
	            unset($data['password']);
	        }
	
	if(input('role')==0)
	{
		$data['astatus']=0;
	}
	        db('user')->update($data);
	        return _json(200,'修改成功');
	    }
	
	    $id = input('id');
	    $datas = db('user')->find($id);
	    $this->assign('id',$id);
	    $this->assign('datas',$datas);
	    return view('add_user');
	}
	
	public function delUser(){
	    $id = input('id');
	    $status = input('status');
	    db('user')->where('id',$id)->update(['is_use'=>$status]);
	    return _json(200,'操作成功！');
	}

}