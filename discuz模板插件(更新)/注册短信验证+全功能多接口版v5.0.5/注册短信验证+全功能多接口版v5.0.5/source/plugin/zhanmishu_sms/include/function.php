<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      ะกฒÝธ๙(QQฃบ2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *    	qq:2575163778 $
 */	

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}


function getconfig(){
	global $_G;
	/*www-cgzz8-com*/include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zmssmsconfig.php';

	loadcache('plugin');	
	$config = $_G['cache']['plugin']['zhanmishu_sms'];
	$config['waittime'] = $config['waittime']>0?$config['waittime']:60;
	$config['no_tip_group'] = unserialize($config['no_tip_group']);
	$config['no_limit'] = unserialize($config['no_limit']);
	$config['limit_forums'] = unserialize($config['limit_forums']);
	$config['emailnoticeforum'] = unserialize($config['emailnoticeforum']);
	$config['smsnoticegroups'] = unserialize($config['smsnoticegroups']);
	$config['emailnoticegroups'] = unserialize($config['emailnoticegroups']);
	$config['reply_limit_forums'] = unserialize($config['reply_limit_forums']);
	$config['reply_nolimit_group'] = unserialize($config['reply_nolimit_group']);
	$config['smsnoticeforum'] = unserialize($config['smsnoticeforum']);
	$config['intel_codes'] = zmssmsstrtoarray_tomobile($config['intel_codes'],false);
	$config['intel_codes_json'] = json_encode($config['intel_codes']);

	$config['mobilerule'] = $config['mobilerule'] ? $config['mobilerule'] : "/^0?(13[0-9]|15[0-9]|17[0678]|18[0-9]|14[57])[0-9]{8}$/";
	$config['tip_times'] = $config['tip_times'] ? intval($config['tip_times']) * 60 + 1000 : 1200;
	if (!function_exists('seccheck')) {
		list($config['seccodecheck'], $config['secqaacheck']) = check_seccode('register');
	}else{
		list($config['seccodecheck'], $config['secqaacheck']) = seccheck('register');
	}
	$config['smsconfig'] = $smsconfig;

	return $config;
}



function ismobile_register($mobile){

	if (checkqianfan_exists()) {
		$user = DB::fetch_first('select uid from %t where phone = '.$mobile,array('phonebind'));
		if (!empty($user)) {
			return $user['uid'];
		}
	}
	$user = DB::fetch_first('select uid,mobile from %t where mobile = '.$mobile,array('common_member_profile'));
	if (empty($user)) {
		return false;
	}else{
		return $user['uid'];
	}
}

function getmobilebyuid($uid){
	$user = DB::fetch_first('select uid ,mobile from %t where uid = '.$uid,array('common_member_profile'));
	if (empty($user)) {
		return false;
	}
	$ismobile =verify_mobile_number($user['mobile']);
	if (!$ismobile) {
		return false;
	}
	return $user['mobile'];
}

function getuidbymobile($mobile){
	$verifytype = get_verify_id();
	if (!$verifytype) {
		return false;
	}

	if (checkqianfan_exists()) {
		$user = DB::fetch_first('select uid from %t where phone = '.$mobile,array('phonebind'));
		if (!empty($user)) {
			return $user['uid'];
		}
	}

	$users = DB::fetch_all('select uid from %t where mobile = '.$mobile,array('common_member_profile'),'uid');
	if (empty($users)) {
		return false;
	}
	if (count($users) == 1) {
		$user = current($users);
		return $user['uid'];
	}
	if (count($users) > 1) {
		$uids = array_keys($users);
		$uids = implode(',', $uids);
		$where = ' where uid in ('.$uids.') and verify'.$verifytype.' = 1';
		$user = DB::fetch_first('select * from %t '.$where,array('common_member_verify'));
		return $user['uid'];
	}

	return false;
}

function checkqianfan_exists(){
	$table = DB::table('phonebind');
	$count = DB::fetch_first("show tables like '".$table."'");

	if (!empty($count)) {
		return true;
	}
	return false;
}

function verify_mobile_number($mobile){
	$config = &  getconfig();

	$preg = $config['mobilerule'];
	if (!preg_match($preg, $mobile)) {
		return false;
	}
	return true;
}
function verify_ip_check($ip){  
 	if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip))  {  
		return 1;  
	}else{  
		return 0;  
	}  
}  
function checkusernameexists($username){
	$user = DB::fetch_first('select uid,username from %t where username = '.$username,array('common_member'));
	if (empty($user)) {
		return false;
	}
	return true;
}
function getuidbyverifymobile($mobile){
	$verifytype = get_verify_id();
	if (!$verifytype) {
		return false;
	}

	$user = DB::fetch_first('select p.mobile,p.uid,v.verify'.$verifytype.' from '.DB::table("common_member_verify").' v left join '.DB::table("common_member_profile").' p on p.uid = v.uid having v.verify'.$verifytype.' =1 and p.mobile='.$mobile);
	return isset($user['uid'])?$user['uid']:false;
}

