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

require_once libfile('function/core', 'plugin/zhuzhu_taobao');

$itemid = $_GET['num_iid'];
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

if($_G['charset'] !== 'utf-8'){
	$other = auto_charset($other);
	$detail = auto_charset($detail);
}

$detail = $detail['0'];

$src = 'source/plugin/zhuzhu_taobao/static/image/';

$font = "source/plugin/zhuzhu_taobao/static/font/msyh.ttf";
$arial = "source/plugin/zhuzhu_taobao/static/font/arialbd.ttf";
$fzltcxhjw = "source/plugin/zhuzhu_taobao/static/font/FZLTCXHJW.ttf";

$title = $detail['title'];
$price = $_GET['q_price'];
$value = $detail['zk_final_price'];
$quan = $value-$price;

if(strlen($quan) == '1'){
	$quan = '  '.$quan;
}elseif(strlen($quan) == '2'){
	$quan = ' '.$quan;
}

if(substr($detail['pict_url'], 0, 5) == 'https') {
	$goods = 'http'.ltrim($detail['pict_url'], 'https');
} else {
	$goods = $detail['pict_url'];
}


require_once libfile('function/code', 'plugin/zhuzhu_taobao');
$url = $_G['siteurl']."/plugin.php?id=zhuzhu_taobao&mod=jump_url&num_iid=".$itemid."&e=".str_replace(" ","+", $_GET['e'])."&traceId=".$_GET['traceId']."&zk_final_price=".$_GET['zk_final_price']."&q_price=".$_GET['q_price'];
$filename = 'source/plugin/zhuzhu_taobao/static/QRcode.png';
$QR = QRcode::png($url,$filename,'L', '2.8', '0');

$goods = imagecreatefromjpeg($goods);
$qcode = imagecreatefrompng($filename);
$q_img = imagecreatefromjpeg($src."img_quan.jpg");
$q_kuang = imagecreatefromjpeg($src."img_kuang.jpg");
$q_sheng = imagecreatefromjpeg($src."img_sheng.jpg");

if($_G['charset'] !== 'utf-8'){
	$title = diconv($title, "GB2312", "UTF-8");
}

$title = autowrap(12, 0, $font, $title, 250);

$detail = imagecreatetruecolor(820, 1100);
$color = imagecolorAllocate($detail,255,255,255);
imagefill($detail ,0 ,0 ,$color);

$black = imagecolorallocate($detail, 0, 0, 0);
$white = imagecolorallocate($detail, 255,255,255);

imagettftext($detail, 24, 0, 20, 870, $black, $font, $title);
imagecopymerge($detail, $goods, 10, 10, 0, 0, 800, 800, 100);
imagecopymerge($detail, $q_sheng, 40, 960, 0, 0, 450, 120, 100);
imagettftext($detail, 44, 0, 285, 1028, $white, $arial, $price);
imagettftext($detail, 28, 0, 108, 1045, $white, $arial, $quan);
imagettftext($detail, 25, 0, 295, 1063, imagecolorallocate($detail, 255,255,255), $fzltcxhjw, $value);
imagettftext($detail, 25, 0, 296, 1063, imagecolorallocate($detail, 255,255,255), $fzltcxhjw, $value);
imagecopymerge($detail, $q_kuang, 580, 840, 0, 0, 210, 260, 100);
imagecopymerge($detail, $qcode, 594, 854, 0, 0, 182, 182, 100);

header("Content-type: image/jpeg");
imagejpeg($detail, '', 100);

?>