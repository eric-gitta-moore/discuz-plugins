<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: taobao_index.php 10455 2017-06-28 02:03:20Z Вн-Иљ-АЩ $
 */

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/home');

$cat = $_GET['cat'] ? intval($_GET['cat']) : '50010850';
$ac = $_GET['ac'];

if($_GET['cat']){
	$cats = C::t('#zhuzhu_taobao#zhuzhu_taobao_cat')->fetch_all_by_search(array('tb_cat' => $cat));
	if($cats['0']['tb_key']){
	$keyword = $cats['0']['tb_key'];
	}
}else{
	$keyword = $var['t_key'];
}

if($_GET['is_tmall']) $_GET['is_tmall'] = 'true';
if($_GET['is_overseas']) $_GET['is_overseas'] = 'true';

$perpage = $_G['mobile'] ? '20' : '100';
$page = max(1, intval($_GET['page']));

$_GET['start_price'] = $_GET['start_price'] ? intval($_GET['start_price']) : '';
$_GET['end_price'] = $_GET['end_price'] ? intval($_GET['end_price']) : '';

$get = array(
	'id' => 'zhuzhu_taobao',
	'mod' => 'tbk',
	'cat' => $_GET['cat'],
	'is_tmall' => $_GET['is_tmall'],
	'sort' => $_GET['sort'],
	'is_overseas' => $_GET['is_overseas'],
	'sort' => $_GET['sort'],
	'ac' => $_GET['ac'],
	'start_price' => $_GET['start_price'],
	'end_price' => $_GET['end_price'],
);

if($_G['charset'] !== 'utf-8' && !$_G['mobile']) $keyword = diconv(urldecode($keyword), CHARSET, 'utf-8');
if($_G['mobile']) {
	$keywords = diconv(urlencode($keyword), CHARSET, 'utf-8');
	$keyword = diconv($keyword, CHARSET, 'utf-8');
}

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkItemGetRequest;
$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
$req->setQ("".$keyword."");
$req->setCat("".$cat."");
$req->setItemloc("");
$req->setSort("".$_GET['sort']."");
$req->setIsTmall($_GET['is_tmall']);
$req->setIsOverseas($_GET['is_overseas']);
if($_GET['ac'] == '9k9'){
	$req->setStartPrice('9');
	$req->setEndPrice('10');
}elseif($_GET['ac'] == '39k9'){
	$req->setStartPrice("39");
	$req->setEndPrice("40");
}else{
	if($_GET['start_price'] || $_GET['end_price']){
		$req->setStartPrice("".$_GET['start_price']."");
		$req->setEndPrice("".$_GET['end_price']."");
	}elseif($var['StartPrice'] && $var['EndPrice']){
		$req->setStartPrice("".$var['StartPrice']."");
		$req->setEndPrice("".$var['EndPrice']."");
	}
}

$req->setPlatform("1");
$req->setPageNo("".$page."");
$req->setPageSize("".$perpage."");
$resp = $c->execute($req);
$resp = json_decode(json_encode($resp),true);

$count = $resp['total_results'];
$resp = $resp['results']['n_tbk_item'];

$theurl = 'plugin.php?'.url_implode($get);
$url = "plugin.php?id=zhuzhu_taobao&mod=tbk";
if($count) {
	foreach($resp as $key=>$v){
		if($_G['charset'] !== 'utf-8'){
			$v['nick'] = diconv($v['nick'], 'utf-8', CHARSET);
			$v['provcity'] = diconv($v['provcity'], 'utf-8', CHARSET);
			$v['title'] = diconv($v['title'], 'utf-8', CHARSET);
		}
		$list[] = $v;
	}
	$multi = multi($count, $perpage, $page, $theurl);
}

$seo = $zz_seo['tbk'];

$indexseoset = array(
	'seotitle' => $seo['seotitle'],
	'seokeywords' => $seo['seokeywords'],
	'seodescription' => $seo['seodescription']
);
$foot_key = explode(',', $indexseoset['seokeywords']);
list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

include template('zhuzhu_taobao:t_tbk');

function page_url($gets) {
	$arr = array();
	foreach ($gets as $key => $value) {
		if($value) {
			$arr[] = $key.'='.urlencode($value);
		}
	}
	return implode('&', $arr);
}
//WWW.CAOGEN8.CO
?>