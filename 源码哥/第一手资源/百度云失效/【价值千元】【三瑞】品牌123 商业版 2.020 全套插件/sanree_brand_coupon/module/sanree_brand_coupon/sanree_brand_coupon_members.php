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
$viewarray = array('list');
$view = !in_array($view, $viewarray) ? 'list' : $view;
$actives[$view] = ' class="a"';
$ordercount = array();
$ordercount['default'] = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->count_by_wherec(array('t.puid='.$_G['uid'],'t.status=0'));
$ordercount['use'] = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->count_by_wherec(array('t.puid='.$_G['uid'],'t.status=1'));
$ordercount['get'] = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->count_by_wherec(array('t.puid='.$_G['uid'],'t.status=2'));
$ordercount['all'] = $ordercount['default'] + $ordercount['use'] +$ordercount['get'];

require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod.'_'.$view, $plugin['identifier']);
?>