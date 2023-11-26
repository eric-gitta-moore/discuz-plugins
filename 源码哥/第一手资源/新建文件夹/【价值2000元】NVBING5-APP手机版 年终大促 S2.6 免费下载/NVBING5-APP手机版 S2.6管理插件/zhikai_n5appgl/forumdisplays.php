<?php
if(!defined('IN_DISCUZ') ) {
	exit('Access Denied');
}
include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php';
$n5app = init_n5app();
$fid = $_G['fid'];
$forumstyle = $n5app['forumstyle'][$fid];
?>