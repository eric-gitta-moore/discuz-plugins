<?php

/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */

if (!defined('IN_DISCUZ')) {
	exit ('Access Denied');
}

if(!$_G['uid']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}


loadcache("usergroups");

$xmlcfg = $_G['cache']['plugin']['xiaomy_buyvipgroup'];


$curpage=intval(getgpc('page'));
			
if($curpage<1){
	$curpage=1;
}
$pageUrl="plugin.php?id=xiaomy_buyvipgroup:payrecord";
	
$pagesize=15;

//��ȡ��ǰ�û��ĳ�ֵ��¼
$suserpay = C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->fetch_by_uid($_G['uid'],($curpage-1)*$pagesize,$pagesize);

$suserpaycount = C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->fetch_by_uidrcount($_G['uid']);

$pagenav = multi($suserpaycount['rcount'], $pagesize, $curpage, $pageUrl);

//��ȡ���³�ֵ��¼
$record = C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->fetch_pay_record(7);

$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='xiaomy_buyvipgroup'");
if(!strstr($ym_copyright['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8526'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('xiaomy_buyvipgroup:payrecord');

?>