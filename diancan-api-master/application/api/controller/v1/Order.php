<?php
/**
 * Author: kevin
 * Date: 2017/2/22
 * Time: 21:52
 */

namespace app\api\controller\v1;

use app\api\model\User as usermodel;
use app\api\controller\BaseController;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\lib\exception\BaseException;
use think\Controller;


class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
        'checkSuperScope' => ['only' => 'delivery,getSummary']
    ];
    
    /**
     * 下单
     * @url /order
     * @HTTP POST
     */
    public function placeOrder()
    {
		
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = Token::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }
	public function cancelor($id)
	{
		(new IDMustBePositiveInt())->goCheck();
	    $oid=$id;
		OrderModel::destroy($oid);
	
	}
	
	
    /**
     * 获取订单详情
     * @param $id
     * @return static
     * @throws OrderException
     * @throws \app\lib\exception\ParameterException
     */
    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail)
        {
            throw new OrderException();
        }

        return $orderDetail
            ->hidden(['prepay_id']);
    }
	public function changeOrder5($id,$qid)
	{
		
		
	    (new IDMustBePositiveInt())->goCheck();
		
		$order = OrderModel::get($id);
		if (!$order)
		{
		    throw new OrderException();
		}
			
		    $order->status = 5;
			$order->buser_id = $qid;
			$order->take_time=time();
			$order->dthink_time=time()+300;
		    $order->save();
		
	}
	public function changeOrder6($id,$qid)
	{
		
		
	    (new IDMustBePositiveInt())->goCheck();
		$u_id=OrderModel::get();
		$order = OrderModel::get($id);
		if (!$order)
		{
		    throw new OrderException();
		}
		$order->status = 6;
		$order->qtake_time=time();
		$order->think_time=time()+1800;
		$order->quser_id = $qid;
		$order->save();
		
	}
	public function changeOrder7($id)
	{
		
	    (new IDMustBePositiveInt())->goCheck();
		
		$order = OrderModel::get($id);
		if (!$order)
		{
		    throw new OrderException();
		}
		$order->status = 7;
		$order->save();
		
		
		
		
	}
	public function checkOrderstute($id)
	{
		
	    (new IDMustBePositiveInt())->goCheck();
		$order = OrderModel::get($id);
		$orderCheck = OrderModel::where('id',$id)->value('ustatus');
		if (!$order)
		{
		    throw new OrderException();
		}
		if($orderCheck==0)
		{
		$order->ustatus = 1;
		$order->save();
		}
		
		
		
		
		
	}
	public function changeOrderu($id,$account)
	{
		$daccount=$account;
		
		(new IDMustBePositiveInt())->goCheck();
			
		$buser = OrderModel::get($id);
		if(!$buser)
		{
			throw new UserException([
			   'msg' => $buser,
			    'errorCode' => 70001
			]);
		}
		
		$busermo=usermodel::where('id',$buser->buser_id); 	
		if(empty($busermo))
		{
			throw new UserException([
			   'msg' => "没找到对象",
			    'errorCode' => 70001
			]);
		}
		$busermo->setInc('money',$daccount);
	
		
			
		$quser = OrderModel::get( $id);
		
		$qusermo=usermodel::where('id',$quser->buser_id)->setInc('money',2); // 金钱增加	
			
		$order = OrderModel::get($id);
		if (!$order)
		{
		throw new OrderException();
		}
		$order->ustatus = 1;
		$order->save();
			
			
			
			
			
			
		}
public function changeOrderQuit($id)
	{
	
		(new IDMustBePositiveInt())->goCheck();
			
		$orderStatus = OrderModel::where('id',$id)->value('status');
	
		
		if($orderStatus>2)
		{
			throw new UserException([
			   'msg' => '错误',
			    'errorCode' => 70001
			]);
		}else
		{
			$order = OrderModel::get($id);
		if (!$order)
		{
		throw new OrderException();
		}
		$order->status = 8;
		$order->save();
		}
		
		
			
			
		}

    /**
     * 根据用户id分页获取订单列表（简要信息）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummaryByUser($page = 1, $status=0,$size = 15)
    {
        (new PagingParameter())->goCheck();
        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUserList($uid,$status, $page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
//        $collection = collection($pagingOrders->items());
//        $data = $collection->hidden(['snap_items', 'snap_address'])
//            ->toArray();
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];

    }
	public function getSummaryBoss($page = 1, $status=1,$size = 15)
    {
        (new PagingParameter())->goCheck();
		$uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByBoss($status,$uid,$page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
//        $collection = collection($pagingOrders->items());
//        $data = $collection->hidden(['snap_items', 'snap_address'])
//            ->toArray();
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];

    }
	public function getSummaryDispatcher($page = 1, $status=0,$size = 15)
    {
        (new PagingParameter())->goCheck();
		$uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryDispatcher($status,$uid, $page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
//        $collection = collection($pagingOrders->items());
//        $data = $collection->hidden(['snap_items', 'snap_address'])
//            ->toArray();
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];

    }
    /**
     * 获取全部订单简要信息（分页）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummary($page=1, $size = 20){
        (new PagingParameter())->goCheck();
//        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }
	
    public function delivery($id){
        (new IDMustBePositiveInt())->goCheck();
        $order = new OrderService();
        $success = $order->delivery($id);
        if($success){
            return new SuccessMessage();
        }
    }
}






















