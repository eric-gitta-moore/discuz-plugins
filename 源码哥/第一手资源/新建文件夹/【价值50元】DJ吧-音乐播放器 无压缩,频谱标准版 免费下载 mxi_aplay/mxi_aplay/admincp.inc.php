<?php


/*
 *源     码     哥 y  m   g   6   .     c     o m
 *更多商业插件/模版免费下载 就在源  码  哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit ('Access Denied');
}

loadcache('plugin');
$identifier = 'mxi_aplay';
$mxi_aplay = $_G['cache']['plugin'][$identifier];

include_once DISCUZ_ROOT."./source/plugin/mxi_aplay/function/function_aplay.php";
showtableheader();
 
echo '
<script src="./static/image/admincp/cloud/jquery.min.js"></script>
<script>jQuery.noConflict();</script>
<script src="./source/plugin/mxi_aplay/template/admincp.js"></script>
<label for="aid">附件aid:</label>
<input type="text" name="attachaid" id="attachaid" />
<input type="submit" name="urlcreate" id="urlcreate" onclick="aplay_url()" value="'.$lang['ok'].'" />
<br><div id="aidcompress"></div>
';
$checkOS = '<ul><li>';
$checkOS .= "safe_mode :".(ini_get('safe_mode') ? '<font color=red>[&times;]On</font>' : '<font color=green>[&radic;]Off</font>');
$checkOS .= "</li>";
if (!strpos(ini_get('disable_functions'),'exec')) {
	$checkOS .= '<li><span style="color:green">[&radic;] exce OK</span></li>';
} else {
	$checkOS .= '<li><span style="color:red">[&times;] exce '.lang_aplay('exec_disable').'</span></li>';
$checkOS .= '<li><span style="color:red">'.lang_aplay('exec_enable').'</span></li>';
}
$checkOS .= '<li>'.lang_aplay('exec_open').'</li>';
$checkOS .= '<li><img src="./source/plugin/mxi_aplay/template/image/cmd_con.png"></li>';
$checkOS .= '<li><img src="./source/plugin/mxi_aplay/template/image/lame_conf_linux.png"></li>';
$checkOS .= '</ul>';

showtips($checkOS );
showtablefooter();
?>