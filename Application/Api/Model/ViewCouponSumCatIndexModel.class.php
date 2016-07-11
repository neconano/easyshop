<?php
namespace Api\Model;
use Think\Model\ViewModel;

class ViewCouponSumCatIndexModel extends ViewModel  {
   public $viewFields = array(
     'CouponSum'=>array('_table'=>"coupon_sum",'_type'=>'Right','id','title','num','dateline','finish_date','master_list','master_id'),
     'CatIndex'=>array('_table'=>"cat_index",'cat_id','cat_name','_on'=>'CouponSum.id=CatIndex.tag_id and CatIndex.tag_cat = "coupon-sum"'),
   );
}


