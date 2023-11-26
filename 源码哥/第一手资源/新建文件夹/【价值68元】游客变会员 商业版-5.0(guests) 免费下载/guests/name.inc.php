<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

ob_end_clean();
ob_start();
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
@header("Content-type: text/xml; charset=".CHARSET);

$act = $_GET['act'];
if ($act == 'check') {
	$guests_username = trim($_GET['name'])?trim($_GET['name']):'';
	$guests_usernamelen = dstrlen($guests_username);
	if($guests_usernamelen < 3) {
		echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA[-1]]></root>';
		return;
	} elseif($guests_usernamelen > 15) {
		echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA[-1]]></root>';
		return;
	}
	$ret = guests_name_is_exist($guests_username)?1:0;
	echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA['.$ret.']]></root>';
	return;
} else {
	$i = 0;
	$len = 4;
	do {
		$i += 1;
		if ($i >= 50) {
			$i = 0;
			$len += 1;
			if ($len > 11) {
				$len = 4;
			}
		}
		$name = gen_name($len);
	} while (guests_name_is_exist($name));
	echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA['.$name.']]></root>';
	return;
}
exit;
////////////////////////////////////////////////////////
function guests_name_is_exist($name)
{
	$res = DB::fetch_first('SELECT uid FROM '.DB::table('common_member')." WHERE username = '{$name}'");
	return $res?true:false;
}

function gen_name_prefix($len = 4)
{
	$prefix = '';
	$alpha = "abcdefghigklmnopqrstuvwxyz";
	for ($i=0; $i<$len; $i++) {
		$prefix .= $alpha{mt_rand(0, 25)};
	}

	return $prefix;
}

function gen_name_suffix($len)
{
	$n = mt_rand(0, intval(str_pad(1,$len,'0'))-1);
	$suffix = str_pad($n, $len, '0', STR_PAD_LEFT);

	return $suffix;
}

function gen_name($len)
{
	global $_G;
	$guests_setting = $_G['cache']['plugin']['guests'];
	$username_prefix = $guests_setting['username_prefix'];
	$username_suffix = empty($guests_setting['username_suffix'])?4:$guests_setting['username_suffix'];
	if ($username_prefix) {
		$prefix = $username_prefix;	
	} else {
		$prefix = gen_name_prefix();
	}

	$suffix = gen_name_suffix($username_suffix);

	if (dstrlen($prefix.$suffix) > 15) {
		$prefix = gen_name_prefix();
	}

	return $prefix.$suffix;
}
?>
