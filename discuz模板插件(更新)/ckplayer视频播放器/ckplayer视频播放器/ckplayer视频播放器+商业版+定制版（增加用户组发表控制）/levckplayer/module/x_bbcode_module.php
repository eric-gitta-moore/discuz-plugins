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

class x_bbcode_module {

	public static function x_bbcode($arr = array()) {
		$message = $arr[0];
		$bbcode1 = $arr[1];
		if (!$bbcode1 || !$message) return '';
		
		$bbcode2 = str_replace('[', '[/', $arr[1]);
		if (strpos($message, $bbcode1) !==FALSE) {
			$arr = explode($bbcode1, $message);
			foreach ($arr as $r) {
				if (strpos($r, $bbcode2) ===FALSE) continue;
				$one = explode($bbcode2, $r);
				$res[] = trim($one[0]);
			}
		}
		if ($bbcode1 =='[img]') {
			if (strpos($message, '[img') !==FALSE) {
				$imgs = explode('[/img]', $message);
				foreach ($imgs as $r) {
					$one = strstr($r, '[img');
					$res[] = preg_replace(array("/\[img=(\d{1,4})[x|\,](\d{1,4})\]/ies"), '', $one);
				}
			}
		}
		return $res;
	}

	public static function x_forumimgurl($arr = array()) {
		$message = $arr[0];
		$aid     = $arr[1];
		$w       = $arr[2];
		$h       = $arr[3];
		$type    = $arr[4];
		
		if ($aid) $imgurl = getforumimg($aid, 0, $w, $h, $type);
		if ($imgurl) return $imgurl;
		$imgarr = self::x_bbcode(array($message, '[img]'));
		if ($imgarr) return $imgarr[0];
	}
	
}







