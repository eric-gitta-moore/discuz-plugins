<?php

/**
 * Www.魔趣吧.Vip 
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class x_editpost_module {

	public function x_editpost($arr = array()) {
		global $_G;
		//if ($_G['uid'] <=0) return '';

		$tid = intval($arr[0]);
		$pid = intval($arr[1]);
		if ($tid <1 || $pid <1) return '';
		$subject = trim($arr[2]);
		$message = trim($arr[3]);
		if (!$message) return '';
		
		$modpost = C::m('forum_post', $tid, $pid);

		$_G['group']['disablepostctrl'] = 1;//开放权限
		$modpost->setting = array('editedby' => 0) + $modpost->setting;//关闭编辑日志

		//$modpost->param('redirecturl', "forum.php?mod=viewthread&tid=$tid#pid$pid");

		$param = array(
			'subject' => $subject,
			'message' => $message,
		/*'special' => $special,
			'sortid' => $sortid,
			'typeid' => $typeid,
			'isanonymous' => $isanonymous,

			'cronpublish' => $_GET['cronpublish'],
			'cronpublishdate' => $_GET['cronpublishdate'],
			'save' => $_GET['save'],

			'readperm' => $readperm,
			'price' => $_GET['price'],

			'ordertype' => $_GET['ordertype'],
			'hiddenreplies' => $_GET['hiddenreplies'],
			'allownoticeauthor' => $_GET['allownoticeauthor'],

			'audit' => $_GET['audit'],

			'tags' => $_GET['tags'],

			'bbcodeoff' => $_GET['bbcodeoff'],
			'smileyoff' => $_GET['smileyoff'],
			'parseurloff' => $_GET['parseurloff'],
			'usesig' => $_GET['usesig'],
			'htmlon' => $_GET['htmlon'],

			'extramessage' => $extramessage,*/
		);

		$modpost->editpost($param);

		if($_G['forum']['threadcaches']) {
			deletethreadcaches($tid);
		}

		dsetcookie('clearUserdata', 'forum');

		return TRUE;
	}

}







