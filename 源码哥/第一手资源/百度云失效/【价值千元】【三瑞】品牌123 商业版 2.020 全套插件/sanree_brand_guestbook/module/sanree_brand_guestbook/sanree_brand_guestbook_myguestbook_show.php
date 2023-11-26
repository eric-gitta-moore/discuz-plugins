<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_myguestbook_show.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214b98wB3Bomz||7247||1422453601');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$guestbookid = intval($_G['sr_guestbookid']);

$guestbookresult = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_first_by_guestbookid($guestbookid);	
if (!$guestbookresult) {
	showmessage(guestbook_modlang('error_noguestbook'));
}
if ($guestbookresult[uid]!=$_G[uid]) {
	if (!in_array($guestbookresult[bid], $bids)) {
	
		showmessage(guestbook_modlang('error_nobidguestbook'));
		
	}
}
$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($guestbookresult['bid']);
$guestbookresult['brandname'] = $br['name'];
$guestbookresult['brandurl'] = getburl($br);
$guestbookresult['opdate'] = $guestbookresult[opdate] ? dgmdate($guestbookresult[opdate]):'';
$navtitle =  lang('plugin/sanree_brand_guestbook', 'guestbook');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>