<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$keke_group = $_G['cache']['plugin']['keke_group'];
if(!$_G['uid']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}
include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
$groupid=intval($_GET['groupid']);
$ret=_switchgroup($groupid,$_G['uid']);
$ret['msg']=grogbk2utf($ret['msg']);// f rom  ww w.mo qu8.c om
exit(json_encode(array('state' =>$ret['state'],'msg' =>$ret['msg'])));