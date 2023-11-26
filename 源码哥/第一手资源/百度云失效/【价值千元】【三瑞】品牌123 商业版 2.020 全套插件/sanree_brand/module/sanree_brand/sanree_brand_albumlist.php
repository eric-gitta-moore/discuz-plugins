<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_albumlist.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
if ($isalbum!=1) {

	showmessage(srlang('stopalbumtip'));
	
}
$bid = intval($_G['sr_tid']);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {

	showmessage(srlang('nobrand'));
	
}
if ($brandresult['status']!=1) {

	showmessage(srlang('nostatus'));
	
}
chkbrandend($brandresult);
if ($brandresult[allowalbum]!=1) {

	showmessage(srlang('noallowalbum'));
	
}
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
	$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));
	$value['satisfaction'] = intval($voter[3]);
	$value['poster'] = $_G['setting']['attachurl'].'category/'.$value['poster'];
	$newlist[] = $value;
	
}
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em>'.srlang('myalbum');
$navtitle = srlang('myalbum').'-'.$brandresult['name'].' - '.$config['title'];
$where =array();
$where[] = 'uid='.$brandresult['uid'];
$where[] = 'bid='.$bid;

$albumcatelist = array();
include_once libfile('function/home');
$picshowtipformat = srlang('picshowtip');
foreach(C::t('#sanree_brand#sanree_brand_album_category')->fetch_all_by_searchd($where, 'displayorder,dateline DESC') as $data) {
	
	if($config['isbird']) {
		$data['pic'] = empty($data['pic']) ? 'static/image/common/nophoto.gif' : pic_cover_get($data['pic'], 1);
	} else {
		if ($isalbumthumb==1) {
			$data['pic'] = sr_albumimage($data['pic'], 120, 120);
		} else {
			$data['pic'] = empty($data['pic']) ? 'static/image/common/nophoto.gif' : pic_cover_get($data['pic'], 1);
		}
	}
	$data['url'] = getalbumitemurl($data[catid]);
	$wherealbumsub = array();
	$wherealbumsub[] = 'catid = '.$data[catid];		
	$data['num'] = C::t('#sanree_brand#sanree_brand_album')->count_by_wherec($wherealbumsub);
	$data['picshowtip'] = str_replace("{picnum}",$data['num'],$picshowtipformat);
	$albumcatelist[] = $data;
	
}

if(!$config['isbird']) {
	
	require_once libfile('class/'.$plugin['identifier'].'_menu','plugin/'.$plugin['identifier']);
	$menuclass = new sanree_brand_menu($plugin['identifier']);
	$menuclass->getmenu($brandresult, 'myalbum');
	$brand_header = $menuclass->_brand_header;
	$brand_header_one = $menuclass->_brand_header_one;

}

include templateEx($plugin['identifier'].':'.$template.'/albumlist');
?>