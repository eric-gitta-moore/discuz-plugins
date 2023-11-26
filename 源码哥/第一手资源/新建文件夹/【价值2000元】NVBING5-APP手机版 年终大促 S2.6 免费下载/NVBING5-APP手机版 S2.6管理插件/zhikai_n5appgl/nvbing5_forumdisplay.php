<?php
function forumdisplay_fun1(){
	global $_G,$n5app;
	return DB::fetch_first("SELECT * FROM  ".DB::table('home_favorite')." WHERE  uid=".$_G['uid']." and `idtype`='fid' and id=".$_G[fid]."");
}
function forumdisplay_fun2(){
	global $_G,$n5app,$forumdisplayadd;
	$return = '';
	if(!$_G['forum']['threadsorts']){
		$return .= '<li '.($_GET['filter'] && $_GET['orderby'] == 'dateline' && $_GET['filter'] != 'digest' || $_GET['filter'] == 'heat' || $_GET['filter'] == 'digest'?"":($_GET['filter'] != 'typeid'?'class="a"':"") ).'><a href="forum.php?mod=forumdisplay&fid='.$_G['fid'].($_GET['archiveid']?"&archiveid=".$_GET['archiveid']:"").'">'.$n5app['lang']['lang009'].'</a></li>';
		$return .= '<li '.($_GET['filter'] && $_GET['orderby'] == 'dateline' && $_GET['filter'] != 'digest'?'class="a"':'').'><a href="forum.php?mod=forumdisplay&fid='.$_G[fid].'&filter=author&orderby=dateline">'.$n5app['lang']['lang010'].'</a></li> ';
		$return .= '<li '.($_GET['filter'] == 'heat'?'class="a"':'').'><a href="forum.php?mod=forumdisplay&fid='.$_G[fid].'&filter=heat&orderby=heats'.$forumdisplayadd['heat'].($_GET['archiveid']?"&archiveid=".$_GET['archiveid']:"").'">'.$n5app['lang']['lang011'].'</a></li> ';
		$return .= '<li '.($_GET['filter'] == 'digest'?'class="a"':'').'><a href="forum.php?mod=forumdisplay&fid='.$_G[fid].'&filter=digest&digest=1">'.$n5app['lang']['lang012'].'</a></li> ';
	}//From w ww.ymg6.co m
	if($_G['forum']['threadsorts']){
		foreach($_G['forum']['threadsorts']['types'] as $id=>$name){
			$return .= '<li '.( $_GET['sortid'] == $id ?'class="a"':'' ).'><a href="forum.php?mod=forumdisplay&fid='.$_G['fid'].'&filter=sortid&sortid='.$id.$forumdisplayadd['sortid'].'">'.$name.'</a></li>';
		}
	}
	if($_G['forum']['threadtypes'] && !$_G['forum']['threadsorts']){
		foreach($_G['forum']['threadtypes']['types'] as $id=>$name){
			$return .= '<li '.( ($_GET['typeid'] == $id && $_GET['filter'] == 'typeid') ?'class="a"':'' ).'><a href="forum.php?mod=forumdisplay&fid='.$_G['fid'].'&filter=typeid&typeid='.$id.$forumdisplayadd['typeid'].'">'.$name.'</a></li>';
		}
	}
	echo $return;
}
function forumdisplay_fun3(){
	global $_G,$n5app;
	if($_G['forum']['threadtypes']){
		echo '<div class="ztfl_ycgd"><span></span></div>';
	}
}
function forumdisplay_fun4($thread){
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
function forumdisplay_fun5($thread){
	global $_G,$n5app;
	$thread['groupid'] = DB::result_first('SELECT groupid FROM '.DB::table('common_member').' WHERE uid = '.$thread['authorid'] );
	return $thread['groupid'];
}
function forumdisplay_fun6($thread){
	global $_G,$n5app;
	if($_G['cache']['usergender'][$thread['authorid']]['gender'] == $n5app['lang']['lang001']){
		echo '<i class="iconfont icon-n5appnan qx_nan"></i>';
	}elseif($_G['cache']['usergender'][$thread['authorid']]['gender'] == $n5app['lang']['lang002']){
		echo '<i class="iconfont icon-n5appnv qx_nv"></i>';
	}
}
function forumdisplay_fun7($thread,$xlmm_tp){
	global $_G,$n5app;
	if($xlmm_tp ==1){
		$length = 95;
	}elseif($xlmm_tp ==0 || $xlmm_tp >=2){
		$length = 82;
	}//Fr om www.ym g6.com
	require_once libfile('function/post');
	$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);
	$post['message'] = trim(messagecutstr($post['message'], $length));
	$xlmm_tp = $xlmm_tp>3?3:$xlmm_tp;
	if(in_array($xlmm_tp,array(1,2,3))){
		$threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. $xlmm_tp );
	}
	$return['post'] = $post;
	$return['threadtable'] = $threadtable;
	return $return;
}
function forumdisplay_fun8(){
	global $_G,$n5app;
	return $_G['forum_threadcount'];
}
?>