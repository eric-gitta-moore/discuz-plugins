<?php

/**
 * Www.ħȤ��.Vip 
 *
 * [ħȤ��!] (C)2014-2017 www.moqu8.com.  By www-ħȤ��-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once "class/iqiyi.class.php";

class video_iqiyi_module {

	public static function video_iqiyi($arr = array()) {
		$flvarr = Iqiyi::parse($arr[0], 'high');//print_r($flvarr);
		return $flvarr;
	}
	
}

