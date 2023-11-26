<?php

/**
 *      (C)2010-2020 ainuo.
 *
 *      $QQ QQÈº£º550494646 2017-03 ainuo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$thread['pic'] = '';
$thumbtype = 'fixwr';
$numcount = 0;
$thread['afirst'] = 0;
$thread['first'] = 0;
$thread['cnt'] = 0;
$tid = intval($thread['tid']);
$tableid = getattachtableid($tid);
$countquery = DB::query("SELECT * FROM ".DB::table('forum_attachment_'.$tableid)." WHERE tid ='$tid' and isimage=1 ORDER BY aid ASC LIMIT 9");
while ($countattach = DB::fetch($countquery)) {
	$thread['afirst'] = DB::result_first("SELECT first FROM ".DB::table('forum_post')." WHERE pid ='$countattach[pid]'");
	if($thread['afirst'] || $thread['special'] == 2){
		$numcount++;
	}
}

$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
$message = $post['message'];
$matches = array();
$arr = array();
preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $message, $matches);					
if(!empty($matches) && !empty($matches[1]) && is_array($matches[1])){
	foreach($matches[1] as $src){
		$arr[] = array('src' => $src, 'type' => 'img');
	}
}//Form  www.moq u8.com
$numcount = $numcount + count($arr);
if($numcount == 1){
	$anwidth = 420;
	$anheight = 220;
	$picheight = '180px';
}elseif($numcount == 2){
	$anwidth = 300;
	$anheight = 220;
	$picheight = '140px';
}else{
	$anwidth = 220;
	$anheight = 200;
	$picheight = '90px';
}
$thread['pic'] = '<div class="list_pic listpic_'.$numcount.' cl" style="margin-bottom:5px;">';

$query = DB::query("SELECT * FROM ".DB::table('forum_attachment_'.$tableid)." WHERE tid ='$tid' and isimage=1 ORDER BY aid ASC LIMIT 9");
	while ($attach = DB::fetch($query)) {
		$thread['first'] = DB::result_first("SELECT first FROM ".DB::table('forum_post')." WHERE pid ='$attach[pid]'");
		if($thread['first'] || $thread['special'] == 2){
			$thread['cnt']++;
			$filename = getforumimg($attach['aid'],0,$anwidth,$anheight);
			$thread['pic'] .= '<div class="list_thumb" data-original="'.$filename.'" style="background:url('.$filename.') no-repeat center center;background-size:cover;height:'.$picheight.';"></div>';
		}
	}

foreach($arr as $num => $item){
	if($thread['cnt']<9){
		$src = $item['src'];
		$thread['cnt']++;
		$thread['pic'] .= '<div class="list_thumb list_thumb_'.$thread['cnt'].'" data-original="'.$src.'" style="background:url('.$src.') no-repeat center center;background-size:cover;height:'.$picheight.';"></div>';
		
	}else{
		break;
	}
	
}
$thread['pic'] .= '</div>';




?>