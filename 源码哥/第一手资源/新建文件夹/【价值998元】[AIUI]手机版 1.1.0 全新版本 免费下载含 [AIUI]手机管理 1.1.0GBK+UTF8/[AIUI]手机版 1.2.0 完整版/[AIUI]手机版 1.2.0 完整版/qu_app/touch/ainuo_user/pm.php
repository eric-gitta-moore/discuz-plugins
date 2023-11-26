<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_pm.php 35056 2014-11-03 08:01:19Z hypowang $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$pmid = empty($_GET['pmid'])?0:floatval($_GET['pmid']);
$uid = empty($_GET['uid'])?0:intval($_GET['uid']);
$plid = empty($_GET['plid'])?0:intval($_GET['plid']);
$opactives['pm'] = 'class="a"';

$daterange = empty($_GET['daterange'])?1:intval($_GET['daterange']);

loaducenter();

if($_GET['subop'] == 'view') {

	$msgonly = empty($_GET['msgonly']) ? 0 : intval($_GET['msgonly']);
	$touid = empty($_GET['touid']) ? 0: intval($_GET['touid']);
	$daterange = empty($_GET['daterange']) ? 30 : intval($_GET['daterange']);
	$result = uc_pm_view($_G['uid'], 0, $touid, $daterange, 0, 0, 0, 0);
	$msglist = array();
	$msguser = $messageappend = '';
	$online = 0;
	foreach($result as $key => $value) {
		if($value['authorid'] != $_G['uid']) {
			$msguser = $value['author'];
		}
		$daykey = dgmdate($value['dateline'], 'Y-m-d');
		$msglist[$daykey][$key] = $value;
	}
	if($touid && empty($msguser)) {
		$member = getuserbyuid($touid);
		$msguser = $member['username'];
	}
	if(!$msgonly) {
		$online = C::app()->session->fetch_by_uid($touid) ? 1 : 0;
		if($_G['member']['newpm']) {
			$newpm = setstatus(1, 0, $_G['member']['newpm']);
			C::t('common_member')->update($_G['uid'], array('newpm' => $newpm));
			uc_pm_ignore($_G['uid']);
		}
	}
	if(!empty($_GET['tradeid'])) {
		$trade = C::t('forum_trade')->fetch_goods(0, $_GET['tradeid']);
		if($trade) {
			$messageappend = dhtmlspecialchars('[url='.$_G['siteurl'].'forum.php?mod=viewthread&tid='.$trade['tid'].'&do=tradeinfo&pid='.$trade['pid'].'][b]'.$trade['subject'].'[/b][/url]');
		}
	} elseif(!empty($_GET['commentid'])) {
		$comment = C::t('forum_postcomment')->fetch($_GET['commentid']);
		if($comment) {
			$comment['comment'] = str_replace(array('[b]', '[/b]', '[/color]'), array(''), preg_replace("/\[color=([#\w]+?)\]/i", '', strip_tags($comment['comment'])));
			$messageappend = dhtmlspecialchars('[url='.$_G['siteurl'].'forum.php?mod=redirect&goto=findpost&pid='.$comment['pid'].'&ptid='.$comment['tid'].'][b]'.lang('spacecp', 'pm_comment').'[/b][/url][quote]'.$comment['comment'].'[/quote]');
		}
	} elseif(!empty($_GET['tid']) && !empty($_GET['pid'])) {
		$thread = C::t('forum_thread')->fetch($_GET['tid']);
		if($thread) {
			$messageappend = dhtmlspecialchars('[url='.$_G['siteurl'].'forum.php?mod=redirect&goto=findpost&pid='.intval($_GET['pid']).'&ptid='.$thread['tid'].'][b]'.lang('spacecp', 'pm_thread_about', array('subject' => $thread['subject'])).'[/b][/url]');
		}
	}

}
if($_GET['talk'] == 'all') {
	$talklist = array();
	$type = $_GET['type'];
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
			$ols = array();
			$perpage = 10;
			$perpage = mob_perpage($perpage);
			$member = getuserbyuid($touid);
				$tousername = $member['username'];
				unset($member);
				$count = uc_pm_view_num($_G['uid'], $touid, 0);
				if(!$page) {
					$page = ceil($count/$perpage);
				}
				$talklist = uc_pm_view($_G['uid'], 0, $touid, 10, ceil($count/$perpage)-$page+1, $perpage, 0, 0);
				$multipage = multi($count, $perpage, $page, "home.php?mod=space&do=pm&subop=view&touid=$touid&talk=all");
		$founderuid = empty($talklist)?0:$talklist[0]['founderuid'];
		$pmid = empty($talklist)?0:$talklist[0]['pmid'];


}
?>