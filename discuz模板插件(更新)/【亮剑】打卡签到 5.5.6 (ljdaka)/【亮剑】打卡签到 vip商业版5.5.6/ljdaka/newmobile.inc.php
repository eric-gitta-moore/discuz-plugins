<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : 魔趣吧：www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : 魔趣吧(QQ：10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              魔趣吧出品 必属精品。
 *              魔趣吧源码论坛 全网首发 http://www.moqu8.com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$config = $_G['cache']['plugin']['ljdaka'];
if(empty($_G['uid'])){
	echo '&#35831;&#20808;&#30331;&#24405;&#65281;';
	exit;
}else if(!in_array($_G['groupid'], unserialize($config['lj_groups']))) {
	echo $config['tsy'];
	exit;
}else{
	$_GET['action'] = 'msg';
	$_GET['cont1'] = lang('plugin/aljwsq', 'com51');
	$_GET['formhash'] = formhash();
	$_GET['cont2'] = $config['tips'];
}
include 'source/plugin/ljdaka/daka.inc.php';


?>