<?php
namespace Api\Controller;

class CatController extends BaseController {



	/*get cats*/
	public function n_get_level($tag_cat,$level=0,$cat_id='',$need_arr='') {//cat_id所属cat
		$w['cat_id'] = $this->shop_id;
		$w['tag_cat'] = $tag_cat;
		if( !empty($cat_id) )
			$w['master_id'] = $cat_id;
		$count = D2("ViewCatIndex")->where($w)->count (); // 查询满足要求的总记录数
		$Page = new \Think\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$Page->setConfig('theme', "<ul class='pagination no-margin pull-right'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a> %HEADER%  %NOW_PAGE%/%TOTAL_PAGE% 页</a></ul>");
		$show = $Page->show (); // 分页显示输出
		$list['page'] = $show;
		$result = D2("Cat")->where($w)->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$list['result'] = $result;
		return $list;
	}

	public function get_top($tag_cat) {
		$need_arr['top'] = 1;
		return $this->get_level($tag_cat,0,'',$need_arr);
	}

	/*get cats*/
	public function get_level($tag_cat,$level=0,$cat_id='',$need_arr='') {//cat_id所属cat
		$w['tag_cat_level'] = $level;
		$w['tag_cat'] = $tag_cat;
		// 置顶
		if($need_arr['top'] == 1)
			$w['top'] = 1;
		$dats = D2("Cat")->where($w)->order("sort desc")->select();
		if( empty($dats) )
			return false;
		if( !empty($cat_id) ){
			$dats = $this->hook2cat_get($dats,"cat",$cat_id);
		}
		/*店铺过滤*/
		$dats = R ( "Api/Shop/hook2_get" ,array($dats));
		return $dats;
	}

	/*get cat*/
	public function get_cat($cat_id) {
		/*店铺过滤*/
		if( empty( R ( "Api/Shop/hook2_get" ,array($cat_id)) ) )
			return false;
		$w['id'] = $cat_id;
		$cat = D2("Cat")->where($w)->find();
		$tag_cat = $cat['tag_cat'];
		if($tag_cat == '焕新搭配' || $tag_cat == '明星单品' || $tag_cat == '限时购' ){
			// get goods
			$w2['cat_id'] = $cat_id;
			$w2['tag_cat'] = 'goods';
			$cat_i = D2("CatIndex")->where($w2)->find();
			$w3['id'] = $cat_i['tag_id'];
			$cat['good'] = M ( "Good" )->where($w3)->find();
		}
		if($tag_cat == '大牌钜惠' ){
			/*获得所属brand*/
			$w111['tag_id'] = $cat['id'];
			$w111['tag_cat'] = 'cat';
			$w111['cat_name'] = '品牌';
			$brand = D2("CatIndex")->where($w111)->find();
			/*获得brand包含cat*/
			$w44['cat_id'] = $brand["cat_id"];
			$w44['tag_cat'] = 'cat';
			$list = D2("CatIndex")->where($w44)->select();
			foreach($list as $v){
				$w55['id'] = $v["tag_id"];
				$cat_list[] = D2("Cat")->where($w55)->find();
			}
			// /*店铺过滤,已置顶对cat处理，此处先注释*/
			// $cat_list = R ( "Api/Shop/hook2_get" ,array($cat_list));
			$cat['list'] = $cat_list;
		}
		if($tag_cat == '品牌' ){
			/*获得品牌所属活动*/
			$cat['promotion'] = R ( "Api/Cat/get_level" ,array("大牌钜惠",0,$cat_id));
			/*获得品牌所属商品*/
			$w24['cat_id'] = $cat_id;
			$w24['tag_cat'] = 'goods';
			$cat_s = D2("CatIndex")->where($w24)->select();
			foreach($cat_s as $v){
				$w311['id'] = $v['tag_id'];
				$cat['goods'] = M ( "Good" )->where($w311)->find();
			}
		}
		return $cat;
	}
	
	public function get_cats($tag_cat_name) {
		$w['tag_cat'] = $tag_cat_name;
		$cats = D2("Cat")->where($w)->select();
		/*店铺过滤*/
		$cat_list = R ( "Api/Shop/hook2_get" ,array($cats));
		return $cat_list;
	}

	/*get cat*/
	public function get_cat_bytag($tag_id,$tag_cat,$cat_name) {
		if( empty($tag_id) && empty($tag_cat) && empty($cat_name))
			return false;
		$w['tag_id'] = $tag_id;
		$w['tag_cat'] = $tag_cat;
		$w['cat_name'] = $cat_name;
		$dats = D2("Cat")->where($w)->select();
		if( empty($dats) )
			return false;
		return $dats;
	}



	/*CUD操作*/
	public function setup_demo() {
		$data['img'] = '6633';
		$data['name'] = '6633';
		//$data['text'] = serialize('%……！@#￥%！@##￥%sdfsf<body class="" id="grid">');
		$data['p_id'] = '37';
		$this->setup($data,'限时购');
	}
	public function setup($data,$tag_cat,$delete=0) {
		return D2("Cat")->opt_data($data,$tag_cat,$delete);
	}

	/**/
	public function hook2cat_set($tag_id, $tag_cat, $cat_id) {
		D2("Cat")->hook2cat_set($tag_id, $tag_cat, $cat_id);
	}

	public function hook2cat_get($result,$tag_cat, $cat_id) {
		return D2("CatIndex")->hook2cat_get($result, $tag_cat, $cat_id);
	}

	public function hook2cat_remove($cat_id) {
		D2("CatIndex")->hook2cat_remove($cat_id);
	}












}










