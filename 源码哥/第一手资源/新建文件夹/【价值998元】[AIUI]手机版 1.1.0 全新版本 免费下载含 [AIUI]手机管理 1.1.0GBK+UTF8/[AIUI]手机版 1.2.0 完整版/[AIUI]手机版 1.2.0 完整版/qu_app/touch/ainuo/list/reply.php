<?php

/**
 *      (C)2010-2020 ainuo.
 *
 *      $QQ QQÈº£º550494646 2017-06 ainuo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$replylist = array();
$replylist = DB::fetch_all('SELECT * FROM '.DB::table('forum_post').' WHERE tid='.$thread['tid'].' and first != 1 ORDER BY dateline DESC LIMIT 3');
$ainuo_reply = '';
foreach($replylist as $athread){
	$ainuo_reply .= '<p>';
	$ainuo_reply .= '<a href="home.php?mod=space&uid='.$athread['authorid'].'&do=profile" class="aimg">'.$athread['author'].':&nbsp;</a>';
	$ainuo_reply .= messagecutstr($athread['message']);
	$ainuo_reply .= '</p>';
}
?>