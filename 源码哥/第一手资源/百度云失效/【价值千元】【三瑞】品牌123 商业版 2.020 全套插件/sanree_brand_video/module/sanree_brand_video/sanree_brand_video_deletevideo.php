<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_deletevideo.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098D7zaVQA8A||11681||1381384801');
}

$cid = intval($_G['sr_cid']);

$videoresult = C::t('#sanree_brand_video#sanree_brand_video')->getvideo_by_cid($cid);
if (!$videoresult) {
	showmessage(video_modlang('novideoshow'));
}
if ($_G[uid]!=$videoresult[uid]) {
	showmessage(video_modlang('erroruser'));
}
$tids = array();
foreach (C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_tid_by_cids($cid) as $val) {

	$tids[] = $val[tid];
	
}
require_once libfile('function/forum');
require_once libfile('function/delete');
deletethread($tids);
C::t('#sanree_brand_video#sanree_brand_video')->delete($cid);
$rurl='plugin.php?id=sanree_brand_video&mod=myvideo';
showmessage(video_modlang('succeed'),$rurl);
?>