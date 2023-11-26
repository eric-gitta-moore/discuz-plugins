<?php

/**
 * 魔趣吧官网：http://WWW.moqu8.com
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'lev_module.php';

class lev_class extends lev_module {

	public static $videoext = array('mp4', 'm3u8', 'flv', 'f4v', 'webm', 'ogg');
	public static $flashext = array('mp4', 'm3u8', 'flv', 'f4v');
	public static $html5ext = array('mp4', 'm3u8', 'webm', 'ogg');

	public static function sectime($seconds) {
	    $theTime = intval($seconds);// 秒
	    $theTime1 = 0;// 分
	    $theTime2 = 0;// 小时
	    if($theTime > 60) {
	        $theTime1 = intval($theTime/60);
	        $theTime = intval($theTime%60);
	        if($theTime1 > 60) {
	            $theTime2 = intval($theTime1/60);
	            $theTime1 = intval($theTime1%60);
	        }
	    }
	    $theTime = intval($theTime);
	    $theTime = $theTime <10 ? "0". $theTime : $theTime;
	    $theTime1 = intval($theTime1);
	    $theTime1 = $theTime1 <10 ? "0". $theTime1 : $theTime1;
	    $theTime2 = intval($theTime2);
	    $theTime2 = $theTime2 <10 ? "0". $theTime2 : $theTime2;
	    return $theTime2 .':'. $theTime1 .':'. $theTime;
	}
	
	public static function vdtypes() {
		$_plg = lev_base::$PL_G;
		$vdtypes = self::ismodule2('x_explode', 'init', array($_plg['vdtype']));
		return $vdtypes;
	}
	
	public static function ckrealext($url) {
		foreach (self::$videoext as $v) {
			$ext[$v] = stripos($url, $v);
		}
		$max = max($ext);
		if ($max) {
			foreach ($ext as $k => $v) {
				if ($v ==$max) return $k;
			}
		}
		return '';
	}
	
	public static function getext($url) {
		return self::ckrealext($url);
		if (stripos($url, 'mp4') !==FALSE) {
			return 'mp4';
		}elseif (stripos($url, 'flv') !==FALSE) {
			return 'flv';
		}elseif (stripos($url, 'f4v') !==FALSE) {
			return 'f4v';
		}elseif (stripos($url, 'webm') !==FALSE) {
			return 'webm';
		}elseif (stripos($url, 'ogg') !==FALSE) {
			return 'ogg';
		}elseif (stripos($url, 'm3u8') !==FALSE) {
			return 'm3u8';
		}
	}
	
	public static function ckm3u8($url) {
		if (strpos($url, '.hunantv.com') !=FALSE || strpos($url,'mgtv.com')) {
			return TRUE;
		}elseif (strpos($url, '.115.com') !=FALSE) {
			return TRUE;
		}elseif (strpos($url, '.m3u8') !=FALSE) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public static function html5ext($url) {
		$ext = self::getext($url);
		if ($ext && in_array($ext, self::$html5ext)) return TRUE;
		return FALSE;
	}

	public static function onlyhtml5($url) {
		$ext = self::getext($url);
		if ($ext && in_array($ext, array('webm', 'ogg'))) return TRUE;
		return FALSE;
	}

	public static function onlyflash($url) {
		$ext = self::getext($url);
		if ($ext && in_array($ext, array('flv', 'f4v'))) return TRUE;
		return FALSE;
	}
	
	public static function ckiqiyi($url) {
		return strpos($url, '.iqiyi.com');
	}

	public static function getvideourl($videourl) {
		if (self::getext($videourl)) {
			$urls = explode('[]', $videourl);
			$video['isfile'] = 2;
			$video['high'] = $urls;
		}elseif (strpos($videourl, '.qq.com') !=FALSE) {
			if (!file_exists(DISCUZ_ROOT.'source/plugin/levckplayer/module/video_qq_module.php')) return '-1';
			$video = lev_module::ismodule2('video_qq', '', array($videourl));
			
		}elseif (strpos($videourl, '.iqiyi.com') !=FALSE) {
			if (!file_exists(DISCUZ_ROOT.'source/plugin/levckplayer/module/video_iqiyi_module.php')) return '-1';
			$video = lev_module::ismodule2('video_iqiyi', '', array($videourl));
			
		}elseif (strpos($videourl, '.youku.com') !=FALSE) {
			if (!file_exists(DISCUZ_ROOT.'source/plugin/levckplayer/module/video_youku_module.php')) return '-1';
			$video = lev_module::ismodule2('video_youku', '', array($videourl));
			
		}elseif (strpos($videourl, '.hunantv.com') !=FALSE || strpos($videourl,'.mgtv.com')) {
			if (!file_exists(DISCUZ_ROOT.'source/plugin/levckplayer/module/video_hunantv_module.php')) return '-1';
			$video = lev_module::ismodule2('video_hunantv', '', array($videourl));
			
		}elseif (strpos($videourl, '.tudou.com') !=FALSE) {
			if (!file_exists(DISCUZ_ROOT.'source/plugin/levckplayer/module/video_tudou_module.php')) return '-1';
			$video = lev_module::ismodule2('video_tudou', '', array($videourl));
			
		}elseif (strpos($videourl, '.kankan.com') !=FALSE) {//失效
			$video = lev_module::ismodule2('video_kankan', '', array($videourl));
			
		}elseif (strpos($videourl, '.letv.com') !=FALSE) {//失效
			$video = lev_module::ismodule2('video_letv', '', array($videourl));
			
		}else {
			$video['high'][0] = $videourl;
		}
		if (self::ckrealext($video['high'][0]) =='m3u8') $video['isfile'] = 4;
		$video['title'] = lev_base::levdiconv($video['title']);
		return $video;
	}

	public static function getvd($htmlurl, $v, $k, $ckdir = 0) {
		$vdir = self::$PLSTATIC.'videos/'.md5($htmlurl);
		if ($ckdir) dmkdir($vdir, 0777, FALSE);
		$vext = self::getext($v);
		if (!$vext) return '';
		$filename = $vdir.'/'.$k.'.'.$vext;
		return $filename;
	}
	
	public static function downvideo($htmlurl, $v, $k){
		$filename = self::getvd($htmlurl, $v, $k, 1);
		if (!is_file($filename) || !filesize($filename)) {
			$vsource = lev_module::ismodule2('x_curl', 'doCurl', array('url'=>$v, 'time'=>1060));
			if (!$vsource || stripos($vsource, '<html') !==FALSE) return '0';
			file_put_contents($filename, $vsource);
		}
	}

}













