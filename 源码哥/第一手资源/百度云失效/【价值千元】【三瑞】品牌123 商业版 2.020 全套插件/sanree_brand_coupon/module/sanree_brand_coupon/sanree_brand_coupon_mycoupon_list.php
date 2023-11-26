<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_mycoupon_list.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$st = $_G['sr_st'];
$starray = array('pass', 'couponnew' ,'refuse');
$starrayv= array(1, 0, -1);;
$st = !in_array($st, $starray) ? 'pass' : $st;
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
$where[] = 't.uid='.$_G['uid'];
$where[] = 'c.status=1';
$in = array_search($st, $starray);
$where[] = 't.status='.$starrayv[$in];
$count = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$orderby = 't.istop desc,t.displayorder,t.dateline desc';	
	$datalist = C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	
	    $value['turl'] = coupon_getburl($value);
		$value['editurl'] = 'plugin.php?id=sanree_brand_coupon&mod=published&cid='.$value['cid'];
		$value['deleteurl'] = 'plugin.php?id=sanree_brand_coupon&mod=deletecoupon&cid='.$value['cid'];
		$value['useurl'] = 'plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=printlog&cid='.$value['cid'];
	    $value['dateline'] = dgmdate($value['dateline'] );
		$value['isshow'] = $value['isshow']==1 ? coupon_modlang('showyes') : coupon_modlang('notshow');
		$classarr[$value[cid]] = $value;
		
	}
	$murl= 'plugin.php?id=sanree_brand_coupon&mod=mycoupon'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$navtitle =  coupon_modlang('mycoupon');
$navigation  = '<em>&rsaquo;</em>'.coupon_modlang('mycoupon');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>