<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if (!$_G['adminid']) {
	return false;
}

if(!submitcheck('importsubmit')) {
	showtips($scriptlang['guests']['upload_welcome_logo_tips']);
	showformheader("plugins&operation=logo&do=$pluginid&identifier=guests&pmod=logo", 'enctype');
	showtableheader('');
	showsetting('import_file', 'importfile', '', 'file');
	showtagfooter('tbody');
	showsubmit('importsubmit');
	showtablefooter();
	showformfooter();
	$res = DB::fetch_first('SELECT welcome_path FROM '.DB::table('plugin_guests_info')." WHERE name='guests'");
	if ($res && $res['welcome_path']) {
		echo '<hr /><img src="'.$res['welcome_path'].'" />';
	}
} else {
	$extend = explode('.', $_FILES['importfile']['name']);
	$suffix = $extend[count($extend) - 1];
	if (!$suffix) {
		$suffix = 'png';
	}
	$data = @implode('', file($_FILES['importfile']['tmp_name']));
	@unlink($_FILES['importfile']['tmp_name']);
	$guests_logo_dir = $_G['setting']['attachdir'].'plugin_guests';
	@mkdir($guests_logo_dir, 0777);
	$logo_path = $guests_logo_dir.'/welcome.'.$suffix;
	file_put_contents($logo_path, $data);
	$welcome_path = $_G['setting']['attachurl'].'plugin_guests/welcome.'.$suffix;
	DB::query("UPDATE ".DB::table('plugin_guests_info')." SET welcome_path='$welcome_path' WHERE name='guests'");
	cpmsg('patch_successful', dreferer(), 'succeed');
}
?>
