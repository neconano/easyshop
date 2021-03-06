<?php
namespace Api\Controller;


class BannerController extends BaseController {

	private $banner;
	function _init() {
		$this->banner = M()->table("banner"); 
	}

	/*get banners*/
	public function get_list() {
		$list = $this->banner->order("sort desc,id desc")->select();
		$list = R ( "Api/Shop/hook2_get" ,array($list,'banner') );
		return $list;
	}

	public function create_demo() {
		$this->change_shop(1);
		$this->create(1,1);
	}
	/*C*/
	public function create() {
		$dat['url'] = $_POST['url'] ? $_POST['url'] : 1;
		$dat['sort'] = $_POST['sort'] ? $_POST['sort'] : 1;
		$dat['img'] = $_POST['img'] ? $_POST['img'] : 1;
		$id = $this->banner->add($dat);
		R ( "Api/Shop/hook2_set" ,array($id, 'banner') );
	}

	/*U*/
	public function update() {
		$w['id'] = $_POST['id'];
		$check = $this->banner->where($w)->find();
		if( empty( $check) )
			return false;
		if(!empty($_POST['img']))
			$dat['img'] = $_POST['img'];
		$this->banner->where($w)->save($_POST);
	}

	/*D*/
	public function Delete() {
		$id = $_POST['id'];
		$this->banner->where("id = '$id'")->delete();
	}

}










