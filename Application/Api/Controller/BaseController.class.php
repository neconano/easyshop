<?php
namespace Api\Controller;
use Think\Controller;

class BaseController extends Controller {

	protected $shop_id;

	function _initialize() {
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
			$this->success ( '用户状态已失效！', U ( "Admin/Login/index" ) );
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










