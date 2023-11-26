<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_core.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function weixin_sanree_libfile($libname, $folder = '') {
	$libpath = DISCUZ_ROOT.'/source/plugin/'.$folder;
	if(strstr($libname, '/')) {
		list($pre, $path, $name) = explode('/', $libname);
		return realpath("{$libpath}/{$pre}/$path/{$path}_{$name}.php");
	} else {
		return realpath("{$libpath}/{$libname}.php");
	}
}

function weixin_lang($word) {
	return lang('plugin/sanree_weixin', $word);
}
//From:www_YMG6_COM
?>