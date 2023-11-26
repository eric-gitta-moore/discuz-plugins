<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_mybrand_mymsg.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$perpage = 10;
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$multi 		= '';
$where 		= array();
$bid  		= intval($_G[sr_bid]);
$where[] 	= 'uid='.$_G['uid'];
$where[] 	= 'typeid=2';

if ($bid>0) {
	$where[] = 'bid='.$bid;
}
$count = C::t('#sanree_brand#sanree_brand_msg')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$orderby = 'dateline desc,msgid desc';	
	$datalist = C::t('#sanree_brand#sanree_brand_msg')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	$list = array();
	foreach($datalist as $msg) {
	
	    $msg[dateline] = dgmdate($msg[dateline]);
		$msg[message] = $msg[words];
		$msg[subject] = substr($msg[words],0,10);
			
	    $list[] = $msg;
		
	}
	$murl= 'plugin.php?id=sanree_brand&mod=mybrand&view=mymsg'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$msgcounttip = str_replace('{count}',$count,srlang('msgcounttip'));
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>