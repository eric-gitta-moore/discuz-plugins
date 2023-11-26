<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('CURSCRIPT', 'forum');


global $_G;
$keke_group = $_G['cache']['plugin']['keke_group'];
if(!$_G['uid'] && $_GET['p']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}
include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
$title=dhtmlspecialchars($keke_group['title']);
$alipayoff=empty($keke_group['alipaypid']) || empty($keke_group['alipaykey']) ? 0 : 1;
$wxpayoff=empty($keke_group['wxappid']) || empty($keke_group['wxsecert']) || empty($keke_group['wxmchid']) || empty($keke_group['wxshkey']) ? 0 : 1;
$ys=$keke_group['ys']? dhtmlspecialchars($keke_group['ys']) : '#e14546';
if((strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$_GET['p']) && $wxpayoff){
	include_once libfile('function/cache');
	include_once DISCUZ_ROOT."source/plugin/keke_group/inc.php";
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	dsetcookie($uskey, authcode($openId, 'ENCODE', $_G['config']['security']['authkey']), 8640000);
}
$nowgroup=_getnowgroup();
if($_GET['p']=='my'){
	$pages=intval($_GET['page']);
	$myorderdata=_getmyorder($pages);
	$list=$myorderdata['list'];
	$multipage=$myorderdata['page'];//fr om w ww.mo qu8.co m
}elseif($_GET['p']=='sw'){
	$n=1;
	$expirylist=_getmygrouplist();
}elseif($_GET['p']=='loading'){
	$orderid=daddslashes(dhtmlspecialchars($_GET['orderid']));
}else{
	$gorupdata = _indexdata();
	$keke_group['sm']=dhtmlspecialchars($keke_group['sm']);
}
include template('keke_group:index');