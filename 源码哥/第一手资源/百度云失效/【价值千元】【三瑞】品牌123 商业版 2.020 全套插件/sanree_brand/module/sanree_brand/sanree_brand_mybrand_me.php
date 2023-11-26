<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_mybrand_me.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

$st = $_G['sr_st'];
$starray = array('pass', 'businessesnew' ,'refuse','record');
$starrayv= array(1, 0, -1);;
$st = !in_array($st, $starray) ? 'pass' : $st;
$stactives[$st] = ' class="a"';
$navtitle = srlang('mybrand');
$extra = '&view='.$view;
$extra .= '&st='.$st;

if($st == 'record'){
	
	$perpage = 10;
	$srchadd = $searchtext = $srchuid = '';
	$page = max(1, intval($_G['sr_page']));
	$orderby = ' rid  desc';
	$count = C::t('#sanree_brand#sanree_brand_record')->count_by_wherec($searchtext);
	if ($count>0) {
	
		$datalist = C::t('#sanree_brand#sanree_brand_record')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
		foreach($datalist as $value) {
			
			$value['name'] = C::t('#sanree_brand#sanree_brand_businesses')->getname_by_bid(intval($value['bid']));
			$group = C::t('#sanree_brand#sanree_brand_group')->getgroup_by_gid($value['gid']);
			$busineses = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid(intval($value['bid']));
			$value['turl'] = getburl($busineses);
			$value['groupname'] = $group['groupname'];
			$value['dateline'] = dgmdate($value['dateline'] );
			
			$classarr[$value[rid]] = $value;
		}
		$murl= 'plugin.php?id=sanree_brand&mod=mybrand'.$extra;
		$multi = multi ( $count, $perpage, $page, $murl);
		
	}

	
}else {
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
	$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec($where);
	if ($count>0) {
	
		require_once libfile('function/discuzcode');
		$orderby = 't.istop desc,t.displayorder,t.dateline desc';	
		$datalist = C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
		$maxorder = C::t('#sanree_brand#sanree_brand_group')->get_by_maxorder();
		foreach($datalist as $value) {
		
			$value['turl'] = getburl($value);
			$value['editurl'] = 'plugin.php?id=sanree_brand&mod=published&bid='.$value['bid'];
			$value['brandconfigurl'] = 'plugin.php?id=sanree_brand&mod=brandconfig&bid='.$value['bid'];
			$value['dateline'] = dgmdate($value['dateline'] );
			$value['groupimg'] = getgroupimg($value['groupid']);
			if(intval($value['groupid'])){
				
				$group = C::t('#sanree_brand#sanree_brand_group')->fetch_order_by_groupid(intval($value['groupid']));
				$value['order'] = $group['order'];
				
			}else {
				$value['order'] = -1;
			}
			
			if($value['order'] == $maxorder['order']) {
				$value['maxorder'] = 1;
			}
			$classarr[$value[bid]] = $value;
			
		}
		$murl= 'plugin.php?id=sanree_brand&mod=mybrand'.$extra;
		$multi = multi ( $count, $perpage, $page, $murl);
		
	}

}
$navtitle = srlang('mybrand');
$pubtip_price = srlang('pubtip_price');
$pubtip_price = str_replace(array('{regprice}', '{creditunitname}'), array($regprice, $creditunitname), $pubtip_price);
$pubtip_shen = srlang('pubtip_shen');
$pubtip_shen = str_replace(array('{admintel}'), array($admintel), $pubtip_shen);
$pubtip_ok = srlang('pubtip_ok');
$pubtip_ok = str_replace(array('{admintel}'), array($admintel), $pubtip_ok);
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>