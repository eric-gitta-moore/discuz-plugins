<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (!function_exists('e6_propaganda')) {
	require DISCUZ_ROOT.'source/plugin/e6_propaganda/e6_propaganda.func.php';
}
$e6_propaganda = unserialize($_G['setting']['e6_propaganda']);
if (!$pro_send) require_once DISCUZ_ROOT . 'source/plugin/e6_propaganda/send.php';
$navtitle = pro_lang('title');
$metakeywords = pro_lang('title');
$metadescription = pro_lang('title');
if ($_GET['x'] && empty($_G['uid'])) {
	header("location: http://{$_SERVER['HTTP_HOST']}/forum.php?x={$_GET['x']}");
	dexit();
}
if(empty($_G['uid'])) Showmessage(pro_lang('no_login'), 'member.php?mod=logging&action=login');
if (!$e6_propaganda['open']) {
	!$e6_propaganda['close'] && $e6_propaganda['close'] = pro_lang('pro_close');
	Showmessage($e6_propaganda['close']);
}
if(defined('IN_MOBILE')) {
	Showmessage(pro_lang('error_01'));
}
$nav = $_GET['nav'] ? $_GET['nav'] : 'index';
$nav_list = pro_nav();
if ($e6_propaganda['nav_arr']) {
	foreach($e6_propaganda['nav_arr'] as $v) {
		$e6_nav[$v] = $nav_list[$v];
	}
} else {
	$e6_nav = $nav_list;
}
if(!$e6_propaganda['withdrawopen']) unset($e6_nav['withdraw']);
$e6_nav_css[$nav] = 'a';
$e6_nav_name = $e6_nav[$nav];
$nav_url = 'plugin.php?id=e6_propaganda&nav='.$nav;
if (file_exists("{$pro_module}index_{$nav}.php")) {
	if (file_exists("{$pro_module}index_{$nav}_extra_top.php")) {
		require_once "{$pro_module}index_{$nav}_extra_top.php";
	}
	require_once "{$pro_module}index_{$nav}.php";
	if (file_exists("{$pro_module}index_{$nav}_extra_end.php")) {
		require_once "{$pro_module}index_{$nav}_extra_end.php";
	}
	if (!$no_template && file_exists(DISCUZ_ROOT . "source/plugin/e6_propaganda/template/index_{$nav}.htm")) {
		@include template("e6_propaganda:index_{$nav}");
	}
} else {
	Showmessage(pro_lang('no_module'), 'plugin.php?id=e6_propaganda');
}
dexit();
?>