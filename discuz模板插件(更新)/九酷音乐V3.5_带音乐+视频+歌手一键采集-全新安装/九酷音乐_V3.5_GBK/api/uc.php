<?php
/**
 * UCenter Ӧ�ó��򿪷� API Example
 *
 * ���ļ�Ϊ api/uc.php �ļ��Ŀ����������û����� UCenter ֪ͨ��Ӧ�ó��������
 */

define('UC_VERSION', '1.0.0');		//UCenter �汾��ʶ

define('API_DELETEUSER', 1);		//�û�ɾ�� API �ӿڿ���
define('API_RENAMEUSER', 1);		//�û����� API �ӿڿ���
define('API_UPDATEPW', 1);		//�û������� API �ӿڿ���
define('API_GETTAG', 1);		//��ȡ��ǩ API �ӿڿ���
define('API_SYNLOGIN', 1);		//ͬ����¼ API �ӿڿ���
define('API_SYNLOGOUT', 1);		//ͬ���ǳ� API �ӿڿ���
define('API_UPDATEBADWORDS', 1);	//���¹ؼ����б� ����
define('API_UPDATEHOSTS', 1);		//���������������� ����
define('API_UPDATEAPPS', 1);		//����Ӧ���б� ����
define('API_UPDATECLIENT', 1);		//���¿ͻ��˻��� ����
define('API_UPDATECREDIT', 1);		//�����û����� ����
define('API_GETCREDITSETTINGS', 1);	//�� UCenter �ṩ�������� ����
define('API_UPDATECREDITSETTINGS', 1);	//����Ӧ�û������� ����

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

error_reporting(7);

define('UC_CLIENT_ROOT', DISCUZ_ROOT.'./client/');
chdir('../');
require_once './client/ucenter.php';

$code = $_GET['code'];
parse_str(authcode($code, 'DECODE', UC_KEY), $get);
if(MAGIC_QUOTES_GPC) {
	$get = dstripslashes($get);
}

if(time() - $get['time'] > 3600) {
	exit('Authracation has expiried');
}
if(empty($get)) {
	exit('Invalid Request');
}
$action = $get['action'];
$timestamp = time();

if($action == 'test') {

	exit(API_RETURN_SUCCEED);

} elseif($action == 'deleteuser') {

	!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

	//�û�ɾ�� API �ӿ�
	include './include/db_mysql.class.php';
	$db = new dbstuff;
	$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);

	$uids = $get['ids'];
	$query = $db->query("DELETE FROM {$tablepre}members WHERE uid IN ($uids)");

	exit(API_RETURN_SUCCEED);

} elseif($action == 'renameuser') {

	!API_RENAMEUSER && exit(API_RETURN_FORBIDDEN);

	//�û����� API �ӿ�
	$uid = $get['uid'];
	$usernamenew = $get['newusername'];

	$db->query("UPDATE {$tablepre}members SET username='$usernamenew' WHERE uid='$uid'");

	exit(API_RETURN_SUCCEED);

} elseif($action == 'updatepw') {

	!API_UPDATEPW && exit(API_RETURN_FORBIDDEN);

	//�����û�����
	exit(API_RETURN_SUCCEED);

} elseif($action == 'gettag') {

	!API_GETTAG && exit(API_RETURN_FORBIDDEN);

	//��ȡ��ǩ API �ӿ�
	$return = array($name, array());
	echo uc_serialize($return, 1);

} elseif($action == 'synlogin' && $_GET['time'] == $get['time']) {

	!API_SYNLOGIN && exit(API_RETURN_FORBIDDEN);

	//ͬ����¼ API �ӿ�
	include './source/global/global_conn.php';
	global $db;
	if($row = $db->getrow("select cd_id,cd_name,cd_password from ".tname('user')." where cd_lock=0 and cd_ucenter>0 and cd_ucenter=".intval($get['uid']))) {
		$db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".getonlineip()."',cd_logintime='".date('Y-m-d H:i:s')."' where cd_id=".$row['cd_id']);
		$db->query("delete from ".tname('session')." where cd_uid=".$row['cd_id']);
		$db->query("Insert ".tname('session')." (cd_uid,cd_uname,cd_uip,cd_logintime) values (".$row['cd_id'].",'".$row['cd_name']."','".getonlineip()."','".time()."')");
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		setcookie("cd_id",$row['cd_id'],time()+86400,cd_cookiepath);
		setcookie("cd_name",$row['cd_name'],time()+86400,cd_cookiepath);
		setcookie("cd_password",$row['cd_password'],time()+86400,cd_cookiepath);
	}

} elseif($action == 'synlogout') {

	!API_SYNLOGOUT && exit(API_RETURN_FORBIDDEN);

	//ͬ���ǳ� API �ӿ�
	include './source/global/global.php';
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	setcookie("cd_id","",time()-1,cd_cookiepath);
	setcookie("cd_name","",time()-1,cd_cookiepath);
	setcookie("cd_password","",time()-1,cd_cookiepath);

} elseif($action == 'updatebadwords') {

	!API_UPDATEBADWORDS && exit(API_RETURN_FORBIDDEN);

	//���¹ؼ����б�
	exit(API_RETURN_SUCCEED);

} elseif($action == 'updatehosts') {

	!API_UPDATEHOSTS && exit(API_RETURN_FORBIDDEN);

	//����HOST�ļ�
	exit(API_RETURN_SUCCEED);

} elseif($action == 'updateapps') {

	!API_UPDATEAPPS && exit(API_RETURN_FORBIDDEN);

	//����Ӧ���б�
	exit(API_RETURN_SUCCEED);

} elseif($action == 'updateclient') {

	!API_UPDATECLIENT && exit(API_RETURN_FORBIDDEN);

	//���¿ͻ��˻���
	exit(API_RETURN_SUCCEED);

} elseif($action == 'updatecredit') {

	!UPDATECREDIT && exit(API_RETURN_FORBIDDEN);

	//�����û�����
	exit(API_RETURN_SUCCEED);

} elseif($action == 'getcreditsettings') {

	!GETCREDITSETTINGS && exit(API_RETURN_FORBIDDEN);

	//�� UCenter �ṩ��������
	echo uc_serialize($credits);

} elseif($action == 'updatecreditsettings') {

	!API_UPDATECREDITSETTINGS && exit(API_RETURN_FORBIDDEN);

	//����Ӧ�û�������
	exit(API_RETURN_SUCCEED);

} else {

	exit(API_RETURN_FAILED);

}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function dsetcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie($var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function dstripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

function uc_serialize($arr, $htmlon = 0) {
	include_once UC_CLIENT_ROOT.'./lib/xml.class.php';
	return xml_serialize($arr, $htmlon);
}

function uc_unserialize($s) {
	include_once UC_CLIENT_ROOT.'./lib/xml.class.php';
	return xml_unserialize($s);
}