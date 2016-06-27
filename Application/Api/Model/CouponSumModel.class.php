<?php
namespace Api\Model;

use Think\Model\RelationModel;

class CouponSumModel extends BaseModel {
	protected $trueTableName = 'coupon_sum'; 
	protected $_auto = array ( 
		array('dateline','time',1,'function'),
     );
	protected $_validate = array(
		//array('dateline','require','必须！'), //默认情况下用正则进行验证
   );

	/*生成优惠券*/
	public function make_coupon($dat) {
		$this->create($dat);
		$id = $this->add();
		if($id){
			$coupon = $this->where("id = '$id'")->find();
			D2("coupon")->make_coupon_by_sum($coupon);
			/*relation to shop*/
			$menuresult = R ( "Api/Shop/hook2shop_set",array($id, '优惠券sum', '', $dat['shop_id']) );
		}
		return true;
	}

}