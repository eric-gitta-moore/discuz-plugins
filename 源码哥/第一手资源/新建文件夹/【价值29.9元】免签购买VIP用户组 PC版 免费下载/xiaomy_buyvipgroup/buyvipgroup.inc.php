<?php

/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if (!defined('IN_DISCUZ')) {
	exit ('Access Denied');
}

if(!$_G['uid']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}

$step = daddslashes($_GET['step']);

$xmlcfg = $_G['cache']['plugin']['xiaomy_buyvipgroup'];


$myi = getuserprofile(extcredits.$xmlcfg['itype']);

loadcache("usergroups");

$groupconfigs = explode("\r\n",$xmlcfg['groupconfigs']);
$groupinfo = array();
foreach($groupconfigs as $gbv){
	$akey = explode("=",$gbv);
	$avalue = explode("||",$akey[1]);
	$groupinfo += array($akey[0]=>$avalue);
}

//获取支付配置

$skzhcfgs = explode("\r\n",$xmlcfg['skzhcfgs']);
$payinfo = array();
foreach($skzhcfgs as $gbv){
	$akey = explode("=",$gbv);
	$avalue = explode("||",$akey[1]);
	$payinfo += array($akey[0]=>$avalue);
}
$deaultpay = reset($payinfo);

if($step == "next"){
	
	if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
			showmessage('error');
	}
	
	if($_G['uid'] == 1){
		showmessage(lang('plugin/xiaomy_buyvipgroup', 'bvip01'));
	}
	
	$stepdata = $_GET;
	if($groupinfo[$stepdata['groupskey']][3] == 'yj'){
		$flag = 2;
		$stepdata['icount'] = lang('plugin/xiaomy_buyvipgroup', 'shstr2');
		$stepdata[payrmb] = $groupinfo[$stepdata['groupskey']][1];
	}
	$buygroupid = $groupinfo[$stepdata['groupskey']][0];
}elseif($step =="submityes"){
	
	if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
			showmessage('error');
	}
	
	if($_G['uid'] == 1){
		showmessage(lang('plugin/xiaomy_buyvipgroup', 'bvip01'));
	}
	

	$groupskey = intval($_GET['groupskey']);
	$paydata['payaccount'] = dhtmlspecialchars($_GET['payaccount']);
	$paydata['tnumber'] = dhtmlspecialchars($_GET['tnumber']);
	$paydata['payment'] = dhtmlspecialchars($_GET['payment']);
	
	
	if(!$groupinfo[$groupskey]){
		showmessage('invalid data');
	}
	
	if($groupinfo[$groupskey][3] == 'noyj'){
		$paydata['cyclecount'] = intval($_GET['sjicount']);
		if(!$paydata['cyclecount'] || !$paydata['payaccount']){
			showmessage('invalid data');
		}
		$paydata['payrmb'] =$paydata['cyclecount']*$groupinfo[$groupskey][1];
	}else if($groupinfo[$groupskey][3] == 'yj'){
		$paydata['cyclecount'] = 0;
		if(!$paydata['payaccount'] ){
			showmessage('invalid data');
		}
		$paydata['payrmb'] =$groupinfo[$groupskey][1];
	}
	$paydata['uid'] =$_G['uid'];
	$paydata['username'] =$_G['username'];
	//$paydata['payrmb'] =$paydata['cyclecount']*$groupinfo[$groupskey][1];
	$paydata['dateline'] =$_G['timestamp'];
	$paydata['groupid'] =$groupinfo[$groupskey][0];
	$paydata['status'] =1;
	C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->insert($paydata);
	
	//发送邮件通知
	//发送邮件
	if($xmlcfg['mail']){
		require_once libfile('function/mail');
		$meailsubject =lang('plugin/xiaomy_buyvipgroup', 'bvip02');
		$mailmessage=$_G['username'].lang('plugin/xiaomy_buyvipgroup', 'bvip03');
		sendmail($xmlcfg['mail'],$meailsubject,$mailmessage);
	}
	showmessage(lang('plugin/xiaomy_buyvipgroup', 'postrtc04'),"plugin.php?id=xiaomy_buyvipgroup:buyvipgroup",array(),array('alert'=>'right'));

}else{
	$quickpcount =  explode("\r\n",$xmlcfg['qgrouptime']);
}

$record = C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->fetch_pay_record(7);
$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='xiaomy_buyvipgroup'");
if(!strstr($ym_copyright['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8526'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('xiaomy_buyvipgroup:buyvipgroup');

?>