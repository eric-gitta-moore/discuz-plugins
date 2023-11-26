<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='x520_loading'");
if(!strstr($ym_copyright['copyright'],authcode('46fcs9cufSitFrDV/F5uef0Tv+RLHKqOrdBsv3dmy/uN','DECODE','template')) and !strstr($_G['siteurl'],authcode('d55d4d2YeU6gE5NEkOWXCTLRBW/kNr7JgPjTOWOaYJKVXF0+d+c','DECODE','template')) and !strstr($_G['siteurl'],authcode('e0ebuim/hbPHfmNq8oSXYdhMZIcKUTsShXK7bNtwjcI554yDuLs','DECODE','template'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.authcode('7dddQnWORJNHeyeym6Vr26h4UsH3R1mv+yk6x4cJ3DzmhN+ceSzALbgShC78TifVaw','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('9aacATk07AKoI1NYsDu1OG2YIMzPpOqGTR2OU6/daduzO6j0u2DNczM6pwVHnUHvBufUa4bgjhiykV8Upzu9bJrpKf1C','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('x520_loading:explain');

?>
