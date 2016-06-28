<?php
namespace Api\Model;

use Think\Model\RelationModel;

class CatIndexModel extends BaseModel {
	protected $trueTableName = 'cat_index'; 

	public function hook2cat_set($tag_id, $tag_cat, $cat_id){
		if(empty($tag_id) || empty($tag_cat) || empty($cat_id))
			E('必要数据不存在:1112');
		$w['id'] = $cat_id;
		$dat_cat = D2("Cat")->where($w)->find();
		if( empty($dat_cat) )
			E('数据异常：2221');
		$dat['cat_id'] = $cat_id;
		$dat['tag_id'] = $tag_id;
		$dat['tag_cat'] = $tag_cat;
		$this->create($dat);
		$id = $this->add();
	}

	public function hook2cat_get($result ,$tag_cat , $cat_id ){
		$w['tag_cat'] = $tag_cat;
		$w['cat_id'] = $cat_id;
		$cats = $this->where($w)->select();
		foreach($cats as $v){
			$cats_list[] = $v['tag_id'];
		}
		foreach($result as $v){
			if( in_array($v['id'],$cats_list))
			$result_cats[] = $v;
		}
		return $result_cats;
	}

	public function hook2cat_remove($id ){
		$w['id'] = $id;
		$this->where($w)->delete();
	}

}