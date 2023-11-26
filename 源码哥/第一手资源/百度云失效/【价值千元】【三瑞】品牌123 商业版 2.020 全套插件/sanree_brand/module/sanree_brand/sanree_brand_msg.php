<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_msg.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
if ($allowmsg!=1) {

	showmessage(srlang('nocontrol'));
	
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$bid = intval($_G['sr_bid']);
$type =  intval($_G['sr_type']);
!in_array($type,array(0, 1, 2, 3)) && $type = 0;

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {

	showmessage(srlang('nodengji'));
	
}
if (($brandresult['ownerid'] > 0)&&($type == 1)) {

	showmessage(srlang('noowner'));
	
}
chkbrandend($brandresult);
if(submitcheck('postsubmit')) {

	$errorword = dhtmlspecialchars(trim($_G['sr_errorword']));
	if (empty($errorword))	{
	
		showmessage(srlang('errorwordtip'));
		
	}
	$setarr 			= array();
	$setarr['bid'] 		= $bid;
	$setarr['typeid'] 	= $type;
	$setarr['words'] 	= $errorword;
	$setarr['uid'] 		= $_G['uid'];
	$setarr['status'] 	= 0;	
	$setarr['dateline'] = TIMESTAMP;		
	C::t('#sanree_brand#sanree_brand_msg')->insert($setarr);
	if ($type == 2 ) {
		$touid = $brandresult[uid];
		$message = $subject = $errorword;
		sendpm($touid, $subject, $message, '', 0, 0, 2);
	}
	$extra = array();
	$url_forward = $allurl;
	if ($_G['inajax']) {
	
	    $url_forward = '';
		$extra = array(
			'showdialog' => true,
			'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('cmenu', 0, 1);</script>"
		);
		
	}
	showmessage(srlang('succeedmessage'),$url_forward,array(),$extra);
	
}
else {
	include templateEx($plugin['identifier'].':'.$template.'/msg');
}
//From:www_YMG6_COM
?>