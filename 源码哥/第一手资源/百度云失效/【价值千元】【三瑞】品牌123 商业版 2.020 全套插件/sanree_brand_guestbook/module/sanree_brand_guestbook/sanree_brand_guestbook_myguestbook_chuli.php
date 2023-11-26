<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_myguestbook_chuli.php sanree $
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
if (!in_array($guestbookresult[bid], $bids)) {

	showmessage(guestbook_modlang('error_nobidguestbook'));
	
}
if ($guestbookresult[status]==1) {

	showmessage(guestbook_modlang('error_ishavechuli'));
	
}
$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($guestbookresult['bid']);
$guestbookresult['brandname'] = $br['name'];
$guestbookresult['brandurl'] = getburl($br);
if(submitcheck('postsubmit')) {
    
	$refuse = dhtmlspecialchars(trim($_G['sr_refuse']));
	if (empty($refuse)) {
	
		showmessage(guestbook_modlang('post_inputrefusetip'));
		
	}	
    C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->update($guestbookid , array('refuse' => $refuse, 'status' => 1, 'opdate' => TIMESTAMP, 'cpuid'=>$_G[uid]));
	guestbook_notice($guestbookid, 'handle');
	$extra = array();
	$url_forward = 'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=list';
	$href = $url_forward;
	$href = str_replace("'", "\'", $href);	
	$url_forward = '';	
	$extra = array(
		'showdialog' => false,
		'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
	);
	showmessage(guestbook_modlang('chulisucceed'), $url_forward, array(), $extra);	
	
} else {

	$guestbookresult['opdate'] = $guestbookresult[opdate] ? dgmdate($guestbookresult[opdate]):'';
	$navtitle =  lang('plugin/sanree_brand_guestbook', 'guestbook');
	include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
	
}
//From:www_YMG6_COM
?>