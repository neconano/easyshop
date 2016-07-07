<?php
namespace Api\Controller;
use Think\Controller;

class BaseController extends Controller {

	protected $shop_id;

	function _initialize() {
		$this->_init_shop();
		$this->_init();
	}

	function _init() {
	}

	function _init_shop() {
		/*debug setup*/
		if( $this->checkstr(ACTION_NAME,"demo") ){
			session('shop_id',1);
		}
		$this->shop_id = session('shop_id');
	}

	/*string contain*/
	function checkstr($str,$needle){ 
		$tmparray = explode($needle,$str); 
		if(count($tmparray)>1){ 
			return true; 
		} else{ 
			return false; 
		} 
	} 

	/*change current shop*/
	public function change_shop($id) {
		$w['id'] = $id;
		$cat = D2("Cat")->where($w)->find();
		if( empty($cat) )
			return false;
		session('shop_id',$cat[id]);
		session('shop_name',$cat[name]);
		$this->shop_id = $id;
	}
	
	public function upload() {

		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize = 3145728; // 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =      './Public/'; // 设置附件上传根目录
		$upload->savePath  =      './Uploads/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
		    $this->error($upload->getError());
		}else{// 上传成功 获取上传文件信息
		    foreach($info as $file){
		        // echo $file['savepath'].$file['savename'];
		    }
		}
		return $info;
	}
}
		
/*model redrect*/
function D2($name='',$layer='') {
	return D('Api/'.$name, $layer) ;
}







