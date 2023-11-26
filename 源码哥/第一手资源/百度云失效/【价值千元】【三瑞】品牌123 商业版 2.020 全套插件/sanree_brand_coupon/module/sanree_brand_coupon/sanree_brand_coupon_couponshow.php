<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_couponshow.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
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
if ($couponresult[isshow]!=1) {
	showmessage(coupon_modlang('notisshow'));
}

coupon_chkmodeend($couponresult);
$bid = $couponresult[bid];

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	showmessage(srlang('nobrand'));
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
if ($brandmoduleresult['iscoupon']!=1) {
	showmessage(coupon_modlang('nocoupon'));
}

chkbrandend($brandresult);
$tid = $couponresult['tid'];
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($tid);
C::t('#sanree_brand#forum_thread')->update($tid, array('views' => intval($forum_thread['views']) + 1));
$couponresult['views'] = intval($forum_thread['views']) + 1;
if ($ismultiple==1&&$brandresult['allowmultiple']==1) {
	$icqline = getfirsticq($brandresult[$icq]);
	$brandresult['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
	$brandresult['tel'] = getfirsticq($brandresult['tel']);
} else {
	$brandresult['qq'] = empty($brandresult['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($brandresult['qq']), $icqshow);
	$brandresult['tel'] = getfirsticq($brandresult['tel']);
}
$brandresult['groupimg'] = getgroupimg($brandresult['groupid']);
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($brandresult['tid']);
$brandresult['favtimes'] = $forum_thread['favtimes'];
$brandresult['url'] = getburl($brandresult);
if (empty($brandresult[banner])) {
	$brandresult[banner] = sr_brand_IMG.'/banner.jpg';
}
else {
	$valueparse = parse_url($brandresult['banner']);
	if(!isset($valueparse['host'])) {
		 $brandresult['banner'] = $_G['setting']['attachurl'].'common/'.$brandresult['banner'];
	}
}
$couponresult['dateline'] = empty($couponresult['dateline']) ? '' : dgmdate($couponresult['dateline'],'d');
$couponresult['enddate'] = empty($couponresult['enddate']) ? '' : dgmdate($couponresult['enddate'],'d');
$d = explode('-', $couponresult['enddate']);
$couponresult['end']['yearmonth'] = $d[0]. '-'.$d[1];
$couponresult['end']['day'] = $d[2];

$couponresult['stock'] = intval($couponresult['stock']);

$brandresult['discount'] = $brand_config['selectdiscountshow'][intval($brandresult['discount'])];
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em><a href="'.coupon_getusermodeurl($brandresult).'">'.coupon_modlang('couponshow').'</a>&nbsp;&raquo;&nbsp;'.$couponresult[catename].'&nbsp;&raquo;&nbsp;'.$couponresult[name];
$navtitle = $couponresult[name].'-'.$brandresult['name'].' - '.$config['title'];
$couponresult['keywords'] && $metakeywords = $couponresult['keywords'];
$couponresult['description'] && $metadescription = $couponresult['description'];
$lasttemplate = $template;
$template = $brand_config['template'];
require_once libfile('class/sanree_brand_menu','plugin/sanree_brand');
$menuclass = new sanree_brand_menu('sanree_brand');
$menuclass->getmenu($brandresult, 'coupon');
$brand_header = $menuclass->_brand_header;
$brand_header_one = $menuclass->_brand_header_one;
$template = $lasttemplate;
$couponresult['gpicture'] = coupon_getforumimg($couponresult['homeaid'], 1 , 300, 300, 'fixnone');

$idtype = 'tid';
$favoritelist = array();
foreach(C::t('#sanree_brand#home_favorite')->fetch_all_by_id_idtype($brandresult['tid'], $idtype , 0, 9) as $value) {

	$favoritelist[] = $value;
	
}
$newlist = array();
$where = array();
$where[] = 'c.status=1';
$where[] = 't.status=1';
$where[] = 't.isshow=1';
$orderby = 't.bid desc';	
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby , 0, 9) as $value) {

    $value[url] = getburl($value);
	$newlist[] = $value;
	
}
require_once libfile('function/discuzcode');
$imgarr = explode("|", $couponresult['aids']);
$imglist = array();
$skipaid=array();
$couponresult[content] = discuzcode($couponresult[content]);
$couponresult['content'] = str_replace('&amp;', '&',$couponresult['content']);

$couponresult['condition'] = discuzcode($couponresult['condition']);
$couponresult['condition'] = str_replace('&amp;', '&',$couponresult['condition']);

if(preg_match_all("/\[attachimg\](\d+)\[\/attachimg\]/i", $couponresult[content], $matchaids)) {

	foreach($matchaids[1] as $match)
		$skipaid[] = $match;
		
}
$couponresult[content] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", 'coupon_fixthreadpic(\\1)', $couponresult[content]);
foreach($imgarr as $aid) {

	if (!in_array($aid, $skipaid)&&(intval($aid)>0)) {
		$row=array();
		$row[aid] = $aid;
		$row[pic] = coupon_getforumimg($aid, 1, 650, 0, 'fixnone');
		$imglist[] = $row;
		$tmparray[]= $aid;		
	}
	
}
$catid= $bid;
$aids = "''";
if (count($imgarr)>0) {
	$aids='[';
	$aids.=implode($imgarr,",");
	$aids.=']';
}
$voter = C::t('#sanree_brand_coupon#sanree_brand_coupon_voter')->getvotetotal_by_tid($tid);
$couponresult['satisfaction'] = $voter[3];
$couponresult['satisfactionwidth'] = intval($voter[3]/100 * 91);

$useuserlist = array();
$group = 'puid';
$where = array();
$where[] = 'cid='.$cid;
$orderby = 'printlogid desc';	
foreach(C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_all_by_searche($group, $where, $orderby , 0, 12) as $value) {

	$useuserlist[] = array('uid' => $value['puid'], 'username' => $value['username']);
	
}
include templateEx($plugin['identifier'].':'.$template."/".$mod);
?>