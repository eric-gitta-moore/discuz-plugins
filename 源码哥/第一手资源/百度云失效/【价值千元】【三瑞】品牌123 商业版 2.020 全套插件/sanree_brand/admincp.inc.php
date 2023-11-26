<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp.inc.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
}

$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/config.inc.php';
@require_once($modfile);
$modfile=DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
require_once($modfile);
$branddefault = array();
$modfile=DISCUZ_ROOT.'./data/sysdata/cache_sanree_brand_config.php';
file_exists($modfile) && @require_once $modfile;
$defaultconfig = unserialize($branddefault); 
foreach($_GET as $k => $v) {
	$_G['sr_'.$k] = daddslashes($v);
}
$act= $_G['sr_act'];
$config = array();
foreach($pluginvars as $key => $val) {

	$config[$key] = $val['value'];
	
}
$_G['cache']['plugin']['sanree_brand'] = $config;
$defaultzhishu = empty($config['defaultzhishu']) ? '99.9' : $config['defaultzhishu'];
$mapapi = trim($config['mapapi']);
$mapapi = empty($mapapi) ? 'baidu' : $mapapi;
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
$isbdomain = intval($config['isbdomain']);
$mdomain = $config['mdomain'];
$marr = explode("\r\n", $selectdiscount);
$cardname = $config['cardname'];
$config['selectdiscountshow'] = array();
foreach($marr as $row) {
	list($key , $val) = explode("=", $row);
	$config['selectdiscountshow'][$key] = $val;
}
$isselfdistrict = intval($config['isselfdistrict']);
if ($isselfdistrict==1) {

	$actlist =array(
		'base'			=> array('base', 'updatecache'),
		'businesses'	=> array('businesseslist'),
		'category'		=> array('list'),
		'district'		=> array('district'),
		'slide'			=> array('slide'),
		'group'			=> array('group'),
		'cmenu'			=> array('cmenu'),
		'msgmanage'		=> array('msg'),
		'tag'		=> array('tag'),
		'mf'		=> array('mf'),
		'album' => array( 'album_category','album'),
		'diymanage'		=> array('diyconfig', 'diystyle', 'diytemplate'),
		'domain'		=> array('domainconfig'),
		'card'		=> array('card'),
		'navigation'		=> array('navigation'),
		'friendly_link'		=> array('friendly_link'),
	);

} else {

	$actlist =array(
		'base'			=> array('base', 'updatecache'),
		'businesses'	=> array('businesseslist'),
		'category'		=> array('list'),
		'slide'			=> array('slide'),
		'group'			=> array('group'),
		'cmenu'			=> array('cmenu'),
		'msgmanage'		=> array('msg'),
		'tag'		=> array('tag'),
		'mf'		=> array('mf'),				
		'album'			=> array('album', 'album_category'),
		'diymanage'		=> array('diyconfig', 'diystyle', 'diytemplate'),
		'domain'		=> array('domainconfig'),
		'card'		=> array('card'),
		'navigation'		=> array('navigation') 
	
	);
	
}

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
	if($k == 'card') {
		$menustr.='<li'.$navbar[$k].'><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$v[0].'&identifier=sanree_brand&pmod=admincp"><span>'.$cardname.'</span></a></li>';
	}
	$menustr.='<li'.$navbar[$k].'><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$v[0].'&identifier=sanree_brand&pmod=admincp"><span>'.$langs[$k].'</span></a></li>';
}
$menustr.='</ul>';
$thisurl = "plugins&operation=config&identifier=sanree_brand&pmod=admincp&act=$act";
$gotourl = 'action=plugins&operation=config&identifier=sanree_brand&pmod=admincp&act=';
$adminurl = ADMINSCRIPT.'?action=plugins&operation=config&identifier=sanree_brand&pmod=admincp';
$menustr=$rightlink.$menustr;
cpheader();
$cateid=intval($_G['sr_cateid']);
if ($cateid) $thisurl.='&cateid='.$cateid;
$actfile=sanree_libfile('admincp/'.$plugin['identifier'].'/'.$act, $plugin['identifier']);
if(!file_exists($actfile)) {

	cpmsg($langs['isbusiness'], 'action=plugins&operation=config&identifier=sanree_brand&pmod=admincp&act=list', 'error');
	
}

$bindingforum = intval($config['bindingforum']);
if ($bindingforum<1) {

	cpmsg_error($langs['nobindingforum']);
	
}
chkformtitle($bindingforum);
$creditunit = $config['creditunit'];
if(empty($creditunit)){

	cpmsg_error($langs['nocreditunit']);
	
}
if ($config['isnice']) {
	$homenav = DB::fetch_first('SELECT * FROM %t WHERE identifier = %i', array('common_nav', "'ssanree_brand_nicehome'",));
	if (!$homenav['id']) {
		C::t('common_nav')->insert(array('name'=>$langs['nice_home'], 'type'=>1, 'available'=>1, 'url'=>'plugin.php?id=sanree_brand&mod=home','identifier'=>'ssanree_brand_nicehome'));
	}
} else {
	$homenav = DB::fetch_first('SELECT * FROM %t WHERE identifier = %i', array('common_nav', "'ssanree_brand_nicehome'",));
	if ($homenav['id']) {
		DB::delete('common_nav', DB::field('id', $homenav['id']));
	}
}
require_once $actfile;
?>