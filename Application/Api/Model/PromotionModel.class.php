<?php
namespace Api\Model;

use Think\Model\RelationModel;

class PromotionModel extends BaseModel {
	protected $trueTableName = 'promotion'; 

	protected $_validate = array(
   );

	/*get shop promotion*/
	public function get_promotion($tag_cat,$shop_id,$flag,$promotion_id,$recent) {
    if( empty($promotion_id) ){
      if( empty($shop_id) )
        E('商铺不存在');
      $w['shop_id'] = $shop_id;
      $w['tag_cat'] = $tag_cat;
      //get promotions
      $list = D2("ShopIndex")->where($w)->select();
      foreach($list as $v){
        $promotion_list[] = $this->_get_promotion($v['tag_id'],$flag);
        return $promotion_list;
      }
      if( !empty($recent) ){
        $w22['end_time'] = array("gt",time()) ;
        $promotion = $this->where($w22)->order('start_time asc')->find();
        return $promotion;
      }
    }else if( !empty($promotion_id) ){
        $promotion = $this->_get_promotion($promotion_id,$flag);
        return $promotion;
    }else{
	    E('必要数据不存在');
    }
	}
	public function _get_promotion($promotion_id,$flag) {
			$w2['id'] = $promotion_id;
			$promotion = $this->where($w2)->find();
      if($flag == 1){
        /*obtain contain goods*/
        $w4['promotion_id'] = $promotion['id'];
        $tags = D2("PromotionIndex")->where($w4)->select();
        foreach($tags as $v2){
          if($v2['tag_cat'] == '商品'){
            $w3['id'] = $v2['tag_id'];
            $goods[] = M("Good")->where($w3)->find();
          }
          /*others*/

        }
	      $promotion['goods'] = $goods; 
      }
      return $promotion;
  }

	/*get promotion goods*/
	public function get_promotion_goods($tag_cat,$promotion_id) {
		if( empty($promotion_id) || empty($tag_cat) )
          E('必要数据不存在');
		$w['promotion_id'] = $promotion_id;
		$w['tag_cat'] = $tag_cat;
		$list = D2("promotionIndex")->where($w)->select();
		foreach($list as $v){
			$w2['id'] = $v['tag_id'];
      M ( "Good" )->where($w2)->select();
    }
		return $goods_list;
	}

  public function setup_promotion($promotion,$promotion_cat,$id){
    $dat['promotion'] = $promotion;
    if(!empty($id)){
      $dat[id] = $id;
      /*check name repeat*/
      $w['promotion'] = $dat['promotion'];
      $w['id'] = array("neq",$id);
      if($this->where($w)->find())
        return false;
      $this->create($dat);
      $this->save();
    }else{
      $dat['promotion_cat'] = $promotion_cat;
      /*check name repeat*/
      $w['promotion'] = $dat['promotion'];
      if($this->where($w)->find())
        return false;
      $this->create($dat);
      $id = $this->add();
      /*promotion must belong to an shop */
	      R ( "Api/Shop/hook2shop_set", array($id,$promotion_cat) );
      }
   }





}