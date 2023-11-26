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

$guests_uid = -1;
$guests_gid = -1;
$guests_username = isset($_GET['guests_username'])?addslashes($_GET['guests_username']):(isset($_G['guests_username'])?addslashes($_G['guests_username']):'');
$guests_password = isset($_GET['guests_password'])?$_GET['guests_password']:'';
$guests_clientip = $_G['clientip'];
$guests_setting = $_G['cache']['plugin']['guests'];
$setting = $_G['setting'];
$seccodecheck = $guests_setting['seccode']?true:false;

if (submitcheck('guests_regsubmit', 0, $seccodecheck)) {
	if (!guests_do_register()) {
		return;
	}

	if (!guests_do_login()) {
		return;
	}
	$referer = dreferer();
	showmessage('location_login_succeed', '/', array(), array(
			'extrajs' => '<script type="text/javascript">'.
			'window.location.href =\''.$referer.'\';'.
			'</script>',
			'striptags' => false,
			'showdialog' => false 
		)
	);
} else {
	showmessage('submit_invalid');
}

exit;
////////////////////////////////////////////////////////
function guests_do_register()
{
	global $guests_uid, $guests_gid, $guests_username, $guests_password, $setting, $guests_setting, $guests_clientip;
	
	if(!$setting['regstatus']) {
		showmessage(!$setting['regclosemessage'] ? 'register_disable' : str_replace(array("\r", "\n"), '', $setting['regclosemessage']));
		return false;
	}
	
	$lang = lang('plugin/guests');
	$guests_usernamelen = dstrlen($guests_username);
	if ($guests_username == '') {
		echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA['.$lang['username_not_null'].']]></root>';
		return false;
	}
	if ($guests_password == '') {
		echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA['.$lang['password_not_null'].']]></root>';
		return false;
	}
	if($guests_usernamelen < 3) {
		showmessage('profile_username_tooshort');
		return false;
	} elseif($guests_usernamelen > 15) {
		showmessage('profile_username_toolong');
		return false;
	}
	$censorexp = '/^('.str_replace(array('\\*', "\r\n", ' '), array('.*', '|', ''), preg_quote(($setting['censoruser'] = trim($setting['censoruser'])), '/')).')$/i';
	if($setting['censoruser'] && @preg_match($censorexp, $guests_username)) {
		showmessage('profile_username_protect');
		return false;
	}
	if($setting['pwlength']) {
		if (strlen($guests_password) < $setting['pwlength']) {
			showmessage('profile_password_tooshort', '', array('pwlength' => $setting['pwlength']));
			return false;
		}
	}	
	if(!$guests_password || $guests_password != addslashes($guests_password)) {
		showmessage('profile_passwd_illegal');
		return false;
	}
	
	if (!check_reg_ip($guests_clientip)) {
		echo '<?xml version="1.0" encoding="'.CHARSET.'"?><root><![CDATA['.$lang['user_count_of_ip_over_limit'].']]></root>';
		return false;
	}
	
	loaducenter();
	$username = addslashes(trim(dstripslashes($guests_username)));
	if(uc_get_user($username) && !DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='$username'")) {
		showmessage('profile_username_duplicate');
	}
	
	$questionid = 0;
	$answer = '';
	$email = mt_rand(100000, 99999999999).'@qq.com';
	$guests_uid = uc_user_register($username, $guests_password, $email, $questionid, $answer, $guests_clientip);
	if($guests_uid <= 0) {
		if($guests_uid == -1) {
			showmessage('profile_username_illegal');
		} elseif($guests_uid == -2) {
			showmessage('profile_username_protect');
		} elseif($guests_uid == -3) {
			showmessage('profile_username_duplicate');
		} elseif($guests_uid == -4) {
			showmessage('profile_email_illegal');
		} elseif($guests_uid == -5) {
			showmessage('profile_email_domain_illegal');
		} elseif($guests_uid == -6) {
			showmessage('profile_email_duplicate');
		} else {
			showmessage('undefined_action');
		}
	}
	if ($guests_uid <= 0) {
		showmessage('undefined_action');
	}
	
	if (!empty($guests_setting['groupid'])) {
		$guests_gid = $guests_setting['groupid'];
	} else {
		$guests_gid = $setting['newusergroupid'];
	}
	
	$credits = explode(',', $setting['initcredits']);
	$profile = array();
	$profile['uid'] = $guests_uid;
	$base = array(
		'uid' => $guests_uid,
		'username' => $guests_username,
		'adminid' => 0,
		'groupid' => intval($guests_gid),
		'regdate' => TIMESTAMP,
		'email' => $email,
		'emailstatus' => $guests_setting['emailstatus'],
		'credits' => intval($credits[0]),
		'timeoffset' => 9999
	);
	$status = array(
		'uid' => $guests_uid,
		'regip' => (string)$guests_clientip,
		'lastip' => (string)$guests_clientip,
		'lastvisit' => TIMESTAMP,
		'lastactivity' => TIMESTAMP,
		'lastpost' => 0,
		'lastsendmail' => 0
	);
	$count = array(
		'uid' => $guests_uid,
		'extcredits1' => intval($credits[1]),
		'extcredits2' => intval($credits[2]),
		'extcredits3' => intval($credits[3]),
		'extcredits4' => intval($credits[4]),
		'extcredits5' => intval($credits[5]),
		'extcredits6' => intval($credits[6]),
		'extcredits7' => intval($credits[7]),
		'extcredits8' => intval($credits[8])
	);
	$ext = array('uid' => $guests_uid);
	
	DB::insert('common_member', $base, false, true);
	DB::insert('common_member_status', $status, false, true);
	DB::insert('common_member_count', $count, false, true);
	DB::insert('common_member_profile', $profile, false, true);
	DB::insert('common_member_field_forum', $ext, false, true);
	DB::insert('common_member_field_home', $ext, false, true);
	manyoulog('user', $guests_uid, 'add');
	
	$referer = dreferer();
	DB::insert('plugin_guests_members', array(
		'uid' => $guests_uid,
		'ip' => $guests_clientip,
		'ctime' => date('Y-m-d H:i:s', TIMESTAMP),
		'referer' => $referer,
	));
	
	update_reg_ip($guests_clientip);
	include_once libfile('function/cache');
	updatecache('userstats');

	return true;
}

