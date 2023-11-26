<?php
/**
 * ONEXIN HTML5 PLAYER For Discuz!X 2.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_html5player
 * @module	   html5player 
 * @date	   2017-10-07
 * @author	   King
 * @copyright  Copyright (c) 2017 Onexin Platform Inc. (http://www.onexin.com)
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


require_once DISCUZ_ROOT . './source/plugin/onexin_html5player/function_html5player.php';

/*
//--------------Tall us what you think!----------------------------------
*/

class mobileplugin_onexin_html5player {

	protected static $conf = array();
	protected static $isopen = FALSE;

	public function mobileplugin_onexin_html5player() {
		global $_G;
		
		if(!isset($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		self::$isopen = $_G['cache']['plugin']['onexin_html5player']['isopen'] ? TRUE : FALSE;
		if(self::$isopen){
			self::$conf = $_G['cache']['plugin']['onexin_html5player'];
		}
	}
	
	public function discuzcode() {
		global $_G;
				
		if(!self::$conf['isopen']) return '';
		
		$_G['discuzcodemessage'] = _onexin_html5player($_G['discuzcodemessage'], $_G['cache']['plugin']['onexin_html5player']['video']);	
	}

}

// forum
class mobileplugin_onexin_html5player_forum extends mobileplugin_onexin_html5player {
	
	public function viewthread_onexin_html5player_output() {
		global $_G, $postlist;
		
		if(!self::$conf['isopen']) return '';
		
			foreach($postlist as $pid => $value) {
				//$postlist[$pid]['message'] = _onexin_html5player($postlist[$pid]['message'], $_G['cache']['plugin']['onexin_html5player']['video']);
			}

		return '';
	}	
	
}

// portal
class mobileplugin_onexin_html5player_portal extends mobileplugin_onexin_html5player {
	
	public function view_article_content_output() {
		global $_G, $content;
		
		if(!self::$conf['isopen']) return '';
		
		$content['content'] = _onexin_html5player($content['content'], $_G['cache']['plugin']['onexin_html5player']['video']);
		
		return '';
	}	
	
}


