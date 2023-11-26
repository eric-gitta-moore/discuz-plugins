<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_myguestbook_list.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214b98wB3Bomz||7247||1422453601');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$st = $_G['sr_st'];
$starray = array('pass', 'guestbooknew', 'mygb');
$starrayv= array(1, 0, -1);;
$st = !in_array($st, $starray) ? 'guestbooknew' : $st;
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

if ($st=='mygb') {

		$where = array();
		$where[] = 'gb.uid='.$_G[uid];
		$count = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_wherec($where);
		if ($count>0) {
		
			$orderby = 'gb.displayorder,gb.dateline desc';	
			$datalist = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
			foreach($datalist as $value) {
			
				$value['dateline'] = dgmdate($value['dateline'] );
				$value['style'] = $value['status']==1 ? ' class="sanreechuliok" ':'';
				$value['st'] = $value['status']==1 ? guestbook_modlang('yes'):guestbook_modlang('no');
				$value['url'] =  'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=show&guestbookid='.$value['guestbookid'];
				$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($value['bid']);
				$value['brandurl'] = getburl($br);
				$classarr[$value[guestbookid]] = $value;
				
			}
			$murl= 'plugin.php?id=sanree_brand_guestbook&mod=myguestbook'.$extra;
			$multi = multi ( $count, $perpage, $page, $murl);

		}
		
} else {
	
	$bids = array();
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search("AND uid=$_G[uid]",'displayorder',0,1000) as $data) {
		$bids[] = $data[bid];
	}
	if (count($bids)>0) {
	
		$wherebids = implode($bids, ',');		
		$where = array();
		$where[] = 'gb.bid in ('.$wherebids.')';
		$in= array_search($st,$starray);
		$where[] = 'gb.status='.$starrayv[$in];
		
		$count = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_wherec($where);
		if ($count>0) {
		
			$orderby = 'gb.displayorder, gb.dateline desc';	
			$datalist = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
			foreach($datalist as $value) {
			
				$value['dateline'] = dgmdate($value['dateline'] );
				$value['url'] =  'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=show&guestbookid='.$value['guestbookid'];
				$value['chuliurl'] =  'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=chuli&guestbookid='.$value['guestbookid'];
				$value['deleteurl'] =  'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=delete&guestbookid='.$value['guestbookid'];
				$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($value['bid']);
				$value['brandurl'] = getburl($br);
				$classarr[$value[guestbookid]] = $value;
				
			}
			$murl= 'plugin.php?id=sanree_brand_guestbook&mod=myguestbook'.$extra;
			$multi = multi ( $count, $perpage, $page, $murl);
			
		}
	}
}
$navtitle =  lang('plugin/sanree_brand_guestbook', 'guestbook');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>