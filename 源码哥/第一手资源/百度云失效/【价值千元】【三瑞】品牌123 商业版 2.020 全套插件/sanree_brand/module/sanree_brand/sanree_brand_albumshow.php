<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_albumshow.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
if ($isalbum!=1) {
	showmessage(srlang('stopalbumtip'));
}
$catid = intval($_G['sr_tid']);
$cate =  C::t('#sanree_brand#sanree_brand_album_category')->fetch_by_catid($catid);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($cate[bid]);
if (!$brandresult) {

	showmessage(srlang('nodengji'));
	
}
if ($brandresult['status']!=1) {

	showmessage(srlang('nostatus'));
	
}
chkbrandend($brandresult);
if ($brandresult[allowalbum]!=1) {

	showmessage(srlang('noallowalbum'));
	
}
$cateurl = getalbumurl($brandresult[bid]);

if ($ismultiple==1&&$brandresult['allowmultiple']==1) {
	$icqline = getfirsticq($brandresult[$icq]);
	$brandresult['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
	$brandresult['tel'] = getfirsticq($brandresult['tel']);
} else {
	$brandresult['qq'] = empty($brandresult['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($brandresult['qq']), $icqshow);
	$brandresult['tel'] = getfirsticq($brandresult['tel']);
}
$brandresult['groupimg'] = getgroupimg($brandresult['groupid']);
$brandresult['discount'] = $config['selectdiscountshow'][$brandresult['discount']];
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($brandresult['tid']);
$brandresult['favtimes'] = $forum_thread['favtimes'];
$brandresult['url'] = getburl($brandresult);
$brandresult['poster'] = newtheme($brandresult['poster'], 'category', '/none.gif');
if (empty($brandresult[banner])) {

	$brandresult[banner] = sr_brand_IMG.'/banner.jpg';
	
}
else {

	$valueparse = parse_url($brandresult['banner']);
	if(!isset($valueparse['host'])) {
	
		 $brandresult['banner'] = $_G['setting']['attachurl'].'common/'.$brandresult['banner'];
		 
	}
	
}
$idtype  = 'tid';
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
	$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));
	$value['satisfaction'] = intval($voter[3]);
	$value['poster'] = $_G['setting']['attachurl'].'category/'.$value['poster'];
	$newlist[] = $value;
	
}
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em><a href="'.getalbumurl($brandresult['bid']).'">'.srlang('albumlshow').'</a>&nbsp;&raquo;&nbsp;'.$cate[catname];
$navtitle = $cate[catname].'-'.$brandresult['name'].' - '.$config['title'];
$perpage 	= $albumshowperpage;
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);

$where = 'AND catid='.$catid;
$count = C::t('#sanree_brand#sanree_brand_album')->count_by_where($where);
$aids="''";
if ($count>0) {
	
	include_once libfile('function/home');
	$picturecatelist= array();
	$aids='[';
	$tmparray=array();
	foreach(C::t('#sanree_brand#sanree_brand_album')->fetch_all_by_searchex($where, 'ishome desc,displayorder,albumid desc', ($page - 1) * $perpage, $perpage) as $key => $album) {
		
		if($config['isbird']) {
			$album['thumbpic'] =  pic_cover_get($album['pic'], 1);
		} else {
			$album['thumbpic'] = ($isalbumthumb==1) ? sr_albumimage($album['pic'], 160, 160) : pic_cover_get($album['pic'], 1);
		}
		$album['pic'] = pic_cover_get($album['pic'], 1);
		$picturecatelist[$key] = $album;
		$tmparray[]= "'$album[albumid]'";
		
	}
	$aids.=implode($tmparray,",");
	$aids.=']';
	$murl = getalbumitemurl($catid);
	$multi = multi ( $count, $perpage, $page, $murl);
	
}

if(!$config['isbird']) {
	
	require_once libfile('class/'.$plugin['identifier'].'_menu','plugin/'.$plugin['identifier']);
	$menuclass = new sanree_brand_menu($plugin['identifier']);
	$menuclass->getmenu($brandresult, 'myalbum');
	$brand_header = $menuclass->_brand_header;
	$brand_header_one = $menuclass->_brand_header_one;
	
}

$bid = $brandresult['bid'];
$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
$allowbatchimage = intval($group['allowbatchimage']);
include templateEx($plugin['identifier'].':'.$template.'/albumshow');
?>