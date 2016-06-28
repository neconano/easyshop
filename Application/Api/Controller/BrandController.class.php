<?php
namespace Api\Controller;

class BrandController extends BaseController {

	/*CUD操作*/
	public function setup_brand($data,$delete=0) {
		D2("Cat")->opt_data($data,'品牌',$delete);
	}

	/*hook: relation to brand*/
	public function hook2brand_set($tag_id, $tag_cat, $brand_id) {
		D2("Cat")->hook2_set($tag_id, $tag_cat, $brand_id);
	}

	/*hook: filter to brand*/
	public function hook2shop_get($result,$tag_cat, $brand_id) {
		D2("CatIndex")->hook2_get($result, $tag_cat, $brand_id);
	}

}










