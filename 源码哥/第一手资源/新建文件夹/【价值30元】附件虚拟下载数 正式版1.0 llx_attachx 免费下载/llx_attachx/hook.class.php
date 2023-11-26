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

class plugin_llx_attachx {
	
	public $config = array();
	
	public function __construct() {
		
		global $_G;
		$this->config = $_G['cache']['plugin']['llx_attachx'];
	}
	
	public function post_message($params) {
		
		global $_G;
		
		if(!in_array($_G['fid'], unserialize($this->config['fids']))) return;
		if(!in_array($_G['groupid'], unserialize($this->config['gids']))) return;
		
		$param = $params['param'];
		if($param[0] == 'post_newthread_succeed' || $param[0] == 'post_newthread_mod_succeed') {
			
			$tid = $param[2]['tid'];
			$rs = C::t('forum_attachment')->fetch_all_by_id('tid', $tid);
			foreach($rs as $v) {
				$download_num = mt_rand($this->config['min'], $this->config['max']);
				C::t('forum_attachment')->update_download($v['aid'], $download_num);
			}
		}
	}
}

class plugin_llx_attachx_forum extends plugin_llx_attachx {}

class mobileplugin_llx_attachx_forum extends plugin_llx_attachx {}