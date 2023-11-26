<?php

/**
 *      (C)2010-2020 ainuo.
 *
 *      $QQ QQÈº£º550494646 2017-03 ainuo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT."./source/function/function_post.php");
$f_wordlengh = 200;
$thread['summary'] = DB::result_first('SELECT `message` FROM '.DB::table('forum_post').' WHERE `tid` ='.$thread['tid'].' AND `first` =1');
$thread['summary'] = messagecutstr($thread['summary'],200);
if($thread['summary']){
	$thread['summary'] = '<div class="list_summary cl">'.$thread['summary'].'</div>';
}else{
	$thread['summary'] = '';
}


?>