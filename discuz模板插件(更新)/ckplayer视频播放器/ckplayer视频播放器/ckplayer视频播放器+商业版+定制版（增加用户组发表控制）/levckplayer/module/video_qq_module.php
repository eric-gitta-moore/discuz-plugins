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

//require_once 'class/qq.class.php';

class video_qq_module {
	
	public static function video_qq($arr = array()) {// echo '<pre>@@@@';
		$url = $arr[0];
		$isvid = $arr[1];
		if ($vid = strstr($url, 'vid=')) {
			$info['vid'] = str_ireplace('vid=', '', $vid);
		}else {
			$htmlContent = lev_module::ismodule2('x_curl', 'doCurl', array('url'=>$url));
			$htmlstr = str_ireplace(array("\n", "\r", " ", '</body>', '</html>'), '', $htmlContent);
			$videostr = stristr($htmlstr, 'varVIDEO_INFO=');//varCOVER_INFO=  4
			$videojson = explode(';', $videostr);//print_r($videojson);
			$json = strstr($videojson[0], '{');//print_r($json);
			$_jc = explode('}', $json);
			$json = $_jc[0].'}';
			$info = lev_module::ismodule2('x_curl', 'jsondcode', $json);//print_r($info);
			if (!$info['vid']) {
	            preg_match('/title:"([^"]+)"/s', $htmlContent, $titles);
	            preg_match('/duration:"([^"]+)"/s', $htmlContent, $durations);
	            preg_match('/vid:"([^"]+)"/s', $htmlContent, $vids);
	            $title = (!empty($titles[1]))?$titles[1]:'';
	            $duration = $durations[1];
	            $info['vid'] = $vids[1];
			}
		}
		$vid = trim($info['vid']);
		if ($isvid) return $vid;
		//$realUrl = "http://vv.video.qq.com/geturl?vid=".$vid."&otype=json&platform=1&ran=0.9652906153351068";
		//$realUrl = "http://vv.video.qq.com/getinfo?vid=".$vid."&otype=json&platform=1&ran=0.9652906153351068";
		$platform = stripos($url, '/page/') ? 11001 : 1;
		$realUrl = 'http://h5vv.video.qq.com/getinfo?callback=tvp_request_getinfo_callback_688321&platform='.$platform.'&charge=0&otype=json&sphls=0&sb=1&nocache=0&_rnd=1463590197842&vids='.$vid.'&defaultfmt=auto&&_qv_rmt=ICnFNjuUA16509LC1=&_qv_rmt2=xPSTtKHk143917mkw=&sdtfrom=v5010&callback=tvp_request_getinfo_callback_688321';
		$htmlContent = lev_module::ismodule2('x_curl', 'doCurl', array('url'=>$realUrl, 'cookie'=>$cookie, 'referer'=>$url));
		$json = strstr($htmlContent, '({');
		$info = lev_module::ismodule2('x_curl', 'jsondcode', $json);//print_r($info);
		if ($info) {//['vd']['vi'][0]['url']
			$video['high'][0] = $info['vd']['vi'][0]['url'];
			$mp4 = $info['vl']['vi'][0]['fn'];
			$video['high'][0] = $info['vl']['vi'][0]['ul']['ui'][0]['url'].$mp4.'?vkey='.$info['vl']['vi'][0]['fvkey'].'&br='.$info['vl']['vi'][0]['br'].'&platform=2&fmt=auto&level=0&sdtfrom=v5010';
		}else {
			//$video = Qq::parse($url);
		}
		return $video;
	}

	public static function vdvid($url) {
		return self::video_qq(array($url, 1));
	}
	
}







