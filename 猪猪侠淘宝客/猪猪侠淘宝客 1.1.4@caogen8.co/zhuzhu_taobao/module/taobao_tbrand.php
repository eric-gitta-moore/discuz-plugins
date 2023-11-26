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

require_once libfile('function/home');
$brand = $_G['cache']['zhuzhu_taobao_brand'];
$brand_id = intval($_GET['brand_id']);
$platform = $_G['mobile'] ? 2 : 1;

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkDgItemCouponGetRequest;
$req->setAdzoneId($appadzoneid);
$req->setPlatform($platform);

$theurl = 'plugin.php?id=zhuzhu_taobao&mod=tbrand';
if($_GET['op'] == 'view'){
	$keyword = $brand[$brand_id]['keyword'];
	if($_G['charset'] !== 'utf-8') {
		if($_G['mobile']){
			$keyword = diconv($keyword, CHARSET, 'utf-8');
		}else{
			$keyword = diconv(urldecode($keyword), CHARSET, 'utf-8');
		}
	}
	$req->setPageSize('100');
	$req->setPageNo(''.$_GET['page'].'');
	$req->setQ(''.$keyword.'');
	$resp = $c->execute($req);
	$resp = json_decode(json_encode($resp),true);
	$resp = $resp['results']['tbk_coupon'];
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
}else{

	foreach($brand as $key=>$value){
		if($_G['charset'] !== 'utf-8') $value['keywords'] = diconv($value['keyword'], CHARSET, 'utf-8');
		$req->setQ(''.$value['keywords'].'');
		$req->setPageSize('4');
		$req->setPageNo('1');
		$resp = $c->execute($req);
		$resp = json_decode(json_encode($resp),true);

		$resp = $resp['results']['tbk_coupon'];
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
			$value['list'][] = $v;
		}
		$brandlist[] = $value;
	}
}

$seo = $zz_seo['brand'];

$indexseoset = array(
	'seotitle' => $seo['seotitle'],
	'seokeywords' => $seo['seokeywords'],
	'seodescription' => $seo['seodescription']
);
$foot_key = explode(',', $indexseoset['seokeywords']);
list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

include template('zhuzhu_taobao:t_brand');

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
//From:www_caogen8_co
?>