<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_members_list.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$st = $_G['sr_st'];
$starray = array('all', 'default', 'use', 'get');
$starrayv= array(0, 0, 1, 2);;
$st = !in_array($st, $starray) ? 'all' : $st;
$stactives[$st] = ' class="a"';
$extra = '&view='.$view;
$extra .= '&st='.$st;
$perpage = 10;
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$multi 		= '';
$where = array();
$where[] = 't.puid='.$_G['uid'];
$in= array_search($st,$starray);
if ($st!='all') {
	$where[] = 't.status='.$starrayv[$in];
}
$count = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->count_by_wherec($where);
if ($count>0) {

	$orderby = 't.dateline desc';	
	$datalist = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	$classarr = array();
	foreach($datalist as $value) {
	
	    $value['turl'] = coupon_getitemurl($value['cid']);
	    $value['dateline'] = dgmdate($value['dateline'] );
		$value['statusstr'] = coupon_modlang('couponst'.$value['status']);
		$classarr[] = $value;
		
	}
	$murl= 'plugin.php?id=sanree_brand_coupon&mod=members'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$navtitle =  coupon_modlang('memberscoupon');
$navigation  = '<em>&rsaquo;</em>'.coupon_modlang('memberscoupon');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>