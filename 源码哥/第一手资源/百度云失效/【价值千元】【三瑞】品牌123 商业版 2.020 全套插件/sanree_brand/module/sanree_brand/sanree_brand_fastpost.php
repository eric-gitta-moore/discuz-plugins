<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_fastpost.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$tid = intval($_G['sr_tid']);
$bid = intval($_G['sr_bid']);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {

	$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_tid($tid);
	
}
$bid = intval($brandresult[bid]);
$tid = intval($brandresult[tid]);

$appVer = $_G['setting']['version'];
$dzv = array('X3.2','X3.1');
if(in_array($appVer, $dzv)) {
	
	list($seccodecheck) = seccheck('publish');
	$dzvflag = false;
	
} else {

	$usesigcheck = $_G['uid'] && $_G['group']['maxsigsize'];
	$seccodecheck = ($_G['setting']['seccodestatus'] & 4) && (!$_G['setting']['seccodedata']['minposts'] || getuserprofile('posts') < $_G['setting']['seccodedata']['minposts']);
	$secqaacheck = $_G['setting']['secqaa']['status'] & 2 && (!$_G['setting']['secqaa']['minposts'] || getuserprofile('posts') < $_G['setting']['secqaa']['minposts']);
	$dzvflag = false;

}
$votersucceed = srlang('votersucceed');
if(submitcheck('postsubmit', 0 , $seccodecheck , $secqaacheck)) {

	if ($allowfastpost!=1) {
	
		showmessage(srlang('nofastpostcontrol'));
		
	}
	if ($brandresult[allowfastpost]!=1) {
	
		showmessage(srlang('nofastpostcontrol'));
		
	}	
		
	if (!$_G['uid']) {
	
		showmessage(srlang('nologin'), '', array(), array('login' => true));
		
	}
	$_G['gp_message'] 		= $_G['sr_message'];
	$_G['gp_action'] 		= $_GET['action'] 		= 'reply';
	$_G['gp_tid'] 			= $_GET['tid'] 			= $tid;
	$_G['gp_replysubmit'] 	= $_GET['replysubmit'] 	= "yes";
	$_G['gp_infloat'] 		= $_GET['infloat'] 		= "yes";
	$_G['gp_handlekey'] 	= $_GET['handlekey'] 	= "fastpost";
	$_G['gp_mod'] 			= $_GET['mod'] 			= "post";
	$_G['gp_bbcodeoff'] 	= $_GET['bbcodeoff'] 	= 0;
	$_G['gp_smileyoff'] 	= $_GET['smileyoff'] 	= 0;
    if (empty($_G['gp_message'])) {
	
		showmessage(srlang('novoter'));
		
	}
	if(!isset($_G['cache']['smileycodes'])) {
	
		loadcache(array('smileycodes'));
		
	}
	$_POST['portal_referer'] = getitemurl($bid);
	$_G['tid'] = $tid;
	$inspacecpshare = TRUE;
	require_once libfile('function/forum');
	require libfile('forum/post', 'module');
	C::t('#sanree_brand#sanree_brand_voter')->updatestar_by_tid($_G['uid'], $_G['username'], $tid, intval($_G['sr_star']));
	$href = $_POST['portal_referer'];
	$href = str_replace("'", "\'", $href);	
	$url_forward = 'javascript:history.back()';	
	$extra = array(
		'showdialog' => false,
		'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow;\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
	);	
	showmessage(srlang('votersucceed'), $url_forward, array(), $extra);
	
}
else {

	if (!$brandresult) {
	
		ajaxexit('');
		
	}
	if ($allowfastpost!=1) {
	
		ajaxexit(srlang('nofastpostcontrol'));
		
	}
	if ($brandresult[allowfastpost]!=1) {
	
		ajaxexit(srlang('nofastpostcontrol'));
		
	}	

    $perpage 	= 5;
	$page 		= intval($_G[sr_page]);
	$page 		= max(1, intval($page));
	$start 		= ($page - 1) * $perpage;
	$start 		= max(0, $start);
	require_once libfile('function/discuzcode');
	$count = C::t('#sanree_brand#forum_post')->count_by_tid_post(0, $tid);
	if ($count>0) {

		$postthread = C::t('#sanree_brand#forum_post')->fetch_all_by_tid(0, $tid, true, ' desc', ($page - 1) * $perpage, $perpage, 0, 0);
		foreach($postthread as $key =>$val) {
		
			$postthread[$key]['message'] = discuzcode($val['message'], 0, 0, 0, 1);
			
		}
		$murl= 'plugin.php?id=sanree_brand&mod=fastpost&tid='.$tid.$extra;
		$multi = multi ( $count, $perpage, $page, $murl);		
	}
	include templateEx($plugin['identifier'].':'.$template.'/fastpost');
}
//From:www_YMG6_COM
?>