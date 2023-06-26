<?php
namespace app\admin\controller;

use app\api\model\Image;
use app\api\model\Product as GoodsModel;
use app\api\model\Category as CategoryModel;
use app\api\model\Product as ProductModel;

use app\api\service\Upload;
import('phpexcel.PHPExcel', EXTEND_PATH);
	
class Dproduct extends Base
{
    public function all()
    {
        $category_id = input('category_id',0);
        $recommend = input('recommend',-1);
        $category = CategoryModel::all();
		$type=input('type',1);
        $this->assign('category',$category);
        $this->assign('category_id',$category_id);
        $this->assign('recommend',$recommend);
        $this->assign('type',$type);
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
		if(isset($params['type'])==1)
		{
			$where['type']=$params['type'];
		}
        if( isset($params['name']) ){
            $where['name'] = ['like','%'.$params['name'].'%'];
        }
        if( $params['status'] == 5 ){
            $total = GoodsModel::where($where)->count();
            $list = GoodsModel::all(function ($query) use ($where,$params){
                $query->where($where);
                $query->limit($params['offset'],$params['limit']);
            },'category');

        }else if( $params['status'] == 10 ){
            $total = GoodsModel::onlyTrashed()->where($where)->count();
            $list = GoodsModel::onlyTrashed()->where($where)
                ->limit($params['offset'],$params['limit'])->with('category')->select();
        }
		// if($total==null||$list==null)
		// {
		// $resq==300;
		// }
		// else
		// {
		// 	$resq==200;
		// }
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
	public function suaddProduct()
	{
			$fileInfo = $_FILES["upFile"];
			// $fileInfoName = $fileInfo["name"];//文件名
			// $fileInfoPath = $fileInfo["tmp_name"];//文件当前路径文件夹
			// move_uploaded_file($fileInfoPath,"./source/".$fileInfoName);
			$fileresult=detectUploadFileMIME($fileInfo);
			if($fileresult==true)
			{
				//实例化读取类
				$reader=\PHPExcel_IOFactory::createReader('Excel2007');
			
				//读取要导入的文件
				
				$excel = $reader->load($fileInfo , $encode = 'utf-8');
				//获取总工作表数量
				$sheetCount = $excel->getSheetCount();
				//获取第index个工作表
				$sheet = $excel->getSheet(1);
				$total_rows_num = $sheet->getHighestRow();
				//获取所有内容并转化为数组
				$data = $sheet->toArray();
				
				array_shift($data);  //删除第一个数组(标题);
				$filedata = [];
				foreach($data as $k=>$v) {
					$filedata[$k]['商品名称'] = $v[0];
					$filedata[$k]['商品价格'] = $v[1];
					$filedata[$k]['商品库存'] = $v[2];
					$filedata[$k]['商品分类'] = $v[3];
					$filedata[$k]['商品描述'] = $v[4];
					$filedata[$k]['商品图片'] = $v[5];
					
				}
				foreach($filedata as $k=>$v) {
					$id = GoodsModel::create($main)->getLastInsID();
					$main[$k]['name'] = $v[0];
					$main[$k]['price'] = $v[1];
					$main[$k]['stock'] = $v[2];
					$main[$k]['category_id'] = $v[3];
					$main[$k]['summary'] = $v[4];
					$main[$k]['main_img_url'] = $v[5];
				}
	       
	        $this->redirect('/admin/product/all',['success' => '添加产品成功']);
			}
			else
			{
				
				return _json(200,'不是excel文件，导单失败');
				
			}
	    }
	

     public function addProduct()
        {

            $main = request()->only(['name','price','stock','type']);
    
            
            $id = GoodsModel::create($main)->getLastInsID();
    
            $this->redirect('/admin/dproduct/all',['success' => '添加产品成功']);
        }

    public function edit()
    {

        $id = request()->get('id');
        $category = CategoryModel::all();
        $product = GoodsModel::get($id)->toArray();

        return view('edit',compact('product','category'));
    }

    public function updateProduct()
    {
        $params = request()->param();

        $id = $params['id'];
		
        $main = array_only($params,['name','price','stock','type']);
        $product_info = GoodsModel::get($id);
        $img_info = Image::get($product_info['img_id']);

         GoodsModel::update($main,['id' => $id]);




        $this->redirect('/admin/dproduct/all',['success' => '添加产品成功']);

    }

    public function delete()
    {
        $id = request()->param('id');
        GoodsModel::destroy($id);

        return ['code' => 200,'msg' => '下架成功', 'data' => []];
    }
    public function recommend(){
        $id = request()->param('id');
        $recommend = request()->param('recommend');
        $data = compact('id','recommend');
//        ppd($data);
        GoodsModel::update($data);
        $this->redirect('/admin/product/all',['success' => '设置成功']);
    }
    public function able()
    {
        $id = request()->param('id');
        GoodsModel::onlyTrashed()->where('id',$id)->update([
            'delete_time' => NULL
        ]);
        return ['code' => 200,'msg' => '上架成功', 'data' => []];
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
	if($bname==1)
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
			'stock' => $stock,
			'type'=>1,
	    ]);	
	}
	
	}
	echo("<script type='text/javascript'> alert('添加数据成功！');location.href='/admin/Dproduct/all';</script>"); 
	}
	else
	{
		echo("<script type='text/javascript'> alert('文件错误，请重新导入！');location.href='/admin/Dproduct/all';</script>"); 
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
	
}