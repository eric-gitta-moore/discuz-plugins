<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook.inc.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('CURMODE_SANREE_GUESTBOOK', 'guestbook');
$_G['pidentifier'] = $pidentifier = 'guestbook';
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('IN_SANREE', TRUE);
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$plugin['identifier'] = 'sanree_brand_'.CURMODE_SANREE_GUESTBOOK;
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	showmessage(lang('plugin/sanree_brand_guestbook', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
define('sr_brand_model_TPL', 'source/plugin/sanree_brand_'.CURMODE_SANREE_GUESTBOOK.'/tpl');
global $_G;
foreach($_GET as $k => $v) {

	$_G['sr_'.$k] = daddslashes($v);
	
}
$mod = $_G['sr_mod'];
$brand_config = $_G['cache']['plugin']['sanree_brand'];
$selectdiscount = $brand_config['selectdiscount'];
$marr = explode("\r\n", $selectdiscount);
$brand_config['selectdiscountshow'] = array();
$isshowordinary = intval($brand_config['isshowordinary']);
$ismultiple = intval($brand_config['ismultiple']);
$allicq = array('qq', 'msn', 'wangwang', 'baiduhi', 'skype');
$icq = trim($brand_config['icq']); 
$icq = !in_array($icq, $allicq) ? 'qq' : $icq;
$qqcode = trim($brand_config['qqcode']); 
$msncode = trim($brand_config['msncode']); 
$wangwangcode = trim($brand_config['wangwangcode']); 
$baiduhicode = trim($brand_config['baiduhicode']); 
$skypecode = trim($brand_config['skypecode']);
$icqshow = $icq.'code'; 
$icqshow = $$icqshow;

$albumshowperpage = intval($brand_config['selectdiscountshow'])<1 ? 15 : intval($brand_config['selectdiscountshow']);
foreach($marr as $row) {

	list($key , $val) = explode("=", $row);
	$brand_config['selectdiscountshow'][$key] = $val;
	
}
$config = $_G['cache']['plugin']['sanree_brand_'.CURMODE_SANREE_GUESTBOOK];
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand_guestbook'];
$is_rewrite = intval($config['is_rewrite']);
$sendtimeout = intval($config['sendtimeout']); 
$discuz_version = $appVer; 
$modarray = array('index', 'my'.CURMODE_SANREE_GUESTBOOK, 'userguestbook','checkcode');
$mod = !in_array($mod, $modarray) ? 'index' : $mod;
$copyrightpass = $brand_config['copyrightpass'];
$isopen = intval($config['isopen']);
$isshowcode = intval($config['isshowcode']);
$isopenbyclaim = intval($config['isopenbyclaim']);

$navtitle = $config['title'];
$maintitle = $navtitle;
$metakeywords = $config['keywords'];
$metadescription = $config['description'];
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
$allowgroup = unserialize($config['allowgroup']);

$groupid = $_G['group']['groupid'];
if (!in_array($groupid, $allowgroup)) {

	showmessage(guestbook_modlang('stopallowtip'));
	
}
$deletegroup = unserialize($config['deletegroup']);
$isdeleteuser = in_array($groupid, $deletegroup) ? true : false;
define('sr_brand_'.CURMODE_SANREE_GUESTBOOK.'_TPL', sr_brand_model_TPL."/".$template.'/');
if (!file_exists(sr_brand_model_TPL."/".$template."/copyright.xml")) {

	$template= "default";
	
}
$entrydir = DISCUZ_ROOT.'./source/plugin/sanree_brand_'.CURMODE_SANREE_GUESTBOOK.'/tpl/'.$template;
if(file_exists($entrydir."/copyright.xml")) {

	 $importtxt = @implode('', file($entrydir."/copyright.xml"));
	 
}	 
require_once libfile('class/xml');
$xmldata = xml2array($importtxt);	
if (!is_array($xmldata)) {

	showmessage(srlang('error_template'));
	
}
define('sr_brand_'.CURMODE_SANREE_GUESTBOOK.'_IMG', sr_brand_model_TPL."/".$template.'/images');
define('sr_brand_'.CURMODE_SANREE_GUESTBOOK.'_JS', sr_brand_model_TPL."/".$template.'/js');
$allurl = gethomeurl();
$sanreeurl = "http://www.fx8.cc/";
srhooks();
define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
define('sr_brand_IMG', sr_brand_TPL."/".$brand_config['template'].'/images');
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>