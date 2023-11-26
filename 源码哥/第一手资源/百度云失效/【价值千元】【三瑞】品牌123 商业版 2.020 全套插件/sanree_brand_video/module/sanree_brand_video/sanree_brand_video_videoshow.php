<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_videoshow.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098D7zaVQA8A||11681||1381384801');
}

if (!in_array($groupid, $viewgroup)) {

	if ($_G[uid]!=1) {
	
	    showmessage(video_modlang('stopviewtip'));
		
	}
	
}

$cid = intval($_G['sr_tid']);

$videoresult = C::t('#sanree_brand_video#sanree_brand_video')->getvideo_by_cid($cid);
if (!$videoresult) {
	showmessage(video_modlang('novideoshow'));
}
if ($videoresult[isshow]!=1) {
	showmessage(video_modlang('notisshow'));
}

video_chkmodeend($videoresult);
$bid = $videoresult[bid];

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	showmessage(srlang('nobrand'));
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
if ($brandmoduleresult['isvideo']!=1) {
	showmessage(video_modlang('novideo'));
}

chkbrandend($brandresult);
$tid = $videoresult['tid'];
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($tid);
C::t('#sanree_brand#forum_thread')->update($tid, array('views' => intval($forum_thread['views']) + 1));
$videoresult['views'] = intval($forum_thread['views']) + 1;
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
$videoresult['dateline'] = empty($videoresult['dateline']) ? '' : dgmdate($videoresult['dateline'],'d');
$brandresult['discount'] = $brand_config['selectdiscountshow'][intval($brandresult['discount'])];
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em><a href="'.video_getusermodeurl($brandresult).'">'.video_modlang('videoshow').'</a>&nbsp;&raquo;&nbsp;'.$videoresult[catename].'&nbsp;&raquo;&nbsp;'.$videoresult[name];
$navtitle = $videoresult[name].'-'.$brandresult['name'].' - '.$config['title'];
$videoresult['keywords'] && $metakeywords = $videoresult['keywords'];
$videoresult['description'] && $metadescription = $videoresult['description'];
$lasttemplate = $template;
$template = $brand_config['template'];
require_once libfile('class/sanree_brand_menu','plugin/sanree_brand');
$menuclass = new sanree_brand_menu('sanree_brand');
$menuclass->getmenu($brandresult, 'video');
$brand_header = $menuclass->_brand_header;
$brand_header_one = $menuclass->_brand_header_one;
$template = $lasttemplate;
$videoresult['gpicture'] = video_getforumimg($videoresult['homeaid'], 1 , 300, 300, 'fixnone');

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
$imgarr = explode("|", $videoresult['aids']);
$imglist = array();
$skipaid=array();
$videoresult[content] = discuzcode($videoresult[content]);
$videoresult['content'] = str_replace('&amp;', '&',$videoresult['content']);

$videoresult['condition'] = discuzcode($videoresult['condition']);
$videoresult['condition'] = str_replace('&amp;', '&',$videoresult['condition']);

if(preg_match_all("/\[attachimg\](\d+)\[\/attachimg\]/i", $videoresult[content], $matchaids)) {

	foreach($matchaids[1] as $match)
		$skipaid[] = $match;
		
}
$videoresult[content] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", 'video_fixthreadpic(\\1)', $videoresult[content]);
foreach($imgarr as $aid) {

	if (!in_array($aid, $skipaid)&&(intval($aid)>0)) {
		$row=array();
		$row[aid] = $aid;
		$row[pic] = video_getforumimg($aid, 1, 650, 0, 'fixnone');
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
$voter = C::t('#sanree_brand_video#sanree_brand_video_voter')->getvotetotal_by_tid($tid);
$videoresult['satisfaction'] = $voter[3];
$videoresult['satisfactionwidth'] = intval($voter[3]/100 * 91);
$videoresult['types'] = "wmv avi rmvb mov swf flv";
$videoresult['type'] = 'swf';
$params = "$videoresult[type],$videoresult[width],$videoresult[height]";
///$params = "$videoresult[type], 700,500";
$mediahtml = parsemedia($params, $videoresult['videourl']);
include templateEx($plugin['identifier'].':'.$template."/".$mod);
?>