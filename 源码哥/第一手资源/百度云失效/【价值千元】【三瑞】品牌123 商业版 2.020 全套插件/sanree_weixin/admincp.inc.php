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
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	cpmsg(lang('plugin/sanree_weixin', 'error_install'), $brandplugurl, 'error');
	
}
$pidentifier = 'sanree_weixin';
$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/config.inc.php';
@require_once($modfile);
$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_module.php';
@require_once($modfile);
foreach($_GET as $k => $v) {
	$_G['sr_'.$k] = daddslashes($v);
}
$act= $_G['sr_act'];
$config = array();
foreach($pluginvars as $key => $val) {

	$config[$key] = $val['value'];
	
}
$_G['cache']['plugin']['sanree_weixin'] = $config;
$firstcmd = '@';
$isrebate = intval($config['isrebate']);
$apifile= trim($config['apifile']);
if(empty($apifile)) {

	cpmsg(lang('plugin/sanree_weixin', 'error_apifile'), '', 'error');
	
}

$actlist =array(
    'base'	=> array('base'),
	'weixin'	=> array('list'),
);

$pdo = $navbar =array();
foreach ($actlist as $k => $v){
	$pdo=array_merge($pdo,$v);
}
if(!in_array($act, $pdo)) {
	$act = 'base';
}
$current=' class="current"';
$menustr='<ul class="tab1">';
foreach ($actlist as $k => $v){
	$navbar[$k]=in_array($act,$v) ? $current:'';
	$menustr.='<li'.$navbar[$k].'><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$v[0].'&identifier='.$pidentifier.'&pmod=admincp"><span>'.$langs[$k].'</span></a></li>';
}
$menustr.='</ul>';
$thisurl1 = $thisurl = "plugins&operation=config&identifier=".$pidentifier."&pmod=admincp&act=$act";
$gotourl = 'action=plugins&operation=config&identifier='.$pidentifier.'&pmod=admincp&act=';
$adminurl = ADMINSCRIPT.'?action=plugins&operation=config&identifier='.$pidentifier.'&pmod=admincp';
$menustr=$rightlink.$menustr;
cpheader();
$actfile=weixin_sanree_libfile('admincp/'.$plugin['identifier'].'/'.$act, $plugin['identifier']);
if(!file_exists($actfile)) {

	cpmsg($langs['isbusiness'], 'action=plugins&operation=config&identifier='.$pidentifier.'&pmod=admincp&act=list', 'error');
	
}
$weixincate = array();
$weixincate[] = array(1, weixin_lang('type1'));
require_once $actfile;
?>