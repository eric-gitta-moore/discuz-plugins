<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('DEBUG_MODE', 0);
error_reporting(0);
if(!defined('DISCUZ_VERSION')) require_once(DISCUZ_ROOT.'/source/discuz_version.php');
class plugin_milu_pick {
	var $output;
	var $script;
	var $fast_pick_open;//单帖采集是否开启
	var $cron_open;//计划任务是否开启
	var $vir_data_open;//虚拟数据是否开启
	var $set;
	var $milu_set;
	var $pick_set;

	function global_header() {
		global $_G;
		$set = $_G['cache']['plugin']['milu_pick'];
		if( ( $set['cron_open'] == 1 || $set['is_timing'] == 1 ) ){
			require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
			require_once(DISCUZ_ROOT.'source/plugin/milu_pick/lib/cron.class.php');
				
			if($set['cron_open'] == 1) {
				loadcache('pick_run');
				if($_G['cache']['pick_run'] <= TIMESTAMP) pick_cron::run();
			}
			if($set['is_timing'] == 1) {
				loadcache('pick_timing');
				if($_G['cache']['pick_timing'] <= TIMESTAMP) pick_cron::run_timing();
			}	
			
		}
		//if(DISCUZ_VERSION == 'X2') $this->_milu_portal_content_output();//DZ 2.0 门户文章显示没有相应的hook，只能这样
	}
	
	function _show_output($type = 'bbs') {
		$type = $type == 'bbs' ? $type : 'portal';
		if($this->milu_set['fp_open_mod'][$type] != 1) return;
		if($this->fast_pick_open != 1) return;
		require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
		$script = "<script charset=\"".CHARSET."\" type=\"text/javascript\">var PICK_URL = SITEURL+'admin.php?".PICK_GO."';var fast_type = '".$type."';</script>";
		if($type == 'portal'){
			$script .= '<script language="javascript" charset="gbk" type="text/javascript" src="static/image/editor/editor_base.js"></script>';
		}
		$script .= '<script language="javascript" charset="gbk" type="text/javascript" src="'.PICK_URL.'static/fast_pick.js?v='.PICK_VERSION.'"></script>';
		$output = '<div class="pbt cl">
			<div class="z"><span><input type="text" onblur="pickFocus()" name="article_url" id="article_url"  autocomplete="off" class="px" value="'.lang('plugin/milu_pick', 'input_url').'" onfocus="pickFocus()"  style="width: 32em" tabindex="1"></span>
			<button type="button" id="fast_pick_get" class="pn" style=" margin-bottom:3px;" value="true" onclick="fast_pick()"><em>'.lang('plugin/milu_pick', 'get_data').'</em></button><span id="pick_loading" style="margin:0 10px;width:300px; float:right;height:20px;line-height:20px;"></span></div></div>';
		$this->output = $output;
		$this->script = $script;
	}
	
	//初始化参数
	function _ini(){
		global $_G;
		require_once(DISCUZ_ROOT.'source/plugin/milu_pick/lib/function.global.php');
		$set = $_G['cache']['plugin']['milu_pick'];
		loadcache('milu_pick_setting');
		$milu_set = $_G['cache']['milu_pick_setting'];
		$pick_set = $_G['cache']['milu_pick_setting'];
		$this->vir_data_open = $milu_set['vir_open'] == 1 ? 1 : 0;
		$this->cron_open = $set['cron_open'];
		$this->set = $set;
		$this->milu_set = $milu_set;
		$this->pick_set = $pick_set;
		$this->vip = strexists(strtolower($_G['setting']['plugins']['version']['milu_pick']), 'vip') ? TRUE : FALSE;
		if($this->milu_set['fp_open'] == 2 && $this->milu_set['fp_open'] == 2) return;
		
	}
	
