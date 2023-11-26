<?php

if(!defined('IN_DISCUZ')) {
    exit('');
}

function superping_thread_run($param) {
		global $_G;
		if(!function_exists('curl_init') || !function_exists('curl_exec')) {
			return;
		}

		$tid = intval($param['tid']);
		$fid = intval($param['fid']);
		$pid = intval($param['pid']);
		$thread = $param['thread'];

		$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
		$study_fids = (array)unserialize($splugin_setting['study_fids']);
		if($fid && !in_array($fid, $study_fids)){
			return;
		}
		if(empty($thread)){
				if($pid){//回帖不处理
						$thread = DB::fetch_first("SELECT * FROM ".DB::table('forum_post')." WHERE pid='$pid' AND tid='$tid' AND invisible='0' AND first='1' ORDER BY pid DESC");
				}else{
						$thread = DB::fetch_first("SELECT * FROM ".DB::table('forum_thread')." WHERE tid='$tid' ORDER BY tid DESC");
				}

				if (empty($thread)) {
					return;
				}
		}
		
		if(!in_array($thread['fid'], $study_fids)){
			return;
		}

		$ping_config = array();
		$ping_config['bbsname'] = $_G['setting']['bbname'];
		$ping_config['siteurl'] = $_G['siteurl'];

		$ping_config['threadurl'] = $_G['siteurl'].(@in_array('forum_viewthread', $_G['setting']['rewritestatus']) ? rewriteoutput('forum_viewthread', 1, '', $tid, 1, '', '') : 'forum.php?mod=viewthread&tid='.$tid);
		if($splugin_setting['study_zdy_rewrite'] && $splugin_setting['study_rewrite']){
				$fid = empty($_G['setting']['forumkeys'][$thread['fid']]) ? $thread['fid'] : $_G['setting']['forumkeys'][$thread['fid']];
				$splugin_setting['rewritecompatible'] && $thread['subject'] = rawurlencode($thread['subject']);
				$ping_config['threadurl'] = $_G['siteurl'].str_replace(array('{tid}', '{fid}', '{subject}'), array($tid, $fid, $thread['subject']), $splugin_setting['study_rewrite']);
		}
		$ping_config['rssurl'] = $_G['siteurl'].'forum.php?mod=rss&fid='.$fid;

		$ping_type = (array)unserialize($splugin_setting['ping_type']);

		$baidustatus = $googlestatus = 0;
		
		if(!$param['noping']){
				if(in_array('baidu',$ping_type)){
					$ping_config['type'] = 'baidu';
					$ping_config['pingurl'] = 'http://ping.baidu.com/ping/RPC2';
					$res = superping_ping($ping_config);
					if(strpos($res, '<int>0</int>')){
						$baidustatus = 1;
					}else{
						$baidustatus = 2;
					}
				}
				if(in_array('google',$ping_type)){
						$ping_config['type'] = 'google';
						$ping_config['pingurl'] = 'http://blogsearch.google.com/ping/RPC2';
						$res = superping_ping($ping_config);
						if(strpos($res, '<boolean>0</boolean>')){
							$googlestatus = 1;
						}else{
							$googlestatus = 2;
						}
				}
		}

		$data = array(
			'tid' => $tid,
			'uid' => $thread['authorid'],
			'baidu' => $baidustatus,
			'google' => $googlestatus,
			'threadurl' => daddslashes($ping_config['threadurl']),
			'dateline' => $_G['timestamp'],
		);
		$pingid = DB::result_first("SELECT id FROM " . DB::table('study_seo_ping') . " WHERE tid = '$tid'");
		if($pingid) {
				DB::update('study_seo_ping', $data, "tid='$tid'");
		}else{
				DB::insert('study_seo_ping', $data);
		}
}

