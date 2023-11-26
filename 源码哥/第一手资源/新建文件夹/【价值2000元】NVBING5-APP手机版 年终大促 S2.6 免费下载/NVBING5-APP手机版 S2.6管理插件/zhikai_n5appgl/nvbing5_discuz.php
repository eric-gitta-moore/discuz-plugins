<?php
function discuz_fun2($forum_favlist){
	global $_G,$n5app;

	if(!$n5app['onoff_recom']) return '';
	$recomforums = C::t("forum_forum")->fetch_all_info_by_fids($n5app['recomforums']);
	$favlist = array();
	foreach($forum_favlist as $k=>$f){
		$favlist[$f['id']] = $f;
	}//Fro m www.xhkj5.com
	$return = '<div class="bm_c"><div class="n5sq_gzbt cl">'.$n5app['lang']['lang004'].'</div><ul>';
	foreach($recomforums as $key=>$forum){
		if(!$favlist[$forum['fid']]){
			$return .= '<li>';
			$return .= '<a href="forum.php?mod=forumdisplay&fid='.$forum['fid'].'"><img src="'.($forum['icon']?'data/attachment/common/'.$forum['icon']:'template/zhikai_n5app/images/forum.png').'" align="left" alt="'.$forum[name].'" /></a>';
			$return .= '<a href="forum.php?mod=forumdisplay&fid='.$forum['fid'].'" class="btdb">'.$forum['name'].($forum['todayposts'] > 0?"<span>".$forum['todayposts']."</span>":"").'</a>';
			$return .= '<p>'.( empty($forum['redirect'])?$n5app['lang']['lang005'].":".dnumber($forum[threads])." ".$n5app['lang']['lang006'].":".dnumber($forum[posts]):""  ).'</p>';
			$xlmmlk=discuz_fun3($forum['fid']);
					
			$return .= 	'<a href="'.($xlmmlk['id']?'home.php?mod=space&do=favorite&type=forum':'home.php?mod=spacecp&ac=favorite&type=forum&id='.$forum['fid'].'&hash='.FORMHASH).'" class="n5sq_bkgz '.($xlmmlk['id']?"n5sq_bkgzs":($_G['uid']?"dialog":"n5app_wdlts") ).'">'.($xlmmlk['id']?$n5app['lang']['lang007']:"+".$n5app['lang']['lang008']).'</a>';
			$return .= '</li>';
			
		}
	}//F rom www.xhkj5.com
	$return .= '</ul></div>';
	echo $return;
}
function discuz_fun3($fid){
	global $_G,$n5app;
	return DB::fetch_first("SELECT * FROM  ".DB::table('home_favorite')." WHERE  uid=".$_G['uid']." and `idtype`='fid' and id=".$fid."");
}
?>