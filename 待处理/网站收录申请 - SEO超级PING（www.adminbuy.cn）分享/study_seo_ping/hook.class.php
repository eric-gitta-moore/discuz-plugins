<?php

if(!defined('IN_DISCUZ')) {
    exit('');
}
class plugin_study_seo_ping {
		public function global_footerlink(){
				global $_G, $article;
				$return = '';
				if(CURSCRIPT == 'portal'){
						if(CURMODULE == 'view'){
								$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
								$ping_range = (array)unserialize($splugin_setting['ping_range']);
								if(in_array('portal', $ping_range)){
					          if ($article['viewnum']==1) {
												$splugin_setting['portal_nocatid'] = explode(',', $splugin_setting['portal_nocatid']);
												if(!in_array($article['catid'], $splugin_setting['portal_nocatid'])){
														$aid = intval($article['aid']);
														$pinginfo = DB::fetch_first("SELECT * FROM ".DB::table('study_seo_ping_article')." WHERE aid='$aid' ORDER BY id DESC");
														if(!$pinginfo['baidu'] && !$pinginfo['google']){
																$return = '<script src="plugin.php?id=study_seo_ping:asynchronousping&aid='.$aid.'" type="text/javascript"></script>';
														}
												}
										}
								}
						}
				}
				
				return $return;
		}
}

class plugin_study_seo_ping_forum extends plugin_study_seo_ping{
	
		public function post_message($param) {
				global $_G;
				$param = $param['param'];
				if ($param[0] != 'post_newthread_succeed') {
					return;
				}
				$tid = intval($param[2]['tid']);
				$fid = intval($param[2]['fid']);
				$pid = intval($param[2]['pid']);
				if (!$tid || !$pid) {
					return;
				}
				
				$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
				$ping_range = (array)unserialize($splugin_setting['ping_range']);
				if(in_array('forum', $ping_range)){
						require_once libfile('function_core', 'plugin/st'.'udy_seo_pi'.'ng');
						superping_thread_run(array('tid' => $tid, 'fid' => $fid, 'pid' => $pid, 'noping' => $splugin_setting['ping_way'] == 2 ? 0 : 1));
				}
		}
		
		public function viewthread_bottom() {
				global $_G;
				$return = '';
				$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
				$ping_range = (array)unserialize($splugin_setting['ping_range']);
				$study_fids = (array)unserialize($splugin_setting['study_fids']);
				if($_G['page'] == 1 && !$_G['inajax']){
						if(in_array('forum', $ping_range) && in_array($_G['fid'], $study_fids)){
								if($splugin_setting['ping_way'] == 3){
										if(($_G['thread']['authorid'] && $_G['thread']['authorid'] == $_G['uid']) || ($splugin_setting['asyping_condition'] == 2 && in_array($_G['adminid'], array(1,2,3))) || $splugin_setting['asyping_condition'] == 3){
												$tid = intval($_G['tid']);
												$pinginfo = DB::fetch_first("SELECT * FROM ".DB::table('study_seo_ping')." WHERE tid='$tid' ORDER BY id DESC");
												if(!$pinginfo['baidu'] && !$pinginfo['google']){
														$return = '<script src="plugin.php?id=study_seo_ping:asynchronousping&tid='.$_G['thread']['tid'].'" type="text/javascript"></script>';
												}
										}
								}
						}
				}
				return $return;
		}

}

?>