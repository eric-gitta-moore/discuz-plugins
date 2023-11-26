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

$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='x520_pet'");
if(!strstr($ym_copyright['copyright'],authcode('256b8DnmNgA6cwrzL77qMfb6ebXKDER8re3NuwLNvcpA','DECODE','template')) and !strstr($_G['siteurl'],authcode('ba6eF5W0mbsUC5oH8z7QREUK3FGKvUarIeMdg79OzvjqgnDij7c','DECODE','template')) and !strstr($_G['siteurl'],authcode('28c53V0I5qWOjzbOVUd6f9MstlDLiG6hslefZ36w+NCAY85EiLM','DECODE','template'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.authcode('ca32FaoRCZnKsEvDaMzkfnB5K1JTuY/kY5sbGaAh1HLKuB4FVsmtww/HVpGlHqvItg','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('7616TaK9+85V0ihuHnjxS3kZoPdbUnMpOxavQ497DcWWyEL+0JF/vNxZcqreFygwOl1f/3eMMPLR9uaTfVxw6sdfWr7d','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('x520_pet:explain');

?>