	function _check_open(){
		global $_G;
		$this->_ini();
		$this->fast_pick_open = 0;
		$this->milu_set['fp_forum'] = unserialize($this->milu_set['fp_forum']);
		
		$this->milu_set['fp_usergroup'] = unserialize($this->milu_set['fp_usergroup']);
		if($this->milu_set['fp_open'] == 1){//开启
			$this->milu_set['fp_open_mod'] = unserialize($this->milu_set['fp_open_mod']);
			$this->milu_set['fp_open_mod']['portal'] = in_array(1, $this->milu_set['fp_open_mod']) && $this->vip ? 1 : 0;
			$this->milu_set['fp_open_mod']['bbs'] = in_array(2, $this->milu_set['fp_open_mod']) ? 1 : 0;
			if($this->milu_set['fp_usergroup'] && !in_array($_G['groupid'], $this->milu_set['fp_usergroup'])) {
				$this->fast_pick_open = 0;
				return;
			}	
			if($this->milu_set['fp_forum'] && !in_array($_G['fid'], $this->milu_set['fp_forum']) ) {
				$this->fast_pick_open = 0;
				return;
			}	
			$this->fast_pick_open = 1;
		}
	}
	
	function _article_info($aid = ''){
		$aid = $aid ? $aid : $_GET['pick_aid'];
		$aid = intval($aid);
		if($aid == 0 ) return;
		$arr = DB::fetch_first("SELECT * FROM ".DB::table('strayer_article_title')." WHERE aid='$aid'");
		if(!$arr) return FALSE;
		$content = '';
		if($arr['aid']){
			$query =  DB::query("SELECT * FROM ".DB::table('strayer_article_content')." WHERE aid='".$arr['aid']."' ");
			while(($v = DB::fetch($query))) {
				if($arr['is_bbs'] != 1){
					$content .= $v['content'];
				}
				if($v['pageorder'] == 1){
					$c_arr = $v;
					if($arr['is_bbs'] == 1) $content = $v['content'];
				}else{
					$reply_arr[] = $v;
				}
				$content_arr[] = $v;	
			}
		}
		$re_arr = array_merge($arr, $c_arr);
		$re_arr['content'] = $content;
		return $re_arr;
	}
	
