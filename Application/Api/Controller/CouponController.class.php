<?php
namespace Api\Controller;

/*
*1.coupon是商品的附加属性，所以包含tag_id和tag_cat
*2.coupon_sum是生成工具表
*/

class CouponController extends BaseController {

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


}










