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
require_once libfile('function/core', 'plugin/zhuzhu_taobao');

$itemid = $_GET['num_iid'];
$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkItemRecommendGetRequest;
$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
$req->setNumIid("".$itemid."");
$req->setCount("20");
$req->setPlatform("1");
$resp = $c->execute($req);
$resp =json_decode(json_encode($resp), true);
$other = $resp['results']['n_tbk_item'];

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkItemInfoGetRequest;
$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
$req->setPlatform("1");
$req->setNumIids("".$itemid."");
$resp = $c->execute($req);
$resp =json_decode(json_encode($resp), true);
$detail = $resp['results']['n_tbk_item'];

$v = get_item_taobao($itemid);

$kw = $resp['results']['n_tbk_item']['0']['title'];
$u = 'http://zhannei.baidu.com/api/customsearch/keywords?title='.$kw;
$comtxt = file_get_contents($u);
$comtxts=array();
$comtxts=json_decode($comtxt,true);

if($_G['charset'] !== 'utf-8'){
	$other = auto_charset($other);
	$detail = auto_charset($detail);
	$comtxts = auto_charset($comtxts);
}
$keyword_list=$comtxts['result']['res']['keyword_list'];

$detail = $detail['0'];

function get_item_taobao($itemid = '', $taobaourl = '', $pcate = 0, $ccate = 0, $tcate = 0, $merchid = 0)
{
	$url = get_taobao_info_url($itemid);
	$response = ihttp_get($url);
	$v = $response['data'];
	return $v;
}

function ihttp_get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	return json_decode($data, true);
}

function get_taobao_info_url($itemid) {
	return 'http://hws.m.taobao.com/cache/mtop.wdetail.getItemDescx/4.1/?data=%7B"item_num_id":"'.$itemid.'"%7D';
}

$indexseoset = array(
	'seotitle' => $detail['title'],
	'seokeywords' => implode(',',$keyword_list),
	'seodescription' => $detail['title'].' - 领券立减'.($_GET['zk_final_price']-$_GET['q_price']).'元 到手价'.$_GET['q_price'].'元 '.$detail['volume'].'人已购买',
);
list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

include template('zhuzhu_taobao:jump_url');

?>