<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp.inc.php 2 2012-01-03 13:05:56 sanree $
 */

//error_reporting(E_ALL);
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$pidentifier = 'help';
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/config.inc.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	cpmsg(lang('plugin/sanree_brand_help', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile=DISCUZ_ROOT.'./source/plugin/'.APPP.'/function/function_core.php';
@require_once($modfile);
foreach($_GET as $k => $v) {
	$_G['sr_'.$k] = daddslashes($v);
}
$act= $_G['sr_act'];
$actlist =array(
	'helpmanage'	=> array('list'),
);
$pdo = $navbar =array();
foreach ($actlist as $k => $v){
	$pdo=array_merge($pdo,$v);
}
if(!in_array($act, $pdo)) {
	$act = 'list';
}
$current=' class="current"';
$menustr='<ul class="tab1">';
foreach ($actlist as $k => $v){
	$navbar[$k]=in_array($act,$v) ? $current:'';
	$menustr.='<li'.$navbar[$k].'><a href="'.CURURL.'&act='.$v[0].'"><span>'.$langs[$k].'</span></a></li>';
}
$menustr.='</ul>';
$thisurl= CURURL_1.'&act='.$act;
$thisurl1= CURURL_2.'&act='.$act;
$gotourl = 'action=plugins&operation=config&identifier=sanree_brand_'.$pidentifier.'&pmod=admincp&act=';
$menustr=$rightlink.$menustr;
cpheader();
$actfile=sanree_libfile('admincp/'.APPP.'/'.$act, APPP);
if(!file_exists($actfile)) {
	cpmsg($langs['isbusiness'], CURURL_1.'&act=list', 'error');
}
$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];
}
$helpsort = trim($config['helpsort']);
$marr = explode("\r\n", $helpsort);
$helpcate = array();
foreach($marr as $row) {
	list($key , $val) = explode("=", $row);
	$helpcate[$key] = array($key, $val);
}
require_once $actfile;
?>