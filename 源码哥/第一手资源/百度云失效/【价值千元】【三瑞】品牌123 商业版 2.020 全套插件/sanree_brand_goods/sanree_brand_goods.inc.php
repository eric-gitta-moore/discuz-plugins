<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods.inc.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}
define('CURMODE_SANREE_GOODS', 'goods');
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('IN_SANREE', TRUE);
$brandplugurl = 'http://www.fx8.cc/?@sanree_brand.plugin';
$plugin['identifier'] = 'sanree_brand_'.CURMODE_SANREE_GOODS;
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
if(!file_exists($modfile)) {

	showmessage(lang('plugin/sanree_brand_goods', 'error_install'), $brandplugurl, 'error');
	
}
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_module.php';
@require_once($modfile);
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
define('sr_brand_model_TPL', 'source/plugin/sanree_brand_'.CURMODE_SANREE_GOODS.'/tpl');
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
$ismultiple				= intval($brand_config['ismultiple']);
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
$config = $_G['cache']['plugin']['sanree_brand_'.CURMODE_SANREE_GOODS];
$addgroup = unserialize($config['addgroup']);
$viewgroup = unserialize($config['viewgroup']);
$nochkgroup = unserialize($config['nochkgroup']); 
$allowgroup = unserialize($config['allowgroup']);
$groupid = $_G['group']['groupid'];
if (!in_array($groupid, $allowgroup)) {

	showmessage(goods_modlang('stopallowtip'));
	
}
$pluginversion = $_G['setting']['plugins']['version']['sanree_brand_goods'];
$is_rewrite = $config['is_rewrite'];
$discuz_version = $appVer; 
$modarray = array('index', 'my'.CURMODE_SANREE_GOODS, 'published', 'attachlist', CURMODE_SANREE_GOODS.'show', 'user'.CURMODE_SANREE_GOODS, 'fastpost','delete'.CURMODE_SANREE_GOODS, 'image');
$mod = !in_array($mod, $modarray) ? 'index' : $mod;
$shownum = intval($config['shownum']);
$allowfastpost = intval($config['allowfastpost']);
$isindexlist = intval($config['isindexlist']);
$shownum = max(1,$shownum);
$modulemenuname = $config['modulemenuname'];
$stopaddtip = $config['stopaddtip'];
$copyrightpass = $brand_config['copyrightpass'];
$isopen = intval($config['isopen']);
$djtitle = $config['djtitle'];
$isbuylink = intval($config['isbuylink']);
$addprice = max(0, intval($config['addprice']));
$creditunit = intval($brand_config['creditunit']);
$creditunitname = $_G['setting']['extcredits'][$creditunit]['title'];
$nonepricetip = str_replace('{addprice}', $addprice,$config['nonepricetip']);
$buyimage = !empty($config['buyimage']) ? $config['buyimage'] : 'source/plugin/sanree_brand_goods/tpl/default/images/buy.gif';
$purchasestatement = $config['purchasestatement'];
///$enddatetip = $config['enddatetip'];
$searchword = $config['searchword'];
$indexadimgurl1 = $config['indexadimgurl1'];
$indexadlinkurl1 = $config['indexadlinkurl1'];
$selectpriceunit = $config['selectpriceunit'];
$marr = explode("\r\n", $selectpriceunit);
foreach($marr as $row) {

	list($key , $val) = explode("=", $row);
	$config['selectpriceunitshow'][trim($key)] = goods_shtmlspecialchars(trim($val));
	
}
$wordarr = explode("\r\n", $searchword);
if ($isopen!=1) {

	showmessage(srlang('noopen'));
	
}
$bindingforum = intval($config['bindingforum']);
if ($bindingforum<1) {

	showmessage(srlang('nobindingforum'));
	
}
chkformtitle($bindingforum, $config);
$forumtitle = $config['forumtitle'];
$forumbody = $config['forumbody'];
$navtitle = $config['title'];
$maintitle = $navtitle;
$metakeywords = $config['keywords'];
$metadescription = $config['description'];
$template = trim($config['template']);
$template = empty($template) ? 'default' : $template;
define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
define('sr_brand_good_TPL', 'source/plugin/sanree_brand_goods/tpl');

if(!$brand_config['isbird']) {
	if (!file_exists(sr_brand_TPL."/".$template."/copyright.xml")) {
	
		$template= "default";
		
	}
} else {
	if (!file_exists(sr_brand_good_TPL."/".$template."/copyright.xml")) {
	
		$template= "default";
		
	}
}
$entrydir = DISCUZ_ROOT.'./source/plugin/sanree_brand_'.CURMODE_SANREE_GOODS.'/tpl/'.$template;
if(file_exists($entrydir."/copyright.xml")) {

	 $importtxt = @implode('', file($entrydir."/copyright.xml"));
	 
}	 
define('sr_brand_'.CURMODE_SANREE_GOODS.'_TPL', sr_brand_model_TPL."/".$template.'/');
require_once libfile('class/xml');
$xmldata = xml2array($importtxt);	
if (!is_array($xmldata)) {

	showmessage(srlang('error_template'));
	
}
define('sr_brand_'.CURMODE_SANREE_GOODS.'_IMG', sr_brand_model_TPL."/".$template.'/images');
define('sr_brand_'.CURMODE_SANREE_GOODS.'_JS', sr_brand_model_TPL."/".$template.'/js');
$modelurl = goods_getmodeurl();
$allurl = gethomeurl();
$sanreeurl = "http://www.fx8.cc/";
srhooks();
define('sr_brand_IMG', sr_brand_TPL."/".$brand_config['template'].'/images');
$index_search_word_str ='';
foreach($wordarr as $word) {

    if ($is_rewrite==1) {
		$index_search_word_str.= '<a href="'.$modelurl.'?keyword='.urlencode($word).'">'.$word.'</a>';
	} else {
		$index_search_word_str.= '<a href="'.$modelurl.'&keyword='.urlencode($word).'">'.$word.'</a>';
	}

}
if ($is_rewrite==1) {
	$_G['basefilename'] = $_G['basescript'] = trim($config['urlgoodsmode']);
} else {
	$_GET['id'] = $plugin['identifier'].':'.$plugin['identifier'];
}

if (defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
	
	define('my_mobile_css', 'source/plugin/'.$plugin['identifier'].'_mobile/tpl/mobile/'.$template.'/');
	define('my_mobile_js', 'source/plugin/'.$plugin['identifier'].'_mobile/tpl/mobile/'.$template.'/js/');
	define('my_mobile_img', 'source/plugin/'.$plugin['identifier'].'_mobile/tpl/mobile/'.$template.'/images/');
	$wapconfig = $_G['cache']['plugin']['sanree_brand_wap'];
	$notlimited = srlang('notlimited');
}

require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>