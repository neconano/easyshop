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
        $this->create($dat);
        return $this->add();
      }
  }







}