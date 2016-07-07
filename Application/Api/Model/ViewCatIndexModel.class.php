<?php
namespace Api\Model;
use Think\Model\ViewModel;

class ViewCatIndexModel extends ViewModel  {
   public $viewFields = array(
     'Cat'=>array('_table'=>"cat",'_type'=>'Right','id','name','tag_cat','tag_cat_level','img','text','sort','top','master_id'),
     'CatIndex'=>array('_table'=>"cat_index",'cat_id','cat_name','_on'=>'Cat.id=CatIndex.tag_id and CatIndex.tag_cat = "cat"'),
   );
}


