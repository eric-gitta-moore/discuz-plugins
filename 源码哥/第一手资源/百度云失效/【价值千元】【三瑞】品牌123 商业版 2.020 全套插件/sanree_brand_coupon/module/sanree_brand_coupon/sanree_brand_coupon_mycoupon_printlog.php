<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_mycoupon_printlog.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$cid = intval($_G['sr_cid']);
$stactives['printlog'] = ' class="a"';
$extra = '&view='.$view;
$extra .= '&st='.$st;
$perpage = 10;
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$multi 		= '';
	
$where = array();
if ($cid>0) {
	$where[] = 't.cid='.$cid;
}
$keyword 	= isset($_G['sr_keyword']) ? dhtmlspecialchars(trim($_G['sr_keyword'])) : '';
if(!empty($keyword)){

	$searchfield = array('t.username', 't.printcode','t.uid','t.puid');
	$searchtext = array();
	foreach($searchfield as $v) {
	
		$searchtext[] = "(".$v." LIKE '%".$keyword."%')";
		
	}
	$where[] = '('.implode(' OR ',$searchtext).')';
	$defaultkeyword = $keyword;
	$extra = '&keyword='.urlencode($keyword);
	
}
$where[] = 't.uid='.$_G['uid'];
$count = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->count_by_wherec($where);
if ($count>0) {

	$orderby = 't.dateline desc';	
	$datalist = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	$classarr = array();
	foreach($datalist as $value) {
	    $value['turl'] = coupon_getitemurl($value['cid']);
	    $value['dateline'] = dgmdate($value['dateline'] );
		$value['status'] = coupon_modlang('couponst'.$value['status']);
		$value['shortname'] = cutstr($value['name'],30);
		$classarr[] = $value;
	}
	$murl= 'plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=printlog'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$navtitle =  coupon_modlang('printlog');
$navigation  = '<em>&rsaquo;</em>'.coupon_modlang('printlog');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>