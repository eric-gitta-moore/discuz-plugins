<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_fastpost.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}

$tid = intval($_G['sr_tid']);
$gid = intval($_G['sr_gid']);

$goodsresult = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_gid($gid);
if (!$goodsresult) {

	$goodsresult = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_tid($tid);
	
}
if (!$goodsresult) {

	showmessage(goods_modlang('nogoodsshow'));
	
}
$gid = intval($goodsresult[gid]);
$tid = intval($goodsresult[tid]);
$bid = intval($goodsresult[bid]);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);

$usesigcheck = $_G['uid'] && $_G['group']['maxsigsize'];
$seccodecheck = ($_G['setting']['seccodestatus'] & 4) && (!$_G['setting']['seccodedata']['minposts'] || getuserprofile('posts') < $_G['setting']['seccodedata']['minposts']);
$secqaacheck = $_G['setting']['secqaa']['status'] & 2 && (!$_G['setting']['secqaa']['minposts'] || getuserprofile('posts') < $_G['setting']['secqaa']['minposts']);

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
	$_POST['portal_referer'] = goods_getitemurl($gid);
	$_G['tid'] = $tid;
	$inspacecpshare = TRUE;
	require_once libfile('function/forum');
	require libfile('forum/post', 'module') ;
	C::t('#sanree_brand_goods#sanree_brand_goods_voter')->updatestar_by_tid($_G['uid'], $_G['username'], $tid, intval($_G['sr_star']));
	
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

	if (!$goodsresult) {
	
		ajaxexit('');
		
	}
	if ($allowfastpost!=1) {
	
		ajaxexit(srlang('nofastpostcontrol'));
		
	}
	if ($goodsresult[allowreply]!=1) {
	
		ajaxexit(srlang('nofastpostcontrol'));
		
	}	

    $perpage 	= 3;
	$page 		= intval($_G[sr_page]);
	$page 		= max(1, intval($page));
	$start 		= ($page - 1) * $perpage;
	$start 		= max(0, $start);
	require_once libfile('function/discuzcode');
	$count = C::t('#sanree_brand#forum_post')->count_by_tid_post(0, $tid);
	if ($count>0) {

		$postthread = C::t('#sanree_brand#forum_post')->fetch_all_by_tid(0, $tid, true, ' desc', ($page - 1) * $perpage, $perpage, 0, 0);
		foreach($postthread as $key =>$val) {
		
			$postthread[$key]['message'] = discuzcode($val['message']);
			$postthread[$key]['satisfaction'] = C::t('#sanree_brand_goods#sanree_brand_goods_voterlog')->getstar_by_tid_uid($val['authorid'], $tid) * 20;
			$postthread[$key]['dateline'] = dgmdate($val['dateline']);
			$postthread[$key]['img'] = avatar($val['authorid'], 'middle', 1);
			
		}
		$murl= 'plugin.php?id=sanree_brand_goods&mod=fastpost&tid='.$tid.$extra;
		$multi = multi ( $count, $perpage, $page, $murl);		
	}
	
	$satisfaction = C::t('#sanree_brand_goods#sanree_brand_goods_voterlog')->getstar_by_tid_uid($_G['uid'] ,$tid) * 20;
		
	$seditor = array('fastpost', array('bold', 'color', 'link', 'quote', 'smilies'));
	$selfimg = avatar($_G['uid'], 'middle', 1);
	$wx_prefix = $_G['setting']['attachurl'].'category/';
	
	$appVer = $_G['setting']['version'];
	$dzv = array('X3.2','X3.1');
	if(in_array($appVer, $dzv)) {
		
		list($seccodecheck) = seccheck('publish');
		$dzvflag = true;
		$sectpl = '<div class="rfm"><table><tr><th><sec>: </th><td><span id="sec<hash>" onclick="showMenu({\'ctrlid\':\'sec<hash>\',\'pos\':\'*\'})"><sec></span><br /><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div></td></tr></table></div>';
		
	} else {
		
		$seccodecheck = ($_G['setting']['seccodestatus'] & 4) && (!$_G['setting']['seccodedata']['minposts'] || getuserprofile('posts') < $_G['setting']['seccodedata']['minposts']);
		$secqaacheck = $_G['setting']['secqaa']['status'] & 2 && (!$_G['setting']['secqaa']['minposts'] || getuserprofile('posts') < $_G['setting']['secqaa']['minposts']);
		$dzvflag = false;
	
	}
	
	include templateEx($plugin['identifier'].':'.$template.'/fastpost');
}
//From:www_YMG6_COM
?>