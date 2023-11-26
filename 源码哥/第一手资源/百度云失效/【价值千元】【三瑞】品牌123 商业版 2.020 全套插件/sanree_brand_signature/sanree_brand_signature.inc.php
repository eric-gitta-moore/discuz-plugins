<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_signature.inc.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('CURMODE_SANREE_SIGNATURE', 'signature');
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('IN_SANREE', TRUE);
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$plugin['identifier'] = 'sanree_brand_'.CURMODE_SANREE_SIGNATURE;
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	showmessage(lang('plugin/sanree_brand_signature', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
define('sr_brand_model_TPL', 'source/plugin/sanree_brand_'.CURMODE_SANREE_SIGNATURE.'/tpl');
global $_G;
foreach($_GET as $k => $v) {

	$_G['sr_'.$k] = daddslashes($v);
	
}
$mod = $_G['sr_mod'];
$brand_config = $_G['cache']['plugin']['sanree_brand'];
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
$config = $_G['cache']['plugin']['sanree_brand_'.CURMODE_SANREE_SIGNATURE];
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand_signature'];
$discuz_version = $appVer; 
$modarray = array('my'.CURMODE_SANREE_SIGNATURE);
$mod = !in_array($mod, $modarray) ? 'my'.CURMODE_SANREE_SIGNATURE : $mod;
$copyrightpass = $brand_config['copyrightpass'];
$isopen = intval($config['isopen']);
$navtitle = signature_modlang('mysignature');
$maintitle = $navtitle;
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
$allowgroup = unserialize($config['allowgroup']);
$groupid = $_G['group']['groupid'];
if (!in_array($groupid, $allowgroup)) {

	showmessage(signature_modlang('stopallowtip'));
	
}
if (!file_exists(sr_brand_TPL."/".$template."/copyright.xml")) {

	$template= "default";
	
}
$entrydir = DISCUZ_ROOT.'./source/plugin/sanree_brand_'.CURMODE_SANREE_SIGNATURE.'/tpl/'.$template;
if(file_exists($entrydir."/copyright.xml")) {

	 $importtxt = @implode('', file($entrydir."/copyright.xml"));
	 
}	 
define('sr_brand_'.CURMODE_SANREE_SIGNATURE.'_TPL', sr_brand_model_TPL."/".$template.'/');
require_once libfile('class/xml');
$xmldata = xml2array($importtxt);	
if (!is_array($xmldata)) {

	showmessage(srlang('error_template'));
	
}
define('sr_brand_'.CURMODE_SANREE_SIGNATURE.'_IMG', sr_brand_model_TPL."/".$template.'/images');
define('sr_brand_'.CURMODE_SANREE_SIGNATURE.'_JS', sr_brand_model_TPL."/".$template.'/js');
$allurl = gethomeurl();
$sanreeurl = "http://www.fx8.cc/";
srhooks();
define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
define('sr_brand_IMG', sr_brand_TPL."/".$brand_config['template'].'/images');
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>