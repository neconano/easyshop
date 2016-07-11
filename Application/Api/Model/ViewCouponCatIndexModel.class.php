<?php
namespace Api\Model;
use Think\Model\ViewModel;

class ViewCouponCatIndexModel extends ViewModel  {
   public $viewFields = array(
     'Coupon'=>array('_table'=>"coupon",'_type'=>'Right','id','sum_id','coupon_code','is_use','use_time','tel_user','admin_id','is_delete','push_time','finish_date','master_list','master_id'),
     'CatIndex'=>array('_table'=>"cat_index",'cat_id','cat_name','_on'=>'Coupon.id=CatIndex.tag_id and CatIndex.tag_cat = "coupon"'),
   );
}


