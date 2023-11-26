<?php

/**
 * Www.魔趣吧.Vip 
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

class x_preg_module {
	
	public static function x_preg($arr) {
		$pattern = trim($arr[0]);
		$ckstr   = trim($arr[1]);
		if (!$pattern || !$ckstr) return '-2001';
		if ($pattern ==$ckstr) return '1002';
		if (strpos($pattern, '*') ===FALSE) return '-2002';
		$pattern = self::unrepeat($pattern, '*');
		return self::preg($pattern, $ckstr);
	}
	public static function preg($pattern, $ckstr) {
		$_ckstr = $ckpat = '';
		if ($pattern == $ckstr) return '1000';
		if ($pattern =='*') return '1001';
		if (!$pattern) return '-2004';
		if (substr($pattern, 0, 1) =='*') {
			$pattern = substr($pattern, 1);
			$exp = explode('*', $pattern);
			$one = explode($exp[0], $ckstr);
			$num = count($one);
			if ($num ==1) return '-2003';
			//if (count($exp) ==1) return '1001';
			unset($one[0]);
			foreach ($one as $k => $v) {
				$_ckstr.= ($k ==($num -1)) ? $v : $v.$exp[0];
			}
			unset($exp[0]);
			foreach ($exp as $k => $v) {
				$ckpat.= '*'.$v;
			}
			//echo $_ckstr.'==='.$ckpat.'<br>';
			return self::preg($ckpat, $_ckstr);
		}else {
			$exp = explode('*', $pattern);//print_r($exp);
			$one = explode($exp[0], $ckstr);//print_r($one);
			if ($one[0] !=='') return '-2005';
			$num = count($one);
			unset($one[0]);
			foreach ($one as $k => $v) {
				$_ckstr.= ($k ==($num -1)) ? $v : $v.$exp[0];
			}
			unset($exp[0]);
			foreach ($exp as $k => $v) {
				$ckpat.= '*'.$v;
			}
			//echo $_ckstr.'==='.$ckpat.'<br>';
			return self::preg($ckpat, $_ckstr);
		}
	}
	public static function unrepeat($str, $un) {//指定$un值去重复
		$str = str_replace(' ', '', $str);
		if (strpos($str, $un.$un) !==FALSE) {
			$str = str_replace($un.$un, $un, $str);
			return self::unrepeat($str, $un);
		}
		return $str;
	}
	
}
