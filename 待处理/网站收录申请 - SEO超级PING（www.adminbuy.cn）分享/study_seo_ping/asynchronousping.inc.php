<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once libfile('function_core', 'plugin/st'.'udy_seo_pi'.'ng');
$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
$ping_range = (array)unserialize($splugin_setting['ping_range']);
if($_GET['tid']){
		if(in_array('forum', $ping_range)){
				if($splugin_setting['ping_way'] == 3){
						$tid = intval($_GET['tid']);
						if($tid){
								$pinginfo = DB::fetch_first("SELECT * FROM ".DB::table('study_seo_ping')." WHERE tid='$tid' ORDER BY id DESC");
								if(empty($pinginfo)){
										$pinginfo = DB::fetch_first("SELECT authorid as uid,fid FROM ".DB::table('forum_thread')." WHERE tid='$tid' ORDER BY tid DESC");
										$study_fids = (array)unserialize($splugin_setting['study_fids']);
										if(!in_array($pinginfo['fid'], $study_fids)){
												exit;
										}
								}
								if(($pinginfo['uid'] && $pinginfo['uid'] == $_G['uid']) || ($splugin_setting['asyping_condition'] == 2 && in_array($_G['adminid'], array(1,2,3))) || $splugin_setting['asyping_condition'] == 3){
										if(!$pinginfo['baidu'] && !$pinginfo['google']){
												superping_thread_run(array('tid' => $tid));
										}
								}
						}
				}
		}
}elseif($_GET['aid']){
		if(in_array('portal', $ping_range)){
				$aid = intval($_GET['aid']);
				if($aid){
						$pinginfo = DB::fetch_first("SELECT * FROM ".DB::table('study_seo_ping_article')." WHERE aid='$aid' ORDER BY id DESC");
						if(empty($pinginfo)){
								$pinginfo = DB::fetch_first("SELECT * FROM ".DB::table('portal_article_count')." WHERE aid='$aid' ORDER BY aid DESC");
								if($pinginfo['viewnum'] != 2){
										exit;
								}
								$splugin_setting['portal_nocatid'] = explode(',', $splugin_setting['portal_nocatid']);
								if(in_array($pinginfo['catid'], $splugin_setting['portal_nocatid'])){
										exit;
								}
						}
						if(!$pinginfo['baidu'] && !$pinginfo['google']){
								superping_portal_run(array('aid' => $aid));
						}
				}
		}
}
?>