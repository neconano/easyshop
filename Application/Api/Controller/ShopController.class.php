<?php
namespace Api\Controller;

class ShopController extends BaseController {
	

	// add 店内活动
	public function add_dnhd($name,$content,$top,$id="") {
		if( empty($name) )
			return false;
		if( !empty($id) )
		$data['id'] = $id;
		$data['name'] = $name;
		$data['top'] = $top;
		$data['content'] = $content;
		return R ( "Api/Cat/setup" ,array($data, '店内活动'));
	}
	
	/*店内活动*/
	public function get_dnhd_list() {
		$w['cat_id'] = $this->shop_id;
		$w['cat_name'] = '商铺';
		$w['tag_cat'] = '店内活动';
		$count = D2("ViewCatIndex")->where($w)->count (); // 查询满足要求的总记录数
		$Page = new \Think\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$Page->setConfig('theme', "<ul class='pagination no-margin pull-right'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a> %HEADER%  %NOW_PAGE%/%TOTAL_PAGE% 页</a></ul>");
		$show = $Page->show (); // 分页显示输出
		$list['page'] = $show;
		$result = D2("Cat")->where($w)->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$list['result'] = $result;
		return $list;
	}	

	public function get_dnhd($id) {
		$w['id'] = $id;
		$result = D2("Cat")->where($w)->find ();
		return $result;
	}	
	

	// set shop
	public function change_shop($id) {
		parent::change_shop($id);
	}

	// add shop
	public function add_shop($name,$id="") {
		if( empty($name) )
			return false;
		if( !empty($id) )
		$data['id'] = $id;
		$data['name'] = $name;
		return R ( "Api/Cat/setup" ,array($data, '商铺'));
	}

	// list shop
	public function list_shop() {
		$w['tag_cat'] = '商铺';
		$cats = D2("Cat")->where($w)->select();
		return $cats;
	}

	/*添加管理员到商铺*/
	public function add_shop_admin($uid,$shop_id) {
		$this->hook2shop_set($uid,'用户',$shop_id);
	}

	/*hook: relation to shop*/
	public function hook2_set($tag_id, $tag_cat, $shop_id='') {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		$this->hook2cat_set($tag_id, $tag_cat, $this->shop_id);
	}
	
	// /*get shop cat*/
	// public function get_shop_cat($tag_cat,$shop_id='') {
	// 	if(empty($shop_id))
	// 		$this->_init_shop();
	// 	else
	// 		$this->shop_id = $shop_id;
	// 	$w['tag_cat'] = $tag_cat;
	// 	$cats = D2("Cat")->where($w)->select();
	// 	return $cats;
	// }	

	/*CUD操作*/
	public function setup_shop_demo() {
		$dat['name'] = '啊啊啊';
		$dat['img'] = '123';
		$this->setup_shop($dat);
	}
	public function setup_shop($data,$delete=0) {
		D2("Cat")->opt_data($data,'商铺',$delete);
	}

	/*hook: filter to shop*/
	public function hook2_get($result) {
		if(empty($shop_id))
			$this->_init_shop();
		else
			$this->shop_id = $shop_id;
		return R ( "Api/Cat/hook2cat_get" ,array($result, 'cat', $this->shop_id));
	}


}










