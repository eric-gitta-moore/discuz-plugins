<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_deletecoupon.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

$cid = intval($_G['sr_cid']);

$couponresult = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getcoupon_by_cid($cid);
if (!$couponresult) {
	showmessage(coupon_modlang('nocouponshow'));
}
if ($_G[uid]!=$couponresult[uid]) {
	showmessage(coupon_modlang('erroruser'));
}
$tids = array();
foreach (C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_all_tid_by_cids($cid) as $val) {

	$tids[] = $val[tid];
	
}
require_once libfile('function/forum');
require_once libfile('function/delete');
deletethread($tids);
C::t('#sanree_brand_coupon#sanree_brand_coupon')->delete($cid);
$rurl='plugin.php?id=sanree_brand_coupon&mod=mycoupon';
showmessage(coupon_modlang('succeed'),$rurl);
?>