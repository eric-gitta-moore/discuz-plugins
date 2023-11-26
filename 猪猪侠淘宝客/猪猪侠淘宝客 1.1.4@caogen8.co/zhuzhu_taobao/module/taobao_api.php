<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: taobao_index.php 10455 2017-06-28 02:03:20Z 草-根-吧 $
 */

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once libfile('function/home');
@include_once DISCUZ_ROOT.'./data/sysdata/cache_zhuzhu_taobao_category.php';
$_G['cache']['zhuzhu_taobao_category'] = $zhuzhu_taobao_category;

if(!$_GET['API']){
	exit('Access Denied');
}

header('Content-type:text/json;charset=utf-8');

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;

if($_GET['API'] == 'banner'){

	echo '{"status":1,"content":'.json_encode($slide).'}';

}elseif($_GET['API'] == 'baner_3'){

	$wap_index_baner_3 = explode("\n", $var['wap_index_baner_3']);
	foreach($wap_index_baner_3 as $key => $value) {
		list($pic, $url) = explode('#', $value);
		$baner_3_slide[$key]['pic'] = $pic;
		$baner_3_slide[$key]['url'] = $url;
	}
	echo '{"status":1,"content":'.json_encode($baner_3_slide).'}';

}elseif($_GET['API'] == 'tqg'){
	$num = 15;
	$start = 1;
	$end = 39;
	$connt = 0;
	while($connt<$num){
		$a[]=rand($start,$end);
		$ary=array_unique($a);
		$connt=count($ary);
	}
	foreach ($ary as $key => $value){
		$array[] .= $value;
	}

	$datearr = array("00:00", "08:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "17:00", "19:00", "21:00", "22:00", "23:00", "24:00");

	$Now = dgmdate($_G['timestamp'], 'H').':00';

	foreach($datearr as $key=>$v){
		$key1 = $key - 1;
		$key2 = $key + 1;
		if($v < $Now && $Now < $datearr[$key2] || $v == $Now){
			$start = dgmdate($_G['timestamp'], 'Y-m-d').' '.$v.':00';
			if($Now == "23:00"){
				$end = dgmdate($_G['timestamp'], 'Y-m-d').' '.'23:59:59';
			}else{
				$end = dgmdate(strtotime(dgmdate($_G['timestamp'], 'Y-m-d').' '.$datearr[$key2].':00')-1, 'Y-m-d H:i:s');
			}
		}
		$datelist[] = $v;
	}

	$req = new TbkJuTqgGetRequest;
	$req->setAdzoneId($appadzoneid);
	$req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
	$req->setStartTime("".$start."");
	$req->setEndTime("".$end."");
	$req->setPageNo("1");
	$req->setPageSize("40");
	$resp = $c->execute($req);
	$resp = json_decode(json_encode($resp),true);
	$resp = $resp['results']['results'];
	foreach($resp as $key=>$v){
		if(in_array($key, $array)){
			$v['width'] = round($v['sold_num']/$v['total_amount']*100, 2);
			$v['start'] = strtotime($v['start_time']);
			$v['end'] = strtotime($v['end_time']);
			if($_G['mobile']) $v['coupon_click_url'] = str_replace("https","taobao", $v['coupon_click_url']);
			$tqg_list[] = $v;
		}
	}
	echo '{"status":1,"content":'.json_encode($tqg_list).'}';

}elseif($_GET['API'] == 'coupon'){
	@include_once DISCUZ_ROOT.'./data/sysdata/cache_zhuzhu_taobao_category.php';
	$_G['cache']['zhuzhu_taobao_category'] = $zhuzhu_taobao_category;

	$perpage = '20';
	$page = max(1, intval($_GET['PageNo']));

	$keyword = $_GET['keyWord'] ? $_GET['keyWord'] : $var['q_key'];
	if($_GET['category_id']){
		$keyword = $zhuzhu_taobao_category[$_GET['category_id']]['keyword'];
	}

	$req = new TbkDgItemCouponGetRequest;
	$req->setAdzoneId($appadzoneid);
	$req->setPlatform('2');
	if($cat) $req->setCat($cat);
	$req->setPageSize(''.$perpage.'');
	$req->setQ(''.$keyword.'');
	$req->setPageNo(''.$page.'');
	$resp = $c->execute($req);
	$resp = json_decode(json_encode($resp),true);
	$count = $resp['total_results'];
	$resp = $resp['results']['tbk_coupon'];

	echo '{"status":1,"page":1,"content":'.json_encode($resp).'}';

}elseif($_GET['API'] == 'content'){

	$req = new TbkItemInfoGetRequest;
	$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
	$req->setPlatform("2");
	$req->setNumIids("".$_GET['NumIids']."");
	$resp = $c->execute($req);
	$resp =json_decode(json_encode($resp), true);
	$resp = $resp['results']['n_tbk_item'];

	echo '{"status":1,"page":1,"content":'.json_encode($resp).'}';

}elseif($_GET['API'] == 'taokouling'){

	$req = new TbkTpwdCreateRequest;
	$req->setText($_GET['Text']);
	$req->setUrl($_GET['Url']);
	$req->setLogo($_GET['Logo']);
	$resp = $c->execute($req);
	$resp = json_decode(json_encode($resp),true);

	echo '{"status":1,"content":'.json_encode($resp).'}';

}elseif($_GET['API'] == 'nav'){
	$src = $_G['siteurl'].'/source/plugin/zhuzhu_taobao/static/api/';
	$nav = array(
		array(
			"url" => "/pages/index/index",
			"pic" => $src."home.png",
			"name" => '首页'
		),
		array(
			"url" => "/pages/search/search",
			"pic" => $src."super_icon.png",
			"name" => "分类"
		),
		array(
			"url" => "/pages/brand/brand",
			"pic" => $src."zhemmm.png",
			"name" => "品牌特卖"
		),
		array(
			"url" => "/pages/nine/nine",
			"pic" => $src."fanli.png",
			"name" => "9.9"
		),
		array(
			"url" => "/pages/twenty/twenty",
			"pic" => $src."me.png",
			"name" => "20"
		),
	);

	echo '{"status":1,"page":1,"content":'.json_encode($nav).'}';

}elseif($_GET['API'] == 'category'){
	loadcache(array('zhuzhu_jdk_category', 'zhuzhu_jdk_brand'));

	@include DISCUZ_ROOT.'./data/sysdata/cache_zhuzhu_jdk_category.php';
	$category = $_G['cache']['zhuzhu_jdk_category'] = $zhuzhu_jdk_category;

	echo '{"status":1,"page":1,"content":'.json_encode($_G['cache']['zhuzhu_jdk_category']).'}';

}else{

}
function CateForChild($cate, $upid = 0, $pk = 'category_id') {
	$arr = array();
	foreach($cate as $v) {
		if($v['upid'] == $upid) {
			$v['child'] = CateForChild($cate, $v[$pk], $pk);
			$arr[$v[$pk]] = $v;
		}
	}
	return $arr;
}

function getFatherId($cate, $upid, $pk = 'category_id') {
	$arr = array();
	foreach($cate as $v) {
		if($v[$pk] == $upid) {
			$arr[$v[$pk]] = $v;
			$arr = array_merge(getFatherId($cate, $v['upid'], $pk), $arr);
		}
	}
	return $arr;
}
?>