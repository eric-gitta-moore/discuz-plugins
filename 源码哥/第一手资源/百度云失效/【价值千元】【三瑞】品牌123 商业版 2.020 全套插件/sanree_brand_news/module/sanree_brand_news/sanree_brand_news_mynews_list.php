<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_news_mynews_list.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072820Zq5a00tJ50||7908||1402027202');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$st = $_G['sr_st'];
$starray = array('pass', 'newsnew' ,'refuse');
$starrayv= array(1, 0, -1);;
$st = !in_array($st, $starray) ? 'pass' : $st;
$stactives[$st] = ' class="a"';
$navtitle = srlang('mybrand');
$extra = '&view='.$view;
$extra .= '&st='.$st;
$perpage = 10;
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$multi 		= '';
$where = array();
$where[] = 't.uid='.$_G['uid'];
$where[] = 'c.status=1';
$in= array_search($st,$starray);
$where[] = 't.status='.$starrayv[$in];
$count = C::t('#sanree_brand_news#sanree_brand_news')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$orderby = 't.istop desc,t.displayorder,t.dateline desc';	
	$datalist = C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	    $value['turl'] = news_getburl($value);
		$value['editurl'] = 'plugin.php?id=sanree_brand_news&mod=published&nid='.$value['nid'];
		$value['deleteurl'] = 'plugin.php?id=sanree_brand_news&mod=deletenews&nid='.$value['nid'];
	    $value['dateline'] = dgmdate($value['dateline'] );
		$value['isshow'] = $value['isshow']==1 ? news_modlang('showyes') : news_modlang('notshow');
		$classarr[$value[nid]] = $value;
	}
	$murl= 'plugin.php?id=sanree_brand_news&mod=mynews'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$navtitle =  lang('plugin/sanree_brand', 'mybrand');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>