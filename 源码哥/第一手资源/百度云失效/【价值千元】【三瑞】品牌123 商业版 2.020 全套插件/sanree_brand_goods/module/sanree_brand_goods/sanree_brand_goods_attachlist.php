<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_attachlist.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$homeaid = intval($_G['sr_homeaid']);
$pid = intval($_G['sr_pid']);
$tid = $_G['tid'] = intval($_G['sr_tid']);
$posttime = intval($_G['sr_posttime']);
$aids = $_G['sr_aids'];
	require_once libfile('function/post');
	loadcache('groupreadaccess');
	$attachlist = array();
	$attachs =  getattach($pid, $posttime, $aids);	
	foreach($attachs['attachs']['unused'] as $data) {
	
	    if (intval($data['aid'])>0) {
		
			$attachlist[] = $data;
			
		}
		
	}
	foreach($attachs['attachs']['used'] as $data) {
	
	    if (intval($data['aid'])>0) {
		
			$attachlist[] = $data;
			
		}
		
	}	
	$_G['group']['maxprice'] = isset($_G['setting']['extcredits'][$_G['setting']['creditstrans']]) ? $_G['group']['maxprice'] : 0;

	include template('common/header_ajax');
	include templateEx($plugin['identifier'].':'.$template."/attachlist");
	include template('common/footer_ajax');
	dexit();
?>