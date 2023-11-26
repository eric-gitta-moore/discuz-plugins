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

$typearr = array(
	'1' => lang('plugin/zhuzhu_taobao','typearr_1'),
	'2' => lang('plugin/zhuzhu_taobao','typearr_2'),
	'3' => lang('plugin/zhuzhu_taobao','typearr_3'),
	'4' => lang('plugin/zhuzhu_taobao','typearr_4'),
);

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;

if(empty($_GET['favorites_id'])){

	$req = new TbkUatmFavoritesGetRequest;
	$req->setPageNo("1");
	$req->setPageSize("20");
	$req->setFields("favorites_title,favorites_id,type");
	$req->setType("1");
	$resp = $c->execute($req);
	$resp = json_decode(json_encode($resp),true);

	$navcount = $resp['total_results'];
	$resp = $resp['results']['tbk_favorites'];
	if($navcount) {
		foreach($resp as $key=>$v){
			if($_G['charset'] !== 'utf-8') $v['favorites_title'] = diconv($v['favorites_title'], 'utf-8', CHARSET);
			$req = new TbkUatmFavoritesItemGetRequest;
			$req->setAdzoneId($appadzoneid);
			$req->setFavoritesId(''.$v['favorites_id'].'');
			if($_G['mobile']){
				$req->setPageSize("9");
			}else{
				$req->setPageSize("10");
			}
			$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,status,type");
			$resp = $c->execute($req);
			$resp = json_decode(json_encode($resp),true);

			$count = $resp['total_results'];
			$resp = $resp['results']['uatm_tbk_item'];
			if($count) {
				foreach($resp as $key=>$vv){
					if($_G['charset'] !== 'utf-8'){
						$vv['nick'] = diconv($vv['nick'], 'utf-8', CHARSET);
						$vv['provcity'] = diconv($vv['provcity'], 'utf-8', CHARSET);
						$vv['shop_title'] = diconv($vv['shop_title'], 'utf-8', CHARSET);
						$vv['title'] = diconv($vv['title'], 'utf-8', CHARSET);
					}
					if($_G['mobile']) $vv['coupon_click_url'] = str_replace("https","taobao", $vv['coupon_click_url']);
					$v['list'][] = $vv;
				}
			}
			$uatmlist[] = $v;
		}
	}else{
		showmessage('zhuzhu_taobao:no_uatm');
	}

}else{

	$req = new TbkUatmFavoritesItemGetRequest;
	$req->setAdzoneId($appadzoneid);
	$req->setFavoritesId(''.$_GET['favorites_id'].'');
	$req->setPageSize("200");
	$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,status,type");
	$resp = $c->execute($req);
	$resp = json_decode(json_encode($resp),true);

	$count = $resp['total_results'];
	$resp = $resp['results']['uatm_tbk_item'];
	if($count) {
		foreach($resp as $key=>$v){
			if($v['status']){
				if($_G['charset'] !== 'utf-8'){
					$v['nick'] = diconv($v['nick'], 'utf-8', CHARSET);
					$v['provcity'] = diconv($v['provcity'], 'utf-8', CHARSET);
					$v['shop_title'] = diconv($v['shop_title'], 'utf-8', CHARSET);
					$v['title'] = diconv($v['title'], 'utf-8', CHARSET);
				}
				if($_G['mobile']) $v['coupon_click_url'] = str_replace("https","taobao", $v['coupon_click_url']);
				$list[] = $v;
			}
		}
	}
}

$seo = $zz_seo['uatm'];

$indexseoset = array(
	'seotitle' => $seo['seotitle'],
	'seokeywords' => $seo['seokeywords'],
	'seodescription' => $seo['seodescription']
);
$foot_key = explode(',', $indexseoset['seokeywords']);
list($navtitle, $metadescription, $metakeywords) = get_seosetting($identifier, $mod, $indexseoset);

if($_G['mobile']){
	include template('zhuzhu_taobao:t_uatm');
}else{
	include template('diy:t_uatm', '0', 'source/plugin/zhuzhu_taobao/template');
}
//From:www_caogen8_co
?>