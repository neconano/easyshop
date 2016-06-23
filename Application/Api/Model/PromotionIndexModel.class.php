<?php
namespace Api\Model;

use Think\Model\RelationModel;

class PromotionIndexModel extends RelationModel {
	protected $trueTableName = 'promotion_index'; 

	protected $_validate = array(
   );

  public function hook2promotion_set($promotion_id, $tag_id, $tag_cat, $data_arr, $id){
    $w['id'] = $promotion_id;
    $promotion = D("Promotion")->where($w)->find();
    if( empty($promotion) )
      return false;
    $dat = $data_arr;
    $dat['promotion_id'] = $promotion_id;
    if(!empty($id)){
      $dat[id] = $id;
      D("PromotionIndex")->create($dat);
      D("PromotionIndex")->save();
    }else{
			/*check name repeat*/
      $w2['promotion_id'] = $promotion_id;
      $w2['tag_id'] = $tag_id;
      $w2['tag_cat'] = $tag_cat;
      $check = D("PromotionIndex")->where($w2)->find();
      if($check)
        E('新增失败，同一商品不能重复绑定活动');
      $dat['tag_id'] = $tag_id;
      $dat['tag_cat'] = $tag_cat;
      D("PromotionIndex")->create($dat);
      D("PromotionIndex")->add();
    }
    /*promotion categary*/
    if($promotion['promotion_cat'] == '主题')
    $this->hook2promotion_set_theme($promotion_id,$dat);
    if($promotion['promotion_cat'] == '秒杀')
    $this->hook2promotion_set_seckill($promotion_id,$dat);
    if($promotion['promotion_cat'] == '优惠券')
    $this->hook2promotion_set_coupon($promotion_id,$dat);
  }


	/*hook: relation to theme promotion*/
	public function hook2promotion_set_theme($promotion_id, $data_arr ) {
		$w['promotion_id'] = $promotion_id;
		$dat = D("PromotionExtTheme")->where($w)->find();
		if( empty($dat) ){
			$dat['promotion_id'] = $promotion_id;
			$dat['face_img'] = $data_arr['face_img'];
			$dat['img_list'] = serialize($data_arr['img_list']) ;
			$dat['content'] = $data_arr['content'];
			D("PromotionExtTheme")->add($dat);
		}
		else{
			$dat['face_img'] = $data_arr['face_img']?$data_arr['face_img']:$dat['face_img'];
			$dat['img_list'] = $data_arr['img_list']?$data_arr['img_list']:$dat['img_list'];
			$dat['content'] = $data_arr['content']?$data_arr['content']:$dat['content'];
			$dat['img_list'] = serialize($data_arr['img_list']) ;
			D("PromotionExtTheme")->save($dat);
		}
	}

	/*hook: relation to seckill promotion*/
	public function hook2promotion_set_seckill($promotion_id, $data_arr ) {

	}

	/*hook: relation to coupon promotion*/
	public function hook2promotion_set_coupon($promotion_id, $data_arr ) {

	}



}