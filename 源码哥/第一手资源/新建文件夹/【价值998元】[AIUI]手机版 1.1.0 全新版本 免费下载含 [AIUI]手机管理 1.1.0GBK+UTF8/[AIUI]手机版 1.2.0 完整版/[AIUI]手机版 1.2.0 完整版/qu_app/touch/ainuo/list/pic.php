<?php

/**
 *      (C)2010-2020 ainuo.
 *
 *      $QQ QQÈº£º550494646 2017-03 ainuo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$arr = array();
$thread['pic'] = '';
$tid = intval($thread['tid']);
$tableid = getattachtableid($tid);
$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
$message = $post['message'];
if($thread['attachment'] == 2){
	$thread['url'] = DB::result_first("SELECT attachment FROM ".DB::table('forum_attachment_'.$tableid)." WHERE tid ='$tid'");
	
	$thread['pic'] = 'data/attachment/forum/'.$thread['url'].'';
	
}else{
	preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $message, $matches);					
	if(!empty($matches) && !empty($matches[1]) && is_array($matches[1])){
		foreach($matches[1] as $src){
			$arr[] = array('src' => $src, 'type' => 'img');
		}
	}
	if($arr[0]['src']){
		$thread['pic'] = $arr[0]['src'];
	}else{
		$thread['pic'] = '';
	}
}

?>