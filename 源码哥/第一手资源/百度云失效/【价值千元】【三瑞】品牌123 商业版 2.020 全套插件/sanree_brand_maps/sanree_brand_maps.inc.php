<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_maps.inc.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$_G['pidentifier'] = $pidentifier = 'maps';
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('IN_SANREE', TRUE);
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$plugin['identifier'] = 'sanree_brand_'.$pidentifier;
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	showmessage(lang('plugin/sanree_brand_maps', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
define('sr_brand_model_TPL', 'source/plugin/sanree_brand_'.$pidentifier.'/tpl');
global $_G;
foreach($_GET as $k => $v) {

	$_G['sr_'.$k] = daddslashes($v);
	
}
$mod = $_G['sr_mod'];
$brand_config = $_G['cache']['plugin']['sanree_brand'];
$mapapi = trim($brand_config['mapapi']);
$googlemappos = trim($brand_config['googlemappos']); 
$defaultmappos = trim($brand_config['defaultmappos']);
$defaultcity = trim($brand_config['defaultcity']); 
if ($mapapi=='google') {
	$defaultmappos = $googlemappos;
}
$config = $_G['cache']['plugin']['sanree_brand_'.$pidentifier];
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand_'.$pidentifier];
$is_rewrite = intval($config['is_rewrite']);
$mapshowtxt = trim($config['mapshowtxt']);
$mapshowtxt = str_replace(array("\r\n","'","\\\""),'', $mapshowtxt);
$discuz_version = $appVer; 
$modarray = array('index');
$mod = !in_array($mod, $modarray) ? 'index' : $mod;
$copyrightpass = $brand_config['copyrightpass'];
$isopen = intval($config['isopen']);
if ($isopen!=1) {

	showmessage(srlang('noopen'));
	
}
$shownum = intval($config['shownum']);
$shownum = max(1,$shownum);
$navtitle = $config['title'];
$maintitle = $navtitle;
$metakeywords = $config['keywords'];
$metadescription = $config['description'];
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
$allowgroup = unserialize($config['allowgroup']);
$groupid = $_G['group']['groupid'];
if (!in_array($groupid, $allowgroup)) {

	showmessage(maps_modlang('stopallowtip'));
	
}
if (!file_exists(sr_brand_model_TPL."/".$template."/copyright.xml")) {

	$template= "default";
	
}
$entrydir = DISCUZ_ROOT.'./source/plugin/sanree_brand_'.$pidentifier.'/tpl/'.$template;
if(file_exists($entrydir."/copyright.xml")) {

	 $importtxt = @implode('', file($entrydir."/copyright.xml"));
	 
}	 
define('sr_brand_'.$pidentifier.'_TPL', sr_brand_model_TPL."/".$template.'/');
require_once libfile('class/xml');
$xmldata = xml2array($importtxt);	
if (!is_array($xmldata)) {

	showmessage(srlang('error_template'));
	
}
define('sr_brand_'.$pidentifier.'_IMG', sr_brand_model_TPL."/".$template.'/images');
define('sr_brand_'.$pidentifier.'_JS', sr_brand_model_TPL."/".$template.'/js');
$allurl = gethomeurl();
$modelurl = maps_getmodeurl();
$sanreeurl = "http://www.fx8.cc/";
srhooks();
define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
define('sr_brand_IMG', sr_brand_TPL."/".$brand_config['template'].'/images');
if ($is_rewrite==1) {
	$_G['basefilename'] = $_G['basescript'] = trim($config['mapindex']);
} else {
	$_GET['id'] = $plugin['identifier'];
}
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>