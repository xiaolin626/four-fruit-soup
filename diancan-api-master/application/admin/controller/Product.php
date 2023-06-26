<?php
namespace app\admin\controller;


use app\api\model\Image;
use app\api\model\Product as ProductModel;
use app\api\model\Category as CategoryModel;
use app\api\model\ProductProperty as Property;
use app\api\model\ProductImage;
use app\api\model\ProductProperty;
use app\lib\exception\ProductException;
use app\api\service\Upload;
import('phpexcel.PHPExcel', EXTEND_PATH);

	
class Product extends Base
{
    public function all()
    {
        $category_id = input('category_id',0);
        $recommend = input('recommend',-1);
        $category = CategoryModel::all();
        $this->assign('category',$category);
        $this->assign('category_id',$category_id);
        $this->assign('recommend',$recommend);
		
		
        return view('all');
		
		
    }
    
    public function disable()
    {
		
		
        $category_id = input('category_id',0);
        $category = CategoryModel::all();
        $this->assign('category',$category);
        $this->assign('category_id',$category_id);
        return view('disable');
		
		
    }

    public function getProductAll()
    {
		
        $params = request()->param();
        $where = [];
        if(!empty($params['category_id'])){
            $where['category_id'] = $params['category_id'];
        }
        if(isset($params['recommend']) && $params['recommend'] != -1){
            $where['recommend'] = $params['recommend'];
        }
        if( isset($params['name']) ){
            $where['name'] = ['like','%'.$params['name'].'%'];
        }
        if( $params['status'] == 5 ){
            $total = ProductModel::where($where)->count();
            $list = ProductModel::all(function ($query) use ($where,$params){
                $query->where($where);
                $query->limit($params['offset'],$params['limit']);
            },'category');

        }else if( $params['status'] == 10 ){
            $total = ProductModel::onlyTrashed()->where($where)->count();
            $list = ProductModel::onlyTrashed()->where($where)
                ->limit($params['offset'],$params['limit'])->with('category')->select();
        }


        return ['code' => 200, 'msg' => 'ok' ,'data' => compact('total','list')];
    }

    public function add()
    {
        $category = CategoryModel::all();
        return view('add',compact('category'));
    }
	
	public function suadd()
	{
	    $category = CategoryModel::all();
	    return view('suadd',compact('category'));
	}
	public function upload_excel() {
		
		
		$request = \think\Request::instance();
	        $file = $request->file('excel');
	
	        $save_path = ROOT_PATH . 'uploads/';
	        $info = $file->move($save_path);
	        //print_r($info);exit;
	
	        $filename=$save_path . DIRECTORY_SEPARATOR . $info->getSaveName();
	          if(file_exists($filename)) {//如果文件存在
	          import('phpexcel.PHPExcel', EXTEND_PATH);
	
	
	    if( strstr($filename,'.xlsx'))
	{
	 $PHPReader = new \PHPExcel_Reader_Excel2007();
	}
	else if( strstr($filename,'.xls'))
	{
		 $PHPReader = new \PHPExcel_Reader_Excel5();
	}
	else
	{
		echo("<script type='text/javascript'> alert('文件错误，请重新导入！');location.href='/admin/Product/all';</script>");
	}
	           //载入excel文件
	           $PHPExcel = $PHPReader->load($filename);
	           $sheet = $PHPExcel->getActiveSheet(0);//获得sheet
	           $highestRow = $sheet->getHighestRow()-1; // 取得共有数据数
	           $data=$sheet->toArray();
			   array_shift($data);  //删除第一个数组(标题);
	
	           for($i=0;$i<$highestRow;$i++){
	          $product['name']=trim($data[$i][0]);
			  $product['price']=trim($data[$i][1]);
			  $product['stock']=trim($data[$i][2]);
			  $product['category_id']=trim($data[$i][3]);
			  
			$name=$product['name'];
	$price=$product['price'];
	$stock=$product['stock'];
	$category_id=$product['category_id'];
	$bname=ProductModel::where('name',$name)
				->value('type');
	if($bname==0)
	{
	continue;
	}
	else
	{
	 $product = new ProductModel();
	$product->save(
	    [
			'category_id'=>$category_id,
			'name' => $name,
			'price' => $price,
			'stock' => $stock
	    ]);	
	}
    
	}
	echo("<script type='text/javascript'> alert('添加数据成功！');location.href='/admin/Product/all';</script>"); 
	}
	else
	{
		echo("<script type='text/javascript'> alert('文件错误，请重新导入！');location.href='/admin/Product/all';</script>"); 
	}
	
	}
	/**
	     * 导出excel文件
	     */
	    public function excel_data(){
			//1.清除缓冲区,避免乱码
			        ob_end_clean();
			  import('phpexcel.PHPExcel', EXTEND_PATH);
			  import('phpexcel.PHPExcel.IOFactory', EXTEND_PATH);
			  import('phpexcel.PHPExcel.Writer.Excel2007', EXTEND_PATH);
			  $objPHPExcel=new \PHPExcel();
			  $PHPWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);//用于2007版本格式
	               //5.设置sheet的名称,以及单元格字段信息
	               $objPHPExcel->getActiveSheet()->setTitle('test'); //获取当前的工作表并且设置工作表名称
	               $objPHPExcel->setActiveSheetIndex(0)//设置sheet（工作表）的起始位置为0
	                   ->setCellValue('A1', '商品名称')  //设置单元格字段信息
	                   ->setCellValue('B1', '商品价格')
	                   ->setCellValue('C1', '商品库存')
					   ->setCellValue('D1', '商品分类');
	     //8.设置表格文件的名称
	             $outputFileName = 'total.xlsx';
				 header("Content-Type: application/force-download");
				  
