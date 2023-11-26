<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: taobao_index.php 10455 2017-06-28 02:03:20Z ²Ý-¸ù-°É $
 */

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_GET['op'] == 'del_history'){
	dsetcookie("sch_history", '');
	dexit();
}

require_once libfile('function/home');
@include_once DISCUZ_ROOT.'./data/sysdata/cache_zhuzhu_taobao_category.php';
$_G['cache']['zhuzhu_taobao_category'] = $zhuzhu_taobao_category;

$keyword = $_GET['keyword'] ? $_GET['keyword'] : $var['q_key'];
if($_GET['category_id']){
	$keyword = $zhuzhu_taobao_category[$_GET['category_id']]['keyword'];
}
$category   = CateForChild($_G['cache']['zhuzhu_taobao_category']);
$category_f = getFatherId($_G['cache']['zhuzhu_taobao_category'], $_GET['category_id']);
foreach($category_f as $value) {
	$f_category_id[] = $value['category_id'];
}

$cat = intval($_GET['cat']);
$platform = $_G['mobile'] ? 2 : 1;

$perpage = $_G['mobile'] ? '20' : '20';
$page = max(1, intval($_GET['page']));

$theurl = 'plugin.php?id=zhuzhu_taobao&mod=quan&keyword='.$keyword;
if($_G['charset'] !== 'utf-8' && !$_G['mobile']) $keyword = diconv(urldecode($keyword), CHARSET, 'utf-8');
if($_G['mobile']) {
	$keywords = diconv(urlencode($keyword), CHARSET, 'utf-8');
	$keyword = diconv($keyword, CHARSET, 'utf-8');
	if($_GET['keyword']){
		dsetcookie("sch_history", $_G['cookie']['sch_history'].'|'.$keyword);
	}
}

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkDgItemCouponGetRequest;
$req->setAdzoneId($appadzoneid);
$req->setPlatform($platform);
if($cat) $req->setCat($cat);
$req->setPageSize(''.$perpage.'');
$req->setQ(''.$keyword.'');
$req->setPageNo(''.$page.'');
$resp = $c->execute($req);
$resp = json_decode(json_encode($resp),true);
$count = $resp['total_results'];
$resp = $resp['results']['tbk_coupon'];
if($count) {
	foreach($resp as $key=>$v){
		$v['small_images'] = $v['small_images']['string'];
		if($_G['charset'] !== 'utf-8'){
			$v['coupon_info'] = diconv($v['coupon_info'], 'utf-8', CHARSET);
			$v['nick'] = diconv($v['nick'], 'utf-8', CHARSET);
			$v['shop_title'] = diconv($v['shop_title'], 'utf-8', CHARSET);
			$v['title'] = diconv($v['title'], 'utf-8', CHARSET);
		}
		$v['e'] = str_replace("https://uland.taobao.com/coupon/edetail?e=","", $v['coupon_click_url']);
		$v['q_price']= findNum(substr($v['coupon_info'], -6));
		$v['q_price'] = $v['zk_final_price'] - $v['q_price'];
		$list[] = $v;
	}
	$multi = multi($count, $perpage, $page, $theurl);
}

$seo = $zz_seo['quan'];

$indexseoset = array(
	'seotitle' => $seo['seotitle'],
	'seokeywords' => $seo['seokeywords'],
	'seodescription' => $seo['seodescription']
);

$foot_key = explode(',', $indexseoset['seokeywords']);
list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

if($_G['mobile']){
	include template('zhuzhu_taobao:t_quan');
}else{
	include template('diy:t_quan', '0', 'source/plugin/zhuzhu_taobao/template');
}

function findNum($str=''){
	$str=trim($str);
	if(empty($str)){return '';}
	$result='';
	for($i=0;$i<strlen($str);$i++){
		if(is_numeric($str[$i])){
			$result.=$str[$i];
		}
	}
	return $result;
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
//From:www_caogen8_co
?>