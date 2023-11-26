<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand.inc.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
//error_reporting(E_ALL);
global $_G;
define('IN_SANREE', TRUE);
define('APPC', DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
define('C_CHARSET', (CHARSET=='utf-8') ? '_utf8' : '');
$plugin['identifier'] = 'sanree_brand';
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
$modfile = APPC.'index.php';
@require_once($modfile);
$branddefault = array();
$modfile = DISCUZ_ROOT.'./data/sysdata/cache_sanree_brand_config.php';
file_exists($modfile) && @require_once $modfile;
$defaultconfig = unserialize($branddefault);
foreach($_GET as $k => $v) {

	$_G['sr_'.$k] = daddslashes($v);
	
}
$modarray = array(
	'index', 'published', 'mybrand', 'upload', 'swfupload', 
	'item', 'detail', 'fastpost', 'map', 'userbar', 'brandno','msg', 'district', 
	'album', 'ajax', 'albumlist', 'albumshow', 'brandconfig', 'saveas',
	'image', 'delete', 'misc_swfupload', 'branch', 'searchword', 'weicode', 'assist',
	'apply_promotion', 'promotion', 'hint', 'home', 'showcode'
	);
$mod = isset($_G['sr_mod']) ? $_G['sr_mod'] : '';
$mod = !in_array($mod, $modarray) ? 'index' : $mod;
$weconfig = $_G['cache']['plugin']['sanree_we'];
$tel114config = $_G['cache']['plugin']['sanree_tel114'];
$tel114version = $_G['setting']['plugins']['version']['sanree_tel114'] * 1000;
$tel114_is_rewrite = $tel114config['is_rewrite'];
$discuz_version = $appVer;
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand'];
$config = $_G['cache']['plugin']['sanree_brand'];
$is_rewrite = intval($config['is_rewrite']);
$viewgroup = unserialize($config['viewgroup']);
$stopviewtip = trim($config['stopviewtip']);
$addgroup = unserialize($config['addgroup']);
$albumgroup = unserialize($config['albumgroup']);
$isalbum = intval($config['isalbum']);
$ischkdistrict = intval($config['ischkdistrict']);
$isshowordinary = intval($config['isshowordinary']);
$stopaddtip = $config['stopaddtip'];
$copyrightpass = $config['copyrightpass'];
$defaultzhishu = empty($config['defaultzhishu']) ? '99.9' : $config['defaultzhishu'];
$Recommendnum = intval($config['Recommendnum']);
$Recommendnum = max(1,$Recommendnum);
$maxishomepic = intval($config['maxishomepic']);
$maxishomepic = max(4,$maxishomepic);
$shownum = intval($config['shownum']);
$isopen = intval($config['isopen']);
$ischkpictype = intval($config['ischkpictype']);
$domain = trim($config['domain']);
$mapapi = trim($config['mapapi']);
$mapapi = empty($mapapi) ? 'baidu' : $mapapi;
$googlemappos = trim($config['googlemappos']);
$googlemappos = empty($googlemappos) ? '39.91293336712716,116.39724969863891' : $googlemappos;
$defaultmappos = $config['defaultmappos'];
$defaultmappos = empty($defaultmappos) ? '116.404,39.915' : $defaultmappos;
$defaultcity = trim($config['defaultcity']);
$defaultcity = empty($defaultcity) ? srlang('defaultcity') : $defaultcity;
$admintel = $config['admintel'];
$adminqq = $config['adminqq'];
$admintime = $config['admintime'];
$adimage = $config['adimage'];
$adlink = $config['adlink'];
$adminabouturl = $config['adminabouturl'];
$adminadurl = $config['adminadurl'];
$enddatetip = $config['enddatetip'];
$helloadimage = $config['helloadimage'];
$helloadlink = $config['helloadlink'];
$reurlmode = intval($config['reurlmode']);
$agreement = str_replace("\r\n",'<br />', $config['agreement']);
$shownum = max(1, $shownum);
$creditunit = intval($config['creditunit']);
$creditunitname = $_G['setting']['extcredits'][$creditunit]['title'];
$regprice = intval($config['regprice']);
$bindingforum = intval($config['bindingforum']);
$isindexlist = intval($config['isindexlist']);
$forumtitle = $config['forumtitle'];
$forumbody = $config['forumbody'];
$navtitle = $config['title'];
$sharecode = $config['sharecode'];
$isshowmap = intval($config['isshowmap']);
$issmallpic = intval($config['issmallpic']); 
$isalbumthumb = intval($config['isalbumthumb']); 
$albumshowperpage = intval($config['albumshowperpage'])<1 ? 16 : intval($config['albumshowperpage']);
$logowh = $config['logowh'];
$isselfdistrict = intval($config['isselfdistrict']);
$allowmsg = intval($config['allowmsg']);
$allowfastpost = intval($config['allowfastpost']);
$isslideload = intval($config['isslideload']);
$isshowweburl = intval($config['isshowweburl']);
$albumfilesize = intval($config['albumfilesize']);
$allowsyngroup = intval($config['allowsyngroup']);
$hellobigslide = intval($config['hellobigslide']); 
$ishello = intval($config['ishello']); 
$maintitle = $navtitle;
$metakeywords = $config['keywords'];
$metadescription = $config['description'];
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
$viewwebtip = trim($config['viewwebtip']);
$viewwebtip = empty($viewwebtip) ? 'view web' : $viewwebtip;
$ismultiple = intval($config['ismultiple']);
$allicq = array('qq', 'msn', 'wangwang', 'baiduhi', 'skype');
$icq = trim($config['icq']); 
$icq = !in_array($icq, $allicq) ? 'qq' : $icq;
$qqcode = trim($config['qqcode']); 
$msncode = trim($config['msncode']); 
$wangwangcode = trim($config['wangwangcode']); 
$baiduhicode = trim($config['baiduhicode']); 
$skypecode = trim($config['skypecode']);
$icqshow = $icq.'code'; 
$icqshow = $$icqshow;
$selectdiscount = $config['selectdiscount'];
$marr = explode("\r\n", $selectdiscount);
$frontpagestyle = trim($config['frontpagestyle']);
$config['selectdiscountshow'] = array();
foreach($marr as $row) {

	list($key , $val) = explode('=', $row);
	$config['selectdiscountshow'][$key] = $val;
	
}
$_G['isopendiy'] = intval($config['isopendiy']);
$_G['diytemplate'] = $template;
$defaultwxcodeimg = trim($config['defaultwxcodeimg']);

$popularsearchliststr = $config['popularsearchliststr'];
$popularsearcharray = explode("\r\n", $popularsearchliststr);
foreach($popularsearcharray as $key => $value){
	$searchurl = 'plugin.php?id=sanree_brand&keyword='.$value;
	$popularsearchlist[$key]['name'] = $value;
	$popularsearchlist[$key]['url'] = $searchurl;
}

if ($isopen!=1) {

	showmessage(srlang('noopen'));
	
}
if (!in_array($_G['group']['groupid'], $viewgroup)) {

	showmessage($stopviewtip);
	
} 
if ($bindingforum<1) {

	showmessage(srlang('nobindingforum'));
	
}
if (!$config['isnice'] && $_G['sr_mod'] == 'home') {

	showmessage(srlang('nocontrol'));

}
chkformtitle($bindingforum);
if ($creditunit<1) {

	showmessage(srlang('nocreditunit'));
	
}
if (!file_exists(sr_brand_TPL.'/'.$template.'/copyright.xml')) {

	$template= 'default';
	
}
$entrydir = DISCUZ_ROOT.'./source/plugin/sanree_brand/tpl/'.$template;
if(file_exists($entrydir.'/copyright.xml')) {

	 $importtxt = @implode('', file($entrydir.'/copyright.xml'));
	 
}	 
require_once libfile('class/xml');
$xmldata = xml2array($importtxt);	
if (!is_array($xmldata)) {

	showmessage(srlang('error_template'));
	
}
define('sr_brand_IMG', sr_brand_TPL.'/'.$template.'/images');
define('sr_brand_JS', sr_brand_TPL.'/'.$template.'/js');
define('SANREE_BRAND_TEMPLATE', sr_brand_TPL.'/'.$template);
$_G['template'] = $template;
$allurl = gethomeurl();
$sanreeurl = 'http://www.fx8.cc/';
srhooks();
if (($config['isbird'] || $ishello==1 || $config['isnice']) && $mod=='index') {
	$mod = 'hello';
}

if ($is_rewrite==1) {
	$_G['basefilename'] = $_G['basescript'] = trim($config['urlhomemode']);
} else {
	$_GET['id'] = $plugin['identifier'].':'.$plugin['identifier'];
}

$item_detail = array('item', 'detail');
if(in_array($mod, $item_detail)) {
	if ($_G['cache']['plugin']['sanree_brand']['isnice'] && $mod = 'detail') {
		$_G['item_detail'] = 'item';
	} else {
		$_G['item_detail'] = $mod;
	}
	$mod = 'item';

}

function exitscolumn($field, $table) {
	$query=DB::query('SHOW COLUMNS FROM '.DB::table($table));
	$columns=array();
	while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$columns[]=$row;
	}
	$arraycolumns=array();
	foreach($columns as $v) {
		$arraycolumns[]=$v['Field'];
	}
	return in_array($field,$arraycolumns) ? TRUE:FALSE;
}

require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>