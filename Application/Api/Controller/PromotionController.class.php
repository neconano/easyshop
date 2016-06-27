<?php
namespace Api\Controller;

/*
*1.一个goods只能属于一个promotion
*2.promotion表内无对应shop，会已shop_index的形式对应
*3.promotion类型为theme,seckill,coupon
*/

class PromotionController extends BaseController {

	public function get_the_promotion_demo() {
		$promotion_id = 1;
		$flag = 1;
		$a = $this->get_the_promotion($promotion_id,$flag);
		dump($a);
	}
	/*get the promotion*/
	public function get_the_promotion($promotion_id,$flag) {
		$list = D2("Promotion")->get_promotion('','',$flag,$promotion_id);
		return $list;
	}
	
	public function get_home_seckill_demo() {
		$this->change_shop(1);
		$a = $this->get_home_seckill();
		dump($a);
	}
	/*get home page seckill promotion*/
	public function get_home_seckill($shop_id="",$flag="") {
		/*get recent*/
		$list = $this->get_promotion('秒杀',$shop_id,$flag,'',1);
		return $list;
	}
	
	public function get_promotion_demo() {
		$this->change_shop(1);
		$a = $this->get_promotion('主题','',1);
		dump($a[0]);
	}
	/*get shop promotion*/
	public function get_promotion($tag_cat,$shop_id="",$flag="",$tag_id="",$recent="") {
		if( empty($shop_id))
		$shop_id = $this->shop_id;
		$list = D2("Promotion")->get_promotion($tag_cat,$shop_id,$flag,$tag_id,$recent);
		return $list;
	}

	public function setup_promotion_demo() {
		$this->change_shop(1);
		//$this->setup_promotion('44');
		$this->setup_promotion('444432','秒杀');
	}
	/*setup*/
	/*promotion must belong to an shop */
	public function setup_promotion($promotion,$promotion_cat='主题',$id="",$delete=0) {
		if($delete == 1){
			$w['id'] = $id;
			$d['is_delete'] = 1;
			D2("Promotion")->where($w)->save($d);
			return true;
		}
		D2("Promotion")->setup_promotion($promotion,$promotion_cat,$id);
		return true;
	}
	
	public function hook2promotion_set_demo() {
		$data_arr['num'] = 101;
		$data_arr['price'] = 222;
		$data_arr['face_img'] = 222;
		$this->hook2promotion_set(2,1,"商品",$data_arr);
	}
	/*hook: relation to promotion*/
	public function hook2promotion_set($promotion_id, $tag_id, $tag_cat, $data_arr=array(), $id='') {
		if(empty($promotion_id) || empty($tag_id) || empty($tag_cat))
			return false;
		D2("PromotionIndex")->hook2promotion_set($promotion_id, $tag_id, $tag_cat, $data_arr, $id);
	}

	/*hook: get goods belong promotion*/
	public function hook2promotion_get($goods_id) {
		$tag_id = $goods_id;
		$tag_cat = '商品';
		$w['tag_id'] = $tag_id;
		$w['tag_cat'] = $tag_cat;
		return D2("PromotionIndex")->where($w)->find();
	}



}










