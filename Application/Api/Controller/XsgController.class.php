<?php
namespace Api\Controller;
use Think\Image;
use Think\Upload;

class XsgController extends BaseController {


	public function add($data) {
		return R ( "Api/Cat/add_cat" ,array('限时购',$data));
	}	

	public function get_list($level=0,$master_id=0) {
		$list = R ( "Api/Cat/n_get_level" ,array("限时购",$level,$master_id));
		return $list;
	}	

	public function get($id) {
		$w['id'] = $id;
		$result = D2("Cat")->where($w)->find ();
		$result = unserialize($result[text]);
		return $result;
	}	


}










