<?php
namespace Api\Model;

use Think\Model\RelationModel;

class PromotionModel extends RelationModel {
	protected $trueTableName = 'promotion'; 

	protected $_validate = array(
   );

   public function setup_promotion($promotion,$promotion_cat,$id){
      $dat['promotion'] = $promotion;
      if(!empty($id)){
        $dat[id] = $id;
        /*check name repeat*/
        $w['promotion'] = $dat['promotion'];
        $w['id'] = array("neq",$id);
        if(D("Promotion")->where($w)->find())
          return false;
        D("Promotion")->create($dat);
        D("Promotion")->save();
      }else{
        $dat['promotion_cat'] = $promotion_cat;
        /*check name repeat*/
        $w['promotion'] = $dat['promotion'];
        if(D("Promotion")->where($w)->find())
          return false;
        D("Promotion")->create($dat);
        $id = D("Promotion")->add();
        /*promotion must belong to an shop */
	      R ( "Api/Shop/hook2shop_set", array($id,$promotion_cat) );
      }
   }




}