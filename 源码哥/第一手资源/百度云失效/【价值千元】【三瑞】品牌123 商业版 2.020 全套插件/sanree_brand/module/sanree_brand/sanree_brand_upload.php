<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_upload.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
if (!in_array($_G['group']['groupid'],$addgroup)) {

	showmessage($stopaddtip);
	
}
if ($regprice>0) {

	$account = getuserprofile('extcredits'.$creditunit);		
	if ($regprice>$account) {
	
		showmessage(srlang('nomoney'));
		
	}
	
}
$type = 'image';
$attachexts = $imgexts = '';
$imgexts = 'jpg, jpeg, gif, png, bmp';
if (!$_G['group']['allowpostimage'] || !$imgexts){

	showmessage('no_privilege_postimage');
	
}
$input_imagetip = srlang('input_imagetip');
$input_imagetip = str_replace('{w}',intval($_G['sr_w']),$input_imagetip);
$input_imagetip = str_replace('{h}',intval($_G['sr_h']),$input_imagetip);

include templateEx($plugin['identifier'].':'.$template."/".$mod);
?>