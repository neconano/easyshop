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
				$text = I("post.text",'','stripslashes');
				$result = R ( "Api/Shop/add_dnhd", array (I("post.name"),$text,I("post.top"),I("post.id")));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		if(I("post.method") == 'getinfo'){
			if( !empty(I("post.id")) ){
				$result = R ( "Api/Shop/get_dnhd", array (I("post.id")));
				$this->ajaxReturn ( $result );
			}
			$this->error ( "错误");
		}
		$list = R ( "Api/Shop/get_dnhd_list" );
		$this->assign ( "page", $list[page] );
		$this->assign ( "result", $list[result] );
		$this->display ();
	}

	/*大牌钜惠*/
	public function dpjh() {
		$this->_check_shop();
		if(I("post.method") == 'add'){
			if( !empty(I("post.name")) ){
				$id = I("post.id_1");
				$result = R ( "Api/Brand/add_dpjh", array (I("post."),$id));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}
		if(I("post.method") == 'getinfo'){
			if( !empty(I("post.id")) ){
				$result = R ( "Api/Brand/get_dpjh", array (I("post.id")));
				$this->ajaxReturn ( $result );
			}
			$this->error ( "错误");
		}

		if(I("post.method") == 'add_2'){
			if( !empty(I("post.name_2")) ){
				$id = I("post.id_2");
				$result = R ( "Api/Brand/add_dpjh", array (I("post."),$id,"_2"));
				if($result)
					$this->success ( "成功");
			}
			$this->error ( "错误");
		}

		$list = R ( "Api/Brand/get_dpjh_list" );
		$this->assign ( "page", $list[page] );
		$this->assign ( "result", $list[result] );

		$list = R ( "Api/Brand/get_dpjh_list", array (1,I("get.master")) );		
		$this->assign ( "page_2", $list[page] );
		$this->assign ( "result_2", $list[result] );
		
		$list_option = R ( "Api/Cat/n_get_cats", array ('大牌钜惠') );
		$this->assign ( "list_option", $list_option );
		$this->assign ( "master", I("get.master") );

		$this->display ();
	}

	/*焕新搭配*/
	public function hxdp() {
		$this->display ();
	}

	/*限时购*/
	public function xsg() {
		$this->display ();
	}

	/*明星单品*/
	public function mxdp() {
		$this->display ();
	}

	/*优惠券*/
	public function coupon() {
		$this->display ();
	}

	/*优惠券*/
	public function notShow() {
		$id = I("get.cat_id");
		if( !empty($id) ){
			R ( "Api/Cat/notShow", array ($id) );
			$this->success ( "成功");
		}
		$this->error ( "错误");
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





