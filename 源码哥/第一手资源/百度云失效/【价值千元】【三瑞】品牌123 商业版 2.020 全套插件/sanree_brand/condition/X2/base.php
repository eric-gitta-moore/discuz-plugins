<?php
/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: X2.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$modfile=APPCLASS.'discuz_database.php';
@require_once($modfile);	
$modfile = APPCLASS.'discuz_base.php';
require_once($modfile);
$modfile = APPCLASS.'discuz_table.php';
require_once($modfile);
	 
class C extends discuz_core {
	private static $_tables;
	private static $_imports;
	private static $_app;
	private static $_memory;
	
	public static function t($name) {
		$pluginid = null;
		if($name[0] === '#') {
			list(, $pluginid, $name) = explode('#', $name);
		}
		$classname = 'table_'.$name;
		if(!isset(self::$_tables[$classname])) {
			if(!class_exists($classname, false)) {
				self::import(($pluginid ? 'plugin/'.$pluginid : 'class').'/table/'.$name);
			}
			self::$_tables[$classname] = new $classname;
		}
		return self::$_tables[$classname];
	}
	
	public static function import($name, $folder = '', $force = true) {
		$key = $folder.$name;
		if(!isset(self::$_imports[$key])) {
			$path = DISCUZ_ROOT.'/source/'.$folder;
			if(strpos($name, '/') !== false) {
				$pre = basename(dirname($name));
				$filename = dirname($name).'/'.$pre.'_'.basename($name).'.php';
			} else {
				$filename = $name.'.php';
			}

			if(is_file($path.'/'.$filename)) {
				self::$_imports[$key] = true;
				return include $path.'/'.$filename;
			} elseif(!$force) {
				return false;
			} else {
				throw new Exception('Oops! System file lost: '.$filename);
			}
		}
		return true;
	}
		
}
function dintval($int, $allowarray = false) {
	$ret = intval($int);
	if($int == $ret || !$allowarray && is_array($int)) return $ret;
	if($allowarray && is_array($int)) {
		foreach($int as &$v) {
			$v = dintval($v, true);
		}
		return $int;
	} elseif($int <= 0xffffffff) {
		$l = strlen($int);
		$m = substr($int, 0, 1) == '-' ? 1 : 0;
		if(($l - $m) === strspn($int,'0987654321', $m)) {
			return $int;
		}
	}
	return $ret;
}

class XDB extends discuz_database{
	public static function init() {
		global $discuz;
		parent::$db = $discuz->db;
	}
}
XDB::init();	
?>