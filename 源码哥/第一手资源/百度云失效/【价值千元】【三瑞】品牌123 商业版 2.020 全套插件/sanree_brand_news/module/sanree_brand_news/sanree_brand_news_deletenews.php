<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_news_deletenews.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072820Zq5a00tJ50||7908||1402027202');
}

$nid = intval($_G['sr_nid']);

$newsresult = C::t('#sanree_brand_news#sanree_brand_news')->getnews_by_nid($nid);
if (!$newsresult) {
	showmessage(news_modlang('nonewsshow'));
}
if ($_G[uid]!=$newsresult[uid]) {
	showmessage(news_modlang('erroruser'));
}
$tids = array();
foreach (C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_tid_by_nids($nid) as $val) {

	$tids[] = $val[tid];
	
}
require_once libfile('function/forum');
require_once libfile('function/delete');
deletethread($tids);
C::t('#sanree_brand_news#sanree_brand_news')->delete($nid);
$rurl='plugin.php?id=sanree_brand_news&mod=mynews';
showmessage(news_modlang('succeed'),$rurl);
?>