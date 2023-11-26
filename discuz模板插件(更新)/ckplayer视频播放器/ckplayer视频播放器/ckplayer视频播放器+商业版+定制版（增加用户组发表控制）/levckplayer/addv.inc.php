<?php

/**
 *
 *
 * [Ä§È¤°É!] (C)2014-2017 www.moqu8.com.
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'lev_enter.php';

//if ($_G['adminid'] !=1) showmessage($lev_lang['noactop']);

$vdid = intval($_GET['vdid']);
if ($vdid >=1) {
	$r = DB::fetch_first("SELECT * FROM ".DB::table('lev_ckplayer')." WHERE id='{$vdid}'");
	if (empty($r)) showmessage($lev_lang['notvd']);
	$sets = unserialize($r['settings']);
}

if ($_GET['formhash'] ==FORMHASH) {
	$videourl = trim(strip_tags($_GET['videourl']));
	$title    = trim(strip_tags($_GET['title']));
	$vdtype   = trim(strip_tags($_GET['vdtype']));
	$imgsrc   = lev_module::ismodule2('x_upload', 'up_image', 'imgsrc_file');
	$imgsrc   = $imgsrc ? $imgsrc : trim(strip_tags($_GET['imgsrc']));
	if (!$imgsrc) {
		exit($lev_lang['imgsrc1']);
	}elseif (!lev_module::ismodule2('x_selects', 'valstr', array($_PLG['vdtype'], $vdtype))) {
		exit($lev_lang['vdtype']);
	}elseif (substr($videourl, 0, 4) !='http' || strpos($videourl, '.') ==FALSE) {
		exit($lev_lang['videourl'].$lev_lang['videourl1']);
	}elseif (strtolower(substr($videourl, -4, 4)) =='.swf') {
		exit($lev_lang['videourl2']);
	}elseif (strlen($title) <6) {
		exit($lev_lang['videourl3']);
	}
	foreach ($_GET['sets'] as $k => $v) {
		$sets[$k] = trim(strip_tags($v));
	}
	$insert = array(
		'title' => lev_base::levdiconv($title),
		'vdtype' => $vdtype,
		'isvip' => intval($_GET['isvip']),
		'videourl' => $videourl,
		'imgsrc' => $imgsrc,
		'sectime' => trim(strip_tags($_GET['sectime'])),
		'contents' => trim(strip_tags($_GET['contents'])),
		'settings' => serialize($sets),
		'uptime' => TIMESTAMP,
	);
	if ($vdid >=1) {
		DB::update('lev_ckplayer', $insert, array('id'=>$vdid));
	}else {
		$insert['uid'] = $_G['uid'];
		$insert['bbsname'] = $_G['username'];
		$insert['addtime'] = TIMESTAMP;
		$vdid = DB::insert('lev_ckplayer', $insert, TRUE);
	}
	echo $vdid;
	exit();
}

$sets[webw] = $_GET['webw'] >1 ? $_GET['webw'] : $_PLG['webw'];

include template($PLNAME.':addvideo');









