<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_keke_group {
}


class plugin_keke_group_home extends plugin_keke_group{
	function spacecp_usergroup_top_output() {
		if($_GET['mod']=='spacecp' && $_GET['ac']=='usergroup' && $_GET['do']=='list' && !$_GET['jump']){
			dheader('location: plugin.php?id=keke_group');
		}
	}
}


