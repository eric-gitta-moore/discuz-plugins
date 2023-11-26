<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_brandno.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$brandno = dhtmlspecialchars(trim($_G['sr_tid']));
preg_match("/[^0-9a-zA-Z]/", $brandno, $matches);
if (count($matches)>0) {
	showmessage(srlang('errorbrandno'));
}
if (!$brandno) {

	showmessage(srlang('nodengji'));
	
}
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->get_by_brandno($brandno);
if (!$brandresult) {

	showmessage(srlang('nodengji'));
	
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
chkbrandend($brandresult);
$_G['sr_tid'] = $brandresult['bid'];
$_G['item_detail'] = 'detail';
require_once sanree_libfile('module/'.$plugin['identifier'].'/item', $plugin['identifier']);
?>