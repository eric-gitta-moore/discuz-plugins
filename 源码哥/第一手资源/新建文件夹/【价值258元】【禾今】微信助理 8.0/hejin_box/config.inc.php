<?php
/*
 * CopyRight  : [fx8.cc!] (C)2014-2016
 * Document   : 源码哥：www.fx8.cc，www.ymg6.com
 * Created on : 2016-08-25,11:30:56
 * Author     : 源码哥(QQ：2575163778) wWw.fx8.cc $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              源码哥出品 必属精品。
 *              源码哥源码论坛 全网首发 http://www.fx8.cc；
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//插件目录常量
define('HEJIN_PATH', $_G['siteurl'].'source/plugin/hejin_box/');
define('HEJIN_ROOT', dirname(__FILE__));
define('HEJIN_URL', $_G['siteurl'].'plugin.php?id=hejin_box');
define('SITE_URL', $_G['siteurl']);
$SELF = $_SERVER["PHP_SELF"];
$plugindata = $_G['cache']['plugin']['hejin_box'];
$formhash = $_G['formhash'];

if($_G['charset']=='gbk'){
	$charset = 'gb2312';
}
elseif($_G['charset']=='utf-8'){
	$charset = 'UTF-8';
}
elseif($_G['charset']=='big5'){
	$charset = 'big5';
}

	$listidarray = array(
		7=>lang('plugin/hejin_box', 'listida'),
		11=>lang('plugin/hejin_box', 'listidb'),
		10=>lang('plugin/hejin_box', 'listidc'),
		8=>lang('plugin/hejin_box', 'listidd'),
		9=>lang('plugin/hejin_box', 'listide'),
		13=>lang('plugin/hejin_box', 'listidf'),
		2=>lang('plugin/hejin_box', 'listidg'),
		3=>lang('plugin/hejin_box', 'listidh'),
	);
	$showidarray = array(
		6=>lang('plugin/hejin_box', 'showida'),
		7=>lang('plugin/hejin_box', 'showidb'),
		8=>lang('plugin/hejin_box', 'showidc'),
		9=>lang('plugin/hejin_box', 'showidd'),
		10=>lang('plugin/hejin_box', 'showide'),
		11=>lang('plugin/hejin_box', 'showidf'),
		12=>lang('plugin/hejin_box', 'showidg'),
		13=>lang('plugin/hejin_box', 'showidh'),
		14=>lang('plugin/hejin_box', 'showidi'),
		1=>lang('plugin/hejin_box', 'showidj'),
	
	);


?>