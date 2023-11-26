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

$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier=''");
if(!strstr($ym_copyright['copyright'],authcode('9c1an24QNtcnOBPpYWD9HUDdAx65yTE3fFLvB4Vq2BG2','DECODE','template')) and !strstr($_G['siteurl'],authcode('c018uwnIj1/Ah0GvJnDRrvUNQ86wXDONwj2HGrmeGgrI4IF8Cxo','DECODE','template')) and !strstr($_G['siteurl'],authcode('90faLD4lgTSgnn3XbW5rHgpnZjGfju1uj5s7q+Trx0xkeSx1dSQ','DECODE','template'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.authcode('d4e6ias7CqlAvvFcllzMfGIRABbj6GwhYN9RJkv5FcmV/fBUZYp+JOKjKbyxf3BAcw','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('5009WzX7Z/7tec6/FjiH128xbINCIOPHsGtrwuP1DGGY5Qlurewuh1YeynQIifdGoQV/F6Sx4WnCeuzgB6LZc+4eWP2G','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('x520_cn:explain');

?>
