<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_myguestbook.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214b98wB3Bomz||7247||1422453601');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$view = $_G['sr_view'];
$viewarray = array('list','show', 'chuli', 'delete');
$view = !in_array($view, $viewarray) ? 'list' : $view;
$actives[$view] = ' class="a"';
$bcount[0] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
$bcount[1] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
$bcount[2] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
$bcount[3] = $bcount[0] + $bcount[1] +$bcount[2];


$bids = array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search("AND uid=$_G[uid]",'displayorder',0,1000) as $data) {

	$bids[] = $data[bid];
	
}
$gbcount = array(0,0,0,0);
if (count($bids)>0) {

	$wherebids = implode($bids, ',');
	$gbcount[0] = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_wherec(array('gb.bid in ('.$wherebids.')', 'gb.status=1'));
	$gbcount[1] = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_wherec(array('gb.bid in ('.$wherebids.')', 'gb.status=0'));
	$gbcount[3] = $gbcount[0] + $gbcount[1];
	
}
$gbcount[2] = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_wherec(array('gb.uid = '.$_G[uid]));
	
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod.'_'.$view, $plugin['identifier']);
?>