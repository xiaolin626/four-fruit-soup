<?php

namespace app\api\model;

use think\Model;

class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time'];
    protected $autoWriteTimestamp = true;

    public function getSnapItemsAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode(($value));
    }
    
    public static function getSummaryByUser($uid, $page=1, $size=15)
    {
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }
    public static function getSummaryByUserList($uid, $status,$page=1, $size=15)
    {

        $wh = array('user_id'=>$uid);
        if(!empty($status)){
            if($status < 3)
                $wh['status'] = $status;
            else
                $wh['status'] = array('gt',$status);
        }

        $pagingData = self::where($wh)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }
 public static function getSummaryByBoss($status,$uid,$page=1, $size=15)
    {

        $wh = array('type'=>0,'buser_id'=>['in',[$uid,'0']]);
        if(!empty($status)){
            if($status < 3)
                $wh['status'] = $status;
            else
                $wh['status'] = array('gt',$status);
        }

        $pagingData = self::where($wh)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }
	public static function getSummaryDispatcher($status,$uid,$page=1, $size=15)
	   {
	
	       $wh = array('type'=>0,'quser_id'=>['in',[$uid,'0']]);
		   //$wh['quser_id']=$uid;
	       if(!empty($status)){
	           if($status < 3)
	               $wh['status'] = $status;
	           else
	               $wh['status'] = array('gt',$status);
	       }
	
	       $pagingData = self::where($wh)
	           ->order('create_time desc')
	           ->paginate($size, true, ['page' => $page]);
	       return $pagingData ;
	   }

    public static function getSummaryByPage($page=1, $size=20){
        $pagingData = self::order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }

    public function products()
    {
        return $this->belongsToMany('Product', 'order_product', 'product_id', 'order_id');
    }
}
