<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}


class plugin_qu_app {
	
	function discuzcode($astring){
		global $_G;
		require_once libfile('function/video','plugin/qu_app');
		$ainuo = $_G['cache']['plugin']['qu_app'];
		$pc_width = 500;
		$pc_height = 375;
		$pcahretable = 'forum_attachment_'.substr($_G['tid'], -1);
		$pcshareaid = DB::result_first("SELECT aid FROM ".DB::table($pcahretable)." WHERE tid='$_G[tid]' AND isimage!='0'");
		if($pcshareaid){
			$cover = getforumimg($pcshareaid,1,200,134);
		}else{
			$cover = 'source/plugin/qu_app/pic/cover.jpg';
		}
		$pc_video = $ainuo['pcvideo'];

		$videoPlay = '';

		if($astring['caller'] == 'discuzcode' && $pc_video){
			$amessage = $_G['discuzcodemessage'];
			$media = preg_match_all("/\[media.*?\[\/media\]/",$amessage,$matcharray);
			$v = $matcharray[0][0];
			
			if($v){
				$av = vgetvideo($v,$pc_width,$pc_height,$cover);
				$_G['discuzcodemessage'] = str_replace($v,$av,$_G['discuzcodemessage']);
			}else{
				$flash = preg_match_all("/\[flash.*?\[\/flash\]/",$amessage,$matcharray);
				$vf = $matcharray[0][0];
				if($vf){
					$av = vgetvideo($vf,$pc_width,$pc_height,$cover);
					$_G['discuzcodemessage'] = str_replace($vf,$av,$_G['discuzcodemessage']);
				}
			}
		}


	}
}
