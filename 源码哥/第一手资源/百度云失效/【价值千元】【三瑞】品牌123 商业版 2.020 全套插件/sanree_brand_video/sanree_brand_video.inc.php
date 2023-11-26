<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video.inc.php sanree $
 */
///error_reporting(E_ALL);
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$_G['pidentifier'] = $pidentifier = 'video';
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

	showmessage(lang('plugin/sanree_brand_video', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_module.php';
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
$selectdiscount = $brand_config['selectdiscount'];
$marr = explode("\r\n", $selectdiscount);
$tel114config = $_G['cache']['plugin']['sanree_tel114'];
$tel114version = $_G['setting']['plugins']['version']['sanree_tel114'] * 1000;
$tel114_is_rewrite = $tel114config['is_rewrite'];
$brand_config['selectdiscountshow'] = array();
$albumshowperpage = intval($brand_config['selectdiscountshow'])<1 ? 15 : intval($brand_config['selectdiscountshow']);
foreach($marr as $row) {

	list($key , $val) = explode("=", $row);
	$brand_config['selectdiscountshow'][$key] = $val;
	
}

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
$config = $_G['cache']['plugin']['sanree_brand_'.$pidentifier];
$indexadimgurl1 = $config['indexadimgurl1'];
$indexadlinkurl1 = $config['indexadlinkurl1'];
$addgroup = unserialize($config['addgroup']);
$viewgroup = unserialize($config['viewgroup']);
$nochkgroup = unserialize($config['nochkgroup']); 
$allowgroup = unserialize($config['allowgroup']);
$groupid = $_G['group']['groupid'];
if (!in_array($groupid, $allowgroup)) {

	showmessage(video_modlang('stopallowtip'));
	
}
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand_video'];
$is_rewrite = $config['is_rewrite'];
$discuz_version = $appVer; 
$modarray = array('my'.$pidentifier, 'published', $pidentifier.'show', 'user'.$pidentifier, 'fastpost','delete'.$pidentifier, 'image');
if (!in_array($mod, $modarray)) {
	showmessage(video_modlang('nomod'));
}
$shownum = intval($config['shownum']);
$allowfastpost = intval($config['allowfastpost']);
$isindexlist = intval($config['isindexlist']);
$shownum = max(1,$shownum);
$modulemenuname = $config['modulemenuname'];
$stopaddtip = $config['stopaddtip'];
$copyrightpass = $brand_config['copyrightpass'];
$isopen = intval($config['isopen']);
$indexrecommendnum = intval($config['indexrecommendnum']); 
$djtitle = $config['djtitle'];
$enddatetip = $config['enddatetip'];
$searchword = $config['searchword'];
$sharecode = $config['sharecode'];
$wordarr = explode("\r\n", $searchword);
if ($isopen!=1) {

	showmessage(srlang('noopen'));
	
}
$reurlmode= intval($config['reurlmode']);
$bindingforum = intval($config['bindingforum']);
if ($bindingforum<1) {

	showmessage(srlang('nobindingforum'));
	
}
chkformtitle($bindingforum, $config);
$forumtitle = $config['forumtitle'];
$forumbody = $config['forumbody'];
$navtitle = $brandconfig['title'];
$maintitle = $navtitle;
$metakeywords = $config['keywords'];
$metadescription = $config['description'];
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
if (!defined('sr_brand_TPL')) {
	define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
}
if (!file_exists(sr_brand_TPL."/".$template."/copyright.xml")) {

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
$modelurl = video_getmodeurl();
$allurl = gethomeurl();
$sanreeurl = "http://www.fx8.cc/";
srhooks();
define('sr_brand_IMG', sr_brand_TPL."/".$brand_config['template'].'/images');
$index_search_word_str ='';
foreach($wordarr as $word) {

	$index_search_word_str.= '<a href="'.$modelurl.'&keyword='.urlencode($word).'">'.$word.'</a>';

}
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>