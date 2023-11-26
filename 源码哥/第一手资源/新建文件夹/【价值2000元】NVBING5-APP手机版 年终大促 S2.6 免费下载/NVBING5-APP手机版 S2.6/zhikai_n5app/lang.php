<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$n5app = init_n5app();

function init_n5app(){
	global $_G;
	loadcache('plugin');
	$n5app = $_G['cache']['plugin']['zhikai_n5appgl'];
	$n5app['lang'] = dzlang();
	return $n5app;
}//Fr om www.xhkj 5.com

function dzlang(){
	global $_G;
	$addonname = 'zhikai_n5appgl';
	$dlang = array();
	for($i=1;$i<1000;$i++){
		$key = 'lang'.sprintf("%03d", $i);
		$dlang[$key] = lang('plugin/'.$addonname, $key);
		$tmp = explode("=",$dlang[$key]);
		if(count($tmp) == 2){
			$dlang[$tmp[0]] = $tmp[1];
		}
	}//Fr om www.xhkj5.com
	return $dlang;
}


?>