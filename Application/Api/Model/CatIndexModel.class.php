<?php
namespace Api\Model;

use Think\Model\RelationModel;

class CatIndexModel extends BaseModel {
	protected $trueTableName = 'cat_index'; 

	public function hook2cat_set($tag_id, $tag_cat, $cat_id){
		if(empty($tag_id) || empty($tag_cat) || empty($cat_id))
			E('必要数据不存在:1112');
		/*重复异常*/
		$dat['cat_id'] = $cat_id;
		$dat['tag_id'] = $tag_id;
		$dat['tag_cat'] = $tag_cat;
		if($this->where($dat)->find())
			E('数据异常：5532');
		$w['id'] = $cat_id;
		$dat_cat = D2("Cat")->where($w)->find();
		if( empty($dat_cat) )
			E('数据异常：2221');
		$dat['cat_name'] = $dat_cat['tag_cat'];
		if( $tag_cat == 'cat'){
			$w2['id'] = $tag_id;
			$tag = D2("Cat")->where($w2)->find();
			if( empty($tag) )
			E('4422');
			$dat['tag_cat_name'] = $tag['tag_cat'];
		}
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
		if(is_array($result)){
			foreach($result as $v){
				if( in_array($v['id'],$cats_list))
				$result_cats[] = $v;
			}
		}else{
			if( in_array($result,$cats_list))
			$result_cats[] = $result;
		}
		return $result_cats;
	}

	public function hook2cat_remove($id ){
		$w['id'] = $id;
		$this->where($w)->delete();
	}

}