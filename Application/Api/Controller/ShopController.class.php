<?php
namespace Api\Controller;

class ShopController extends BaseController {

	/*添加管理员到商铺*/
	public function add_shop_admin($uid,$shop_id) {
		$this->hook2shop_set($uid,'用户',$shop_id);
	}

	/*hook: relation to shop*/
	public function hook2_set($tag_id, $tag_cat, $shop_id='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		$this->hook2cat_set($tag_id, $tag_cat, $this->shop_id);
	}
	
	/*get shop cat*/
	public function get_shop_cat($tag_cat,$shop_id='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		$w['tag_cat'] = $tag_cat;
		$cats = D2("Cat")->where($w)->select();
		return $cats;
	}	

	/*CUD操作*/
	public function setup_shop_demo() {
		$dat['name'] = '啊啊啊';
		$dat['img'] = '123';
		$this->setup_shop($dat);
	}
	public function setup_shop($data,$delete=0) {
		D2("Cat")->opt_data($data,'商铺',$delete);
	}

	/*hook: filter to shop*/
	public function hook2_get($result) {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		return R ( "Api/Cat/hook2cat_get" ,array($result, 'cat', $this->shop_id));
	}


}










