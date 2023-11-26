<?php

/**
 * Www.침혹걸.Vip
 *
 * [침혹걸!] (C)2014-2017 www.moqu8.com.  By www-침혹걸-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class _xml_module {

	public static function videourl() {
		$plg = lev_base::$PL_G;
				
		$url = urldecode($_GET['url']);
		
		$video = lev_class::getvideourl($url);
		if (($video =='-1' || !is_array($video['high'])) && $plg['mobileurl']) {
			//$vdurl = lev_module::ismodule2('x_curl', 'doCurl', array('url'=>$plg['mobileurl'].$url));
			$vdurl = $plg['mobileurl'].$url;
			$video = array('high'=>array($vdurl));//print_r($video);
			//$video['high'][0] = $vdurl;
		}
		$vdfix = lev_class::ckrealext($video['high'][0]);
		if ($vdfix) {
			DB::update('lev_ckplayer', array('vdfix'=>$vdfix), array('videourl'=>$url));
		}
		return $video['high'][0];
	}
	
	public static function _xml() {
		$plg = lev_base::$PL_G;
		$url = urldecode($_GET['url']);
		
		$video = lev_class::getvideourl($url);
		if (!is_array($video['high']) && $plg['xmlurl']) {
			$xmlrs = lev_module::ismodule2('x_curl', 'doCurl', array('url'=>$plg['xmlurl'].$url));
			exit($xmlrs);
		}
		$vdfix = lev_class::ckrealext($video['high'][0]);
		if ($vdfix) {
			DB::update('lev_ckplayer', array('vdfix'=>$vdfix), array('videourl'=>strip_tags($url)));
		}
		
		foreach ($video['high'] as $v) {
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
	}

}







