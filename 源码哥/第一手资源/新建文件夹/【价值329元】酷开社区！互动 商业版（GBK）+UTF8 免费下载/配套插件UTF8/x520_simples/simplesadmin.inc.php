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

$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='x520_simples'");
if(!strstr($ym_copyright['copyright'],authcode('fe4cOraarVJA6lQEiuPqBjAUtQ+E1ZWmTw2IcjOrCZsO','DECODE','template')) and !strstr($_G['siteurl'],authcode('77d6IbEzz/reXT9qA0N9v1X/DR4I9LV4ytDAe0Z5w+GiLqYtkDw','DECODE','template')) and !strstr($_G['siteurl'],authcode('b943wO9nnZf0RZey7MAa+zYBioo3x8L9dtajPjIaNK5YTysGEWc','DECODE','template'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.authcode('74c1jYFbzq4AknMX3r5GR59hHVOh+BsOO6VQZSNQJJ2lpXxekhck8Myf758Jiz/k5Q','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('777eYcuBvdKMzfo5Po3wZ+7HP1hwvg/mfjPWHQAfuYNZ6OlygrvXp3G8MgTe0PCXs6lN7rtt2ouJvGrR9YZ/g6An5MZv','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
include template('x520_simples:explain');

?>
