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
	public function hook2_get($result,$tag_cat, $shop_id='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		return $this->hook2cat_get($result, $tag_cat, $this->shop_id);
	}


}










