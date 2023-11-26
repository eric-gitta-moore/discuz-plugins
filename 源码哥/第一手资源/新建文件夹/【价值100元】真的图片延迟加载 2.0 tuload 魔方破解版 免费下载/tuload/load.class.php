<?php
/*
购买的仅是QQ:210667808所发布插件的使用权，并非拥有权。
请勿传播、转卖、公开、修改本插件，否则一切后果作者均不负责。
*/

defined('IN_DISCUZ') or exit('Access Denied');
include DISCUZ_ROOT.'./source/plugin/tuload/load.fun.php';
class plugin_tuload{
	function global_header(){
		return plugin_tuload(1);
	}

	function global_footer(){
		return plugin_tuload(2);
	}

	function common(){
		return plugin_tuload(3);
	}
}
class plugin_tuload_forum{
	function forumdisplay_top_output(){
		plugin_tuload_picstyle();
	}
}
class mobileplugin_tuload{
	function global_header_mobile(){
		return plugin_tuload(1);
	}

	function global_footer_mobile(){
		return plugin_tuload(2);
	}
}
