<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/28
 * Time: 23:06
 */

namespace app\admin\controller;

use app\api\model\Order as OrderModel;

class Dorder extends Base
{

    //订单列表页面
    public function all()
    {
		$this->assign('type',1);
        $this->assign('status',2);
        return view('all');
    }

    public function getOrderAll()
    {
        $params = request()->param();
        $where = [];
        if($params['status'] == 1){
            $where['status'] = 1;
        }else{
            $where['status'] = array('gt',1);
        }
		if($params['type'] == 1){
		    $where['type'] = 1;
		}else{
		    $where['type'] = array('gt',1);
		}
        if( $params['name'] ){
            $where['name'] = ['like','%'.$params['name'].'%'];
        }
        $total = OrderModel::where($where)->count();
        $list = OrderModel::all(function ($query) use ($where,$params){
            $query->where($where);
            $query->order('create_time desc');
            $query->limit($params['offset'],$params['limit']);
        });
        if(!empty($list)){
            foreach ($list as &$item){
                $address = json_decode(json_encode($item['snap_address']),true);
                $item['add_name'] = $address['name'];
                $item['add_mobile'] = $address['mobile'];
            }
        }
        return ['code' => 200, 'msg' => 'ok' ,'data' => compact('total','list')];
    }


    public function detail()
    {
        $id = request()->get('id');
        $data = OrderModel::get($id)->toArray();
        foreach ($data['snap_items'] as $k=>&$v){
            $v = get_object_vars($v);
        }
        $data['snap_address'] = get_object_vars($data['snap_address']);
        return view('detail',compact('data'));
    }

    public function updateAddress()
    {
        $id = request()->post('id');
        $params = request()->post();
        unset($params['id']);


        OrderModel::update(['snap_address' => json_encode($params)],['id' => $id]);

        return redirect('/admin/order/detail?id='.$id.'',['success' => '修改地址成功']);
    }

    public function nopay(){
		$this->assign('type',1);
        $this->assign('status',1);
        return view('all');
    }
}