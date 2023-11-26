<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = "DROP TABLE `pre_e6_pro_user`, `pre_e6_pro_user_count`, `pre_e6_pro_credit`, `pre_e6_pro_clientorder`, `pre_e6_pro_finance`, `pre_e6_pro_task`, `pre_e6_pro_task_list`, `pre_e6_pro_visit`;";
runquery($sql);
if(file_exists( DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')){
	require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';
	$e6_wechat = new WeChatHook;
	if (method_exists($e6_wechat, 'delAPIHook')) {
		WeChatHook::delAPIHook('e6_propaganda');
	}
}
$finish = TRUE;
?>