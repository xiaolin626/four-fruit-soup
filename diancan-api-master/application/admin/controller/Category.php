<?php

namespace app\admin\controller;

use app\api\model\Category as CategoryModel;
use app\api\model\Image;
use app\api\service\Upload;
use think\Validate;

class Category extends  Base
{
    public function all()
    {
        return view('all');
    }

    public function disable()
    {
        return view('disable');
    }

    public function getAllCategory()
    {
        $params = request()->param();
        $where = [];
        if($params['name']){
            $where['name'] = ['like','%'.$params['name'].'%'];
        }
        if( $params['status'] == 5 ){
            $total = CategoryModel::where($where)->count();
            $list = CategoryModel::all(function($query) use ($params,$where) {
                $query->where($where)->order('sort asc');
                $query->limit($params['offset'],$params['limit']);
            },'img');
        }elseif($params['status'] == 10){
            //获取下架中 软删除数据
            $total = CategoryModel::onlyTrashed()->where($where)->count();
            $list = CategoryModel::onlyTrashed()->where($where)
                ->limit($params['offset'],$params['limit'])->with('img')->select();
        }

        return ['code' => 200, 'msg' => 'ok', 'data' => compact('total','list')];
    }

    public function add()
    {
        return view('add');
    }

    /**
     * 添加分类
     * @param name string 分类名称
     * @param description string 分类描述
     * @param topic_img file 分类顶图片文件
     */
    public function addCategory()
    {
        $thumb = input('thumb');
        $params = request()->only(['name','description']);
        $validate = new Validate([
            'name'          =>   'require',
            'description'   =>   'require'
        ]);
        if( !$validate->check($params) ){
            return _json(0,$validate->getError());
        }

        //图片上传
        if( !empty($thumb) ){
            $m = Image::create([
                'url'   => $thumb,
                'from'  => 1,
                'update_time'  => time(),
            ]);
            $params['topic_img_id'] = $m->getLastInsID();
        }
        $params['update_time']  = time();

        CategoryModel::create($params);

        return _json(200,'添加成功！');
    }

    public function edit()
    {
        $id = request()->param('id');
        $data = CategoryModel::get($id,'img')->toArray();
        return view('edit',compact('data'));
    }

    public function updateCategory()
    {
        $id = request()->param('id');
        $thumb = request()->param('thumb');
        $params = request()->only(['name','description']);
        $validate = new Validate([
            'name'          =>   'require',
            'description'   =>   'require'
        ]);
        if( !$validate->check($params) ){
            return _json(0,$validate->getError());
        }

        $info = CategoryModel::get($id);
        if( !empty($thumb) ){
            $m = Image::update([
                'url'   => $thumb,
                'from'  => 1,
                'update_time'  => time(),
            ],['id'=>$info['topic_img_id']]);
            $params['update_time']  = time();
        }

        CategoryModel::update($params,['id' => $id]);

        return _json(200,'修改成功！');
    }

    public function setSort(){
        $id = input('id');
        if(empty($id))
            return _json(0,'参数有误！');

        $sort = input('sort');
        CategoryModel::update(['sort'=>$sort],['id'=>$id]);
        return _json(0,'已修改！');

    }

    public function delete()
    {
        $id = request()->param('id');
        CategoryModel::destroy($id);

        return ['code' => 200,'msg' => '下架成功', 'data' => []];
    }

    public function able()
    {
        $id = request()->param('id');
        CategoryModel::onlyTrashed()->where('id',$id)->update([
            'delete_time' => NULL
        ]);
        return ['code' => 200,'msg' => '上架成功', 'data' => []];
    }
}