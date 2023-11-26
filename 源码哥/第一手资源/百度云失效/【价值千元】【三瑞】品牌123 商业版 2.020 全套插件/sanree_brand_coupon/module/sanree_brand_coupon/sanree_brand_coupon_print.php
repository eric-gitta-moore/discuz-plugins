<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_print.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}
if (!$watermarkfont) {
	showmessage(coupon_modlang('notwatermarkfont'));
}
if (!file_exists(DISCUZ_ROOT.$watermarkfont)) {
	showmessage(coupon_modlang('notwatermarkfontfile'));
}
if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
if (!in_array($groupid, $viewgroup)) {

	if ($_G[uid]!=1) {
	
	    showmessage(coupon_modlang('stopviewtip'));
		
	}
	
}
$cid = intval($_G['sr_tid']);

$couponresult = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getcoupon_by_cid($cid);
if (!$couponresult) {
	showmessage(coupon_modlang('nocouponshow'));
}
if ($couponresult['isshow']!=1) {
	showmessage(coupon_modlang('notisshow'));
}
coupon_chkmodeend($couponresult);
$stock = intval($couponresult['stock']);
if ($stock<1) {
	showmessage(coupon_modlang('nostock'));
}
C::t('#sanree_brand_coupon#sanree_brand_coupon')->update($cid , array('stock' => intval($couponresult['stock']) - 1, 'downnum' => intval($couponresult['downnum']) + 1));
$setarr = array();
$setarr['uid'] = $couponresult['uid'];
$setarr['puid'] = $_G['uid'];
$setarr['username'] = $_G['username'];
$setarr['cid'] = $cid;
$setarr['bid'] = $couponresult['bid'];
$setarr['dateline'] = TIMESTAMP;
$setarr['status'] = 0;
require_once libfile('class/'.$plugin['identifier'].'_ordernumber','plugin/'.$plugin['identifier']);
$setarr['printcode'] = makeorderno();
$pringlogid=C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->insert($setarr, TRUE);
$iscolor = intval($_G['sr_color'])==1 ? 1 : 0;
$img = 'plugin.php?id=sanree_brand_coupon&mod=watermask&tid='.$cid.'&color='.$iscolor.'&pringlogid='.$pringlogid.'&aid='.$couponresult[homeaid].'&t='.TIMESTAMP;
?>
<body onLoad="window.print()"><img src="<?php echo $img?>"></body>