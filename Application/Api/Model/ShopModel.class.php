<?php
namespace Api\Model;

use Think\Model\RelationModel;

class ShopModel extends RelationModel {
	protected $trueTableName = 'shop'; 

	protected $_validate = array(
     array('shop','','标识已经存在！',0,'unique',1),
   );

   public function setup_shop($shop,$shop_cat,$id){
      $dat['shop'] = $shop;
      if(!empty($id)){
        $dat[id] = $id;
        /*check name repeat*/
        $w['shop'] = $dat['shop'];
        $w['id'] = array("neq",$id);
        if(D("Shop")->where($w)->find())
          E('设置失败，数据异常');
        D("Shop")->create($dat);
        D("Shop")->save();
      }else{
        $dat['shop_cat'] = $shop_cat;
        /*check name repeat*/
        $w['shop'] = $dat['shop'];
        if(D("Shop")->where($w)->find())
          E('新增失败，同一商铺名称不能重复');
        D("Shop")->create($dat);
        return D("Shop")->add();
      }
   }

}