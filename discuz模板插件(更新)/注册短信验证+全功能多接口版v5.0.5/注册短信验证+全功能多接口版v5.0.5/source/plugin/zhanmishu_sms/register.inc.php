<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';

$sms = new zhanmishu_sms();
$config = $sms->config;

if ($_GET['action'] == 'common') {

    $return['formhash'] = FORMHASH;
    $return['uid'] = $_G['uid'];
    if ($_G['uid']) {
      $return['mobile'] = getuserprofile('mobile');
      if ($return['mobile']) {
        $return['nationcode'] = '';
      }
    }
    $sechash = !isset($sechash) ? 'S'.($_G['inajax'] ? 'A' : '').$_G['sid'] : $sechash.random(3);
    $return['sechash'] = $sechash;
    $return['groupid'] = $_G['groupid'];
    $return['username'] = $_G['username'];
    $return['loginhash'] = 'L'.random(4);
    $return['config']['regsmssec'] = $config['regsmssec'];
    $return['mobilebuttoncolor'] = $config['mobilebuttoncolor'];
    $return['login_html'] = str_replace('{referer}', urlencode(dreferer()), $config['login_html']);
    $return['isquestion'] = $config['isquestion'];
    $return = array_merge($_G['setting']['reginput'],$return,$_G['setting']['seccodedata']);
 

    echo json_encode($sms->auto_to_utf8($return));
    exit;
}else if ($_GET['action'] == 'sendapi') {
  $_GET['mobile'] = trim($_GET['mobile']);
  if ($_GET['key'] !== $config['sendsafekey']) {
    exit('Access Denied');
  }
  if (strlen($_GET['mobile']) == 11 && strpos($_GET['mobile'], '+') === false && substr($_GET['mobile'], 0,1) == '1') {
    $mobile = '+86'.$_GET['mobile'];
    $nationcode = '86';
  }else if (strlen($_GET['mobile']) == 13 && substr($_GET['mobile'], 0,2) == '86') {
    $mobile = '+'.$_GET['mobile'];
  }  else{
    $mobile = $_GET['mobile'];
  }
  $verify = $verify ? $verify : rand(100000,999999);
  $verify = diconv(strval($verify),CHARSET , 'UTF-8');

  $resp = $sms->sendsms(daddslashes($mobile),$verify,$verify);

  if ($resp['code'] == '1') {
    $return = array('success'=>true);
    $return['code'] = $verify;
    echo json_encode($return);
    exit;
  }else{
    $return = array('success'=>false);
    $return['msg'] = $resp['msg'];
    echo json_encode($return);
    exit;
  }

}

// if (!defined('IN_MOBILE')) {
//   dheader("location:member.php?mod=logging&action=login");
//   exit;
// }

ob_clean();
header('Content-type:text/html;charset=utf-8');

include template("zhanmishu_sms:user");
