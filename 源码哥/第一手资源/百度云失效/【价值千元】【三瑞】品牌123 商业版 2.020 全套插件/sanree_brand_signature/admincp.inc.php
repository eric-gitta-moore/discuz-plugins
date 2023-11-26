<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp.inc.php 2 2012-01-03 13:05:56 sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('CURMODE_SANREE_SIGNATURE', 'signature');
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/config.inc.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	cpmsg(lang('plugin/sanree_brand_signature', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
foreach($_GET as $k => $v) {
	$_G['sr_'.$k] = daddslashes($v);
}
$act= $_G['sr_act'];
$config = array();
foreach($pluginvars as $key => $val) {

	$config[$key] = $val['value'];
	
}
$brand_config = array();
$brandplugin = C::t('#sanree_brand#common_plugin')->fetch_by_identifier('sanree_brand');
if(!$brandplugin) {
	cpmsg(srlang('plugin_not_found'), '', 'error');
} else {
	$sanree_brand_pluginid = $brandplugin['pluginid'];
}
if($brandplugin[version]<1.420) {
	cpmsg(srlang('plugin_error_version'), '', 'error');
}
foreach(C::t('#sanree_brand#common_pluginvar')->fetch_all_by_pluginid($sanree_brand_pluginid) as $var) {
	if(strexists($var['type'], '_')) {
		continue;
	}
	$brand_config[$var['variable']] = $var['value'];
}

$actlist =array(
	CURMODE_SANREE_SIGNATURE	=> array(CURMODE_SANREE_SIGNATURE),
);
$pdo = $navbar =array();
foreach ($actlist as $k => $v){
	$pdo=array_merge($pdo,$v);
}
if(!in_array($act, $pdo)) {
	$act = CURMODE_SANREE_SIGNATURE;
}
$current=' class="current"';
$menustr='<ul class="tab1">';
foreach ($actlist as $k => $v){
	$navbar[$k]=in_array($act,$v) ? $current:'';
	$menustr.='<li'.$navbar[$k].'><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$v[0].'&identifier=sanree_brand_'.CURMODE_SANREE_SIGNATURE.'&pmod=admincp"><span>'.$langs[$k].'</span></a></li>';
}
$menustr.='</ul>';
$thisurl = "plugins&operation=config&identifier=sanree_brand_".CURMODE_SANREE_SIGNATURE."&pmod=admincp&act=$act";
$gotourl = 'action=plugins&operation=config&identifier=sanree_brand_'.CURMODE_SANREE_SIGNATURE.'&pmod=admincp&act=';
$adminurl = ADMINSCRIPT.'?action=plugins&operation=config&identifier=sanree_brand_'.CURMODE_SANREE_SIGNATURE.'&pmod=admincp';
$menustr=$rightlink.$menustr;
cpheader();

$actfile=sanree_libfile('admincp/'.$plugin['identifier'].'/'.$act, $plugin['identifier']);
if(!file_exists($actfile)) {

	cpmsg($langs['isbusiness'], 'action=plugins&operation=config&identifier=sanree_brand_'.CURMODE_SANREE_SIGNATURE.'&pmod=admincp&act=list', 'error');
	
}
require_once $actfile;
?>