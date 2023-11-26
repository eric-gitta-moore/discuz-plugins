<?php

/**
 * Www.침혹걸.Vip 
 *
 * [침혹걸!] (C)2014-2017 www.moqu8.com.  By www-침혹걸-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class x_notice_module {

	public static function to_notice($arr) {//echo '<pre>@@@';print_r($arr);
		//global $_G;
		$notice = trim($arr[1]);
		if (!$notice) return '';
		$uids = explode('=', trim($arr[0]));//1=2=3
		foreach ($uids as $uid) {
			$uid = intval($uid);
			if ($uid <1) continue;
			notification_add($uid, 'system', $notice);
		}
	}

	public static function to_email($arr) {
		global $_G;
		$email = trim($arr[0]) ? trim($arr[0]) : $_G['member']['email'];
		$subject = trim($arr[1]);
		$message = trim($arr[2]);
		$suc = sendmail($email, $subject, $message);
		return $suc;
	}

	public static function to_sendpm($arr) {
		require_once libfile('function/editor');
		$message = html2bbcode($arr[1]);
		if (!$message) return '';
		$subject = trim($arr[2]);
		
		$fromid = '';
		$replypmid = 0;
		$isusername = 0;
		$type = 0;
		$uids = explode('=', trim($arr[0]));//1=2=3
		foreach ($uids as $toid) {
			$toid = intval($toid);
			if ($toid <1) continue;
			sendpm($toid, $subject, $message, $fromid, $replypmid, $isusername, $type);
		}
	}
	

}







