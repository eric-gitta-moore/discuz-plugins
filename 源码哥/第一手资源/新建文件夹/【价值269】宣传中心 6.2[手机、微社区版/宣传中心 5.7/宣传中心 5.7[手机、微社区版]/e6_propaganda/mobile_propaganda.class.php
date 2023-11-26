<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class mobileplugin_e6_propaganda {
	function common() {
		global $_G, $_GET;
		$_GET['x'] && $GLOBALS['x'] = $x = intval($_GET['x']);
		$_GET['regsubmit'] && $e6_reg = 1;
		if ($_G['uid'] && getcookie('pro_x')) {
			if (!$_G['member']['regdate']) $user = C::t('common_member')->fetch($_G['uid']);
			$regdate = $_G['member']['regdate'] ? $_G['member']['regdate'] : $user['regdate'];
			if (($_G['timestamp'] - $regdate) < 600 && ($_G['timestamp'] - $regdate) > 1) {
				$pro_reg = C::t('#e6_propaganda#e6_pro_user')->fetch($_G['uid']);
				if (!$pro_reg) {
					$e6_reg = 1;
				}
			}
		}
		if ($x or ($e6_reg && $_G['uid'] && getcookie('pro_x'))) {
			!$GLOBALS['e6_propaganda_x'] && @include DISCUZ_ROOT . 'source/plugin/e6_propaganda/x.php';
		}
	}
	function index_top_mobile() {
		global $_G, $_GET;
		if ($_GET['mobile'] == 1) {
			$left = '<span class="pipe">|</span>';
		} else {
			$left = '&nbsp;&nbsp;&nbsp;';
		}
		return $left.'<a href="plugin.php?id=e6_propaganda">'.lang('plugin/e6_propaganda', 'title').'</a>';
	}
}
class mobileplugin_e6_propaganda_forum extends mobileplugin_e6_propaganda {}

?>