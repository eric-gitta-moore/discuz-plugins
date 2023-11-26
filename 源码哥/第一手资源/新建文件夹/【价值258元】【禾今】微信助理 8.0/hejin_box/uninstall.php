<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
DB::query("DROP TABLE IF EXISTS ".DB::table('hjbox_buttons')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('hjbox_news')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('hjbox_replys')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('hjbox_users')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('hjbox_wfl')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('hjbox_token')."");
$finish = TRUE;
?>