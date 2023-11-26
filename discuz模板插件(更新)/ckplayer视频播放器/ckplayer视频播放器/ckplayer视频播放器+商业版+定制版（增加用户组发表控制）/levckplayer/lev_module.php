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

require_once 'lev_base.php';

class lev_module extends lev_base {
	
	public static function _m($class ='', $method = '', $param = '') {
		if (!$method) $method = $class;
		if ($method[0] !='_') exit(self::$lang['noact']);
		self::ismodule2($class, $method, $param);
	}
	
	public static function __m($class ='', $method = '', $param = '') {
		if (!$method) $method = $class;
		if ($method[1] !='_') exit(self::$lang['noact']);
		self::ismodule2($class, $method, $param);
	}
	
	public static function ismodule2($class = '', $method = '', $param = array()) {
		
		if (!$class) return '';
		
		$ismodule = parent::levloadclass($class.'_module', 'module');
		if ($ismodule) {
			if (!$method) $method = $class;
			if (method_exists($ismodule, $method)) {
				return $ismodule->$method($param);
			}
		}
		return FALSE;
	}
	
}










