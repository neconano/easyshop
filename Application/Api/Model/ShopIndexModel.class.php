<?php
namespace Api\Model;

use Think\Model\RelationModel;

class ShopIndexModel extends BaseModel {
	protected $trueTableName = 'shop_index'; 

   public function hook2shop_set($tag_id, $tag_cat, $id, $shop_id){
		if(empty($tag_id) || empty($tag_cat) || empty($shop_id))
          E('必要数据不存在');
		$dat['shop_id'] = $shop_id;
		if(!empty($id)){
			$dat[id] = $id;
			$this->create($dat);
			$this->save();
		}else{
			$dat['tag_id'] = $tag_id;
			$dat['tag_cat'] = $tag_cat;
			$this->create($dat);
			return $this->add();
		}
   }


}