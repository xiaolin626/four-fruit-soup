<?php
/**
 * User: kevin
 * Date: 2017/2/15
 * Time: 13:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Banner as BannerModel;


/**
 * Banner资源
 */ 
class Banner extends BaseController
{
//    protected $beforeActionList = [
//        'checkPrimaryScope' => ['only' => 'getBanner']
//    ];


    public function getBanner()
    {
        $banner = db('banner')->where('status',1)->order('sort desc')->limit(4)->select()->toArray();
//        $banner = get_object_vars($banner);
//        ppd($banner);
        if(!empty($banner)){
            foreach ($banner as &$item){
                $item['image'] = config('wx.img_prefix').$item['image'];
            }
        }
        return $banner;
    }
}