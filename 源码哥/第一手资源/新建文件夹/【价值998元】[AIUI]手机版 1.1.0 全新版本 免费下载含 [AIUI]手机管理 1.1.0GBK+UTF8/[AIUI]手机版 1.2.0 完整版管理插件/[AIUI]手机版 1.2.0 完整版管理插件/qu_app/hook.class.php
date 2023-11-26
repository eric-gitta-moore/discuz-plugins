<?php

/**
 *      [ainuo] (C)2010-2018 ainuo.
 *
 *      $QQ QQ群：550494646 2017-03 ainuo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class mobileplugin_qu_app {
	function global_footer_mobile() {
		global $_G;
		$_G['setting']['qu_app'] = (array)unserialize($_G['setting']['qu_app']);
		if($_GET['diy'] == 'yes' & getstatus($_G['member']['allowadmincp'], 1)){	
			$_G['sign'] = dsign($_G['style']['directory'].'/touch'.$_G['style']['tplfile']);
			include_once template('qu_app:header_diy');
		    return qu_tpl_diy();
	    }
	}

	function ainuo_generate($value) {
		global $_G;
		$_init_style = false;
		if($_init_style === false) {
			C::app()->_init_style();
			$_init_style = true;
		}
		$file = 'touch/'.$value['dir'].'/'.$value['template'];
		!empty($value['id']) && $file = $file.'_'.$value['id'];
		$tplfile = 'data/diy/./template/qu_app/'.$file.'.htm';
		
		if(is_file(DISCUZ_ROOT.$tplfile)){
			$templateid = 'diy';
			$cachefile = './data/template/'.(defined('STYLEID') ? STYLEID.'_' : '_').$templateid.'_'.str_replace('/', '_', $file).'.tpl.php';
			$tpldir = 'data/diy/./template/qu_app';
			mobileplugin_qu_app::ainuo_checktplrefresh($tplfile, $tplfile, @filemtime(DISCUZ_ROOT.$cachefile), $templateid, $cachefile, $tpldir, $file);
		}
	}
	function ainuo_checktplrefresh($maintpl, $subtpl, $timecompare, $templateid, $cachefile, $tpldir, $file) {
		$tplrefresh = $timestamp = $targettplname = NULL;
		if($tplrefresh === null) {
			$tplrefresh = getglobal('config/output/tplrefresh');
			$timestamp = getglobal('timestamp');
		}
		if(empty($timecompare) || $tplrefresh == 1 || ($tplrefresh > 1 && !($timestamp % $tplrefresh))) {
			if(empty($timecompare) || @filemtime(DISCUZ_ROOT.$subtpl) > $timecompare) {
				require_once DISCUZ_ROOT.'/source/class/class_template.php';
				$template = new template();
				$template->parse_template($maintpl, $templateid, $tpldir, $file, $cachefile);
				if($targettplname === null) {
					$targettplname = $file;
					if(!empty($targettplname)) {
						include_once libfile('function/block');
						$targettplname = strtr($targettplname, ':', '_');
						update_template_block($targettplname, './template/qu_app', $template->blocks);
					}
					$targettplname = true;
				}
				return TRUE;
			}
		}
		return FALSE;
	}
	
	function discuzcode($string){
		global $_G;
		require_once libfile('function/video','plugin/qu_app');
		$cover = 'source/plugin/qu_app/pic/cover.jpg';
		$height = 210;
		$width = '100%';
		loadcache('ainuodata');
		$v_arraya = $_G['cache']['ainuodata']['data'];
		
		$v_array_video = $v_arraya['f_video'];
		$vids_video = (array)unserialize($v_array_video) ? (array)unserialize($v_array_video) : 0;
		
		if(in_array($_G['fid'], $vids_video)) {
			if($string['caller'] == 'discuzcode'){
				$amessage = $_G['discuzcodemessage'];
				$media = preg_match_all("/\[media.*?\[\/media\]/",$amessage,$matcharray);
				$v = $matcharray[0][0];
				if($v){
					$_G['discuzcodemessage'] = str_replace($v,'',$_G['discuzcodemessage']);
				}else{
					$flash = preg_match_all("/\[flash.*?\[\/flash\]/",$amessage,$matcharray);
					$vf = $matcharray[0][0];
					if($vf){
						$_G['discuzcodemessage'] = str_replace($vf,'',$_G['discuzcodemessage']);
					}else{
						$audio = preg_match_all("/\[audio.*?\[\/audio\]/",$amessage,$matcharray);
						$va = $matcharray[0][0];
						if($va){
							$str = preg_replace('/\[audio.*?\](.*)\[\/audio\]/','$1',$va);
							$av = vgetaudio($str);
							$av = '<div class="ainuo_audio cl">'.$av.'</div>';
							$_G['discuzcodemessage'] = str_replace($va,$av,$_G['discuzcodemessage']);
						}
					}
				}
			
			}
		}else{
			if($string['caller'] == 'discuzcode'){
				$amessage = $_G['discuzcodemessage'];
				$media = preg_match_all("/\[media.*?\[\/media\]/",$amessage,$matcharray);
				$v = $matcharray[0][0];
				if($v){
					$str = preg_replace('/\[media.*?\](.*)\[\/media\]/','$1',$v);
					$av = vgetvideo($str,$width,$height,$cover);
					$_G['discuzcodemessage'] = str_replace($v,$av,$_G['discuzcodemessage']);
				}else{
					$flash = preg_match_all("/\[flash.*?\[\/flash\]/",$amessage,$matcharray);
					$vf = $matcharray[0][0];
					if($vf){
						$str = preg_replace('/\[media.*?\](.*)\[\/media\]/','$1',$vf);
						$avf = vgetvideo($str,$width,$height,$cover);
						$_G['discuzcodemessage'] = str_replace($vf,$avf,$_G['discuzcodemessage']);
					}else{
						$audio = preg_match_all("/\[audio.*?\[\/audio\]/",$amessage,$matcharray);
						$va = $matcharray[0][0];
						if($va){
							$str = preg_replace('/\[audio.*?\](.*)\[\/audio\]/','$1',$va);
							$av = vgetaudio($str);
							$av = '<div class="ainuo_audio cl">'.$av.'</div>';
							$_G['discuzcodemessage'] = str_replace($va,$av,$_G['discuzcodemessage']);
						}
					}
				}
			}
		}
	}

}

class mobileplugin_qu_app_portal extends mobileplugin_qu_app {
	function list_quappdiy(){
		$para = array('template' => 'list','dir'=>'portal');
        mobileplugin_qu_app::ainuo_generate($para);	
	}
	function topic_qu(){
		global $_G;
		$file = 'touch/portal/portal_topic_content_'.$_GET['topicid'];
		if(file_exists(DISCUZ_ROOT.'./data/diy/template/qu_app/'.$file.'.htm')){
			$para = array('template' => 'portal_topic_content', 'dir' => 'portal', 'id' => $_GET['topicid']);
            mobileplugin_qu_app::ainuo_generate($para);	
			$cachefile = DISCUZ_ROOT.'./data/template/'.(defined('STYLEID') ? STYLEID.'_' : '_').'diy_'.str_replace('/', '_', $file).'.tpl.php';
			include $cachefile;
			exit;
		}
	}
	
}

class mobileplugin_qu_app_forum extends mobileplugin_qu_app {
	
	function guide_quappdiy(){
		global $_G;
		
		$para = array('template' => 'guide','dir'=>'forum');
		$file = 'touch/forum/guide';
		if(file_exists(DISCUZ_ROOT.'./data/diy/template/qu_app/'.$file.'.htm')){
            mobileplugin_qu_app::ainuo_generate($para);
		    $cachefile = DISCUZ_ROOT.'./data/template/'.(defined('STYLEID') ? STYLEID.'_' : '_').'diy_'.str_replace('/', '_', $file).'.tpl.php';
			include $cachefile;
			exit;
		}
	}
	
	function index_quappdiy(){
		$para = array('template' => 'discuz','dir'=>'forum');
        mobileplugin_qu_app::ainuo_generate($para);	
	}
	
	function viewthread_top_mobile(){
		global $_G;
		require_once libfile('function/video','plugin/qu_app');
		$cover = 'source/plugin/qu_app/pic/cover.jpg';
		$width = '100%';
		$height = 210;
		$tid = $_G['tid'];
		loadcache('ainuodata');
		$view_arraya = $_G['cache']['ainuodata']['data'];
		$v_array_video = $view_arraya['f_video'];
		$vids_videos = (array)unserialize($v_array_video) ? (array)unserialize($v_array_video) : 0;	
		if(!in_array($_G['fid'], $vids_videos)) {return;}
		$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
		$message = $post['message'];
		$matches = array();
		$arr = array();
		$av = '';
		$media = preg_match_all("/\[media.*?\[\/media\]/",$message,$matcharray);
		$v = $matcharray[0][0];
		if($v){
			$str = preg_replace('/\[media.*?\](.*)\[\/media\]/','$1',$v);
			$av = vgetvideo($str,$width,$height,$cover);
		}else{
			$flash = preg_match_all("/\[flash.*?\[\/flash\]/",$message,$matcharray);
			$vf = $matcharray[0][0];
			if($vf){
				$str = preg_replace('/\[flash.*?\](.*)\[\/flash\]/','$1',$vf);
				$av = vgetvideo($str,$width,$height,$cover);
			}
		}
		if($av){
			$av = '<style>.topfixdiv,.header .nav .name{display:none;}.header{background:none;}.header .nav .z,.header .nav .jubao{ color:#fff;}</style>'.$av;
		}else{
			$av = '';
		}
		return $av;
	}
	
	function forumdisplay_littlepic_mobile_output(){
		global $_G;
        $return = $listinfo = $tids = array();
        foreach($_G['forum_threadlist'] as $key){$tids[] = $key['tid'];}
		sort($tids);
        $listinfo = $this->get_alistinfo($_G['forum_threadlist'],$tids);
		loadcache('ainuodata');
		$f_arraya = $_G['cache']['ainuodata']['data'];
		
		$f_array_news = $f_arraya['f_news'];
		$fids_news = (array)unserialize($f_array_news) ? (array)unserialize($f_array_news) : 0;
		
		$f_array_quan = $f_arraya['f_quan'];
		$fids_quan = (array)unserialize($f_array_quan) ? (array)unserialize($f_array_quan) : 0;
		
		$f_array_tuwen = $f_arraya['f_tuwen'];
		$fids_tuwen = (array)unserialize($f_array_tuwen) ? (array)unserialize($f_array_tuwen) : 0;
		
		$f_array_qqzone = $f_arraya['f_qqzone'];
		$fids_qqzone = (array)unserialize($f_array_qqzone) ? (array)unserialize($f_array_qqzone) : 0;
		
		$f_array_weibo = $f_arraya['f_weibo'];
		$fids_weibo = (array)unserialize($f_array_weibo) ? (array)unserialize($f_array_weibo) : 0;
		
		$f_array_bigpic = $f_arraya['f_bigpic'];
		$fids_bigpic = (array)unserialize($f_array_bigpic) ? (array)unserialize($f_array_bigpic) : 0;
		
		$f_array_pbl = $f_arraya['f_pbl'];
		$fids_pbl = (array)unserialize($f_array_pbl) ? (array)unserialize($f_array_pbl) : 0;
		
		$f_array_video = $f_arraya['f_video'];
		$fids_video = (array)unserialize($f_array_video) ? (array)unserialize($f_array_video) : 0;
		
		$f_array_music = $f_arraya['f_music'];
		$fids_music = (array)unserialize($f_array_music) ? (array)unserialize($f_array_music) : 0;
		
		$f_array_trade = $f_arraya['f_trade'];
		$fids_trade = (array)unserialize($f_array_trade) ? (array)unserialize($f_array_trade) : 0;
		
		$f_array_activity = $f_arraya['f_activity'];
		$fids_activity = (array)unserialize($f_array_activity) ? (array)unserialize($f_array_activity) : 0;
		
		
		
		//新闻风格
		if(in_array($_G['fid'], $fids_news)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					if($numcount == 1 || $numcount == 2){
						$rstring = '<div class="apic1 ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div><div class="atitle" '.$thread['highlight'].'>'.$thread['subject'].'</div>';
					}elseif($numcount == 3){
						$rstring = '<div class="atitle" '.$thread['highlight'].'>'.$thread['subject'].'</div></div><div class="apic3 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[2].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
					}
				}else{
					$rstring = '<div class="atitle" '.$thread['highlight'].'>'.$thread['subject'].'</div>';
				}
				
				$return[] = $rstring;
			}
		//视频风格
		}elseif(in_array($_G['fid'], $fids_video)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					$rstring = '<div class="atitle" '.$thread['highlight'].'>'.$thread['subject'].'</div>';
					$rstring .= '<div class="avideo">'.$alist_thumb.'</div>';
				}else{
					$rstring = '<div class="atitle" '.$thread['highlight'].'>'.$thread['subject'].'</div>';
				}
				
				$return[] = $rstring;
			}
		//音频风格
		}elseif(in_array($_G['fid'], $fids_music)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					$rstring = '<div class="atitle" '.$thread['highlight'].'><a href="forum.php?mod=viewthread&tid='.$thread[tid].'">'.$thread['subject'].'</a></div>';
					$rstring .= '<div class="amusic">'.$alist_thumb.'</div>';
				}else{
					$rstring = '<div class="atitle" '.$thread['highlight'].'>'.$thread['subject'].'</div>';
				}
				
				$return[] = $rstring;
			}
		//商品风格
		}elseif(in_array($_G['fid'], $fids_trade)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					$rstring = '<img class="ainuolazyload" data-original="'.$alist_thumb[0].'" />';
				}else{
					$rstring = '<img class="ainuolazyload" data-original="source/plugin/qu_app/images/nopic.png" />';
				}
				
				$return[] = $rstring;
			}
		//圈子风格+图文
		}elseif(in_array($_G['fid'], $fids_quan) || in_array($_G['fid'], $fids_tuwen)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					if($numcount == 1){
						$rstring = '<div class="apic1 ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
					}elseif($numcount == 2){
						$rstring = '</div><div class="apic2 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';

					}else if($numcount == 3){
						$rstring = '</div><div class="apic3 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[2].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';

					}
				}
				
				$return[] = $rstring;
			}
		//大图风格+活动风格
		}elseif(in_array($_G['fid'], $fids_bigpic) || in_array($_G['fid'], $fids_activity)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					$rstring = '<div class="apic"><img class="ainuolazyload" data-original="'.$alist_thumb[0].'" /></div>';
				}else{
					if(in_array($_G['fid'], $fids_activity)){
						$rstring = '<div class="apic"><img class="ainuolazyload" data-original="source/plugin/qu_app/images/activity.png" /></div>';
					}
				}
				
				$return[] = $rstring;
			}
		//瀑布流风格
		}elseif(in_array($_G['fid'], $fids_pbl)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					$rstring = '<div class="apic"><img src="'.$alist_thumb[0].'" /></div>';
				}else{
					$rstring = '<div class="apic"><img src="source/plugin/qu_app/images/nopic.png" /></div>';
				}
				
				$return[] = $rstring;
			}
		//微博风格
		}elseif(in_array($_G['fid'], $fids_weibo)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					if($numcount == 1){
						$rstring = '<div class="apic1"><img class="ainuolazyload" data-original="'.$alist_thumb[0].'" /></div>';
					}elseif($numcount == 2){
						$rstring = '<div class="apic2 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '</div>';

					}elseif(($numcount > 2) && $numcount < 6){
						$rstring = '<div class="apic3 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[2].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '</div>';

					}elseif(($numcount > 5) && $numcount < 9){
						$rstring = '<div class="apic3 cl">';
						foreach($alist_thumb as $thumb){
							$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$thumb.'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						}
						$rstring .= '</div>';

					}elseif($numcount == 9){
						$rstring = '<div class="apic3 cl">';
						foreach($alist_thumb as $thumb){
							$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$thumb.'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						}
						$rstring .= '</div>';

					}
					
				}
				
				$return[] = $rstring;
			}
		//空间风格
		}elseif(in_array($_G['fid'], $fids_qqzone)) {
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					if($numcount == 1){
						$rstring = '<div class="apic1"><img class="ainuolazyload" data-original="'.$alist_thumb[0].'" /></div>';
					}elseif($numcount == 2){
						$rstring = '<div class="apic2 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '</div>';
					}elseif($numcount == 3){
						$rstring = '<div class="apic3 cl">';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[1].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$alist_thumb[2].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27450%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						$rstring .= '</div>';
					}
				}
				
				$return[] = $rstring;
			}
		//默认风格
		}else{
			foreach($_G['forum_threadlist'] as $thread) {
				$tid = $thread['tid'];
				$rstring = '';
				$alist_thumb = $listinfo[$tid]['newimgarr'];
				if($numcount = count($alist_thumb)){
					if($numcount == 1){
						$rstring = '<div class="apic1 ainuolazyloadbg" data-original="'.$alist_thumb[0].'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
					}elseif($numcount == 2){
						$rstring = '</div><div class="apic2 cl">';
						foreach($alist_thumb as $key => $thumb) {
							$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$thumb.'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						}
					}else if($numcount == 3){
						$rstring = '</div><div class="apic3 cl">';
						foreach($alist_thumb as $key => $thumb) {
							$rstring .= '<div class="apic ainuolazyloadbg" data-original="'.$thumb.'" style="background-size:cover;"><img src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%27600%27%20height%3D%27450%27%20version%3D%271.1%27%20xmlns%3D%27http%3A//www.w3.org/2000/svg%27%3E%3Crect%20x%3D%270%27%20y%3D%270%27%20width%3D%27100%25%27%20height%3D%27100%25%27%20style%3D%27fill%3Atransparent%3B%27/%3E%3C/svg%3E" /></div>';
						}
					}
				}
				
				$return[] = $rstring;
			}
		}
		
        return $return;
	}
	
	function get_alistinfo($threads,$tids){
		global $_G;
		require_once libfile('function/cache');
		$cachename = md5('qu_'.implode('', $tids));
		$cache_file = DISCUZ_ROOT.'./data/sysdata/qu_app_cache/forumdisplay/cache_'.$cachename.'.php';
		loadcache('ainuodata');
		$f_arraya = $_G['cache']['ainuodata']['data'];
		$f_array_qqzone = $f_arraya['f_qqzone'];
		$fids_qqzone = (array)unserialize($f_array_qqzone) ? (array)unserialize($f_array_qqzone) : 0;
		$f_array_weibo = $f_arraya['f_weibo'];
		$fids_weibo = (array)unserialize($f_array_weibo) ? (array)unserialize($f_array_weibo) : 0;
		$f_array_bigpic = $f_arraya['f_bigpic'];
		$fids_bigpic = (array)unserialize($f_array_bigpic) ? (array)unserialize($f_array_bigpic) : 0;
		$f_array_pbl = $f_arraya['f_pbl'];
		$fids_pbl = (array)unserialize($f_array_pbl) ? (array)unserialize($f_array_pbl) : 0;
		$f_array_video = $f_arraya['f_video'];
		$fids_video = (array)unserialize($f_array_video) ? (array)unserialize($f_array_video) : 0;
		$f_array_music = $f_arraya['f_music'];
		$fids_music = (array)unserialize($f_array_music) ? (array)unserialize($f_array_music) : 0;
		$f_array_trade = $f_arraya['f_trade'];
		$fids_trade = (array)unserialize($f_array_trade) ? (array)unserialize($f_array_trade) : 0;
		$f_array_activity = $f_arraya['f_activity'];
		$fids_activity = (array)unserialize($f_array_activity) ? (array)unserialize($f_array_activity) : 0;
		
		$anwidth = 220;
		$anheight = 180;
		$ainuofix = 'fixwr';
				
		if(in_array($_G['fid'], $fids_weibo)) {
			$anwidth = 200;
			$anheight = 200;
			$picnum = 8;
		}elseif(in_array($_G['fid'], $fids_bigpic) || in_array($_G['fid'], $fids_activity)){
			$anwidth = 480;
			$anheight = 220;
			$picnum = 1;
		}elseif(in_array($_G['fid'], $fids_pbl)){
			$anwidth = 250;
			$anheight = 500;
			$picnum = 1;
			$ainuofix = 'fixnone';
		}elseif(in_array($_G['fid'], $fids_trade)){
			$anwidth = 180;
			$anheight = 180;
			$picnum = 1;
			$ainuofix = 'fixwr';
		}else{
			$picnum = 2;
		}
		
		$av = $avf = $ava = '';
		
		$listcachetime = $_G['cache']['plugin']['qu_app']['listcachetime'] ? $_G['cache']['plugin']['qu_app']['listcachetime'] : 0;
		if(($_G['timestamp'] - @filemtime($cache_file)) > $listcachetime) {
			
			//视频
			if(in_array($_G['fid'], $fids_video)) {
				require_once libfile('function/video','plugin/qu_app');
				$cover = 'source/plugin/qu_app/pic/cover.jpg';
				$height = 210;
				$width = '100%';
				foreach ($threads as $thread) {
					$newimgarr = array();
					$tid = $thread['tid'];
					$apost = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
					$amessage = $apost['message'];
					$matcharray = array();
					$media = preg_match_all("/\[media.*?\[\/media\]/",$amessage,$matcharray);
					$v = $matcharray[0][0];
					if($v){
						$str = preg_replace('/\[media.*?\](.*)\[\/media\]/','$1',$v);
						$av = vgetvideo($str,$width,$height,$cover);
					}else{
						$flash = preg_match_all("/\[flash.*?\[\/flash\]/",$amessage,$matcharray);
						$vf = $matcharray[0][0];
						if($vf){
							$str = preg_replace('/\[media.*?\](.*)\[\/media\]/','$1',$vf);
							$av = vgetvideo($str,$width,$height,$cover);
						}
					}
					$data[$tid]['newimgarr'] = $av;
				}
				
			}elseif(in_array($_G['fid'], $fids_music)) {
				require_once libfile('function/video','plugin/qu_app');
				$width = '100%';
				foreach ($threads as $thread) {
					$newimgarr = array();
					$tid = $thread['tid'];
					$apost = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
					$amessage = $apost['message'];
					$matcharray = array();
					$audio = preg_match_all("/\[audio.*?\[\/audio\]/",$amessage,$matcharray);
					$va = $matcharray[0][0];
					if($va){
						$str = preg_replace('/\[audio.*?\](.*)\[\/audio\]/','$1',$va);
						$ava = vgetaudiomusic($str);
						$av = '<div class="ainuo_audio cl">'.$ava.'</div>';
					}
					$data[$tid]['newimgarr'] = $av;
				}
			}else{
				require_once libfile('class/image');
				$img = new image;
				foreach ($threads as $thread) {
					$piccount = 0;
					$list_thumb = array();
					$newimgarr = array();
					$tid = $thread['tid'];
					$tableid = getattachtableid($tid);
					$query = DB::query("SELECT * FROM ".DB::table('forum_attachment_'.$tableid)." WHERE tid ='$tid' and isimage=1 ORDER BY aid ASC LIMIT 3");
					if(count($query)){
						while ($qattach = DB::fetch($query)) {
							$isfirst = DB::result_first("SELECT first FROM ".DB::table('forum_post')." WHERE pid ='$qattach[pid]'");
							if($isfirst || ($thread['special'] == 2)){
								$piccount++;
								$list_thumb[] = $_G['setting']['attachurl'].'forum/'.$qattach['attachment'];
							}
						}
					}
					
					if($piccount < $picnum){
						$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
						$message = $post['message'];
						$matches = array();
						$arr = array();
						preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $message, $matches);					
						if(!empty($matches) && !empty($matches[1]) && is_array($matches[1])){
							foreach($matches[1] as $key => $src){
								if(strpos($src,'/face') || strpos($src,'/smile') || strpos($src,'/emotion')){
									continue;
								}
								if($piccount == ($picnum+1)){break;}
								$piccount++;
								$list_thumb[] = $src;
							}
						}
					}
					
					
					if(in_array($_G['fid'], $fids_qqzone) && (count($list_thumb) == 1)) {
						$anwidth = 300;
						$anheight = 400;
						$ainuofix = 'fixnone';
					}
					if(in_array($_G['fid'], $fids_weibo) && (count($list_thumb) == 1)) {
						$anwidth = 300;
						$anheight = 400;
						$ainuofix = 'fixnone';
					}

					foreach($list_thumb as $key => $athumb){
						$thumbfile = 'qu_app/'.$thread['fid'].'/'.$tableid.'/'.$thread['tid'].'_'.$key.'.jpg';
						if(strpos($athumb,'.gif')){
							$newimgarr[] = $athumb;
						}else{
							if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
								$newimgarr[] = $_G['setting']['attachurl'].$thumbfile;
							}else{
								$_G['setting']['thumbquality'] = '100';
								if($img->Thumb($athumb, $thumbfile, $anwidth, $anheight, $ainuofix)){
									$newimgarr[] = $_G['setting']['attachurl'].$thumbfile;
								}
							}
						}
					}
	
					$data[$tid]['newimgarr'] = $newimgarr;
				}
			}
			$cacheArray = "\$apicdata=".arrayeval($data).";\n";
            $this->awritetocache($cachename, $cacheArray);
		}else{
			include_once DISCUZ_ROOT.'./data/sysdata/qu_app_cache/forumdisplay/cache_'.$cachename.'.php';
            $data = $apicdata;
		}
        return $data;
    }

	
	function awritetocache($script, $cachedata, $prefix = 'cache_') {
		global $_G;
	
		$dir = DISCUZ_ROOT.'./data/sysdata/qu_app_cache/forumdisplay/';
		if(!is_dir($dir)) {
			dmkdir($dir, 0777);
		}
		if($fp = @fopen("$dir$prefix$script.php", 'wb')) {
			fwrite($fp, "<?php\n//Discuz! cache file, DO NOT modify me!\n//Identify: ".md5($prefix.$script.'.php'.$cachedata.$_G['config']['security']['authkey'])."\n\n$cachedata?>");
			fclose($fp);
		} else {
			exit('Can not write to cache files, please check directory ./data/ and ./data/sysdata/qu_app_cache/forumdisplay/ .');
		}
	}

	
	function forumdisplay_mobile_summary_output(){
		global $_G;	
		loadcache('ainuodata');
		$f_arrayw = $_G['cache']['ainuodata']['data'];
		$f_arrayword = $f_arrayw['f_forumsword'];
		$f_arraynum = $f_arrayw['f_wordnum'];
		
		$q_txtfids = (array)unserialize($f_arrayword) ? (array)unserialize($f_arrayword) : 0;
		$f_wordlengh = $f_arraynum;
		$f_wordlengh = $f_wordlengh ? $f_wordlengh : 0;
		$f_wordlengh = intval($f_wordlengh) * 2;
		$threadlist = $_G['forum_threadlist'];
		require_once(DISCUZ_ROOT."./source/function/function_post.php");
		$s = array();
		if(in_array($_G['fid'], $q_txtfids)){
			foreach($threadlist as $key => $value){
				
				$value['summary'] = DB::result_first('SELECT `message` FROM '.DB::table('forum_post').' WHERE `tid` ='.$value['tid'].' AND `first` =1');
				$qvalue = messagecutstr($value['summary'],$f_wordlengh);
				if($qvalue){
					$s[] = '<div class="list_summary cl">'.$qvalue.'</div>';
				}else{
					$s[] = '';
				}
			}

		}
		return $s;
	}

}


?>