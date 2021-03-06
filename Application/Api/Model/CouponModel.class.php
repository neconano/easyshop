<?php
namespace Api\Model;

use Think\Model\RelationModel;

class CouponModel extends BaseModel {
	protected $trueTableName = 'coupon'; 
	private $code_list = array();

	/*poll coupon check notice*/
	public function poll_coupon($shop_id) {
		if(empty($shop_id))
			return false;
		$w['is_use'] = 0;
		$w['shop_id'] = $shop_id;
		$w['push_time'] = array("gt",time()-60*20);//20分钟内
		$reuslt = $this->where($w)->select();
		return $reuslt;
	}

	/*push coupon check notice*/
	public function push_coupon($id) {
		$w['id'] = $id;
		$w['is_use'] = 0;
		$dat['push_time'] = time();
		$this->where($w)->save($dat);
	}

	/*give_coupon*/
	public function give_coupon($admin_id,$id,$coupon_code) {
		if( empty($id) && empty($coupon_code))
			return false;
		if($id)
		$w['id'] = $id;
		else
		$w['coupon_code'] = $coupon_code;
		$dat['is_use'] = 1;
		$dat['use_time'] = time();
		$dat['admin_id'] = $admin_id;
		$this->where($w)->save($dat);
	}

	/*生成优惠券*/
	public function make_coupon_by_sum($dat) {
		$sum_id = $dat[id];
		unset($dat[id]);
		$num = $dat['num'];
		if( empty($num) )
			return false;
		for($i=0;$i<$num;$i++){
			$dat2 = null;
			$dat2 = $dat;
			$code = $this->_make_coupon_code($dat);
			$dat2['sum_id'] = $sum_id;
			$dat2['coupon_code'] = $code;
			// $dat2['tag_id'] = $dat['tag_id'];
			// $dat2['tag_cat'] = $dat['tag_cat'];
			//$dat2['shop_id'] = $dat['shop_id'];
			$dat2['finish_date'] = $dat['finish_date'];
			$this->create($dat2);
			$id = $this->add();
			/*relation to shop*/
			$menuresult = R ( "Api/Shop/hook2_set",array($id, 'coupon', $dat['shop_id']) );
			/*所属cat*/
			D2("CatIndex")->hook2cat_set($id, 'coupon', $dat['master_id']);
		}
		return true;
	}

	/*make code*/
	public function _make_coupon_code($dat) {
		$sum_id = sprintf("%04d", $dat["id"]);//生成4位数，不足前面补0   
		$rand = $this->_generateCode();
		$code = $sum_id.$rand[0];
		if(!in_array($code,$this->code_list))
		array_push($this->code_list,$code);
		else
		$code = $this->_make_coupon_code($dat);
		return $code;
	}

	/**
     * 生成vip激活码
     * @param int $nums             生成多少个优惠码
     * @param array $exist_array     排除指定数组中的优惠码
     * @param int $code_length         生成优惠码的长度
     * @param int $prefix              生成指定前缀
     * @return array                 返回优惠码数组
     */
    public function _generateCode( $nums=1,$exist_array='',$code_length = 4,$prefix = '' ) {
        //$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz";
        $characters = "0123456789";
        $promotion_codes = array();//这个数组用来接收生成的优惠码
        for($j = 0 ; $j < $nums; $j++) {
            $code = '';
            for ($i = 0; $i < $code_length; $i++) {
                $code .= $characters[mt_rand(0, strlen($characters)-1)];
            }
            //如果生成的4位随机数不再我们定义的$promotion_codes数组里面
            if( !in_array($code,$promotion_codes) ) {
                if( is_array($exist_array) ) {
                    if( !in_array($code,$exist_array) ) {//排除已经使用的优惠码
                        $promotion_codes[$j] = $prefix.$code; //将生成的新优惠码赋值给promotion_codes数组
                    } else {
                        $j--;
                    }
                } else {
                    $promotion_codes[$j] = $prefix.$code;//将优惠码赋值给数组
                }
            } else {
                $j--;
            }
        }
        return $promotion_codes;
    }

	
}