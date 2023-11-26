<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$op = $_GET['op'];
$opArray = array("delete","list","edit","add");
if(!in_array($op,$opArray)) $op = 'list';
include DISCUZ_ROOT.'./source/plugin/zhikai_topic/admincp/'.$op.'.php';
?>