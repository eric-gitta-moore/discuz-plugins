<?php
function forumdisplay_fun1(){
	global $_G,$n5app;
	return DB::fetch_first("SELECT * FROM  ".DB::table('home_favorite')." WHERE  uid=".$_G['uid']." and `idtype`='fid' and id=".$_G[fid]."");
}
function viewthread_fun1($post){
	global $_G,$n5app;
	echo '<div class="'.($post[first]?"n5sq_lzys":"n5sq_hfys".(!$post['first'] && $post['rewardfloor']?" n5sq_qzlc":"") ).' cl" id="pid'.$post['pid'].'">';
}
function viewthread_fun2($thread){
	global $_G,$n5app;
	$thread['groupid'] = DB::result_first('SELECT groupid FROM '.DB::table('common_member').' WHERE uid = '.$thread['authorid'] );
	return $thread['groupid'];
}
function viewthread_fun3($thread,$post){
	return $thread['author'] && $post['author'] == $thread['author'] && $post['position'] !== '1';
}//Fr om www.xhkj5.com
function viewthread_fun4($thread){
	global $_G,$n5app;
	if($_G['cache']['usergender'][$thread['authorid']]['gender'] == $n5app['lang']['lang001']){
		echo '<i class="iconfont icon-n5appnan qx_nan"></i>';
	}elseif($_G['cache']['usergender'][$thread['authorid']]['gender'] == $n5app['lang']['lang002']){
		echo '<i class="iconfont icon-n5appnv qx_nv"></i>';
	}
}
function viewthread_fun5($post,$alloweditpost_status, $edittimelimit){
	global $_G,$n5app;
	if( (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit))) ){
		echo '<a class="hdcz_bj" href="forum.php?mod=post&action=edit&fid='.$_G['fid'].'&tid='.$_G['tid'].'&pid='.$post['pid'].(!empty($_GET[modthreadkey])?"}&modthreadkey=".$_GET['modthreadkey']:"").'&page='.$page.'">'.$n5app['lang']['lang013'].'</a>';
	}
}//From w ww.ym g6.com
function viewthread_fun6(){
	global $_G,$n5app,$post;
	return $_G['forum_thread']['special'] == 3 && ($_G['forum']['ismoderator'] && (!$_G['setting']['rewardexpiration'] || $_G['setting']['rewardexpiration'] > 0 && ($_G[timestamp] - $_G['forum_thread']['dateline']) / 86400 > $_G['setting']['rewardexpiration']) || $_G['forum_thread']['authorid'] == $_G['uid']) && $post['authorid'] != $_G['forum_thread']['authorid'] && $post['first'] == 0 && $_G['uid'] != $post['authorid'] && $_G['forum_thread']['price'] > 0;
}
function viewthread_fun7(){
	global $_G,$n5app,$post,$threadsortshow;
	if($post['first']  && $threadsortshow){
		if($threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']){
			if( $threadsortshow['optionlist'] == 'expire'){
				echo $n5app['lang']['lang014'];
			}else{
				echo '<div class="box_ex2 viewsort">'.($threadsortshow['typetemplate']?$threadsortshow['typetemplate']:"").'</div>';
			}
		}
	}
}
function viewthread_fun8(){
	global $_G,$n5app;
	return DB::fetch_first("SELECT * FROM  ".DB::table('home_favorite')." WHERE  uid=".$_G['uid']." and `idtype`='tid' and id=".$_G['tid']."");
}

function checkIsGroup($fid){
	global $_G;
	$info = C::t("forum_forum")->fetch_info_by_fid($fid);
	return $info['status'] == 3 ? true : false;
}
?>