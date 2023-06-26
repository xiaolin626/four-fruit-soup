<?php
/**
 * Author: kevin
 * Date: 2017/2/20
 * Time: 2:01
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden=['product_id', 'delete_time', 'id'];

    /**
     *
     * @param $id 商品id
     * @return $property 商品属性
     */
    public static function getProperty($id)
    {
        $property=self::where('product_id',$id)->select();

        return $property;
    }
}