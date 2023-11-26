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

class _vd_module {

	public static function _vd() {
		global $_G;
		$lang = lev_base::$lang;
		if ($_G['adminid'] !=1) exit($lang['noact']);
		$srhkey = trim(stripsearchkey(strip_tags($_GET['srhkey'])));
		if ($srhkey ==$lang['srhkey1']) $srhkey = '';
		$rs = DB::fetch_all("SELECT * FROM ".DB::table('lev_ckplayer')." WHERE `title` LIKE '%$srhkey%' OR videourl LIKE '%$srhkey%' ORDER BY uptime DESC LIMIT 10");
		foreach ($rs as $r) {
			$s = unserialize($r['settings']);
			$html .= "<tr><td>vdid:{$r['id']}</td>";
			$html .="<td><a title='{$lang[ctovd]}' style='color:blue' href='javascript:;' onclick='setckplayer({$r['id']}, \"{$s['webw']}\", this)'>{$r['title']}</a></td></tr>";
		}
		$html = '<table width=400>'.$html.'</table>';
		echo $html;
		
	}

	public static function _delvd($id) {
		global $_G;
		$lev_lang = lev_base::$lang;
		if ($_G['adminid'] !=1) exit($lev_lang['noact']);
		$id = intval($id);
		$ck = DB::fetch_first("SELECT * FROM ".DB::table('lev_ckplayer')." WHERE id='$id'");
		if ($ck) {
			$vdfile = DISCUZ_ROOT.str_ireplace($_G['siteurl'], '', $ck['videourl']);
			$imgsrc = DISCUZ_ROOT.str_ireplace($_G['siteurl'], '', $ck['imgsrc']);
			if (file_exists($vdfile) && strpos($vdfile, 'levckplayer/statics/upload/')) {
				@unlink($vdfile);
			}
			if (file_exists($imgsrc) && strpos($imgsrc, 'levckplayer/statics/upload/')) {
				@unlink($imgsrc);
			}
			DB::query("DELETE FROM ".DB::table('lev_ckplayer')." WHERE id='$id'");
		}
		exit("1");
	}
	
}







