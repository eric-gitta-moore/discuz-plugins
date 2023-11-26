<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_weixin.inc.php sanree $
 */

if(!defined('IN_DISCUZ')||!defined('IN_SANREE_WEIXIN')) {
	exit('Access Denied');
}
$_G['pidentifier'] = $pidentifier = 'weixin';
if (CHARSET=='utf-8') {

	define('C_CHARSET','_utf8');
	
} else {

	define('C_CHARSET','');
	
}
define('IN_SANREE', TRUE);
$pidentifier = $plugin['identifier'] = 'sanree_weixin';
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_core.php';
require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/'.$plugin['identifier'].'/function/function_module.php';
@require_once($modfile);
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);

global $_G;
foreach($_GET as $k => $v) {

	$_G['sr_'.$k] = daddslashes($v);
	
}
$pluginversion = $_G['setting']['plugins']['version']['sanree_weixin'];
$discuz_version = $appVer; 
$config = $_G['cache']['plugin'][$pidentifier];
$isopen = intval($config['isopen']);
$firstcmd = '@';
define("TOKEN", $config['token']);
if ($isopen!=1) {

	showmessage('no open');
	
}

require_once DISCUZ_ROOT.'/source/plugin/sanree_weixin/class/class_sanree_weixin.php';
define('WEIXINTOKEN', trim($config['token']));
$chat = new wechatCallbackapi();
$chat -> valid();
?>