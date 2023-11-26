<?php

/**
 *      (C)2010-2020 ainuo.
 *
 *      $QQ QQÈº£º550494646 2017-06 ainuo $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$ainuozdarr = array();
foreach($_G['forum_threadlist'] as $ainuozd){
	if($ainuozd['displayorder'] <= 0){continue;}
	$ainuozdarr[] = $ainuozd;
}
?>