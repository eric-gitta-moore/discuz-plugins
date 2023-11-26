<?php

/**
 *
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'lev_enter.php';

$vdtypes = lev_class::vdtypes();

$vdtp = trim($_GET['k']);
$url = urldecode($_GET['url']);
if (!$url) {
	$vdid = intval($_GET['vdid']);
	$vd = DB::fetch_first("SELECT * FROM ".DB::table('lev_ckplayer')." WHERE id='$vdid'");
	if ($vd) {
		$updata = array('hitnum'=>$vd['hitnum']+1);
		$tid = intval($_GET['tid']);
		if ($tid) $updata['tid'] = $tid;
		DB::update('lev_ckplayer', $updata, array('id'=>$vdid));
		$url = $vd['videourl'];
		$_GET['url'] = urlencode($url);
		$xgvd = DB::fetch_all("SELECT * FROM ".DB::table('lev_ckplayer')." WHERE vdtype='{$vd['vdtype']}' OR id='$vdid' ORDER BY displayorder ASC, uptime DESC LIMIT 25");
	}
}elseif (substr($_GET['k'], 0, 4) =='9999') {
	$xgvd = lev_module::ismodule2('video_qq_grab', 'xgvd');
	$vd['title'] = $_GET['title'];
	if ($vdtp =='9999.3' && !$_GET['play1']) {
		$_GET['url'] = urlencode($xgvd[0]['url']);
	}
}

$advmar = $_PLG['advmar'];
$whpx = explode('=', $_PLG['whpx']);
$w = $whpx[0] >330 ? $whpx[0] : '100%';
$h = $whpx[1] >330 ? $whpx[1] : '540';

$w = $_GET['w'] >330 ? $_GET['w'] : $w;
$h = $_GET['h'] >330 ? $_GET['h'] : $h;

$webv = $_PLG['webw'] >330 ? (960 - $_PLG['webw']) : 0;
$webv = $_GET['webw'] >330 ? (960 - $_GET['webw']) : $webv;

$w = '100%';//固定视频宽

if (checkmobile()) {
	$h = 340;
	$webv = 600;
	$s = '';
	$videourl = lev_module::ismodule2('_xml', 'videourl', $_GET['url']);
}elseif (lev_class::ckm3u8($url) || $vd['vdfix'] =='m3u8' || $_GET['vdfix'] =='m3u8') {
	$s = 4;
	$videourl = lev_module::ismodule2('_xml', 'videourl', $_GET['url']);
}else {
	$s = 2;
	$videourl = $_G['siteurl'].$lm.'_xml&url='.$_GET['url'];
}

if ($vd || $url) {
	$vip = lev_module::ismodule2('vip', 'myvipinfo', $_G['uid']);
	if (checkmobile()) {
		include template($PLNAME.':'.$PLNAME);
	}else {
		include lev_base::tmp();
	}
}else {
	if ($vdtypes[$vdtp]) {
		$where = " `vdtype`='$vdtp' ";
	}else {
		$where = 1;
	}
	$tidurl = $PLURL.':levckplayer&vdid=';
	$uidurl = 'home.php?mod=space&uid=';

	$lists = lev_base::levpages('lev_ckplayer', "$where ORDER BY uptime DESC", 20);
	
	if (substr($vdtp, 0, 4) =='9999') {
		$vdtp = substr($vdtp, 0, 4) =='9999' ? $vdtp : '9999';
		$lists = lev_module::ismodule2('video_qq_grab');
	}
	
	include lev_base::tmp('player_list');
}









