<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_llx_threadhighlight {
	
	public $config = array();
	
	public function __construct() {
		
		global $_G;
$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='llx_threadhighlight'");
if(!strstr($ym_copyright['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x662f;&#x76d7;&#x5356;&#x4efd;&#x5b50;&#x8f6c;&#x8f7d;&#x4e8e;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODYyMC0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
		$this->config = $_G['cache']['plugin']['llx_threadhighlight'];
	}
	
	public function post_message($params) {
		
		global $_G;
		
		if(!in_array($_G['fid'], unserialize($this->config['fids']))) return;
		if(!in_array($_G['groupid'], unserialize($this->config['gids']))) return;
		
		$param = $params['param'];
		if($param[0] == 'post_newthread_succeed' || $param[0] == 'post_newthread_mod_succeed') {
			
			$tid = $param[2]['tid'];
			$highlight_color = mt_rand(0, 8);
			C::t('forum_thread')->update($tid, array('highlight' => $highlight_color), true);
			C::t('forum_forumrecommend')->update($tid, array('highlight' => $highlight_color));
		}
	}
}

class plugin_llx_threadhighlight_forum extends plugin_llx_threadhighlight {}

class mobileplugin_llx_threadhighlight_forum extends plugin_llx_threadhighlight {}