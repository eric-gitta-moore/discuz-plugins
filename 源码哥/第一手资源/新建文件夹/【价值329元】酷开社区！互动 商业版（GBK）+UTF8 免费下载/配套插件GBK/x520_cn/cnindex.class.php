<?php
/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_x520_cn {
	
	function forumdisplay_x520_top() {
		global $_G,$_GET;
		$var = $_G['cache']['plugin']['x520_cn'];
		return $var['chinaz_forumdisplaypic'];
		
	}

	function forumdisplay_x520_ptext() {
		global $_G,$_GET;
		$var = $_G['cache']['plugin']['x520_cn'];
		return $var['chinaz_ptext'];
		
	}

	function post_right() {
		global $_G,$_GET;
		$var = $_G['cache']['plugin']['x520_cn'];
		return $var['chinaz_forumdisplayaction'];
		
	}

}

class plugin_x520_cn_forum extends plugin_x520_cn {
	
}

?>
