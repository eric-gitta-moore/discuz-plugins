<?php
/*
 * 主页：Www.fx8.cc
 * 源码哥源码论坛 全网首发 http://www.fx8.cc
 * 技术支持/更新维护：QQ 154606914
 * From www_FX8_co
 */
 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
ALTER TABLE `pre_forum_thread`
DROP COLUMN `tobaidu`,
DROP COLUMN `todate`;
EOF;
runquery($sql);
if(file_exists(DISCUZ_ROOT.'./data/cache/cache_baidusitemap_over.php')) @unlink($filepath);
if(file_exists(DISCUZ_ROOT.'./data/cache/cache_baidusitemap_remain.php')) @unlink($filepath);
if(file_exists(DISCUZ_ROOT.'./data/sysdata/cache_baidusitemap_over.php')) @unlink($filepath);
if(file_exists(DISCUZ_ROOT.'./data/sysdata/cache_baidusitemap_remain.php')) @unlink($filepath);
$finish = TRUE;
