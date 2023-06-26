<?php

namespace app\api\model;

use think\Model;

class Goods extends BaseModel
{
	
	protected $pk = 'id';
	
    protected $autoWriteTimestamp = true;
    protected $hidden = [
        'delete_time', 'category_id',
        'create_time', 'update_time'];


    //分类属性
    public function category()
    {
        return $this->hasOne('Category','id','category_id');
    }

   

    /**
     * 获取某分类下商品
     * @param $categoryID
     * @param int $page
     * @param int $size
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getProductsByCategoryID(
        $categoryID, $paginate = true, $page = 1, $size = 30)
    {
        $query = self::
        where('category_id', '=', $categoryID);
        if (!$paginate)
        {
            return $query->select();
        }
        else
        {
            // paginate 第二参数true表示采用简洁模式，简洁模式不需要查询记录总数
            return $query->paginate(
                $size, true, [
                'page' => $page
            ]);
        }
    }

    /**
     * 获取商品详情
     * @param $id
     * @return null | Product
     */
    

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

}
