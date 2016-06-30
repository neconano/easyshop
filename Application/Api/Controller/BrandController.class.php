<?php
namespace Api\Controller;

class BrandController extends BaseController {

	public function get_promotion_list($brand_id) {
		/*获得指定品牌cats*/
		$cats = R ( "Api/Cat/get_cat" ,array($brand_id));
		$cat_all = R ( "Api/Cat/get_cats" ,array("大牌钜惠"));
		foreach($cats['list'] as $v){
			$list[] = $v;
			$list_ids[] = $v['id'];
		}
		foreach($cat_all as $v){
			if( !in_array($v[id],$list_ids))
			$list[] = $v;
		}
		return $list;
	}

}










