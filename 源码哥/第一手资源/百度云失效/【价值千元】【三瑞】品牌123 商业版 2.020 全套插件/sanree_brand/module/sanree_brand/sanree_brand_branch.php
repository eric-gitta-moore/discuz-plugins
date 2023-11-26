<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_branch.php sanree $
 */
if(!defined('IN_DISCUZ')) {
	exit('');
}
$bid = intval($_G['sr_tid']);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {

	showmessage(srlang('nodengji'));
	
}
$pbidlist = array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.pbid='.$bid, 't.status=1'), 't.istop desc,t.displayorder, t.dateline desc', 0, 100) as $value) {
	$url = getburl($value);
	$pbidlist[] = array('name' => $value['name'],'url' => $url);
}
$_G['style']['tplfile'] = $template = templateEx($plugin['identifier'].':'.$template.'/branch');
include $template;
?>