	function _public_add_info($type = 'bbs'){
		$info = $this->_article_info();
		if(!$info) return;
		if($type == 'bbs'){
			require_once libfile('function/editor');
			$info['content'] = dstripslashes($info['content']);
			$info['content'] = img_htmlbbcode($info['content'], $info['page_url']);
			$info['content'] = media_htmlbbcode($info['content'], $info['page_url']);
			$info['content'] = audio_htmlbbcode($info['content'], $info['page_url']);
			$info['content'] = htmlspecialchars_decode(html2bbcode($info['content']));
			$info['content'] = dstripslashes(format_html($info['content']));
			
			$script .= '<div id="show_title" style="display:none">'.$info['title'].'</div><div id="show_content" style="display:none">'.$info['content'].'</div><script language="javascript" type="text/javascript" >';
			$script .= '
					var subject = $("show_title").innerHTML;
					var message = $("show_content").innerHTML;
					$("subject").value= subject;
					message = message.replace(/<p>([\s\S]*?)<\/p>/ig, "$1<br />");
					message = message.replace(/<center>([\s\S]*?)<\/center>/ig, "[align=center]$1[/align]");
					$(\'e_textarea\').value = message;
					$("subject").focus();';
			$script .= '</script>';	
		}else if($type == 'portal'){
			$script .= '<div id="show_title" style="display:none">'.$info['title'].'</div><div id="show_content" style="display:none">'.$info['content'].'</div><script language="javascript" type="text/javascript" >';
			$script .= '
					var subject = $("show_title").innerHTML;
					var message = $("show_content").innerHTML;
					$("title").value= subject;
					$("from").value= \''.$this->_public_data($info['from']).'\';
					document.getElementsByName(\'fromurl\')[0].value = \''.$this->_public_data($info['url']).'\';
					document.getElementsByName(\'author\')[0].value = \''.$this->_public_data($info['author']).'\';
					$(\'uchome-ttHtmlEditor\').value  = message;
					var p = window.frames[\'uchome-ifrHtmlEditor\'];
					var obj = p.window.frames[\'HtmlEditor\'];
					obj.document.body.innerHTML = message;
					edit_save();
					$("title").focus()';
			$script .= '</script>';	
		}else if($type == 'blog'){
			$script .= '<div id="show_title" style="display:none">'.$info['title'].'</div><div id="show_content" style="display:none">'.$info['content'].'</div><script language="javascript" type="text/javascript" >';
			$script .= '
					var subject = $("show_title").innerHTML;
					var message = $("show_content").innerHTML;
					$("subject").value= subject;
					document.getElementsByName(\'tag\')[0].value = \''.$this->_public_data($info['article_tag']).'\';
					$(\'uchome-ttHtmlEditor\').value  = message;
					var p = window.frames[\'uchome-ifrHtmlEditor\'];
					var obj = p.window.frames[\'HtmlEditor\'];
					obj.document.body.innerHTML = message;
					edit_save();
					$("subject").focus()';
			$script .= '</script>';	
		}
		return $script;	
	}
	function _public_data($str){
		if(!$str) return;
		return str_replace("'", "\'", $str);
	}
	
	function get_count_data($data){
		if(!strexists($data, ',')) return $data;
		$temp_arr = format_wrap($data, ',');	
		return rand($temp_arr[0], $temp_arr[1]);	
	}
	function get_count_arr($data){
		if(strexists($data, ',')){
			$temp_arr = format_wrap($data, ',');
			$must_arr = range($temp_arr[0], $temp_arr[1]);
		}else if(strexists($data, '|')){
			$must_arr = format_wrap($data, '|');
		}else{
			$must_arr = array($data);
		}
		return $must_arr;
	}
	function get_member_list($num = 0){
		if($num == 0) return array();
		$get_type = $this->milu_set['online_data_from'];
		$must_num = 0;
		if($this->milu_set['vir_must_online']){
			$must_arr = $this->get_count_arr($this->milu_set['vir_must_online']);
		}
		$sql_base = "SELECT uid,username,groupid FROM ".DB::table('common_member');
		$uid_arr = $must_arr;
		$query = DB::query($sql_base." WHERE groupid!=9 AND uid IN (".dimplode($uid_arr).")  ORDER BY groupid");
		while(($v = DB::fetch($query))) {
			$must_member_arr[] = $v;
		}
		$must_num = count($must_member_arr);
		if($must_num > $num || $must_num == $num){
			$must_member_arr = array_slice($must_member_arr, 0, $num);
			return $must_member_arr;//既然必须登录的会员凑够数了，没必要再去取
		}
		
		
		$limit_num = (int)$num - $must_num;//没凑够数当然要再获取了
		$limit_str = 'LIMIT 1,'.$limit_num;
		
		if($get_type == 1 || !$get_type){//所有会员
			
		}else if($get_type == 2){//从用户组
			$this->milu_set['vir_data_usergroup'] = unserialize($this->milu_set['vir_data_usergroup']);
			if($this->milu_set['vir_data_usergroup']){
				$sql = " AND groupid IN (".dimplode($this->milu_set['vir_data_usergroup']).") ";
			}
		}else if($get_type == 3){//自定义
			if($this->milu_set['vir_must_online']){
				$user_arr = $this->get_count_arr($this->milu_set['online_data_user_set']);
			}
			$sql = " AND uid IN (".dimplode($user_arr).") ";
		}
		$query = DB::query($sql_base." WHERE  groupid!=9 $sql ORDER BY rand() $limit_str");
		while(($rs = DB::fetch($query))) {
			$must_member_arr[] = $rs;
		}
		return $must_member_arr;
	} 
	function  _jammer($first = 1) {
	 	$rand_arr = $first == 1 ? $this->pick_set['push_content_body_arr'] : $this->pick_set['push_reply_body_arr'];
		$randomstr = $rand_arr[array_rand($rand_arr)];
		return mt_rand(0, 1) && $bbs==1 ? '<font class="jammer">'.$randomstr.'</font>'."<br />" :
		 "<br />".'<span style="display:none">'.$randomstr.'</span>';
	}
	
	function _milu_portal_content_output(){
		global $_G,$content,$article;
		if( $this->pick_set['open_seo'] != 1) return;
		$this->pick_set['open_seo_mod'] = unserialize($this->pick_set['open_seo_mod']);
		if(!in_array(1, $this->pick_set['open_seo_mod'])) return;
		$aid = intval($_GET['aid']);
		$mod = $_GET['mod'];
		if(empty($aid) && $mod != 'view') return false;
		$seo_arr = $this->_article_seo_output(array('content' => $content['content'], 'title' => $article['title']));
		$content['content'] = $seo_arr['content'];
		$article['title'] = $seo_arr['title'];
	}
	function _article_seo_output($data){
		pload('F:seo');
		$seo_arr = pick_seo_replace($data, 0, 0);
		$arr['content'] = $seo_arr['content'];
		$arr['title'] = $seo_arr['title'];
		return $arr;
	}
	
}

class plugin_milu_pick_forum extends plugin_milu_pick {
	function plugin_milu_pick_forum(){
		global $isfirstpost;
		$this->_check_open();
		if($isfirstpost != 1 || $this->milu_set['fp_open_mod']['bbs'] != 1) return;
		$this->_show_output();
	}
	function post_top_output() {
		
		if($this->output) return $this->output;
		
	}
	function post_bottom_output() {
		if($_GET['pick_aid']){
			$show = $this->_public_add_info();
			$this->script .= $show;
		}
		if($this->output || $_GET['pick_aid']) return $this->script;
		
	}
	//虚拟数据
	function index_top_output() {
		global $_G,$invisiblecount,$todayposts,$postdata,$posts,$whosonline,$detailstatus,$onlinenum,$membercount,$guestcount,$onlineinfo,$forumlist;
		if($this->vir_data_open != 1) return;
		$bei = intval($this->milu_set['vir_data_bei']);
		if($this->milu_set['vir_data_bei'] > 1){//数据加倍
			$_G['cache']['userstats']['totalmembers'] = ceil($_G['cache']['userstats']['totalmembers'] * $bei);
			$onlineinfo[0] = ceil($onlineinfo[0] * $bei);
			if($this->milu_set['vir_data_forum']){
				loadcache('milu_pick_vir_data');
				$setting = $_G['cache']['milu_pick_vir_data'];
				if(!$setting || $setting['old_todayposts'] != $todayposts){//
					$setting['old_todayposts'] = $todayposts;
					$todayposts = $posts = 0;
					$this->milu_set['vir_data_forum'] = unserialize($this->milu_set['vir_data_forum']);
					$fid_arr = array_keys($forumlist);
					foreach($fid_arr as $fid){
						if(!in_array($fid, $this->milu_set['vir_data_forum'])) continue;
						$forumlist[$fid]['todayposts'] = $forumlist[$fid]['todayposts'] ? $forumlist[$fid]['todayposts'] * $bei : ceil($forumlist[$fid]['threads'] / 12);
						$forumlist[$fid]['threads'] = $forumlist[$fid]['threads'] * $bei;//主题数
						$forumlist[$fid]['folder'] = 'class="new"';
						$forumlist[$fid]['lastpost']['dateline'] = dgmdate($_G['timestamp'] - rand(0, 100) * 60, 't');
						$forumlist[$fid]['posts'] = $forumlist[$fid]['posts'] * $bei;//回复数
						$todayposts +=  $forumlist[$fid]['todayposts'];//今日帖子
						$posts += $forumlist[$fid]['posts'];//总帖子
					}
					$setting['forumlist'] = $forumlist;
					$setting['posts'] = $posts;
					$setting['todayposts'] = $todayposts;
					$setting['dateline'] = $_G['timestamp'];
					save_syscache('milu_pick_vir_data', $setting);
				}else{
					$posts = $setting['posts'];
					$todayposts = $setting['todayposts'];
					$forumlist = $setting['forumlist'];
				}
				unset($setting);
			}else{
				$todayposts = $todayposts * $bei;
			}
			loadcache('milu_pick_vir_postdata');
			$setting = $_G['cache']['milu_pick_vir_postdata'];
			$cache_dateline = $setting['dateline'];
			if(date("d", $cache_dateline) != date("d", $_G['timestamp']) || !$setting){
				$postdata[0] = $postdata[0] < $todayposts ? $todayposts + rand(ceil($todayposts*0.05), ceil($todayposts*0.3)) : $postdata[0];
				$setting['postdata'] = $postdata;
				$setting['dateline'] = $_G['timestamp'];
				save_syscache('milu_pick_vir_postdata', $setting);
			}else{
				$postdata = $setting['postdata'];
			}
			
		}
		
		$member_online_count = $this->get_count_data($this->milu_set['vir_online_member_count']);
		$guest_online_count = $this->get_count_data($this->milu_set['vir_online_guest_count']);
		$add_member_count = $add_guest_count = 0;
		if($member_online_count > $membercount){
			$add_member_count = $member_online_count - $membercount;
		}
		if($guest_online_count > $guestcount){
			$add_guest_count = $guest_online_count - $guestcount;
		}
		
		loadcache('milu_pick_vir_online');
		$setting = $_G['cache']['milu_pick_vir_online'];
		$onlinehold = $_G['setting']['onlinehold'] ;//在线保持时间
		$cache_setting = array();
		if (($_G['timestamp'] - $setting['dateline']) > $onlinehold ) $setting = FALSE;
		if($detailstatus){//显示详细的在线会员
			if(!$setting){//缓存起来
				foreach((array)$whosonline as $k => $v){
					$old_uid_arr[] = $v['uid']; 
				}
				$member_list = $this->get_member_list($add_member_count);
				$invisible = 0;
				foreach($member_list as $k => $v){
					if(in_array($v['uid'], $old_uid_arr)) continue;
					$groupid = $v['groupid'];
					$icon = empty($_G['cache']['onlinelist'][$groupid]) ? $_G['cache']['onlinelist'][0] : $_G['cache']['onlinelist'][$groupid];
					$rand_id = rand(1,100);
					$invisible  = $invisiblecount += $rand_id < 3 ? 1 : 0;
					
					$lastactivity = dgmdate($_G['timestamp'] - rand(1, $onlinehold/60) * 60, 't');
					$memberlist = array('uid' => $v['uid'], 'username' => $v['username'], 'groupid' => $_G['groupid'], 'invisible' => $invisible, 'icon' => $icon, 'action' => 2, 'lastactivity' => $lastactivity);
					$whosonline[] = $memberlist;
				}
				$cache_setting['whosonline'] = $whosonline;
				$cache_setting['invisiblecount'] = $invisiblecount;
			}else{
				$whosonline = $setting['whosonline'];
				if($_G['uid']){
					$have = 0;
					foreach($whosonline as $k => $v){
						if($v['uid'] == $_G['uid']) {
							$have = 1;
							break;
						}
					}
					$now_user = array();
					if($have == 0){
						$now_user = $_G['session'];
						$groupid = $_G['groupid'];
						$now_user['icon'] = empty($_G['cache']['onlinelist'][$groupid]) ? $_G['cache']['onlinelist'][0] : $_G['cache']['onlinelist'][$groupid];
						$whosonline[0] = $now_user;
					}
				}
				$invisiblecount = $setting['invisiblecount'];
			}
			
			$membercount = count($whosonline);
		}else{
			$membercount += $add_member_count;
		}
		$guestcount += $add_guest_count;
		if(!$setting){
			$cache_setting['guestcount'] = $guestcount;
			$cache_setting['dateline'] = $_G['timestamp'];
			save_syscache('milu_pick_vir_online', $cache_setting);
		}else{
			$guestcount = $setting['guestcount'];
		}
		$onlinenum = $guestcount+$membercount;
		$onlineinfo[0] = $onlineinfo[0] < $onlinenum ? $onlinenum + $onlineinfo[0] : $onlineinfo[0]; 
		return;
	}
	
	//
	function viewthread_bottom_output(){
		global $_G,$postlist,$navtitle;
		if($this->pick_set['open_seo'] != 1) return;
		$this->pick_set['open_seo_mod'] = unserialize($this->pick_set['open_seo_mod']);
		if(!in_array(2, $this->pick_set['open_seo_mod'])) return;
		$this->pick_set['push_content_body_arr'] = format_wrap($this->pick_set['push_content_body']);
		$this->pick_set['push_reply_body_arr'] = format_wrap($this->pick_set['push_reply_body']);
		foreach($postlist as $pid => $post) {
			if($post['first'] == 1){
				$seo_arr = $this->_article_seo_output(array('title' => $post['subject'], 'content' => $post['message']));
				$postlist[$pid]['message'] = $seo_arr['content'];
				$short_title = cutstr($seo_arr['title'], 52);
				$navtitle = str_replace($post['subject'], $seo_arr['title'], $navtitle);
				$_G['forum_thread']['short_subject'] = str_replace($_G['forum_thread']['short_subject'], $short_title, $_G['forum_thread']['short_subject']);
				$postlist[$pid]['subject'] = $seo_arr['title'];
			}
			if(($post['first'] == 1 && $this->pick_set['push_content_body_arr']) || ($post['first'] != 1 && $this->pick_set['push_reply_body_arr']) ) $postlist[$pid]['message'] = preg_replace("/<br \/>|<br>/e", "\$this->_jammer(\$post['first'])", $postlist[$pid]['message']);
		}
	}
	
}

class plugin_milu_pick_portal extends plugin_milu_pick {
	
	function plugin_milu_pick_portal(){
		$this->_check_open();
		$this->_show_output('portal');
	}
	function portalcp_top_output() {
		if($this->output) return $this->output;
		
	}
	function view_article_content_output(){
		global $_G,$content,$article,$navtitle;
		if(  $this->pick_set['open_seo'] != 1) return;
		$this->pick_set['open_seo_mod'] = unserialize($this->pick_set['open_seo_mod']);
		if(!in_array(1, $this->pick_set['open_seo_mod'])) return;
		$seo_arr = $this->_article_seo_output(array('content' => $content['content'], 'title' => $article['title']));
		$content['content'] = $seo_arr['content'];
		$navtitle = str_replace($article['title'], $seo_arr['title'], $navtitle);
		$article['title'] = $seo_arr['title'];
	}
	

	function portalcp_bottom_output(){
		if($_GET['pick_aid']){
			$show = $this->_public_add_info('portal');
			$this->script .= $show;
		}
		if($this->script || $_GET['pick_aid']) return $this->script;
	}
}


class plugin_milu_pick_home extends plugin_milu_pick {
	
	function plugin_milu_pick_home(){
		
	}
	
	function space_blog_title_output(){
		global $_G,$blog,$navtitle;
		$this->_ini();
		$old_subject = $blog['subject'];
		if(  $this->pick_set['open_seo'] != 1) return;
		$this->pick_set['open_seo_mod'] = unserialize($this->pick_set['open_seo_mod']);
		if(!in_array(3, $this->pick_set['open_seo_mod'])) return;
		$seo_arr = $this->_article_seo_output(array('title' => $blog['subject'], 'content' => $blog['message']));
		$blog['message'] = $seo_arr['content'];
		$navtitle = str_replace($blog['subject'], $seo_arr['title'], $navtitle);
		$blog['subject'] = $seo_arr['title'];
	}
	function spacecp_blog_bottom_output(){
		if(!$_GET['pick_aid']) return;
		$show = $this->_public_add_info('blog');
		return $show;
	}
}	

?>