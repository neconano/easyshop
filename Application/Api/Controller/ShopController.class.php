<?php
namespace Api\Controller;
use Think\Controller;

class ShopController extends Controller {

	private $shop_id;

	function _initialize() {
	}

	function _init_shop() {
		$this->shop_id = session('shop_id');
		/*shop_id不存在则*/
		if( empty($this->shop_id) ){
			session(null);
			$this->success ( '用户状态已失效！', U ( "Admin/Login/index" ) );
		}
	}

	/*字符串包含*/
	function checkstr($str,$needle){ 
		$tmparray = explode($needle,$str); 
		if(count($tmparray)>1){ 
		return true; 
		} else{ 
		return false; 
		} 
	} 	

	/*切换店铺*/
	public function change_shop($id) {
		session('shop_id',$id);
		$this->shop_id = $id;
	}

	public function setup_shop_demo() {
		$this->setup_shop('1');
	}
	/*商铺设置*/
	public function setup_shop($shop,$id="",$delete=0) {
		if($delete == 1){
			$w['id'] = $id;
			D("Shop")->where($w)->delete();
			return;
		}
		$dat['shop'] = $shop;
		if(!empty($id)){
			$dat[id] = $id;
			D("Shop")->save($dat);
		}else{
			return D("Shop")->add($dat);
		}
		dump(D("Shop"));
	}

	public function set_demo() {
		change_shop(1);
		$this->set(1,1);
	}
	/*钩子：关联至商铺*/
	public function set($tag_id, $tag_cat, $id='') {
		$this->_init_shop();
		$dat['shop_id'] = $this->shop_id;
		$dat['tag_id'] = $tag_id;
		$dat['tag_cat'] = $tag_cat;
		if(!empty($id)){
			$dat[id] = $id;
			D("ShopIndex")->create($dat);
			D("ShopIndex")->save();
		}else{
			D("ShopIndex")->create($dat);
			return D("ShopIndex")->add();
		}
	}
	
	public function get_demo() {
		//$this->set(1,1);
	}
	/*钩子：过滤到商铺*/
	public function get($result,$tag_cat) {
		// foreach($result as $v){
		// 	if($v[])
		// }
	}


}










