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

$url = urldecode($_GET['url']);

$hook = intval($_GET['hook']);
$i = intval($_GET['i']);

$advmar = lev_base::levdiconv($_PLG['advmar'], CHARSET, 'utf-8');
$whpx = explode('=', $_PLG['whpx']);
$w = $whpx[0] >1 ? $whpx[0] : '100%';
$h = $whpx[1] >1 ? $whpx[1] : '540';

if ($url) {
	$params = explode('[=]', $url);
	$videourl = $params[0];
	$whc = explode('=', $params[1]);
	$w = $whc[0] >1 ? $whc[0] : $w;
	$h = $whc[1] >1 ? $whc[1] : $h;
}
if (checkmobile()) {
	$w = $h = '100%';
}
$videourl = $videourl ? $videourl : 'http://v.qq.com/cover/p/p9bwwn685vytr0x.html?vid=g0016ij9jd6';

$video = lev_class::getvideourl($videourl);
$videourl = $video['high'][$i];
$vnum = count($video['high']);

foreach ($video['high'] as $k => $v) {
	//lev_class::downvideo($params[0], $v, $k+1);
	$wd4.='		<video>'.chr(13);
	$wd4.='			<file>'.$v.'</file>'.chr(13);;
	$wd4.='		</video>'.chr(13);
}
$urllist2='<?xml version="1.0" encoding="utf-8"?>'.chr(13);
$urllist2.='	<ckplayer>'.chr(13);
$urllist2.='	<flashvars>'.chr(13);
$urllist2.='		{h->2}{q->rate}'.chr(13);
$urllist2.='	</flashvars>'.chr(13);
$urllist2.='	'.$wd4;
$urllist2.='	</ckplayer>';
ob_clean();
echo $urllist2;

if ($_GET['debug']) {
	echo '<pre>@@@';
	print_r($video);
}







