<?php
namespace Api\Model;

use Think\Model\RelationModel;

class CatModel extends BaseModel {
	protected $trueTableName = 'cat'; 

	protected $_validate = array(
   );

  /*C/U操作*/
  public function setup($data,$tag_cat){
      /*U*/
      if(!empty($data['id'])){
        $this->create($data);
        $this->save();
      }else{
      /*C*/
        if( empty($tag_cat) )
	        E('必要数据不存在:4442');
        if( $tag_cat != '商铺' && empty(session('shop_id')) )
          E('必要数据不存在:221');
        if( !empty($data['p_id'])){
          $w['id'] = $data['p_id'];
          $w['tag_cat'] = $tag_cat;
          $d = $this->where($w)->find();
          if( !empty($d) )
          $data['tag_cat_level'] = $d["tag_cat_level"]+1;//tag_cat要相同
        }
        $data['tag_cat'] = $tag_cat;
        $this->create($data);
        $id = $this->add();
        if( !empty($data['p_id'])){
          /*所属cat*/
          D2("CatIndex")->hook2cat_set($id, 'cat', $data['p_id']);
        }
        if( $data['tag_cat'] != '商铺' ){
          /*所属商铺*/
          D2("CatIndex")->hook2cat_set($id, 'cat', session('shop_id'));
        }
      }
  }

  /*D操作*/
  public function remove($id){
      if( empty($id) )
          E('必要数据不存在:12322');
			$w['id'] = $id;
			$d['is_delete'] = 1;
			D2("Shop")->where($w)->save($d);
  }

	/*CUD操作*/
	public function opt_data($data,$tag_cat,$delete=0) {
		if($delete == 1){
			$this->remove($data['id']);
			return true;
		}
		return $this->setup($data,$tag_cat);
	}


}