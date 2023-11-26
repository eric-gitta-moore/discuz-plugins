<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_goodsshow.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}

if (!in_array($groupid, $viewgroup)) {

	if ($_G[uid]!=1) {
	
	    showmessage(goods_modlang('stopviewtip'));
		
	}
	
}

$gid = intval($_G['sr_tid']);

$goodsresult = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_gid($gid);
if (!$goodsresult) {
	showmessage(goods_modlang('nogoodsshow'));
}
if ($goodsresult['isshow']!=1) {
	showmessage(goods_modlang('notisshow'));
}

goods_chkmodeend($goodsresult);
$bid = $goodsresult['bid'];

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	showmessage(srlang('nobrand'));
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
if ($brandmoduleresult['isgoods']!=1) {
	showmessage(goods_modlang('nogoods'));
}

chkbrandend($brandresult);
$tid = $goodsresult['tid'];
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($tid);
C::t('#sanree_brand#forum_thread')->update($tid, array('views' => intval($forum_thread['views']) + 1));
if ($ismultiple==1&&$brandresult['allowmultiple']==1) {
	$brandresult['allicq'] = getallicq($brandresult[$icq], '&nbsp;');
	$icqline = getfirsticq($brandresult[$icq]);
	$brandresult['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
	$brandresult['tel'] = getfirsticq($brandresult['tel']);
} else {
	$brandresult['qq'] = empty($brandresult['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($brandresult['qq']), $icqshow);
	$brandresult['tel'] = getfirsticq($brandresult['tel']);
	$brandresult['allicq'] = $brandresult['qq'];
	
}
$brandresult['groupimg'] = getgroupimg($brandresult['groupid']);
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($brandresult['tid']);
$brandresult['favtimes'] = $forum_thread['favtimes'];
$brandresult['url'] = getburl($brandresult);
$brandresult['poster'] = newtheme($brandresult['poster'], 'category', '/none.gif');
if (empty($brandresult['banner'])) {
	$brandresult[banner] = sr_brand_IMG.'/banner.jpg';
}
else {
	$valueparse = parse_url($brandresult['banner']);
	if(!isset($valueparse['host'])) {
		 $brandresult['banner'] = $_G['setting']['attachurl'].'common/'.$brandresult['banner'];
	}
}
$goodsresult['dateline'] = empty($goodsresult['dateline']) ? '' : dgmdate($goodsresult['dateline']);
$goodsresult['buylink'] = empty($goodsresult['buylink']) ? '' : 'http://'.str_replace('http://', '', $goodsresult['buylink']);
$brandresult['discount'] = $brand_config['selectdiscountshow'][intval($brandresult['discount'])];
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em><a href="'.goods_getusermodeurl($brandresult).'">'.goods_modlang('goodsshow').'</a>&nbsp;&raquo;&nbsp;'.$goodsresult['catename'].'&nbsp;&raquo;&nbsp;'.$goodsresult['name'];
$navtitle = $goodsresult['name'].'-'.$brandresult['name'].' - '.$config['title'];
$goodsresult['keywords'] && $metakeywords = $goodsresult['keywords'];
$goodsresult['description'] && $metadescription = $goodsresult['description'];

if (!defined('IN_MOBILE')) {
	
	if(!$brand_config['isbird']) {
		$lasttemplate = $template;
		$template = $brand_config['template'];
		require_once libfile('class/sanree_brand_menu','plugin/sanree_brand');
		$menuclass = new sanree_brand_menu('sanree_brand');
		$menuclass->getmenu($brandresult, 'goods');
		$brand_header = $menuclass->_brand_header;
		$brand_header_one = $menuclass->_brand_header_one;
		$template = $lasttemplate;
	} else {
	
		$lasttemplate = $template;
		$template = $brand_config['template'];
		require_once libfile('class/sanree_brand_newmenu','plugin/sanree_brand');
		new sanree_brand_newmenu('goods', $brandresult, $mod);
		$template = $lasttemplate;
	
	}
}

$goodsresult['gpicture'] = goods_getforumimg($goodsresult['homeaid'], 1 , 300, 300, 'fixnone');

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
require_once libfile('function/discuzcode');
$imgarr = explode("|", $goodsresult['aids']);
$imglist = array();
$skipaid=array();
$skipaid[]= $goodsresult['homeaid'];
$goodsresult['content'] = discuzcode($goodsresult['content'], false, false);
$goodsresult['content'] = str_replace('&amp;', '&',$goodsresult['content']);
if(preg_match_all("/\[attachimg\](\d+)\[\/attachimg\]/i", $goodsresult['content'], $matchaids)) {

	foreach($matchaids[1] as $match)
		$skipaid[] = $match;
		
}
$goodsresult['content'] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", 'goods_fixthreadpic(\\1)', $goodsresult['content']);
if ($goodsresult['homeaid']) {
	$tmparray[] = $goodsresult['homeaid'];
}
foreach($imgarr as $aid) {

    if (!in_array($aid, $skipaid)) {
		$row=array();
		$row['aid'] = $aid;
		$row['pic'] = goods_getforumimg($aid, 1, 650, 0, 'fixnone');
		$imglist[] = $row;
		
	}
}
$catid= $bid;
$aids = "''";
if (count($imgarr)>0) {
	$aids='[';
	$aids.=implode($imgarr,",");
	$aids.=']';
}
$voter = C::t('#sanree_brand_goods#sanree_brand_goods_voter')->getvotetotal_by_tid($tid);
$goodsresult['satisfaction'] = $voter[3];
$goodsresult['satisfactionwidth'] = intval($voter[3]/100 * 91);
$brandresult['tel114url']	= '';
$tel114id = intval($brandresult['tel114id']);
if (($tel114id >0)&&($tel114version >=1121)) {

	$url = $tel114_is_rewrite ? 'tel114-view-'.$tel114id.'.html' : 'plugin.php?id=sanree_tel114&mod=view&tid='.$tel114id;
	$brandresult['tel114url'] = "<a href=\"".$url."\" onclick=\"showWindow('showtelkey', this.href)\"><img height=18 width=18 align=\"absmiddle\" src=\"".sr_brand_IMG."/tel114.png\" /></a>";
	
}
include templateEx($plugin['identifier'].':'.$template."/".$mod);
?>