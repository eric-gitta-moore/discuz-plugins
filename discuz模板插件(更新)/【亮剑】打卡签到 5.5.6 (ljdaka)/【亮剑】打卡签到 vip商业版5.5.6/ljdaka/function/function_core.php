<?php
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
function generatethread($subject,$message,$ip,$uid,$username,$bkfid){
	global $_G;
	include_once libfile('function/forum');
	include_once libfile('function/post');
		if(!$ip){
			$clientip="202.".rand(96,184).".".rand(124,127).".".rand(9,200);
		}else{
			$clientip=$ip;
		}
		if(!$username){
			$username=DB::result_first('select username from '.DB::table('common_member')." where uid=$uid");
		}
		DB::query("INSERT INTO ".DB::table('forum_thread')." (
		fid, posttableid, readperm, price, typeid, sortid, author, authorid, subject, dateline, lastpost, lastposter, displayorder, digest, special, attachment, moderated, highlight, closed, status, isgroup) VALUES (
		'$bkfid', '0', '0', '0', '9', '0', '$username', '$uid', '$subject', '$_G[timestamp]', '$_G[timestamp]', '$username', '0', '0', '$special', '0', '0', '0', '1', '32', '0')");
		$synctid = DB::insert_id();
		$tid=$synctid;
		$syncpid = insertpost(array('fid' => $bkfid,'tid' => $synctid,'first' => '1','author' => $username,'authorid' =>$uid,'subject' => $subject,'dateline' => $_G['timestamp'],'message' => $message,'useip' => $clientip,'invisible' => '0','anonymous' => '0','usesig' => '1','htmlon' => 1,'bbcodeoff' => 0,'smileyoff' => 0,'parseurloff' => '0','attachment' => '2',));
		$pid=$syncpid;
		//updatepostcredits('+', $uid, 'post', $bkfid);
		$synclastpost = "$synctid\t".addslashes($subject)."\t$_G[timestamp]\t$username";
		DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$synclastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='$bkfid'", 'UNBUFFERED');
		$feedcontent = array(
				'tid' => $synctid,
				'content' => $todaysay,
		);
		if($_G['setting']['version']!='X2'){
			C::t('forum_threadpreview')->insert($feedcontent);
			$followfeed = array(
				'uid' => $uid,
				'username' =>$username,
				'tid' => $synctid,
				'note' => '',
				'dateline' => TIMESTAMP
			);
				
			C::t('home_follow_feed')->insert($followfeed, true);
			C::t('common_member_count')->increase($uid, array('feeds'=>1));
		}
		$expiration=$_G['timestamp']+24*60*60;
		DB::insert('forum_threadmod',array(
			'tid'=>$tid,
			'uid'=>$uid,
			'username'=>$username,
			'dateline'=>$_G['timestamp'],
			'expiration'=>$expiration,
			'action'=>'EHL',
			'status'=>'1',
		));
		DB::insert('forum_threadmod',array(
			'tid'=>$tid,
			'uid'=>$uid,
			'username'=>$username,
			'dateline'=>$_G['timestamp'],
			'action'=>'CLS',
			'status'=>'1',
		));
		//updatepostcredits('+', $_G['uid'], 'post', $bkfid);
		return $tid;

}
function generatepost($huitie,$uid,$tid,$fid,$Signiture,$mes,$ip){
	global $_G;
	$time=$_G['timestamp'];
	include_once libfile('function/forum');
	include_once libfile('function/post');
	if(!$username){
		$username = DB :: result_first("SELECT username FROM " . DB :: table('common_member') . " where uid=$uid");
	}
	if(!$ip){
		$clientip="202.".rand(96,184).".".rand(124,127).".".rand(9,200);
	}else{
		$clientip=$ip;
	}
	if(!$fid){
		$fid=DB::result_first("SELECT fid FROM ".DB::table('forum_thread')." where tid=$tid");
	}
	$pid = insertpost(array('fid' => $fid, 'tid' => $tid, 'first' => '0', 'author' => $username, 'authorid' => $uid, 'subject' => '', 'dateline' => $time, 'message' => $huitie, 'useip' => $clientip, 'invisible' => '0', 'anonymous' => '0', 'usesig' => $Signiture, 'htmlon' => '0', 'bbcodeoff' => '0', 'smileyoff' => '0', 'parseurloff' => '0', 'attachment' => '0',)); 									
	$lastpost = "$tid\t" . addslashes($mes) . "\t$_G[timestamp]\t$username";
	DB :: query("UPDATE " . DB :: table('common_member_count') . " SET posts=posts+1 WHERE uid='$uid'", 'UNBUFFERED');
	DB :: query("UPDATE " . DB :: table('common_member_status') . " SET lastip='$clientip',lastvisit='$time',lastactivity='$time',lastpost='$time' WHERE uid='$uid'", 'UNBUFFERED');
	DB :: query("UPDATE " . DB :: table('forum_forum') . " SET posts=posts+1,todayposts=todayposts+1,lastpost='$lastpost' WHERE fid='$fid'", 'UNBUFFERED');
	if($_G['setting']['version']!='X2'){
		$max=DB::result_first(' select position from '.DB::table('forum_post')." where pid=$pid");
		DB :: query("UPDATE " . DB :: table('forum_thread') . " SET replies=replies+1,views=views+1,lastposter='$username', lastpost='$time',maxposition=$max WHERE tid='$tid'", 'UNBUFFERED');
	}else{
		DB :: query("UPDATE " . DB :: table('forum_thread') . " SET replies=replies+1,views=views+1,lastposter='$username', lastpost='$time' WHERE tid='$tid'", 'UNBUFFERED');
	}
	if (!empty($uid) && $uid != $_G['uid']) {
		$notification = "<a href=\"home.php?mod=space&amp;uid=$uid\">$username</a> 回复了您的帖子 <a target=\"_blank\" href=\"forum.php?mod=redirect&amp;goto=findpost&amp;ptid=$tid&amp;pid=$pid\">$subject</a> &nbsp; <a class=\"lit\" target=\"_blank\" href=\"forum.php?mod=redirect&amp;goto=findpost&amp;pid=$pid&amp;ptid=$tid\">查看</a>";
		$notification = nl2br(str_replace(':', '&#58;', $notification));
		notification_add($authorid, 'post',$notification );
	}

}



?>