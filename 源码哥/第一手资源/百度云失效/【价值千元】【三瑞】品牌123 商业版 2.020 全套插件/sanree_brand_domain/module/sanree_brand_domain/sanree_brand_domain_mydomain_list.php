<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domain_mydomain_list.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2013112510ufVaYF1VzC||18562||1381384801');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$navtitle = srlang('mybrand');
$extra = '&view='.$view;
$perpage = 10;
$page 		= intval($_G['sr_page']);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$multi 		= '';

$wherebids = implode($bids, ',');		
$where = array();
$where[] = 'd.uid = '.$_G['uid'];
$count = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_whered($where);
if ($count>0) {

	$orderby = 'd.domainid desc';	
	$datalist = C::t('#sanree_brand_domain#sanree_brand_domain')->fetch_all_by_searchd($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	
		$value['dateline'] = $value['dateline'] ? dgmdate($value['dateline']):'';
		$value['enddate'] = $value['enddate'] ? dgmdate($value['enddate']):'';
		$value['st'] = $value['status']==1 ? domain_modlang('passok') : domain_modlang('pending');	
		$value['isshowstr'] = $value['isshow']==1 ? domain_modlang('tmp_yew') : domain_modlang('tmp_no');	
		$value['editurl'] = 'plugin.php?id=sanree_brand_domain&mod=editdomain&domainid='.$value['domainid'].'&page='.$page;
		$classarr[$value['domainid']] = $value;
		
	}
	$murl= 'plugin.php?id=sanree_brand_domain&mod=mydomain'.$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}

$navtitle =  lang('plugin/sanree_brand_domain', 'domain');
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>