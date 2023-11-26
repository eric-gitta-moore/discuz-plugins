<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_swfupload.php sanree $
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
	
		showmessage(lang('plugin/sanree_brand','nomoney'));
		
	}
}
 
$_G['uid'] = intval($_G['uid']);
if((empty($_G['uid']) && $_GET['operation'] != 'upload') || $_POST['hash'] != md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])) {
	exit();
} else {
	if($_G['uid']) {
		$_G['member'] = getuserbyuid($_G['uid']);
	}
	$_G['groupid'] = $_G['member']['groupid'];
	loadcache('usergroup_'.$_G['member']['groupid']);
	$_G['group'] = $_G['cache']['usergroup_'.$_G['member']['groupid']];
}

if($_GET['operation'] == 'upload') {

	if($_FILES['Filedata']['error']==0){
		$tmpavatar = $_FILES['Filedata']['tmp_name'];
		list($width, $height, $type, $attr) = getimagesize($tmpavatar);
		if ($ischkpictype==1) {
		
			$imgtype = array(1, 2, 3, 6);
			if (!in_array($type, $imgtype)) {
				file_exists($tmpavatar) && @unlink($tmpavatar);
				$type= intval($type);
				echo 'DISCUZUPLOAD|1|4|'.$type.'|0|0|0|0';
				exit();			
			}
			
		}
	} else {
		echo 'DISCUZUPLOAD|1|-1|0|0|0|0|0';
		exit();		
	}
	require_once(DISCUZ_ROOT.'./source/plugin/sanree_brand/class/forum_upload.php');		
	new sanree_forum_upload();
	
} 
?>