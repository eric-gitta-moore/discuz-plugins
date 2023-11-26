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

class plugin_levckplayer {

	public function __construct() {
		self::_init();
	}
	
	public static function view_article_top_output() {
		if (!self::ckforum()) return '';
		global $content;
		$levckplayers = self::x_bbcode(array($content['content'], '[levckplayer]'));
		if ($levckplayers) {
			//$_PLG = self::$PL_G;
			//$PLSTATIC = self::$PLSTATIC;
			foreach ($levckplayers as $v) {  $i = random(6);
				$mobile = checkmobile() ? '&mobile=2' : '';
				$videoifr = '<iframe id="levckplayerifr_'.$i.'" width="100%" frameborder="0" marginheight="0" src="plugin.php?id=levckplayer'.$mobile.'&ifr='.$i.'&'.$v.'&tid=-'.$_GET['aid'].'" scrolling="no"></iframe>';
				$content['content'] = str_ireplace('[levckplayer]'.$v.'[/levckplayer]', $videoifr, $content['content']);
			}
		}
		$js = self::loadjs();
		return $js;
	}
	
	public static function portalcp_extend() {
		if (!self::ckforum()) return '';
		$lev_lang = self::$lang;
		$js.= self::icon_btn(700);
		$js = "<div class='sadd z'><dl><dt>{$lev_lang['ckplayer']}</dt><dd>$js</dd></dl><script>function insertText(str) {edit_insert(str);}</script></div>";
		return $js;
	}
	
	public static function post_editorctrl_left() {
		return self::icon_btn();
	}
	public static function icon_btn($webw = 760) {
		if (!self::ckforum()) return '';
		$PLSTATIC = self::$PLSTATIC;
		$lev_lang = self::$lang;
		$js = self::loadjs();
		include template('levckplayer:hook');
		$js.= $return;

		return $js;
	}
	
	public static function viewthread_top() {
		if (!self::ckforum()) return '';
		return self::loadjs();
	}
	
	public static function discuzcode($value) {
		if (!self::ckforum()) return '';
		global $_G;
		$levckplayers = self::x_bbcode(array($_G['discuzcodemessage'], '[levckplayer]'));
		if ($levckplayers) {
			//$_PLG = self::$PL_G;
			//$PLSTATIC = self::$PLSTATIC;
			foreach ($levckplayers as $v) { $i = random(6);
				$videoifr = '<iframe id="levckplayerifr_'.$i.'" width="100%" frameborder="0" marginheight="0" src="plugin.php?id=levckplayer&ifr='.$i.'&'.$v.'&tid='.$_GET['tid'].'" scrolling="no"></iframe>';
				$_G['discuzcodemessage'] = str_ireplace('[levckplayer]'.$v.'[/levckplayer]', $videoifr, $_G['discuzcodemessage']);
			}
		}
	}
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
		return $res;
	}
	public static function ckforum() {
		global $_G;//print_r($_G['thread']);
		$ckforum = unserialize(self::$PL_G['ckplayerfid']);
		$fid = $_GET['fid'] ? $_GET['fid'] : $_G['thread']['fid'];
		if ($ckforum[0] && !in_array($fid, $ckforum)) return FALSE;
		return true;
	}
	
	
	public static $PL_G, $_G, $PLNAME, $PLSTATIC, $PLURL, $lang = array(), $table, $navtitle, $uploadurl, $remote, $talk;
	public static $lm, $lm2, $loadjs;
	
	public static function _init() {

		global $_G;
		self::$_G     = $_G;
		self::$PLNAME = 'levckplayer';
		self::$PL_G   = self::$_G['cache']['plugin'][self::$PLNAME];//print_r($PL_G);

		self::$PLSTATIC = 'source/plugin/'.self::$PLNAME.'/statics/';
		self::$PLURL    = 'plugin.php?id='.self::$PLNAME;
		self::$uploadurl= self::$PLSTATIC.'upload/common/';
		self::$remote   = 'plugin.php?id='.self::$PLNAME.':l&fh='.FORMHASH.'&m=';
		self::$lm       = self::$remote.'_m.';
		self::$lm2      = self::$remote.'__m.';
		self::$loadjs   = self::$remote.'__m.x_loadjs.__init';
		self::$lang     = self::levlang();
	}

	//return $instr = 1,2,3,4,5,6
	public static function sqlinstr($array, $key = '') {
		if (!is_array($array)) {
			$array = (array)unserialize($array);
			$key = '';
		}
		$instr = '';
		if ($key) {
			foreach ($array as $v) {
				if (is_numeric($v[$key])) $instr .= $v[$key].',';
			}
		}else {
			foreach ($array as $v) {
				if (is_numeric($v)) $instr .= $v.',';
			}
		}
		if ($instr) $instr = substr($instr, 0, -1);
		return $instr;
	}
	
	public static function levlang($string = '', $key = 0) {
		$sets  = $string ? $string : (!$key ? self::$PL_G['levlang'] : '');
		$lang  = array();
		if ($sets) {
			$array = explode("\n", $sets);
			foreach ($array as $r) {
				$thisr  = explode('->', trim($r), 2);
				$lang[trim($thisr[0])] = trim($thisr[1]);
			}
			if (!$key) {
				$lang['extscore'] = self::$_G['setting']['extcredits'][self::$PL_G['scoretype']]['title'];
				$flang = lang('plugin/levckplayer');
				if (is_array($flang)) $lang = $lang + $flang;
			}
		}
		return $lang;
	}

	public static function _levdiconv($string, $in_charset = 'utf-8', $out_charset = CHARSET) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = diconv($val, $in_charset, $out_charset);
			}
		} else {
			$string = diconv($string, $in_charset, $out_charset);
		}
		return $string;
	}
	
	public static function _isopen($key = 'close') {
		$isopen = unserialize(self::$PL_G['isopen']);
		if (is_array($isopen) && in_array($key, $isopen)) return TRUE;
		return FALSE;
	}
	
	public static function loadjs() {
		$js = '<script language="javascript" type="text/javascript" src="'.self::$loadjs.'"></script>';
		return $js;
	}
	
	
}

class plugin_levckplayer_forum extends plugin_levckplayer {}
class plugin_levckplayer_portal extends plugin_levckplayer {}












