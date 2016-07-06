<?php
namespace Api\Controller;

class BrandController extends BaseController {

	public function get_promotion_list($brand_id) {
		/*获得指定品牌cats*/
		$cats = R ( "Api/Cat/get_cat" ,array($brand_id));
		$cat_all = R ( "Api/Cat/get_cats" ,array("大牌钜惠"));
		foreach($cats['list'] as $v){
			$list[] = $v;
			$list_ids[] = $v['id'];
		}
		foreach($cat_all as $v){
			if( !in_array($v[id],$list_ids))
			$list[] = $v;
		}
		return $list;
	}

	public function get_list() {
		$w['tag_cat'] = '品牌';
		$count = D2("Cat")->where($w)->count (); // 查询满足要求的总记录数
		$Page = new \Think\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$Page->setConfig('theme', "<ul class='pagination no-margin pull-right'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a> %HEADER%  %NOW_PAGE%/%TOTAL_PAGE% 页</a></ul>");
		$show = $Page->show (); // 分页显示输出
		$list['page'] = $show;
		$result = D2("Cat")->where($w)->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$list['result'] = $result;
		return $list;
	}

	public function add_brand($name,$id="") {
		if( empty($name) )
			return false;
		if( !empty($id) )
		$data['id'] = $id;
		$data['name'] = $name;
		return R ( "Api/Cat/setup" ,array($data, '品牌'));
	}






}










