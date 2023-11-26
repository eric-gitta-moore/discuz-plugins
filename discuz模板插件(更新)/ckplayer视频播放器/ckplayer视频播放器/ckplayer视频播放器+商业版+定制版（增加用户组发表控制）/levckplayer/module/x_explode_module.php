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

class x_explode_module {

	public static function init($arr = array()) {
		$fg = $arr[1] ? $arr[1] : '=';
		$br = explode("\n", trim($arr[0]));
		$rs = array();
		foreach ($br as $r) {
			$r = trim($r);
			if ($r) {
				$one = explode($fg, $r);
				//$rs[trim($one[0])] = $one;
				$k = trim($one[0]);
				foreach ($one as $v) $rs[$k][] = trim($v);
			}
		}
		return $rs;
	}
	
}







