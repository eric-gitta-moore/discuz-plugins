<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$opt                = $_G['cache']['plugin']['guests'];
$qq_login           = $opt['qq_login'];
$recommend_username = $opt['recommend_username'];
$reg_protocol_open  = $opt['reg_protocol_open'];
$title              = $opt['title'];
$content            = $opt['content'];
$seccodecheck       = $opt['seccode']?true:false;
$register_url       = $opt['register_url'];
$welcome_logo       = $opt['welcome_logo']?true:false;
$month_count        = 1;

$res = DB::fetch_first('SELECT count,month_count FROM '.DB::table('plugin_guests')." WHERE ip = '{$_G['clientip']}'");
if ($res && $res['month_count']) {
	$month_count = $res['month_count'];
}
$content = str_replace('_MONTH_COUNT_', $month_count, $content);
$siteurl = !empty($_G['setting']['siteurl'])?$_G['setting']['siteurl']:'/';
$content = str_replace('_SITEURL_', $siteurl, $content);
$bbname = !empty($_G['setting']['bbname'])?$_G['setting']['bbname']:'';
$content = str_replace('_BBNAME_', $bbname, $content);

$guests_welcome_path = '';
if ($welcome_logo) {
	$res = DB::fetch_first('SELECT welcome_path FROM '.DB::table('plugin_guests_info')." WHERE name = 'guests'");
	if ($res && $res['welcome_path']) {
		$guests_welcome_path = $res['welcome_path'];
	}
}

/*
$templatelang = $_G['cache']['pluginlanguage_template']['guests'];
if ($recommend_username) {
	$template_username = <<<EOF
				<td align="right" height="24" width="35%">{$templatelang['random_name']}</td>
				<td colspan="2">
					<input name="_check_username_result" id="_check_username_result" type="hidden" value="-1" />
					<input type="text" id="guests_username" name="guests_username" onkeydown="return keydown_enter_login(event)" style="display:none" onchange="guests_check_username()" class="px vm _input_1" autocomplete="off"/>
					<span id="_guests_name"></span>&nbsp;<span id="_checkusernameverify"></span>
					<a class="guests_change" id="_change_username" href="javascript:;" onclick="guests_change_username()">[{$templatelang['change']}]</a>
					<a class="guests_change" id="_cancel_change" href="javascript:;" onclick="guests_cancel_change()" style="display:none">[{$templatelang['cancel']}]</a>
				</td>
				<script>
				function guests_get_name()
				{
					ajaxget('/plugin.php?id=guests:name', '_guests_name', null);
				}
				guests_get_name();
				</script>
EOF;
} else {
	$template_username = <<<EOF
				<td align="right" height="24" width="35%">{$templatelang['input_username']}</td>
				<td colspan="2">
					<input name="_check_username_result" id="_check_username_result" type="hidden" value="-1" />
					<input type="text" id="guests_username" name="guests_username" onkeydown="return keydown_enter_login(event)" style="display:none" onchange="guests_check_username()" class="px vm _input_1" autocomplete="off"/>
					<span id="_guests_name"></span>&nbsp;<span id="_checkusernameverify"></span>
				</td>
EOF;
}
 */

include_once template('guests:dialog');
?>
