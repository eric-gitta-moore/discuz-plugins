<?php
/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
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