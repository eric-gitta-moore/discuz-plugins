<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class e6_propaganda_api {
	function forumdisplay_topBar() {
		global $_G;
		$e6_propaganda = unserialize($_G['setting']['e6_propaganda']);
		if (!function_exists('pro_lang')) {
			require 'e6_propaganda.func.php';
		}
		if ($e6_propaganda['mobile_url'] == 0) {
			$return = array();
			$return[] = array(
				'name' => pro_lang('title'),
				'html' => "<a href=\"{$this->get_url()}\">{$e6_propaganda['top_text']}</a>",
				'more' => $this->get_url(),
			);
			return $return;
		}
	}
	function forumdisplay_sideBar() {
		global $_G;
		$e6_propaganda = unserialize($_G['setting']['e6_propaganda']);
		if (!function_exists('pro_lang')) {
			require 'e6_propaganda.func.php';
		}
		if ($e6_propaganda['mobile_url'] == 1) {
			return "<li><a href=\"{$this->get_url()}\" style=\"color:#FF5500;\">".pro_lang('title')."</a></li>";
		}
	}
	function get_url() {
		require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
		return WeChatHook::getPluginUrl('e6_propaganda');
	}
}

?>