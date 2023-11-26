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

class x_loadjs_module {

	public static function __init() {
		$PLSTATIC = lev_base::$PLSTATIC;
		$js = <<<EOF
		
if (typeof(load_dialog41) == 'undefined') {
	var load_dialog41 = true;
	document.write(unescape("%3Clink  href='{$PLSTATIC}dialog417/skins/default.css?4.1.7' type='text/css'' rel='stylesheet'%3E"));
	document.write(unescape("%3Cscript src='{$PLSTATIC}dialog417/dialog.js?skin=default' type='text/javascript'%3E%3C/script%3E"));
	document.write(unescape("%3Cscript src='{$PLSTATIC}dialog417/plugins/iframeTools.js' type='text/javascript'%3E%3C/script%3E"));
}

if (typeof(jQuery) == 'undefined') {
	document.write(unescape("%3Cscript src='{$PLSTATIC}jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
	document.write(unescape("%3Cscript src='{$PLSTATIC}jquery.init.js' type='text/javascript'%3E%3C/script%3E"));
}
		
EOF;
		echo $js;
		exit();
	}
	
}







