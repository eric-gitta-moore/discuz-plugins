<?php

/**
 * 魔趣吧官网：http://WWW.moqu8.com
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

class x_newthread_module {

	public $sending = false;
	
	public function x_newthread($arr = array()) {
		global $_G;
		//if ($_G['uid'] <=0) return '';
		
		$fid = intval($arr[0]);
		if ($fid <1) return '';
	 	$subject = trim($arr[1]);
		$message = trim($arr[2]);
		if (!$subject || !$message) return '';
		
		$modthread = C::m('forum_thread', $fid);
		$modthread->param = array();
		
		$_G['group']['disablepostctrl'] = 1;//开放权限

		$bfmethods = $afmethods = array();

		$params = array(
		'subject' => $subject,
		'message' => $message,
		'typeid' => 0,
		'sortid' => 0,
		'special' => 0,
		);
		$params['closed'] = $arr[3];

		$publishdate = $_G['timestamp'];

		$params['publishdate'] = $publishdate;

		//$params['sticktopic'] = $_GET['sticktopic'];

		//$params['digest'] = $_GET['addtodigest'];
		//$params['readperm'] = $readperm;
		//$params['isanonymous'] = $_GET['isanonymous'];
		//$params['price'] = $_GET['price'];

		if($special == 1) {


		} elseif($special == 3) {


		} elseif($special == 4) {
		} elseif($special == 5) {


		} elseif($specialextra) {

		//	@include_once DISCUZ_ROOT.'./source/plugin/'.$_G['setting']['threadplugins'][$specialextra]['module'].'.class.php';
		//	$classname = 'threadplugin_'.$specialextra;
		//	if(class_exists($classname) && method_exists($threadpluginclass = new $classname, 'newthread_submit')) {
		//		$threadpluginclass->newthread_submit($_G['fid']);
		//	}
		//	$special = 127;
		//	$params['special'] = 127;
		//	$params['message'] .= chr(0).chr(0).chr(0).$specialextra;

		}

		//$params['typeexpiration'] = $_GET['typeexpiration'];






		//$params['ordertype'] = $_GET['ordertype'];

		//$params['hiddenreplies'] = $_GET['hiddenreplies'];

		$params['allownoticeauthor'] = 0;
		//$params['tags'] = $_GET['tags'];
		//$params['bbcodeoff'] = $_GET['bbcodeoff'];
		//$params['smileyoff'] = $_GET['smileyoff'];
		//$params['parseurloff'] = $_GET['parseurloff'];
		$params['usesig'] = 0;
		//$params['htmlon'] = $_GET['htmlon'];
		$params['geoloc'] = diconv($_GET['geoloc'], 'UTF-8');
		$return = $modthread->newthread($params);
		return $modthread->tid;
		
		
		
		
		
		if($_G['group']['allowimgcontent']) {
			$params['imgcontent'] = $_GET['imgcontent'];
			$params['imgcontentwidth'] = $_G['setting']['imgcontentwidth'] ? intval($_G['setting']['imgcontentwidth']) : 100;
		}

		$params['geoloc'] = diconv($_GET['geoloc'], 'UTF-8');

		if($_GET['rushreply']) {
			$bfmethods[] = array('class' => 'extend_thread_rushreply', 'method' => 'before_newthread');
			$afmethods[] = array('class' => 'extend_thread_rushreply', 'method' => 'after_newthread');
		}

		$bfmethods[] = array('class' => 'extend_thread_replycredit', 'method' => 'before_newthread');
		$afmethods[] = array('class' => 'extend_thread_replycredit', 'method' => 'after_newthread');

		if($sortid) {
			$bfmethods[] = array('class' => 'extend_thread_sort', 'method' => 'before_newthread');
			$afmethods[] = array('class' => 'extend_thread_sort', 'method' => 'after_newthread');
		}
		$bfmethods[] = array('class' => 'extend_thread_allowat', 'method' => 'before_newthread');
		$afmethods[] = array('class' => 'extend_thread_allowat', 'method' => 'after_newthread');
		$afmethods[] = array('class' => 'extend_thread_image', 'method' => 'after_newthread');

		if(!empty($_GET['adddynamic'])) {
			$afmethods[] = array('class' => 'extend_thread_follow', 'method' => 'after_newthread');
		}

		$modthread->attach_before_methods('newthread', $bfmethods);
		$modthread->attach_after_methods('newthread', $afmethods);

		$return = $modthread->newthread($params);
		$tid = $modthread->tid;
		$pid = $modthread->pid;









		dsetcookie('clearUserdata', 'forum');
		if($specialextra) {
			$classname = 'threadplugin_'.$specialextra;
			if(class_exists($classname) && method_exists($threadpluginclass = new $classname, 'newthread_submit_end')) {
				$threadpluginclass->newthread_submit_end($_G['fid'], $modthread->tid);
			}
		}
		if(!$modthread->param('modnewthreads') && !empty($_GET['addfeed'])) {
			$modthread->feed();
		}

		if(!empty($_G['setting']['rewriterule']['forum_viewthread']) && in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
			$returnurl = rewriteoutput('forum_viewthread', 1, '', $modthread->tid, 1, '', $extra);
		} else {
			$returnurl = "forum.php?mod=viewthread&tid={$modthread->tid}&extra=$extra";
		}
		$values = array(
			'fid' => $modthread->forum('fid'), 
			'tid' => $modthread->tid, 
			'pid' => $modthread->pid, 
			'coverimg' => '', 
			'sechash' => !empty($_GET['sechash']) ? $_GET['sechash'] : '');
		//showmessage($return, $returnurl, array_merge($values, (array)$modthread->param('values')), $modthread->param('param'));
		//showmessage($return, $returnurl);
		return $modthread->tid;
	}

}







