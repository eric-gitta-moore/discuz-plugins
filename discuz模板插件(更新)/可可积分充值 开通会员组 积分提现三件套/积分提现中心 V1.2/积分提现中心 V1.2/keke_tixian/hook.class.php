<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}


class mobileplugin_keke_tixian{
	function global_footer_mobile(){
		global $_G;
		$return='';
		if($_GET['mod']='space' && $_GET['do']='profile' && checkmobile()){
			include template('keke_tixian:enter');
		}
		return $return;
	}
}

