<?php
/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='x520_top'");
if(!strstr($ym_copyright['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('x520_top:explain');

?>
