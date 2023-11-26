<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_myvideo_list.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098D7zaVQA8A||11681||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$st = $_G['sr_st'];
$starray = array('pass', 'videonew' ,'refuse');
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
$count = C::t('#sanree_brand_video#sanree_brand_video')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$orderby = 't.istop desc,t.displayorder,t.dateline desc';	
	$datalist = C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	    $value['turl'] = video_getburl($value);
		$value['editurl'] = 'plugin.php?id=sanree_brand_video&mod=published&cid='.$value['cid'];
		$value['deleteurl'] = 'plugin.php?id=sanree_brand_video&mod=deletevideo&cid='.$value['cid'];
	    $value['dateline'] = dgmdate($value['dateline'] );
		$value['isshow'] = $value['isshow']==1 ? video_modlang('showyes') : video_modlang('notshow');
		$classarr[$value[cid]] = $value;
	}
	$murl= 'plugin.php?id=sanree_brand_video&mod=myvideo'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$navtitle =  lang('plugin/sanree_brand', 'mybrand');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>