				         header("Content-Type: application/octet-stream");
				  
				         header("Content-Type: application/download");
				  
				         header('Content-Disposition:inline;filename="' . $outputFileName . '"');
				  
				         header("Content-Transfer-Encoding: binary");
				  
				         header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				  
				         header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				  
				         header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				  
				         header("Pragma: no-cache");
				         //9.生成并下载表格
				         $PHPWriter->save("php://output");
						 exit;
						 return ['code' => 200,'msg' => '导出成功', 'data' => []];
	    }

     public function addProduct()
        {
            $main = request()->only(['name','price','stock','category_id','summary']);
            unset($_FILES['fileImage']);
            $result = Upload::upload($_FILES);
            if( $result['code'] == 200 ){
                $m = Image::create([
                    'url'   => $result['data']['main_img_url'],
                    'from'  => 1]);
                $main['main_img_url'] = $result['data']['main_img_url'];
                $main['img_id'] = $m->getLastInsID();}else{
                $this->error($result['msg']);
                exit;}
            $id = ProductModel::create($main)->getLastInsID();
            //产品详情图片添加
            $params = request()->param();
            $file = isset(array_only($params,['file'])['file'])?array_only($params,['file'])['file']:[];
            if(!empty($file)){
                foreach ($file as $k=>$v){
                    $result = Upload::uploadBase64($v);
                    $img_id = Image::create([
                        'url'   => $result['data'],
                        'from'  => 1
                    ])->getLastInsID();
                    $img = [
                        'product_id' => $id,
                        'order'      => $k+1,
                        'img_id'     => $img_id
                    ];
                    ProductImage::create($img);
                }
            }
            //产品属性添加
            list($property_name,$property_detail) = array_values(request()->only(['property_name','property_detail']));
            if(!empty($property_name)){
                foreach ($property_name as $k=>$v){
                    if( $v ){
                        ProductProperty::create([
                            'name'      => $v,
                            'detail'    => $property_detail[$k],
                            'product_id'=> $id,
                        ]);
                    }
                }
            }
            $this->redirect('/admin/product/all',['success' => '添加产品成功']);
        }

    public function edit()
    {

        $id = request()->get('id');
        $category = CategoryModel::all();
        $product = ProductModel::get($id,['imgs' => function($query){
            $query->with('imgUrl');
        },'category','properties'])->toArray();

        return view('edit',compact('product','category'));
    }

    public function updateProduct()
    {
        $params = request()->param();

        $id = $params['id'];
        $main = array_only($params,['name','price','stock','category_id','summary']);
        $product_info = ProductModel::get($id);
        $img_info = Image::get($product_info['img_id']);

        if( $_FILES['main_img_url']['error'] == 0 ){
            unset($_FILES['fileImage']);
            $result = Upload::upload($_FILES);
            if( $result['code'] == 200 ){
                if($img_info){
                    $m = Image::update([
                        'url'   => $result['data']['main_img_url'],
                        'from'  => 1
                    ],['id'=>$img_info['id']]);
                    $main['main_img_url'] = $result['data']['main_img_url'];
                }else{
                    $m = Image::create([
                        'url'   => $result['data']['main_img_url'],
                        'from'  => 1
                    ]);
                    $main['main_img_url'] = $result['data']['main_img_url'];
                    $main['img_id'] = $m->getLastInsID();
                }


            }else{
                $this->error($result['msg']);
                exit;
            }
        }
        ProductModel::update($main,['id' => $id]);

        //产品属性修改
        ProductProperty::destroy(['product_id' => $id]);
        list($property_name,$property_detail) = array_values(array_only($params,['property_name','property_detail']));
        if( $property_name && $property_detail ) {
            foreach ($property_name as $k => $v) {
                if ($v) {
                    ProductProperty::create([
                        'name' => $v,
                        'detail' => $property_detail[$k],
                        'product_id' => $id,
                    ]);
                }
            }
        }


        //产品详情图片添加
        //旧
        $img_id = isset(array_only($params,['img_id'])['img_id'])?array_only($params,['img_id'])['img_id']:[];
        $result = ProductImage::all(['product_id' => $id],'img_url')->toArray();
        if( $result ){
            foreach ($result as $k=>$v){
                $img[] = $v['img_url']['url'];
            }
            $diff = array_diff_assoc($img,$img_id);
            foreach ( $diff as $k=>$v ){
                $i_id = $result[$k]['id'];
                ProductImage::destroy(['id' => $i_id]);
            }
        }



        //新
        $file = isset(array_only($params,['file'])['file'])?array_only($params,['file'])['file']:[];
        if( $file ){
            foreach ($file as $k=>$v){
                $result = Upload::uploadBase64($v);
                $img_id = Image::create([
                    'url'   => $result['data'],
                    'from'  => 1
                ])->getLastInsID();
                $img = [
                    'product_id' => $id,
                    'order'      => $k+1,
                    'img_id'     => $img_id
                ];
                ProductImage::create($img);
            }
        }


        $this->redirect('/admin/product/all',['success' => '添加产品成功']);

    }

    public function delete()
    {
        $id = request()->param('id');
        ProductModel::destroy($id);

        return ['code' => 200,'msg' => '下架成功', 'data' => []];
    }
    public function recommend(){
        $id = request()->param('id');
        $recommend = request()->param('recommend');
        $data = compact('id','recommend');
//        ppd($data);
        ProductModel::update($data);
        $this->redirect('/admin/product/all',['success' => '设置成功']);
    }
    public function able()
    {
        $id = request()->param('id');
        ProductModel::onlyTrashed()->where('id',$id)->update([
            'delete_time' => NULL
        ]);
        return ['code' => 200,'msg' => '上架成功', 'data' => []];
    }
}