function superping_portal_run($param) {
		global $_G;
		if(!function_exists('curl_init') || !function_exists('curl_exec')) {
			return;
		}

		$aid = intval($param['aid']);
		$catid = intval($param['catid']);
		$article = $param['article'];

		$splugin_setting = $_G['cache']['plugin']['study_seo_ping'];
		$splugin_setting['portal_nocatid'] = explode(',', $splugin_setting['portal_nocatid']);
		if($catid && in_array($catid, $splugin_setting['portal_nocatid'])){
			return;
		}
		
		if(empty($article)){
				$article = DB::fetch_first("SELECT * FROM ".DB::table('portal_article_title')." WHERE aid='$aid' ORDER BY aid DESC");
				if(empty($article)) {
					return;
				}
		}
		
		if(in_array($article['catid'], $splugin_setting['portal_nocatid'])){
			return;
		}

		$ping_config = array();
		$ping_config['bbsname'] = $_G['setting']['bbname'];
		$ping_config['siteurl'] = $_G['siteurl'];
		$ping_config['threadurl'] = $_G['siteurl'].(@in_array('portal_article', $_G['setting']['rewritestatus']) ? rewriteoutput('portal_article', 1, '', $aid, 1, '', '') : 'portal.php?mod=view&aid='.$aid);
		$ping_config['rssurl'] = '';

		$ping_type = (array)unserialize($splugin_setting['ping_type']);

		$baidustatus = $googlestatus = 0;
		if(in_array('baidu', $ping_type)){
			$ping_config['type'] = 'baidu';
			$ping_config['pingurl'] = 'http://ping.baidu.com/ping/RPC2';
			$res = superping_ping($ping_config);
			if(strpos($res, '<int>0</int>')){
				$baidustatus = 1;
			}else{
				$baidustatus = 2;
			}
		}
		if(in_array('google', $ping_type)){
				$ping_config['type'] = 'google';
				$ping_config['pingurl'] = 'http://blogsearch.google.com/ping/RPC2';
				$res = superping_ping($ping_config);
				if(strpos($res, '<boolean>0</boolean>')){
					$googlestatus = 1;
				}else{
					$googlestatus = 2;
				}
		}

		$data = array(
			'aid' => $aid,
			'uid' => $article['authorid'],
			'baidu' => $baidustatus,
			'google' => $googlestatus,
			'threadurl' => daddslashes($ping_config['threadurl']),
			'dateline' => $_G['timestamp'],
		);
		$pingid = DB::result_first("SELECT id FROM ".DB::table('study_seo_ping_article')." WHERE aid = '$aid'");
		if($pingid) {
				DB::update('study_seo_ping_article', $data, "aid='$aid'");
		}else{
				DB::insert('study_seo_ping_article', $data);
		}
}

function superping_ping($ping_config) {
	$xml = superping_getpingxml($ping_config);
	$ch = curl_init();
	$headers = array(
		'POST '.$ping_config['pingurl'].' HTTP/1.0',
		'Content-type: text/xml; charset="utf-8"',
		'Accept: text/xml',
		'Content-length: '.strlen($xml)
	);
	curl_setopt($ch, CURLOPT_URL, $ping_config['pingurl']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}

function superping_getpingxml($ping_config) {
		$xml = '';
		if($ping_config['type'] == 'baidu'){
			$xml = '<?xml version="1.0" encoding="UTF-8"?>
			<methodCall>
				<methodName>weblogUpdates.extendedPing</methodName>
				<params>
					<param><value><string>'.$ping_config['bbsname'].'</string></value></param>
					<param><value><string>'.$ping_config['siteurl'].'</string></value></param>
					<param><value><string>'.$ping_config['threadurl'].'</string></value></param>
					<param><value><string>'.$ping_config['rssurl'].'</string></value></param>
				</params>
			</methodCall>';
		}else{
			$xml = '<?xml version="1.0"?>
			<methodCall>
			  <methodName>weblogUpdates.extendedPing</methodName>
			  <params>
					<param><value>'.$ping_config['bbsname'].'</value></param>
					<param><value>'.$ping_config['siteurl'].'</value></param>
					<param><value>'.$ping_config['threadurl'].'</value></param>
					<param><value>'.$ping_config['rssurl'].'</value></param>
			  </params>
			</methodCall>';
		}
		return $xml;
}

if(!file_exists(DISCUZ_ROOT.'./source/plugin/study_seo_ping/thank.inc.php')){
		exit;
}
?>