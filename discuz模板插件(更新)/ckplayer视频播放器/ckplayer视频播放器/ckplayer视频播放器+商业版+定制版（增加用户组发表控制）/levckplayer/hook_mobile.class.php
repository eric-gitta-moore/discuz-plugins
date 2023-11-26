<?php

/**
 * www.moqu8.com [moqu8.com! ]
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

require_once 'hook.class.php';

new plugin_levckplayer_forum();

class mobileplugin_levckplayer {

	/*public static function common() {
		if ($_GET['mod'] =='view' && $_GET['aid']) {
			return plugin_levckplayer_forum::view_article_top_output();
		}
	}
	*/
	public static function global_header_mobile() {
		if ($_GET['mod'] =='view' && $_GET['aid']) {
			return plugin_levckplayer_forum::view_article_top_output();
		}
	}
	
	public static function discuzcode($value) {
		plugin_levckplayer_forum::discuzcode($value);
	}
	

}

class mobileplugin_levckplayer_forum extends mobileplugin_levckplayer {}







