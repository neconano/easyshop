<?php
namespace Api\Controller;
use Think\Controller;

class ShopController extends Controller {

	private $shop_id;

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

	/*coupon
	*=====================================================
	*/
	public function make_coupon_demo() {
		$this->make_coupon('11',3,"11","11","11");
	}
	/*make coupon*/
	public function make_coupon($title,$num,$desription,$tag_id="",$tag_cat="") {
		$this->_init_shop();
		$dat['shop_id'] = $this->shop_id;
		$dat['tag_id'] = $tag_id;
		$dat['tag_cat'] = $tag_cat;
		$dat['title'] = $title;
		$dat['num'] = $num;
		$dat['desription'] = $desription;
		D("CouponSum")->make_coupon($dat);
	}

	public function poll_coupon_demo() {
		$a = $this->poll_coupon(1);
		dump($a);
	}
	/*poll coupon check notice*/
	public function poll_coupon($uid="") {
		$username = session("wadmin");
		$admin_info = A("Api")->get_admin_info($username,$uid);
		$result = D("Coupon")->poll_coupon($admin_info['shop']['shop_id']);
		return $result;
	}

	private $coupon_testid = 52;
	public function push_coupon_demo() {
		$id = $this->coupon_testid;
		$this->push_coupon($id);
	}
	/*push coupon check notice*/
	public function push_coupon($id) {
		D("Coupon")->push_coupon($id);
	}

	public function give_coupon_demo() {
		$id = $this->coupon_testid;
		$this->give_coupon($id);
	}
	/*give_coupon*/
	public function give_coupon($id="",$coupon_code="") {
		$admin_info = A("Api")->get_admin_info(session("wadmin"));
		D("Coupon")->give_coupon($admin_info['id'],$id,$coupon_code);
	}

	public function take_coupon_demo() {
		$id = $this->coupon_testid;
		$tel_user = '12345678910';
		$this->take_coupon($id,$tel_user);
	}
	/*take coupon*/
	public function take_coupon($id,$tel_user) {
		D("Coupon")->take_coupon($id,$tel_user);
	}


	/*shop
	*=====================================================
	*/
	public function add_shop_admin_demo() {
		$this->add_shop_admin('1');
	}
	/*add admin to shop*/
	public function add_shop_admin($uid,$shop_id) {
		$this->set($uid,'用户',$shop_id);
	}

	/*change current shop*/
	public function change_shop($id) {
		session('shop_id',$id);
		$this->shop_id = $id;
	}

	public function setup_shop_demo() {
		$this->setup_shop('1');
	}
	/*shop setup*/
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
	}

	public function set_demo() {
		change_shop(1);
		$this->set(1,1);
	}
	/*hook: relation to shop*/
	public function set($tag_id, $tag_cat, $id='', $shop_id='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
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
	/*hook: filter to shop*/
	public function get($result,$tag_cat) {
		// foreach($result as $v){
		// 	if($v[])
		// }
	}


}










