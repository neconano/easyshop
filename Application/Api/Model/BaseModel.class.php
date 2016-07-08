<?php
namespace Api\Model;

use Think\Model\RelationModel;

class BaseModel extends RelationModel {

}

/*model redrect*/
function D2($name='',$layer='') {
	return D('Api/'.$name, $layer) ;
}

function pull_array($data,$ext) {
	foreach($ext as $k=>$v){
		$data[$k] = $v;
	}
	return $data;
}
