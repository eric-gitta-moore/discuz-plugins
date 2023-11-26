<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_uservideo.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098D7zaVQA8A||11681||1381384801');
}

$bid = intval($_G['sr_tid']);

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
if (empty($brandresult['banner'])) {
	$brandresult[banner] = sr_brand_IMG.'/banner.jpg';
}
else {
	$valueparse = parse_url($brandresult['banner']);
	if(!isset($valueparse['host'])) {
		 $brandresult['banner'] = $_G['setting']['attachurl'].'common/'.$brandresult['banner'];
	}
}
$brandresult['discount'] = $brand_config['selectdiscountshow'][intval($brandresult['discount'])];
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em>'.video_modlang('videoshow').'&nbsp;&raquo;&nbsp;';
$navtitle = $brandresult['name'].' - '.$config['title'];
$perpage 	= 16;
$page 		= isset($_G['sr_page']) ? intval($_G['sr_page']) : 1;
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);

$where = array();
$where[] = 't.bid='.$bid;
$where[] = 'c.status=1';
$where[] = 't.status=1';
$where[] = 't.isshow=1';

$count = C::t('#sanree_brand_video#sanree_brand_video')->count_by_wherec($where);
if ($count>0) {
	
	$videolist= array();
	foreach(C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_by_searchc($where, 'displayorder,bid desc', ($page - 1) * $perpage, $perpage) as $key => $video) {
	
		$video['pic'] = (intval($video['homeaid'])>0) ? video_getforumimg($video['homeaid'], 1, 160, 100) : 'static/image/common/nophoto.gif';
		$video['url'] = video_getburl($video);
		$videolist[$key] = $video;
		
	}
	$murl= video_getusermodeurl( array('bid' =>$bid));
	$multi = multi ( $count, $perpage, $page, $murl);
	
}	

$lasttemplate = $template;
$template = $brand_config['template'];
require_once libfile('class/sanree_brand_menu','plugin/sanree_brand');
$menuclass = new sanree_brand_menu('sanree_brand');
$menuclass->getmenu($brandresult, 'video');
$brand_header = $menuclass->_brand_header;
$brand_header_one = $menuclass->_brand_header_one;
$template = $lasttemplate;

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

    $value['url'] = getburl($value);
	$newlist[] = $value;
	
}
include templateEx($plugin['identifier'].':'.$template."/".$mod);
?>