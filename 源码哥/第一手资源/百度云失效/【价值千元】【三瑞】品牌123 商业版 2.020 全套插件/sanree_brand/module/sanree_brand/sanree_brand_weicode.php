<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_show2code.php sanree $
 */
if(!defined('IN_DISCUZ')) {
	exit('');
}
session_start();
$bid = intval($_G['sr_tid']);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
$gotourl = '';
if (!$brandresult) {

	showmessage(srlang('nodengji'));
	
}
$backgroundimage = empty($brandresult['weixinimg']) ? $defaultwxcodeimg : $_G['setting']['attachurl'].'category/'.$brandresult['weixinimg'].'?'.random(6);				
$weixintitle = str_replace('{name}', $brandresult['name'], srlang('weixintitle'));
$_G['style']['tplfile'] = $template = templateEx($plugin['identifier'].':'.$template.'/weicode');
include $template;

?>