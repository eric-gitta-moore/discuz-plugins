<?php


/*
 *源   码 哥   y m    g    6    .     c    o m
 *更多商业插件/模版免费下载 就在源   码  哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if (!defined('IN_DISCUZ')) {
	exit ('Access Denied');
}
 
class plugin_mxi_aplay {
	//TODO - Insert your code here
	var $setting;
	var $forums;
	public function __construct($onx) {
		global $_G;
		$this->setting = $_G['cache']['plugin']['mxi_aplay'];
		$this->forums =  unserialize( $this->setting['forums']);
	}
	public function global_header() {
		$returns = '';
		include template('mxi_aplay:global_header');
		return $returns;
	}

	public function forumdisplay_bottom_output() {
		global $_G;
		$returns = '';
		$setting = $this->setting;
		if(!in_array( $_G['forum']['fid'],$this->forums) || !$setting['forumdispaly']){
			return;
		}
		include template('mxi_aplay:hook_forumdisplay');
		return $returns;
	}
	public function viewthread_bottom_output() {
		global $_G;
		$returns = '';		 
		if(!in_array( $_G['forum']['fid'],$this->forums)){
			return;
		}
		$author = avatar($_G['forum_thread']['authorid'], small);
		$postdateline = date($_G['forum_thread']['dateline']);
		include template('mxi_aplay:hook_viewthread');
		return $returns;
	}
	//嵌入点-帖子，有待优化
	public function _viewthread_postbottom() {
		global $_G, $thread, $postlist, $skipaids;
		$setting = $this->setting;		 
		if(!in_array( $_G['forum']['fid'],$this->forums)){
			return;
		}
		require_once libfile('function/attachment');	
		foreach ($postlist as $pid => $post) {			
			$table = getattachtablebytid($post['tid']);
			//未登录时处理音乐附件到下面的列表中。
			if (!$_G['uid']) {
				$query = DB :: query("SELECT * FROM " . DB :: table($table) . " WHERE tid=" . $post['tid'] . " and pid=" . $post['pid'] . " ORDER BY aid ASC ");
				while ($row = DB :: fetch($query)) {
					$tmp_attach[$row['aid']] = $row;
				}
			}	
		 
			
			foreach ($post['attachments'] as $aid => $attach) {
				$attachment = $_G['setting']['attachdir'] . 'forum/' . $attach['attachment'];
				$audutiondir = (($setting['isremote']&& $attach['remote']) ? $_G['setting']['ftp']['attachurl'].$setting['remote_auditiondir']:$_G['siteurl'].$_G['setting']['attachurl']."forum/") ;
				$waveformdir = (($setting['isremote']&& $attach['remote']) ? $_G['setting']['ftp']['attachurl'].$setting['remote_wavedir']:$setting['waveformdir']);
				
				//remote attat 
				$path = $this->attach_path( $attach['attachment']);
				$attach_ext = explode('.',$attach['attachment']);
				$attach_ext = $attach_ext[1];				 
				if (file_exists($attachment) || ( $attach['remote'] )&& in_array($attach_ext, array ('mp3','wma'))) {					
					$path = $this->attach_path( $attach['attachment']);
					if (in_array($attach_ext, array ('mp3','wma'))) {					
						$audition_audio = $this->setting['safeurl'] ? 'plugin.php?id=mxi_aplay&mod=play&aid='. packaids($attach) :$audutiondir .$attach['attachment'];
						$audition_crimp = $waveformdir .$path. "$audition.png";						
						$posttime='';
						$postlist[$pid]['attachments'][$aid]['audition'] = $audition_audio;						
						$postlist[$pid]['attachments'][$aid]['crimp'] = 1 ;
						$postlist[$pid]['attachments'][$aid]['exif'] = '';
						$postlist[$pid]['attachments'][$aid]['packaid'] = packaids($attach);
						 
					}
					
				}
			}
		}
	}
	//嵌入点-论坛列表
	public function _forumdisplay_thread() {
		global $_G, $thread, $postlist, $skipaids;
		$returns ='';
		$setting = $this->setting;		 
		require_once libfile('function/attachment');
		if(!in_array( $_G['forum']['fid'],$this->forums) || !$setting['forumdispaly']){
			return;
		}		 
		foreach($_G['forum_threadlist'] as $key =>$thread){
			if($thread['attachment'] >0){				
				$threadids[]= $thread['tid'];
			}
		}
		 
		 if($threadids){
			$tids = implode(',',$threadids);
			$attachs = C::t('forum_attachment')->fetch_all_by_id('tid',$threadids);
			
			foreach($attachs as $aid=>$attach){
				$ext='';
				$tableid = 'aid:' . $aid;
				$attachment = C :: t('forum_attachment_n')->fetch($tableid, $aid);
				if ($attachment) {
					$audutiondir = (($setting['isremote']&& $attachment['remote']) ? $_G['setting']['ftp']['attachurl'].$setting['remote_auditiondir']:$_G['setting']['attachurl']."forum/") ;
				    $waveformdir =  (($setting['isremote']&& $attachment['remote'] )? $_G['setting']['ftp']['attachurl'].$setting['remote_wavedir']:$setting['waveformdir']);
		
					$filename = explode('.',$attachment['attachment']);
					$ext = strtolower($filename[1]);
					if($ext=='mp3'){
						$path = $this->attach_path( $attachment['attachment']);
						 
						$auditionlist[$attachment['tid']]= array('aid'=>$aid,'remote'=>$attachment['remote'],'path'=>$path,'price'=>$attachment['price'],);
						foreach($_G['forum_threadlist'] as $key =>$thread){
							if($thread['tid'] == $attachment['tid']){									 
								$audition_audio = $this->setting['safeurl'] ? 'plugin.php?id=mxi_aplay&mod=play&aid='.packaids($attachment) : $audutiondir  .$attachment['attachment'];
								$waveformp =    $waveformdir .$path. "$aid_md5.png";
								$crimp = file_exists(DISCUZ_ROOT . $waveformp) ? $waveformp : "1";
								$audition =array('tid'=>$attachment['tid'],'uid'=>$attachment['uid'],'price'=>$attachment['price'],'aid'=>$aid,'filename'=>$attachment['filename'], 'mp3'=>$audition_audio,'packaid'=>packaids($attachment),'crimp'=>$crimp,'waveform'=>$waveformp);
								$_G['forum_threadlist'][$key]['palylist'][]=$audition;
							}
						}						
					}					
				}else{
					
				}
			}			 
		}
		 
		 //单独处理forumlist中图标
		if($auditionlist){
			foreach($_G['forum_threadlist'] as $key =>$thread){
				 	 		
					if(in_array( $thread['tid'] ,$threadids) && $thread['palylist']) {							 			
						$aid =  ($auditionlist[$attachment['tid']]['aid']);
						$path =$auditionlist[$attachment['tid']]['path'];
						$remote= $auditionlist[$attachment['tid']]['remote'];
						$price= $auditionlist[$attachment['tid']]['price'];
						 
						$aid_md5 = md5(md5($aid));
						
						$audutiondir = ($setting['isremote']&& $remote) ? $_G['setting']['ftp']['attachurl'].$setting['remote_auditiondir']:$setting['auditiondir'] ;
						$waveformdir =  ($setting['isremote']&& $remote )? $_G['setting']['ftp']['attachurl'].$setting['remote_wavedir']:$setting['waveformdir'];
				
						$audition_audio =  $this->setting['safeurl'] ? 'plugin.php?id=mxi_aplay&mod=play&aid='. packaids($auditionlist[$attachment['tid']]):$audutiondir .$attachment['attachment'];
						$waveformp =   $waveformdir.$path. "$aid_md5.png";
						$audition =array('aid'=>$aid, 'mp3'=>$audition_audio,'waveform'=>$waveformp,'price'=>$price,);
						$_G['forum_threadlist'][$key]['audition'] = $audition;
						$avatar = avatar($thread['authorid'],small);			 
						 
						$thread['uid'] = $thread['authorid'];
						$thread['date'] = gmdate('Y-M-d',$thread['date']);
						include template('mxi_aplay:hook_forumdisplay_thread');
						$playlist[$key] = $returns;
					} else{ 				
					$playlist[$key] ='';
				}
			}
		}		
	 	return $playlist;
	}
	//hook
	public function viewthread_attach_extra($dd) {	
		global $_G,$postlist ;		 
		$return = array();
		//生成索引
		foreach ($postlist as $pid => $post) {			 
			foreach ($post['attachments'] as $aid => $attach) {
				$return[$attach['aid']]='';
			}
		} 		
		return $return;
	} 
	//hook
	public function viewthread_attach_extra_output($dd) {		
		  print_r($dd);
	} 
	public function delete($prame){	
	}
	public function ajax($prame){
		global $_G;	
	}
	function audioinfo($file) {
		global $_G;
		$mod_exif = DISCUZ_ROOT . "./source/plugin/mxi_aplay/class/getid/getid3.php";
		if(!file_exists($mod_exif)){
			//uninstall module exit fun.
			return;
		}
		require_once $mod_exif;
		require_once DISCUZ_ROOT . "./source/plugin/mxi_aplay/class/class_audioexif.php";
		$au = new AudioInfo();
		if (file_exists($file)) {
			$audioinfo = $au->Info($file);
			$ext = strtolower($audioinfo['format_name']);
			$audioinfo['ext'] = $ext;
			$audioinfo['filesize'] = sizecount($audioinfo['filesize']);
			$audioinfo['playtimes'] = floor($audioinfo['playing_time'] / 60) . '"' . $audioinfo['playing_time'] % 60 . "'";
			$audioinfo['bitrate'] = $audioinfo['avg_bit_rate'] ? intval($audioinfo['avg_bit_rate']) / 1000 : 0;
			return $audioinfo;
		}
		return array ('bitrate'=>'128KBS','playtimes'=>'0:00','filesize'=>'Unkonw');
	} 	
	
	public function attach_path($attach) {
		if ($attach) {
			$paths = explode('/', $attach);			 
        	array_pop($paths);
        	$paths = implode('/', $paths) . '/';
			return $paths;
		}
	}
	
	function mx_debug($log,$identifier="aplay") {
		//协助作者调试，由用户手动开启,一般不写文件
		
	}
}
//脚本
class plugin_mxi_aplay_forum extends plugin_mxi_aplay {	 
	public function viewthread_postbottom_output() {
		global $_G;
		return $this->_viewthread_postbottom();
	}
	public function viewthread_attach_extra_output($dd) {		
		global $_G,$postlist;
		//填充索引,处理block
		$setting = $this->setting;		
		foreach ($postlist as $pid => $post) {			 
			foreach ($post['attachments'] as $aid => $attach) {
				$block_extra ='';
				//这里的数据从_viewthread_postbottom()中得
				
				if($attach['audition']){
					include template('mxi_aplay:hook_viewthread_attach_extra');
					$return[$attach['aid']]=$block_extra;
				}
			}
		} 
		 
		return $return;
	} 
	public function forumdisplay_thread_output(){
		return $this->_forumdisplay_thread();
	}
}
?>