<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_delete.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$do = $_G['sr_do'];
$doarray = array('album');
if (!in_array($do, $doarray)) {

	showmessage(srlang('unknowact'));
	
}
if ($do == 'album') {
	$bid = intval($_G['sr_bid']);
	$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
	if (!$brandresult) {
	
		showmessage(srlang('nodengji'));
		
	}	
	$brandgroup = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
	if (intval($brandgroup['allowdeletealbum'])!=1) {
		showmessage(srlang('notallowdeletealbum'));
	}	
	$albumid = intval($_G['sr_albumid']);
	$albumresult = C::t('#sanree_brand#sanree_brand_album')->userget_by_albumid($albumid, intval($_G['uid']));
	if (!$albumresult) {
		showmessage(srlang('nopic'));
	}
	if ($_G['uid']!=$albumresult['uid']) {
		showmessage(srlang('erroruser'));
	}
	$result = C::t('#sanree_brand#sanree_brand_album_category')->get_by_catid(intval($albumresult['catid']));
	if (md5($result['pic']) == md5($albumresult['pic'])) {
		fixalbumpic(intval($albumresult['catid']), array('pic' => NULL));
	}	
	mydeletepics($albumid);
	$rurl='plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&bid='.$bid.'&catid='.intval($albumresult['catid']);
	showmessage(srlang('succeed'),$rurl);
}
//From:www_YMG6_COM
?>