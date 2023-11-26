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

$num = $_G['mobile'] ? 14 : 15;
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

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;

/* Tqg Start  */
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
		if($_G['charset'] !== 'utf-8'){
			$v['category_name'] = diconv($v['category_name'], 'utf-8', CHARSET);
			$v['title'] = diconv($v['title'], 'utf-8', CHARSET);
		}
		$v['width'] = round($v['sold_num']/$v['total_amount']*100, 2);
		$v['start'] = strtotime($v['start_time']);
		$v['end'] = strtotime($v['end_time']);
		if($_G['mobile']) $v['coupon_click_url'] = str_replace("https","taobao", $v['coupon_click_url']);
		$tqg_list[] = $v;
	}
}
/* Tqg End  */

/* Tbrand Start  */
$brand = $_G['cache']['zhuzhu_taobao_brand'];

$req = new TbkDgItemCouponGetRequest;
$req->setAdzoneId($appadzoneid);
$req->setPlatform($platform);
$req->setPageSize('4');
$req->setPageNo('1');
if($cat) $req->setCat($cat);

$i = '1';
foreach($brand as $key=>$value){
	if($i < '7'){
		if($_G['charset'] !== 'utf-8') $value['keyword'] = diconv($value['keyword'], CHARSET, 'utf-8');
		$req->setQ(''.$value['keyword'].'');
		$resp = $c->execute($req);
		$resp = json_decode(json_encode($resp),true);
		$resp = $resp['results']['tbk_coupon'];
		foreach($resp as $v){
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
	$i ++;
}

/* Tbrand End  */

/* Quan Start  */
$q_key = $var['q_key'];
if($_G['charset'] !== 'utf-8') $q_key = diconv($q_key, CHARSET, 'utf-8');

$req = new TbkDgItemCouponGetRequest;
$req->setAdzoneId($appadzoneid);
$req->setPlatform($platform);
$req->setQ(''.$q_key.'');
$req->setPageSize('40');
$req->setPageNo('1');
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
		$quan_list[] = $v;
	}
}
/* Quan End  */

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

$index_left_slide = explode("\n", $var['index_left_slide']);

foreach($index_left_slide as $key => $value) {
	list($pic, $url) = explode('#', $value);
	$left_slide[$key]['pic'] = $pic;
	$left_slide[$key]['url'] = $url;
}

$seo = $zz_seo['index'];

$indexseoset = array(
	'seotitle' => $seo['seotitle'],
	'seokeywords' => $seo['seokeywords'],
	'seodescription' => $seo['seodescription']
);

list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

$foot_key = explode(',', $indexseoset['seokeywords']);


if($_G['mobile']){
	$wap_index_baner_3 = explode("\n", $var['wap_index_baner_3']);
	foreach($wap_index_baner_3 as $key => $value) {
		list($pic, $url) = explode('#', $value);
		$baner_3_slide[$key]['pic'] = $pic;
		$baner_3_slide[$key]['url'] = $url;
	}
	include template('zhuzhu_taobao:t_index');
}else{
	include template('diy:t_index', '0', 'source/plugin/zhuzhu_taobao/template');
}
//From:www_caogen8_co
?>