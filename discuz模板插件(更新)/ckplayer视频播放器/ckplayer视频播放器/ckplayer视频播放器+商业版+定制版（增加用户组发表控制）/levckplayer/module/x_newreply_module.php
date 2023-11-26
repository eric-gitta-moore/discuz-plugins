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

class x_newreply_module {

	public static function x_newreply($arr = array()) {
		global $_G;
		//if ($_G['uid'] <=0) return '';
		$tid = intval($arr[0]);
		if ($tid <1) return '';
		$subject = trim($arr[1]);
		$message = trim($arr[2]);
		if (!$message) return '';


		$modpost = C::m('forum_post', $tid);
		//$member = DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid=2");
		//$modpost->member = $member + $modpost->member;//print_r($modpost->member);exit();
		$_G['group']['disablepostctrl'] = 1;
		$modpost->thread = array('closed'=>0) + $modpost->thread;
		$bfmethods = $afmethods = array();


		$params = array(
		'subject' => $subject,
		'message' => $message,
		'special' => 0,
		//'extramessage' => $extramessage,
		//'bbcodeoff' => $_GET['bbcodeoff'],
		//'smileyoff' => $_GET['smileyoff'],
		//'htmlon' => $_GET['htmlon'],
		//'parseurloff' => $_GET['parseurloff'],
		'usesig' => 0,
		'isanonymous' => 0,
		//'noticetrimstr' => $_GET['noticetrimstr'],
		'noticeauthor' => $_GET['noticeauthor'],
		//'from' => $_GET['from'],
		//'sechash' => $_GET['sechash'],
		//'geoloc' => diconv($_GET['geoloc'], 'UTF-8'),
		);


		if(!empty($_GET['trade']) && $thread['special'] == 2 && $_G['group']['allowposttrade']) {
			$bfmethods[] = array('class' => 'extend_thread_trade', 'method' => 'before_newreply');
		}




		$attentionon = empty($_GET['attention_add']) ? 0 : 1;
		$attentionoff = empty($attention_remove) ? 0 : 1;
		$bfmethods[] = array('class' => 'extend_thread_rushreply', 'method' => 'before_newreply');
		if($_G['group']['allowat']) {
			$bfmethods[] = array('class' => 'extend_thread_allowat', 'method' => 'before_newreply');
		}

		$bfmethods[] = array('class' => 'extend_thread_comment', 'method' => 'before_newreply');
		$modpost->attach_before_method('newreply', array('class' => 'extend_thread_filter', 'method' => 'before_newreply'));



		if($_G['group']['allowat']) {
			$afmethods[] = array('class' => 'extend_thread_allowat', 'method' => 'after_newreply');
		}


		$afmethods[] = array('class' => 'extend_thread_rushreply', 'method' => 'after_newreply');



		$afmethods[] = array('class' => 'extend_thread_comment', 'method' => 'after_newreply');



		if(helper_access::check_module('follow') && !empty($_GET['adddynamic'])) {
			$afmethods[] = array('class' => 'extend_thread_follow', 'method' => 'after_newreply');
		}


		if($thread['replycredit'] > 0 && $thread['authorid'] != $_G['uid'] && $_G['uid']) {
			$afmethods[] = array('class' => 'extend_thread_replycredit', 'method' => 'after_newreply');
		}


		if($special == 5) {
			$afmethods[] = array('class' => 'extend_thread_debate', 'method' => 'after_newreply');
		}



		$afmethods[] = array('class' => 'extend_thread_image', 'method' => 'after_newreply');



		if($special == 2 && $_G['group']['allowposttrade'] && $thread['authorid'] == $_G['uid']) {
			$afmethods[] = array('class' => 'extend_thread_trade', 'method' => 'after_newreply');
		}
		$afmethods[] = array('class' => 'extend_thread_filter', 'method' => 'after_newreply');





		if($_G['forum']['allowfeed']) {
			if($special == 2 && !empty($_GET['trade'])) {
				$modpost->attach_before_method('replyfeed', array('class' => 'extend_thread_trade', 'method' => 'before_replyfeed'));
				$modpost->attach_after_method('replyfeed', array('class' => 'extend_thread_trade', 'method' => 'after_replyfeed'));
			} elseif($special == 3 && $thread['authorid'] != $_G['uid']) {
				$modpost->attach_before_method('replyfeed', array('class' => 'extend_thread_reward', 'method' => 'before_replyfeed'));
			} elseif($special == 5 && $thread['authorid'] != $_G['uid']) {
				$modpost->attach_before_method('replyfeed', array('class' => 'extend_thread_debate', 'method' => 'before_replyfeed'));
			}
		}




		if(!isset($_GET['addfeed'])) {
			$space = array();
			space_merge($space, 'field_home');
			$_GET['addfeed'] = $space['privacy']['feed']['newreply'];
		}

		$modpost->attach_before_methods('newreply', $bfmethods);
		$modpost->attach_after_methods('newreply', $afmethods);

		$return = $modpost->newreply($params);
		$pid = $modpost->pid;

		if($specialextra) {

			@include_once DISCUZ_ROOT.'./source/plugin/'.$_G['setting']['threadplugins'][$specialextra]['module'].'.class.php';
			$classname = 'threadplugin_'.$specialextra;
			if(class_exists($classname) && method_exists($threadpluginclass = new $classname, 'newreply_submit_end')) {
				$threadpluginclass->newreply_submit_end($_G['fid'], $_G['tid']);
			}

		}

		if($modpost->pid && !$modpost->param('modnewreplies')) {

			if(!empty($_GET['addfeed'])) {
				$modpost->replyfeed();
			}
		}


		if($modpost->param('modnewreplies')) {
			$url = "forum.php?mod=viewthread&tid=".$_G['tid'];
		} else {

			$antitheft = '';
			if(!empty($_G['setting']['antitheft']['allow']) && empty($_G['setting']['antitheft']['disable']['thread']) && empty($_G['forum']['noantitheft'])) {
				$sign = helper_antitheft::get_sign($_G['tid'], 'tid');
				if($sign) {
					$antitheft = '&_dsign='.$sign;
				}
			}

			$url = "forum.php?mod=viewthread&tid=".$_G['tid']."&pid=".$modpost->pid."&page=".$modpost->param('page')."$antitheft&extra=".$extra."#pid".$modpost->pid;
		}

		if(!isset($inspacecpshare)) {
			//showmessage($return , $url, $modpost->param('showmsgparam'));
		}

		return $modpost->pid;
	}

}