function ispost_check(){
	global $_G;
	$verifytype = get_verify_id();
	if (!$verifytype) {
		return false;
	}
	$info = get_member_verify_info($_G['uid'],$verifytype);
	$config = getconfig();
	$isvid = check_user_isverify();

	if ($isvid || empty($config['limit_forums']) || !in_array($_GET['fid'], $config['limit_forums']) || !$config['post_verify'] || empty($config['no_limit']) || (!empty($config['no_limit']) && in_array($_G['groupid'], $config['no_limit']))) {
		return false;
	}
	if ($_GET['mod'] == 'post' && CURSCRIPT =='forum' && $_GET['action'] =='newthread' && $_GET['fid']) {
		return true;
	}

	if ($_G['uid'] && $config['force_verisy'] && !in_array($_G['groupid'], $config['no_tip_group'])) {
		return true;
	}

	
	return false;
}

function isreply_check($isallget=false,$isnoaction=false){
	global $_G,$postlist;
	if (!$_GET['fid'] && !empty($postlist)) {
		$t = current($postlist);
		$_GET['fid'] = $t['fid'];
	}
	$verifytype = get_verify_id();
	if (!$verifytype) {
		return false;
	}
	$info = get_member_verify_info($_G['uid'],$verifytype);
	$config = getconfig();
	$isvid = check_user_isverify();
	if ($isvid || empty($config['reply_limit_forums']) || !in_array($_GET['fid'], $config['reply_limit_forums']) || !$config['reply_verify'] || empty($config['reply_nolimit_group']) || (!empty($config['reply_nolimit_group']) && in_array($_G['groupid'], $config['reply_nolimit_group']))) {

		return false;
	}
	if (($_GET['mod'] == 'post' || $isallget) && CURSCRIPT =='forum' && ($_GET['action'] =='reply' || $isnoaction) && $_GET['fid']) {
		return true;
	}


	return false;
}

function get_verify_setting(){
	$verify = C::t('common_setting')->fetch(array('skey'=>'verify'));
	$verify = unserialize($verify);
	return $verify;
}

function get_verify_id(){
	$config = getconfig();
	if ($config['verifyid']) {
		return $config['verifyid'];
	}

	$verify = get_verify_setting();
	foreach ($verify as $key => $value) {
		if (isset($value['field']['mobile'])) {
		    $verify_id = $key;
			break;
		}
	}
	return $verify_id;
}

function check_verify($verify){
	foreach ($verify as $key => $value) {
		if (is_array($value['field']) && isset($value['field']['mobile']) && isset($value['field']['mobile'])) {
			if ($verify[$key]['available'] == '1') {
				return true;
			}
		}
	}

	return false;
}

function get_member_verify_info($uid,$verifytype,$flag=false){
	global $_G;
	$uid = $uid ? $uid : $_G['uid'];
	$verifytype = $verifytype ? $verifytype : get_verify_id();
	if (!$verifytype) {
		return false;
	}
	if ($flag !== false) {
		$flag = ' and flag = '.$flag;
	}
	$info = DB::fetch_first('select * from %t where verifytype = '.$verifytype.$flag.' and uid ='.$uid,array('common_member_verify_info'));
	$info['field'] = unserialize($info['field']);
	return $info;
}

function get_verify($verify){
	foreach ($verify as $key => $value) {
		if (is_array($value['field']) && count($value['field'] = 1) && isset($value['field']['mobile']) && $value['field']['mobile']=='mobile') {
			$verify_id = $key;
			break;
		}
	}
	if (!isset($verify_id)) {
		foreach ($verify as $key => $value) {
			if (!$value['title'] && !$value['available'] && !$value['icon'] && $key > 0) {
				$verify_id = $key;
				break;
			}
		}
	}

	if (!$verify_id) {
		return false;
	}

	$verify['enabled'] = true;
	$verify[$verify_id]['available'] = '1';
	$verify[$verify_id]['title'] = lang('plugin/zhanmishu_sms', 'mobileverify');
	$verify[$verify_id]['field'] = array('mobile'=>'mobile');
	$verify[$verify_id]['groupid'] = get_groupids();
	return $verify;
}


function check_user_isverify($uid = '',$verifytype = ''){

	global $_G;
	$uid = $uid ? $uid : $_G['uid'];
	$config = getconfig();
	if ($config['iseasy_verisy']) {
		
		if (getmobilebyuid($uid)) {
			return true;
		}

	}
	$verifytype = $verifytype ? $verifytype : get_verify_id();
	if (!$verifytype) {
		return false;
	}
	$user = DB::fetch_first('select * from %t where uid = '.$uid.' and verify'.$verifytype.' = 1',array('common_member_verify'));

	if (empty($user)) {
		return false;
	}else{
		return true;
	}
}

function get_groupids(){
	$groupids = DB::fetch_all('select groupid from %t',array('common_usergroup'),'groupid');
	return array_keys($groupids);
}



function zmssmsstrtoarray_tomobile($str,$isCheckMobile=true){
	$str = str_replace(array("\r\n", "\r", "\n"), '####', $str);
	$str = str_replace('########', '####', $str);
	$arr = array();
	$arr = explode('####', $str);
	$arr = array_unique($arr);
	foreach ($arr as $key => $value) {
		$ismobile = $isCheckMobile ? verify_mobile_number($value) : true;
		if (!$value || !$ismobile) {
			unset($arr[$key]);
		}
	}
	return $arr;
}

//From:www_caogen8_co
?>