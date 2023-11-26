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

class _tanmu_module {

	public static function _tanmu() {
		global $_G;
		$_PLG = lev_base::$PL_G;
		$lev_lang = lev_base::$lang;
		$formhash = FORMHASH;
		$speak = trim(strip_tags(lev_base::levdiconv($_GET['speak'])));
		$videoid = intval($_GET['videoid']);
		if ($speak) {
			$speak = cutstr($speak, 20);
			$ckv = DB::fetch_first("SELECT * FROM ".DB::table('lev_ckplayer')." WHERE id='$videoid'");
			//if (empty($ckv)) exit($lev_lang['novd']);
			if ($ckv) {
				DB::update('lev_ckplayer', array('cmnum'=>$ckv['cmnum'] +1), array('id'=>$videoid));
			}
			$sql = "SELECT * FROM ".DB::table('lev_ckplayer_tanmu')." WHERE uid='{$_G['uid']}' OR formhash='{$formhash}' OR clientip='{$_G['clientip']}' ORDER BY id DESC";
			$rs = DB::fetch_first($sql);
			if (TIMESTAMP - $rs['addtime'] >$_PLG['wttime']) {
				$insert = array(
						'videoid'=>$videoid, 
						'descs'=>$speak, 
						'uid'=>$_G['uid'], 
						'bbsname'=>$_G['username'], 
						'formhash'=>$formhash, 
						'clientip'=>$_G['clientip'], 
						'addtime'=>TIMESTAMP
				);
				$inid = DB::insert('lev_ckplayer_tanmu', $insert, TRUE);
				echo $inid;
			}else {
				exit($lev_lang['wttime']);
			}
		}else {
			exit($lev_lang['nospeak']);
		}
	}

	public static function _data($videoid) {
		$videoid = intval($videoid);
		$rs = DB::fetch_all("SELECT * FROM ".DB::table('lev_ckplayer_tanmu')." WHERE videoid='$videoid' ORDER BY id DESC LIMIT 28");
		foreach ($rs as $r) {
			$data .= $r['descs'].'()'.$r['id'].'<>';
		}
		echo $data;
	}

	public static function autodeltanmu() {
		$_PLG = lev_base::$PL_G;
		if ($_PLG['autodeltanmu'] >0) {
			$time = TIMESTAMP - 3600 * 24 *$_PLG['autodeltanmu'];
			DB::query("DELETE FROM ".DB::table('lev_ckplayer_tanmu')." WHERE addtime<'$time'");
		}
	}

}







