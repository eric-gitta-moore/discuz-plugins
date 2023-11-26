<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_apply_promotion.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}


if($_G['sr_promotion']) {
	
	$uid = C::t('#sanree_brand#sanree_brand_businesses')->fetch_uid_by_bid(intval($_G['sr_bid']));
	if($uid != $_G['uid']) {
		echo -1;
		
		return;
	}
	
	
	if (intval($_G['sr_gp'])>0) {
	
		$account = getuserprofile('extcredits'.$creditunit);
		if (intval($_G['sr_gp']) > $account) {
		
			echo 0;
			
			return;
			
		}
		
	}
	
	$former = C::t('#sanree_brand#sanree_brand_businesses')->getgroupid_by_bid(intval($_G['sr_bid']));
	C::t('#sanree_brand#sanree_brand_businesses')->update(intval($_G['sr_bid']) , array('groupid' => intval($_G['sr_gid'])));
	
	$creditdata=array('extcredits'.$creditunit => -intval($_G['sr_gp']));
	updatemembercount($_G[uid], $creditdata, true, 'BRD', 1);
	
	
	$setarr = array();
	$setarr['bid'] = intval($_G['sr_bid']);
	$setarr['uid'] = intval($_G['uid']);
	$setarr['former'] = intval($former);
	$setarr['gid'] = intval($_G['sr_gid']);
	$setarr['cost'] = $_G['sr_gp'];
	$setarr['dateline'] = TIMESTAMP;
	C::t('#sanree_brand#sanree_brand_record')->insert($setarr);
	
	echo 1;
	
} else {
	
	if (!$_G['uid']) {

		showmessage(srlang('nologin'), '', array(), array('login' => true));
		
	}
	if (!in_array($_G['group']['groupid'],$addgroup)) {
	
		showmessage($stopaddtip);
		
	}
	$brandname = C::t('#sanree_brand#sanree_brand_businesses')->getname_by_bid(intval($_G['sr_bid']));
	$groups = C::t('#sanree_brand#sanree_brand_group')->fetch_all_by_order(intval($_G['sr_order']));
	$groupname = C::t('#sanree_brand#sanree_brand_group')->fetch_groupname_by_order(intval($_G['sr_order']));
	$uid = C::t('#sanree_brand#sanree_brand_businesses')->fetch_uid_by_bid(intval($_G['sr_bid']));
	$current_credit = getuserprofile('extcredits'.$creditunit);
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
}
//From:www_YMG6_COM
?>