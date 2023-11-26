<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
!$fromversion && $fromversion = $_GET['fromversion'];
if ($fromversion == '3.52') {
$sql = <<<SQL
ALTER TABLE `pre_e6_pro_credit` DROP `username`;
ALTER TABLE `pre_e6_pro_task` CHANGE `grouplimit` `grouplimit` TEXT NOT NULL;
SQL;
	runquery($sql);
	if (file_exists(DISCUZ_ROOT . "data/e6_propaganda.config.php")) {
		include DISCUZ_ROOT . "data/e6_propaganda.config.php";
		C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($e6_propaganda))));
		updatecache('setting');
		@unlink(DISCUZ_ROOT . '/data/e6_propaganda.config.php');
	}
} elseif ($fromversion == '5.0') {
$sql = <<<SQL
ALTER TABLE `pre_e6_pro_task` CHANGE `grouplimit` `grouplimit` TEXT NOT NULL;
SQL;
	runquery($sql);	
}
if ($fromversion < 5.3) {
	$username_column = DB::result_first("Describe ".DB::table('e6_pro_credit')." username");
	if ($username_column) {
		runquery("ALTER TABLE `pre_e6_pro_credit` DROP `username`;");
	}
}
if (file_exists( DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')) {
	$pluginid = 'e6_propaganda';
	$Hooks = array(
		'forumdisplay_sideBar',
		'forumdisplay_topBar',
	);
	$data = array();
	foreach ($Hooks as $Hook) {
		$data[] = array($Hook => array('plugin' => $pluginid, 'include' => 'api.class.php', 'class' => $pluginid . '_api', 'method' => $Hook));
	}
	require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
	$e6_wechat = new WeChatHook;
	if (method_exists($e6_wechat, 'updateAPIHook')) {
		WeChatHook::updateAPIHook($data);
	}
}
$finish = TRUE;
?>