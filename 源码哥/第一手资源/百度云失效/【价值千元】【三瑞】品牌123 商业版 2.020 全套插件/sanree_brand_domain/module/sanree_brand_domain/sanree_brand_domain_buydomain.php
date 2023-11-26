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

if ($domainprice>0) {

	$account = getuserprofile('extcredits'.$creditunit);		
	if ($domainprice>$account) {
	
		showmessage($nonepricetip);
		
	}
	
}
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
		$domainname = dhtmlspecialchars(trim($_G['sr_domainname']));
		if (empty($domainname)) {
			showmessage(domain_modlang('error_domaintitle'));
		}	
		
		chkdomain($domainname);	
		if ( $config["isshen"] == 1 ) {
		
			$msg  = domain_modlang('yesmessage');
			$status = 0;
			$smsg = 'domain_pending';
			
		}
		else {
		
			$status = 1;
			$msg  = domain_modlang('okmessage');
			$smsg = 'domain_pass';
			
		}		
			
		$setarr['domainname'] = $domainname;
		$setarr['uid'] =  $_G['uid'];
		$setarr['username'] =  $_G['username'];
		$setarr['status'] = $status;
		$setarr['price'] = $domainprice;
		$count=C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_where(' AND domainname=\''.$domainname.'\'');
		if ($count>0) {
	
			showmessage(domain_modlang('error_bdomain_have'));			
				
		}	
		$setarr['dateline'] = TIMESTAMP;
		$setarr['enddate'] = TIMESTAMP + $overday * 24 * 60 * 60;	
		$domainid = C::t('#sanree_brand_domain#sanree_brand_domain')->insert($setarr, TRUE);
		if ($domainprice > 0) {
		
			$creditdata=array('extcredits'.$creditunit => -intval($domainprice));	
			updatemembercount($_G['uid'], $creditdata, true, 'DMN', 1);
			
		}		
		senddomain_notice($domainid, $smsg);
		$url_forward = 'plugin.php?id=sanree_brand_domain&mod=mydomain&view=list&page'.$page;	
	    $href = $url_forward;
		$href = str_replace("'", "\'", $href);	
		$extra = array(
			'showdialog' => false,
			'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('buydlg', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
		);
		showmessage($msg,'',array(),$extra);

} else {

	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>