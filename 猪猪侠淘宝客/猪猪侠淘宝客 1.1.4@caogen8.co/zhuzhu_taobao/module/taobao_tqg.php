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

$datearr = array("00:00", "08:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "17:00", "19:00", "21:00", "22:00", "23:00", "24:00");

if($_GET['date']){
	$Now = $datearr[$_GET['date']];
}else{
	$Now = dgmdate($_G['timestamp'], 'H').':00';
}
foreach($datearr as $key=>$v){
	$key1 = $key - 1;
	$key2 = $key + 1;
	if($v < $Now && $Now < $datearr[$key2] || $v == $Now){

		if($_GET['date']){
			$start = dgmdate($_G['timestamp'], 'Y-m-d').' '.$Now.':00';
			if($Now == '23:00'){
				$end = dgmdate($_G['timestamp'], 'Y-m-d').' '.'23:59:59';
			}else{
				$end = dgmdate(strtotime(dgmdate($_G['timestamp'], 'Y-m-d').' '.$datearr[$_GET['date']+1].':00')-1, 'Y-m-d H:i:s');
			}
		}else{
			$start = dgmdate($_G['timestamp'], 'Y-m-d').' '.$v.':00';
			if($Now == '23:00'){
				$end = dgmdate($_G['timestamp'], 'Y-m-d').' '.'23:59:59';
			}else{
				$end = dgmdate(strtotime(dgmdate($_G['timestamp'], 'Y-m-d').' '.$datearr[$key2].':00')-1, 'Y-m-d H:i:s');
			}

		}
	}
	$datelist[] = $v;
}

$perpage = '20';
$page = max(1, intval($_GET['page']));

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;

$req = new TbkJuTqgGetRequest;
$req->setAdzoneId($appadzoneid);
$req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
$req->setStartTime("".$start."");
$req->setEndTime("".$end."");
$req->setPageNo("".$page."");
$req->setPageSize("".$perpage."");
$resp = $c->execute($req);
$resp = json_decode(json_encode($resp),true);

$count = '10000';
$resp = $resp['results']['results'];
if($count) {
	foreach($resp as $key=>$v){
		if($_G['charset'] !== 'utf-8'){
			$v['category_name'] = diconv($v['category_name'], 'utf-8', CHARSET);
			$v['title'] = diconv($v['title'], 'utf-8', CHARSET);
			//$v['pic_url'] = '<img src='.$v['pic_url'].' />';
			$v['start'] = strtotime($v['start_time']);
			$v['end'] = strtotime($v['end_time']);
		}
		if($_G['mobile']) $v['coupon_click_url'] = str_replace("https","taobao", $v['coupon_click_url']);
		$list[] = $v;
	}
}

$seo = $zz_seo['tqg'];

$indexseoset = array(
	'seotitle' => $seo['seotitle'],
	'seokeywords' => $seo['seokeywords'],
	'seodescription' => $seo['seodescription']
);
$foot_key = explode(',', $indexseoset['seokeywords']);
list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

if($_G['mobile']){
	$m_slide = explode("\n", $var['m_slide']);
    foreach($m_slide as $key => $value) {
        list($pic, $url) = explode('#', $value);
        $slide[$key]['pic'] = $pic;
        $slide[$key]['url'] = $url;
    }
	include template('zhuzhu_taobao:t_tqg');
}else{
	include template('diy:t_tqg', '0', 'source/plugin/zhuzhu_taobao/template');
}
//From:www_caogen8_co
?>