function check_reg_ip($ip)
{
	global $guests_setting;
	
	if ($guests_setting['user_count_of_ip'] == 0) {
		return true;
	}
	
	if (!$ip) {
		return true;
	}
	
	$res = DB::fetch_first('SELECT reg_count,reg_time FROM '.DB::table('plugin_guests')." WHERE ip = '{$ip}'");
	if (!$res || !$res['reg_time']) {
		return true;
	}
	
	$today = strtotime(date('Y-m-d'));
	$tomorrow = strtotime(date("Y-m-d",strtotime("+1 day")));
	$reg_time = strtotime($res['reg_time']);
	
	if (($reg_time >= $today && $reg_time < $tomorrow && $res['reg_count'] < $guests_setting['user_count_of_ip'])
		|| (time() - $reg_time >= 86400)) {
		return true;
	}
	
	return false;
}

function update_reg_ip($ip)
{
	if (!$ip) {
		return;
	}
	
	$res = DB::fetch_first('SELECT reg_count,reg_time FROM '.DB::table('plugin_guests')." WHERE ip = '{$ip}'");
	if (!$res || !isset($res['reg_count']) || !isset($res['reg_time'])) {
		return;
	}
	
	if (date('j') - date('j', strtotime($res['reg_time'])) >= 1) {
		DB::update('plugin_guests', 
			array('reg_count' => 1, 'reg_time' => date('Y-m-d H:i:s', TIMESTAMP)), 
			array('ip' => $ip)
		);
	} else {
		DB::update('plugin_guests', 
			array('reg_count' => $res['reg_count']+1, 'reg_time' => date('Y-m-d H:i:s', TIMESTAMP)), 
			array('ip' => $ip)
		);
	}
}

function guests_do_login()
{
	global $guests_uid, $guests_gid, $guests_username, $guests_password;

	include_once libfile('function/member');
	include_once libfile('function/stat');
	setloginstatus(array(
		'uid' => $guests_uid,
		'username' => $guests_username,
		'groupid' => $guests_gid,
	), 0);
	updatestat('register');

	return true;
}
?>
