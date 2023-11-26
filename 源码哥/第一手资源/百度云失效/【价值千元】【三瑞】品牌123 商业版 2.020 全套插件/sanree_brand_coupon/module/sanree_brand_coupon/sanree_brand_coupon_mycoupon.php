<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_mycoupon.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$view = $_G['sr_view'];
$viewarray = array('list','printlog', 'dealconsumer', 'viewconsumer', 'getreward');
$view = !in_array($view, $viewarray) ? 'list' : $view;
$actives[$view] = ' class="a"';
$bcount[0] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
$bcount[1] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
$bcount[2] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
$bcount[3] = $bcount[0] + $bcount[1] +$bcount[2];

$gcount[0] = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
$gcount[1] = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
$gcount[2] = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
$gcount[3] = $gcount[0] + $gcount[1] +$gcount[2];

require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod.'_'.$view, $plugin['identifier']);
?>