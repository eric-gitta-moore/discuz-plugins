<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$keke_group = $_G['cache']['plugin']['keke_group'];
if(!function_exists('curl_init')){
	echo 'not function curl_init';
}
define('WXAPPID', trim($keke_group['wxappid']));
define('WXSECRET', trim($keke_group['wxsecert']));
define('WXMCHID', trim($keke_group['wxmchid']));
define('WXKEY', trim($keke_group['wxshkey']));

include_once DISCUZ_ROOT."source/plugin/keke_group/paylib/wechat/lib/WxPay.Config.php";
include_once DISCUZ_ROOT."source/plugin/keke_group/paylib/wechat/lib/WxPay.Api.php";
include_once DISCUZ_ROOT.'source/plugin/keke_group/paylib/wechat/lib/WxPay.Data.php';
include_once DISCUZ_ROOT.'source/plugin/keke_group/paylib/wechat/lib/WxPay.Exception.php';
include_once DISCUZ_ROOT."source/plugin/keke_group/paylib/wechat/WxPay.JsApiPay.php";
include_once DISCUZ_ROOT."source/plugin/keke_group/paylib/wechat/WxPay.NativePay.php";
include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
$uskey= substr(md5('keke_group'.$_G['siteurl']), 0, 7);
$iswx='';
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
	$iswx=1;
}
$s_type=$iswx?"JSAPI" : "NATIVE";