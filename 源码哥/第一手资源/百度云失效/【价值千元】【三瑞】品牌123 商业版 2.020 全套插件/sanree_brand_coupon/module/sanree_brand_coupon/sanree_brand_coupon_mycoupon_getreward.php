<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_mycoupon_getreward.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
if ($isrebate!=1) {
	showmessage(coupon_modlang('notrebate'));
}
$printlogid = intval($_G['sr_tid']);
$result = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_first_by_printlogid_and_puid($printlogid, $_G['uid']);
if (!$result) {
	showmessage(coupon_modlang('noprintlog'));
}
$status = intval($result['status']);
if ($status==0) {
	showmessage(coupon_modlang('notuseprintlog'));
}	
if ($status==2) {
	showmessage(coupon_modlang('getrewarded'));
}	
if(submitcheck('postsubmit')) {
    C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->update($printlogid , array('status'=> 2, 'rebatesdate' => TIMESTAMP));
	$addreward = $consumeproportion * intval($result['minprice']);
	if ($addreward>0) {
	
		$creditdata=array('extcredits'.$rebateunit => $addreward);	
		updatemembercount($result['puid'], $creditdata, true, 'COU', 1);	
		
	}	
	$url_forward = 'plugin.php?id=sanree_brand_coupon&mod=members';
	if ($_G['inajax']) {

		$href = $url_forward;
		$href = str_replace("'", "\'", $href);	
		$url_forward = '';	
		$extra = array(
			'showdialog' => false,
			'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('getrewarddlg', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
		);		
	}	
	showmessage(coupon_modlang('getreward_succeed'),$url_forward,array(),$extra);
		
} else {

	$result['dateline'] = dgmdate($result['dateline'] );
	$result['status'] = coupon_modlang('couponst'.$result['status']);	
	include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
	
}
//From:www_YMG6_COM
?>