<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domain.inc.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('CURMODE_SANREE_DOMAIN', 'domain');
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('IN_SANREE', TRUE);
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$plugin['identifier'] = 'sanree_brand_'.CURMODE_SANREE_DOMAIN;
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	showmessage(lang('plugin/sanree_brand_domain', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
define('sr_brand_model_TPL', 'source/plugin/sanree_brand_'.CURMODE_SANREE_DOMAIN.'/tpl');
global $_G;
foreach($_GET as $k => $v) {

	$_G['sr_'.$k] = daddslashes($v);
	
}
$mod = $_G['sr_mod'];
$config = $_G['cache']['plugin']['sanree_brand_'.CURMODE_SANREE_DOMAIN];
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand_domain'];
$is_rewrite = intval($config['is_rewrite']);
$discuz_version = $appVer; 
$modarray = array('index', 'my'.CURMODE_SANREE_DOMAIN, 'editdomain', 'buydomain');
$mod = !in_array($mod, $modarray) ? 'index' : $mod;
$brand_config = $_G['cache']['plugin']['sanree_brand'];
$copyrightpass = $brand_config['copyrightpass'];
$isopen = intval($config['isopen']);

$navtitle = $config['title'];
$maintitle = $navtitle;
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
$allowgroup = unserialize($config['allowgroup']);
$domainprice = intval($config['domainprice']);
$ischkdomain = intval($config['ischkdomain']);
$creditunit = intval($brand_config['creditunit']);
$nonepricetip = trim($config['nonepricetip']);
$creditunitname = $_G['setting']['extcredits'][$creditunit]['title'];
$overday = intval($config['overday']);
$groupid = $_G['group']['groupid'];
if (!in_array($groupid, $allowgroup)) {

	showmessage(domain_modlang('stopallowtip'));
	
}
define('sr_brand_'.CURMODE_SANREE_DOMAIN.'_TPL', sr_brand_model_TPL."/".$template.'/');
if (!file_exists(sr_brand_domain_TPL."/".$template."/copyright.xml")) {

	$template= "default";
	
}
$entrydir = DISCUZ_ROOT.'./source/plugin/sanree_brand_'.CURMODE_SANREE_DOMAIN.'/tpl/'.$template;
if(file_exists($entrydir."/copyright.xml")) {

	 $importtxt = @implode('', file($entrydir."/copyright.xml"));
	 
}	 
require_once libfile('class/xml');
$xmldata = xml2array($importtxt);	
if (!is_array($xmldata)) {

	showmessage(srlang('error_template'));
	
}
$mdomain = trim($config['mdomain']);
if (!$mdomain) {
	showmessage(lang('plugin/sanree_brand_domain'));
}
$okdomain = '.'.$mdomain;
define('sr_brand_'.CURMODE_SANREE_DOMAIN.'_IMG', sr_brand_model_TPL."/".$template.'/images');
define('sr_brand_'.CURMODE_SANREE_DOMAIN.'_JS', sr_brand_model_TPL."/".$template.'/js');
$allurl = gethomeurl();
$sanreeurl = "http://www.fx8.cc/";
srhooks();
define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
define('sr_brand_IMG', sr_brand_TPL."/".$brand_config['template'].'/images');
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>