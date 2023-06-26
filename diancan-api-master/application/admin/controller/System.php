<?php
/**
 * User : kevin.liu
 * Date : 2019/08/19 0019 下午 8:27
 * QQ : 791845283@qq.com
 * wechat : hanyi7918
 * Descript :
 */
namespace app\admin\controller;
class System extends Base
{
    public function config(){

        if(request()->isPost()){
            $data = input('post.');
            unset($data['topic_img']);
            db('system')->where('id',1)->update($data);
            return _json(200,'操作成功！');
        }else{
            $data = db('system')->find(1);
            $this->assign('data',$data);
            return view();

        }

    }

    public function wxconfig(){

    }

    public function banner(){
        return view();
    }

    public function bannerAll(){
        $params = request()->param();

//         $total = db('banner')->where($where)->count();
        $result = db('banner')->order('sort desc')
            ->paginate(array('list_rows'=>$params['limit'],'page'=>$params['offset']))
            ->toArray();

        $total = 0;
        $list  = [];
        if(!empty($result)){
            $total = $result['total'];
            $list = $result['data'];
        }

        return ['code' => 200, 'msg' => 'ok' ,'data' => compact('total','list')];
    }

    public function addBanner(){
        if(request()->isPost()){
            $data = input();
            if(empty($data['image']))
                return _json(0,'请传图片!');
            $item =[];
            $item['name'] = $data['name'];
            $item['description'] = $data['description'];
            $item['image'] = $data['image'];
            $item['status'] = isset($data['status']) ? $data['status'] : 1;
            $item['position'] = isset($data['position']) ? $data['position'] : 0;
            db('banner')->insert($item);
            return _json(200,'上传成功!');
        }else{
            $this->assign('Data',array());
            $this->assign('id',0);
            return view();
        }

    }

    public function editBanner(){
        if(request()->isPost()){
            $data = input();
            if(empty($data['image']))
                return _json(0,'请传图片!');
            $item =[];
            $item['name'] = $data['name'];
            $item['description'] = $data['description'];
            $item['image'] = $data['image'];
            $item['status'] = isset($data['status']) ? $data['status'] : 1;
            $item['position'] = isset($data['position']) ? $data['position'] : 0;
            db('banner')->where('id',$data['id'])->update($item);
            return _json(200,'修改成功!');
        }else{
            $id = input('id');
            $Data = db('banner')->find($id);
            $this->assign('Data',$Data);
            $this->assign('id',$id);
            return view('addbanner');
        }

    }

    function postSort(){
        $id = input('id');
        $sort = input('sort');
        db('banner')->where('id',$id)->update(['sort'=>$sort]);
        return _json(200,'设置成功！');
    }

    function delBanner(){
        $id = input('id');
        db('banner')->where('id',$id)->delete();
        $this->redirect(url('banner'));
    }
}