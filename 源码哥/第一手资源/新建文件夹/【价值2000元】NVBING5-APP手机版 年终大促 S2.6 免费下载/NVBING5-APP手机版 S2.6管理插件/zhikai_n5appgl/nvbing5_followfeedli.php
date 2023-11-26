<?php
function followfeedli_fun1($thread){
	global $_G,$n5app;
	$thread['groupid'] = DB::result_first('SELECT groupid FROM '.DB::table('common_member').' WHERE uid = '.$thread['authorid'] );
	return $thread['groupid'];
}
function followfeedli_fun2($feed){
	global $_G,$n5app;
	if($_G['cache']['usergender'][$feed['uid']]['gender'] == $n5app['lang']['lang001']){
		echo '<i class="iconfont icon-n5appnan qx_nan"></i>';
	}elseif($_G['cache']['usergender'][$feed['uid']]['gender'] == $n5app['lang']['lang002']){
		echo '<i class="iconfont icon-n5appnv qx_nv"></i>';
	}//Fro m www.xhkj5.com
}
?>