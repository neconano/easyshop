<?php
namespace Api\Controller;

class CouponController extends BaseController {


	public function setup_demo() {
		$tag_id = 57;
		$cat_id = 16;
		$this->hook2_set($tag_id, $cat_id);
	}

	public function get_my_list() {
		$w['tel'] = session('tel');
		$list = D2("Coupon")->where($w)->select();
		return $list;
	}

	public function get_detail($coupon_id) {
		$w['id'] = $coupon_id;
		$coupon = D2("Coupon")->where($w)->find();
		$dats = R ( "Api/Cat/get_cat_bytag",array($coupon['sum_id'],"coupon","焕新搭配"));
		return $dats[0];
	}

	public function get_new($cat_id) {
		if( empty(session('tel')) ){
			return false;
		}
		$w['tag_cat'] = 'coupon';
		$w['cat_id'] = $cat_id;
		$dat = D2("CatIndex")->where($w)->find();
		if(empty($dat))
		return false;
		$w2['id'] = $dat['tag_id'];
		$dat2 = D2("CouponSum")->where($w2)->find();
		if(empty($dat2))
		return false;
		$w3['sum_id'] = $dat['tag_id'];
		$w3['is_delete'] = 0;
		$w3['tel_user'] = 0;
		$w3['is_use'] = 0;
		$dat3 = D2("Coupon")->where($w3)->find();
		if(empty($dat3))
		return false;
		$dat3['tel_user'] = session('tel');
		D2("Coupon")->where($w3)->save($dat3);
		return $dat3;
	}

	/*hook: relation to coupon*/
	public function hook2_set($tag_id, $cat_id) {
		$this->hook2cat_set($tag_id, 'coupon', $cat_id);
	}

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
		D2("CouponSum")->make_coupon($dat);
	}

	public function poll_coupon_demo() {
		$a = $this->poll_coupon(1);
		dump($a);
	}
	/*poll coupon check notice*/
	public function poll_coupon() {
		$username = session("wadmin");
		$admin_info = A("Api")->get_admin_info($username,$uid);
		$result = D2("Coupon")->poll_coupon($admin_info['shop']['shop_id']);
		return $result;
	}

	private $coupon_testid = 52;
	public function push_coupon_demo() {
		$id = $this->coupon_testid;
		$this->push_coupon($id);
	}
	/*push coupon check notice*/
	public function push_coupon($id) {
		D2("Coupon")->push_coupon($id);
	}

	public function give_coupon_demo() {
		$id = $this->coupon_testid;
		$this->give_coupon($id);
	}
	/*give_coupon*/
	public function give_coupon($id="",$coupon_code="") {
		$admin_info = A("Api")->get_admin_info(session("wadmin"));
		D2("Coupon")->give_coupon($admin_info['id'],$id,$coupon_code);
	}


}










