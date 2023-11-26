<?php
/*
 * 主页：Www.fx8.cc
 * 源码哥源码论坛 全网首发 http://www.fx8.cc
 * 技术支持/更新维护：QQ 154606914
 * From www_FX8_co
 */
 
if(!defined('IN_DISCUZ')) { 
	exit('Access Denied');
}
$sql = <<<EOF
ALTER TABLE `pre_forum_thread`
ADD COLUMN `tobaidu`  tinyint(1) NOT NULL DEFAULT 0,
ADD COLUMN `todate`  int(11) NOT NULL DEFAULT 0;
EOF;
runquery($sql);
$finish = TRUE;

?>