<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domain_editdomain.php sanree $
 */
if(!defined('IN_DISCUZ')) {
	exit('2013112510ufVaYF1VzC||18562||1381384801');
}
$page 		= intval($_G['sr_page']);
$page 		= max(1, intval($page));
if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$domainid=intval($_G['sr_domainid']);
$result = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_uidanddomainid($_G['uid'], $domainid);
if (!$result) {

	showmessage(domain_modlang('nodomainid'));
	
}
if ($result['status'] !=1 ) {

	showmessage(domain_modlang('nostatus'));
	
}
$domaininfo = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->get_by_uidanddomainid($_G['uid'], $domainid);
$result['bid'] = intval($domaininfo['bid']);
$result['isshow'] = intval($domaininfo['isshow']);
$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);   
	
$brandcount = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
if ($brandcount<1) {

	$href = 'plugin.php?id=sanree_brand_domain&mod=mydomain&view=list&page'.$page;	
	$href = str_replace("'", "\'", $href);	
	$extra = array(
		'showdialog' => false,
		'extrajs' => "<script type=\"text/javascript\" reload=\"1\">setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
	);
    showmessage(domain_modlang('pleaseaddbrand'),'',array(),$extra);
	
}

if(submitcheck('postsubmit')) {
	    $setarr = array();
		$bid = intval($_G['sr_bid']);
		$brand = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bidanduid($_G['uid'], $bid);	
		if (!$brand) {
		
			showmessage(domain_modlang('error_bid'));
			
		}
		$setarr['bid'] = $bid;
		$setarr['uid'] =  $_G['uid'];		
		$setarr['username'] =  $_G['username'];			
		$setarr['isshow'] = intval(trim($_G['sr_isshow']));	
		$did = $domaininfo['id'];			
        if ($domaininfo) {

			C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->update($domaininfo['id'], $setarr);
			
		} else {

			$setarr['domainid'] = $domainid;			
			$setarr['status'] = 1;		
		    $setarr['dateline'] = TIMESTAMP;			
			$did = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->insert($setarr, TRUE);
			
		}
		makedomain($did);		
		$url_forward = 'plugin.php?id=sanree_brand_domain&mod=mydomain&view=list&page'.$page;	
	    $href = $url_forward;
		$href = str_replace("'", "\'", $href);	
		$extra = array(
			'showdialog' => false,
			'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('editdlg', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
		);
		showmessage(domain_modlang('succeed'),'',array(),$extra);

} else {

	$orderby = 'displayorder,dateline desc';
	$where = array();
	$where[] = 't.uid='.$_G['uid'];
	$where[] = 'c.status=1';
	$where[] = 't.status=1';
	$mybrandlist = C::t('#sanree_brand_domain#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, 0, 1000);	
	$selectlist = array();	
	foreach($mybrandlist as $data) {
	
		$selectlist[] =array('bid'=> $data['bid'], 'name' => $data['name'], 'selected' => '');
		
	}	
	if ($result['isshow']==1) {
	
		$isshowst = ' checked="checked" ';
		$notshowst = '';
		
	} else {
	
		$isshowst = '';
		$notshowst = ' checked="checked" ';
		
	}	
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>