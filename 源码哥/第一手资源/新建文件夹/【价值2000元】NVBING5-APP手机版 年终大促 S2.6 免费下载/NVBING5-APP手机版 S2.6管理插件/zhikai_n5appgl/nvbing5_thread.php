<?php
function spacethread_fun1($thread){
	global $_G,$n5app;
	include_once libfile('function/post');
	include_once libfile('function/attachment');
	$thread['post'] = C::t('forum_post')->fetch_all_by_tid_position($thread['posttableid'],$thread['tid'],1);
	$thread['post'] = array_shift($thread['post']);
	$xlmm_tp = C::t('forum_attachment_n')->count_image_by_id('tid:'.$thread['post']['tid'], 'pid', $thread['post']['pid']);
	$return['post'] = $thread['post'];
	$return['xlmm_tp'] = $xlmm_tp;
	return $return;
}
function spacethread_fun2($thread){
	global $_G,$n5app;
	$thread['groupid'] = DB::result_first('SELECT groupid FROM '.DB::table('common_member').' WHERE uid = '.$thread['authorid'] );
	return $thread['groupid'];
}//Fro m www.xhkj5.com
function spacethread_fun3($thread){
	global $_G,$n5app;
	if($_G['cache']['usergender'][$thread['authorid']]['gender'] == $n5app['lang']['lang001']){
		echo '<i class="iconfont icon-n5appnan qx_nan"></i>';
	}elseif($_G['cache']['usergender'][$thread['authorid']]['gender'] == $n5app['lang']['lang002']){
		echo '<i class="iconfont icon-n5appnv qx_nv"></i>';
	}
}
function spacethread_fun4($thread,$xlmm_tp){
	global $_G,$n5app;
	if($xlmm_tp ==1){
		$length = 95;
	}elseif($xlmm_tp ==0 || $xlmm_tp >=2){
		$length = 82;
	}
	require_once libfile('function/post');
	$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);
	$post['message'] = trim(messagecutstr($post['message'], $length));
	$xlmm_tp = $xlmm_tp>3?3:$xlmm_tp;
	if(in_array($xlmm_tp,array(1,2,3))){
		$threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. $xlmm_tp );
	}//From ww w.ym g6.com
	$return['post'] = $post;
	$return['threadtable'] = $threadtable;
	return $return;
}
?>