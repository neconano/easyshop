<?php
namespace Admin\Controller;

// 本类由系统自动生成，仅供测试用途
class IndexController extends PublicController {
	function _initialize() {
		parent::_initialize ();
	}

	public function _check_shop() {
		if( empty(session('shop_id')) )
			$this->error ( "请选定商城");
	}

	public function index() {
		$this->display ();
	}

	public function shop() {
		if(I("post.method") == 'add'){
			if( !empty(I("post.name")) ){
				$result = R ( "Api/Shop/add_shop", array (I("post.name"),I("post.id")));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		if(I("post.method") == 'setshop'){
			if( empty(I("post.shop_id")) )
				$this->error ( "错误");
			R ( "Api/Shop/change_shop", array (I("post.shop_id")));
			$this->success ( "成功");
		}
		$list = R ( "Api/Shop/list_shop");
		$this->assign ( "list", $list );
		$this->display ();
	}

	public function brand() {
		if(I("post.method") == 'add'){
			if( !empty(I("post.name")) ){
				$result = R ( "Api/Brand/add_brand", array (I("post.name"),I("post.id")));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		$list = R ( "Api/Brand/get_list" );
		$this->assign ( "page", $list[page] );
		$this->assign ( "result", $list[result] );
		$this->display ();
	}

	/*店内活动*/
	public function dnhd() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			if( !empty(I("post.name")) ){
				$content = I("post.content",'','stripslashes');
				$result = R ( "Api/Shop/add_dnhd", array (I("post.name"),$content,I("post.top"),I("post.id")));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		if(I("post.method") == 'getinfo'){
			$this->_short_block('getinfo',"Api/Shop/get_dnhd");
		}
		$this->_short_block('default',"Api/Shop/get_dnhd_list");
		$this->display ();
	}

	/*大牌钜惠*/
	public function dpjh() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			$this->_short_block('add',"Api/Brand/add_dpjh");
		}
		if(I("post.method") == 'getinfo'){
			$this->_short_block('getinfo',"Api/Brand/get_dpjh");
		}
		$this->_short_block('default',"Api/Brand/get_dpjh_list",'大牌钜惠');
		$this->display ();
	}

	/*焕新搭配*/
	public function hxdp() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			$this->_short_block('add',"Api/Hxdp/add");
		}
		if(I("post.method") == 'getinfo'){
			$this->_short_block('getinfo',"Api/Hxdp/get");
		}
		$this->_short_block('default',"Api/Hxdp/get_list",'焕新搭配');
		$this->display ();
	}

	/*限时购*/
	public function xsg() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			$this->_short_block('add',"Api/Xsg/add");
		}
		if(I("post.method") == 'getinfo'){
			$this->_short_block('getinfo',"Api/Xsg/get");
		}
		$this->_short_block('default',"Api/Xsg/get_list",'限时购');
		$this->display ();
	}

	/*明星单品*/
	public function mxdp() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			$this->_short_block('add',"Api/Mxdp/add");
		}
		if(I("post.method") == 'getinfo'){
			$this->_short_block('getinfo',"Api/Mxdp/get");
		}
		$this->_short_block('default',"Api/Mxdp/get_list");
		$this->display ();
	}

	/*优惠券*/
	public function coupon() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			if( !empty(I("post.name")) ){
				$result = R ( "Api/Shop/add", array (I("post.name"),$content,I("post.top"),I("post.id")));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		
		if(I("post.method") == 'getinfo'){
			$this->_short_block('getinfo',"Api/Coupon/get");
		}
		$this->_short_block('default',"Api/Coupon/get_list");
		$this->display ();
	}

	public function notShow() {
		$id = I("get.cat_id");
		if( !empty($id) ){
			R ( "Api/Cat/notShow", array ($id) );
			$this->success ( "成功");
		}
		$this->error ( "错误");
	}

	
	/*短代码块处理*/
	public function _short_block($method,$path,$tag_cat='') {
		if($method == 'add'){
			if( !empty(I("post.")) ){
				$result = R ( $path, array (I("post.")));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		if($method == 'getinfo'){
			if( !empty(I("post.id")) ){
				$result = R ( $path, array (I("post.id")));
				if(  empty($result[id]) )
					$this->error ( "错误");
				$this->ajaxReturn ( $result );
			}
			$this->error ( "错误");
		}

		if($method == 'default'){
			$list = R ( $path );
			$this->assign ( "page", $list[page] );
			$this->assign ( "result", $list[result] );
			if( !empty($tag_cat)){
				$list = R ( $path, array (1,I("get.master")) );		
				$this->assign ( "page_2", $list[page] );
				$this->assign ( "result_2", $list[result] );
				/*二级*/
				$list_option = R ( "Api/Cat/n_get_cats", array ($tag_cat) );
				$this->assign ( "list_option", $list_option );
				$this->assign ( "master", I("get.master") );
			}
		}

	}

	











	public function setting() {
		$result = R ( "Api/Api/setting", array (I("post.name"),I("post.notification")));
		$this->success ( "修改成功");
	}
	public function set() {
		if (session("wadmin")) {
			$result = R ( "Api/Api/getsetting" );
			$this->assign ( "info", $result );
			
			$themedir = getDir("./Theme/");
			
			for ($i = 0; $i < count($themedir); $i++) {
				$theme[$i] = simplexml_load_file("./Theme/".$themedir[$i]."/config.xml");
				if (isset($theme[$i])) {
					$theme[$i]->dir = $themedir[$i];
				}
			}
			$this->assign("theme",$theme);
			$this->assign("settheme",$result["theme"]);
			$payresult = R ( "Api/Api/getalipay" );
			$this->assign ( "alipay", $payresult );
			$this->display ();
		}
	}
	public function settheme(){
		
		$name = I("get.name");

		$data = array("id"=>1,"theme"=>$name[0]);
		$result = M("Info")->save($data);
		$this->success("操作成功");
	}

}





