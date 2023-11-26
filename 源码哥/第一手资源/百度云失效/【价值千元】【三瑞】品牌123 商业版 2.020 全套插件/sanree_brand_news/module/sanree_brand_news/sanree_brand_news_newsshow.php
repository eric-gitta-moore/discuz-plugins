<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_news_newsshow.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072820Zq5a00tJ50||7908||1402027202');
}

if (!in_array($groupid, $viewgroup)) {

	if ($_G[uid]!=1) {
	
	    showmessage(news_modlang('stopviewtip'));
		
	}
	
}

$nid = intval($_G['sr_tid']);

$newsresult = C::t('#sanree_brand_news#sanree_brand_news')->getnews_by_nid($nid);
if (!$newsresult) {
	showmessage(news_modlang('nonewsshow'));
}
if ($newsresult[isshow]!=1) {
	showmessage(news_modlang('notisshow'));
}

news_chkmodeend($newsresult);
$bid = $newsresult[bid];

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	showmessage(srlang('nobrand'));
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
if ($brandmoduleresult['isnews']!=1) {
	showmessage(news_modlang('nonews'));
}

chkbrandend($brandresult);
$tid = $newsresult['tid'];
$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($tid);
C::t('#sanree_brand#forum_thread')->update($tid, array('views' => intval($forum_thread['views']) + 1));
$newsresult['views'] = intval($forum_thread['views']) + 1;
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
$newsresult[dateline] = empty($newsresult['dateline']) ? '' : dgmdate($newsresult['dateline']);

$brandresult['discount'] = $brand_config['selectdiscountshow'][intval($brandresult['discount'])];
$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em><a href="'.news_getusermodeurl($brandresult).'">'.news_modlang('newsshow').'</a>&nbsp;&raquo;&nbsp;'.$newsresult[catename].'&nbsp;&raquo;&nbsp;'.$newsresult[name];
$navtitle = $newsresult[name].'-'.$brandresult['name'].' - '.$config['title'];
$newsresult['keywords'] && $metakeywords = $newsresult['keywords'];
$newsresult['description'] && $metadescription = $newsresult['description'];
$lasttemplate = $template;
$template = $brand_config['template'];
require_once libfile('class/sanree_brand_menu','plugin/sanree_brand');
$menuclass = new sanree_brand_menu('sanree_brand');
$menuclass->getmenu($brandresult, 'news');
$brand_header = $menuclass->_brand_header;
$brand_header_one = $menuclass->_brand_header_one;
$template = $lasttemplate;
$newsresult['gpicture'] = news_getforumimg($newsresult['homeaid'], 1 , 300, 300, 'fixnone');

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
$imgarr = explode("|", $newsresult['aids']);
$imglist = array();
$skipaid=array();
$newsresult['content'] = discuzcode($newsresult[content]);
$newsresult['content'] = str_replace('&amp;', '&',$newsresult['content']);
if(preg_match_all("/\[attachimg\](\d+)\[\/attachimg\]/i", $newsresult[content], $matchaids)) {

	foreach($matchaids[1] as $match)
		$skipaid[] = $match;
		
}
$newsresult[content] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", 'news_fixthreadpic(\\1)', $newsresult[content]);
foreach($imgarr as $aid) {

	if (!in_array($aid, $skipaid)&&(intval($aid)>0)) {
		$row=array();
		$row[aid] = $aid;
		$row[pic] = news_getforumimg($aid, 1, 650, 0, 'fixnone');
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
$voter = C::t('#sanree_brand_news#sanree_brand_news_voter')->getvotetotal_by_tid($tid);
$newsresult['satisfaction'] = $voter[3];
$newsresult['satisfactionwidth'] = intval($voter[3]/100 * 91);
include templateEx($plugin['identifier'].':'.$template."/".$mod);
?>