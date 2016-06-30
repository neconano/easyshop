<?php
namespace App\Controller;
use Think\Controller;

class BaseController extends Controller {
	function _initialize() {
		// $_GET = I("get.");
		// $_POST = I("post.");
		$this->_init();
		$this->_init_shop();
	}

	function _init() {

	}

	function _init_shop() {
		/*debug setup*/
		if( $this->checkstr(ACTION_NAME,"demo") ){
			session('shop_id',1);
		}
		$this->shop_id = session('shop_id');
		/*shop_id is null*/
		if( empty($this->shop_id) ){
			session(null);
			$this->error ( '店铺状态已失效！');
			exit;
		}
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
		session('shop_id',$id);
		$this->shop_id = $id;
	}
}


/*model redrect*/
function D2($name='',$layer='') {
	return D('Api/'.$name, $layer) ;
}
