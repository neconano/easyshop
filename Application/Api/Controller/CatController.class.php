<?php
namespace Api\Controller;

class CatController extends BaseController {


	public function get_top($tag_cat) {
		$need_arr['top'] = 1;
		return $this->get_level($tag_cat,0,'',$need_arr);
	}

	public function get_level($tag_cat,$level=0,$cat_id='',$need_arr='') {
		$w['tag_cat_level'] = $level;
		$w['tag_cat'] = $tag_cat;
		$w['shop_id'] = $this->shop_id;
		// 置顶
		if($need_arr['top'] == 1)
			$w['top'] = 1;
		$dat = D2("Cat")->where($w)->order("sort desc")->select();
		if( empty($dat) )
			return false;
		if( !empty($cat_id) ){
			$dat = $this->hook2cat_get($dat,"cat",$cat_id);
		}
		return $dat;
	}

	public function get_cat($cat_id) {
		$w['id'] = $cat_id;
		$cat = D2("Cat")->where($w)->find();
		$tag_cat = $cat['tag_cat'];
		if($tag_cat == '焕新搭配' || $tag_cat == '明星单品' || $tag_cat == '限时购' ){
			$w2['cat_id'] = $cat_id;
			$cat['good'] = M ( "Good" )->where($w2)->find();
		}
		return $cat;
	}

	/*CUD操作*/
	public function setup_demo() {
		$data['img'] = '6666';
		$data['name'] = '222';
		//$data['p_id'] = '17';
		$this->setup($data,'大牌钜惠');
	}
	public function setup($data,$tag_cat,$delete=0) {
		D2("Cat")->opt_data($data,$tag_cat,$delete);
	}

	/**/
	public function hook2cat_set($tag_id, $tag_cat, $cat_id) {
		D2("Cat")->hook2cat_set($tag_id, $tag_cat, $cat_id);
	}

	public function hook2cat_get($result,$tag_cat, $cat_id) {
		return D2("CatIndex")->hook2cat_get($result, $tag_cat, $cat_id);
	}

	public function hook2cat_remove($cat_id) {
		D2("CatIndex")->hook2cat_remove($cat_id);
	}












}










