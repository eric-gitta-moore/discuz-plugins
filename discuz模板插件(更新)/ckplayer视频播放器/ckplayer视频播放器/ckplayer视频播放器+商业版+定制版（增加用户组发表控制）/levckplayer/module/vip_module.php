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

class vip_module {


	public static function vip() {
		global $_G;
		
		$isvip = lev_base::$PL_G['isvip'];
		$vipyear = lev_base::$PL_G['vipyear'];
		if ($isvip <1 && !$vipyear) return '1001';
		if (!is_file(DISCUZ_ROOT.'source/plugin/levvip/lev_base.php')) return '1002';

		$time = TIMESTAMP;
		$sql = "SELECT * FROM ".DB::table('lev_vip_user')." WHERE uid='{$_G['uid']}' AND viptime>$time";
		$rs  = DB::fetch_first($sql);
		if ($vipyear && $rs['vipyear'] >TIMESTAMP) return '1003';
		if ($isvip && $isvip <=$rs['viplv']) return '1004';
		showmessage(lev_base::$lang['viplang']);
		
	}

	public static function myvipinfo($uid) {
		if (!is_file(DISCUZ_ROOT.'source/plugin/levvip/lev_base.php')) return FALSE;
		if ($uid <1) return FALSE;
		$time = TIMESTAMP;
		$sql = "SELECT * FROM ".DB::table('lev_vip_user')." WHERE uid='{$uid}' AND viptime>$time";
		$rs  = DB::fetch_first($sql);
		return $rs;
	}

}







