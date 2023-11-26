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

$itemid = $_GET['num_iid'];
$url = "https://uland.taobao.com/coupon/edetail?e=".str_replace(" ","+", $_GET['e'])."&traceId=".$_GET['traceId'];

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkItemInfoGetRequest;
$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
$req->setPlatform("2");
$req->setNumIids("".$itemid."");
$resp = $c->execute($req);
$resp =json_decode(json_encode($resp), true);

$goods = $resp['results']['n_tbk_item']['0'];

$req = new TbkTpwdCreateRequest;
$req->setText($goods['title']);
$req->setUrl($url);
$req->setLogo("".$goods['pict_url']."");
$resp = $c->execute($req);
$resp = json_decode(json_encode($resp),true);

if($_G['charset'] == 'utf-8'){
	$model = $resp['data']['model'];
} else {
	$model = diconv($resp['data']['model'], 'utf-8', CHARSET);
	$goods['title'] = diconv($goods['title'], 'utf-8', CHARSET);
}

include template('zhuzhu_taobao:t_tkl');

?>