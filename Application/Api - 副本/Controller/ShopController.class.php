<?php
namespace Api\Controller;

/*
*1.shop定义为分类，商铺，品牌都是分类
*2.商品的归属一律使用shop_index
*3.定义为属性-->明星单品
*
*/

class ShopController extends BaseController {

	public function add_shop_admin_demo() {
		$this->add_shop_admin('1');
	}
	/*add admin to shop*/
	public function add_shop_admin($uid,$shop_id) {
		$this->set($uid,'用户',$shop_id);
	}
	
	public function setup_brand_demo() {
		$this->setup_brand('1');
	}
	/*brand setup*/
	public function setup_brand($shop,$id="",$delete=0) {
		$this->setup_shop($shop,'品牌',$id,$delete);
	}

	public function setup_shop_demo() {
		$this->setup_shop('2');
	}
	/*shop setup*/
	public function setup_shop($shop,$shop_cat='商铺',$id="",$delete=0) {
		if($delete == 1){
			$w['id'] = $id;
			$d['is_delete'] = 1;
			D2("Shop")->where($w)->save($d);
			return true;
		}
		D2("Shop")->setup_shop($shop,$shop_cat,$id);
	}

	public function hook2shop_set_demo() {
		$this->change_shop(1);
		$this->hook2shop_set(1,1);
	}
	/*hook: relation to shop or brand*/
	public function hook2shop_set($tag_id, $tag_cat, $id='', $shop_id='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		D2("ShopIndex")->hook2shop_set($tag_id, $tag_cat, $id, $this->shop_id);
	}
	
	/*hook: filter to shop*/
	public function hook2shop_get($result='',$tag_cat='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		$w['tag_cat'] = $tag_cat;
		$w['shop_id'] = $this->shop_id;
		$shops = D2("ShopIndex")->where($w)->select();
		foreach($shops as $v){
			$shop_list[] = $v['tag_id'];
		}
		foreach($result as $v){
			if( in_array($v['id'],$shop_list))
			$result_shop[] = $v;
		}
		return $result_shop;
	}


}










