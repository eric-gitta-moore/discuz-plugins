<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_mycoupon_dealconsumer.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$printlogid = intval($_G['sr_printlogid']);
$result = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_first_by_printlogid_and_uid($printlogid,$_G['uid']);
if (!$result) {
	showmessage(coupon_modlang('noprintlog'));
}
$result['dateline'] = dgmdate($result['dateline'] );
$result['status'] = coupon_modlang('couponst'.$result['status']);
$result['usedateline'] = empty($result['usedateline']) ? '-' : dgmdate($result['usedateline']);
$result['rebatesdate'] = empty($result['rebatesdate']) ? '-' : dgmdate($result['rebatesdate']);
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>