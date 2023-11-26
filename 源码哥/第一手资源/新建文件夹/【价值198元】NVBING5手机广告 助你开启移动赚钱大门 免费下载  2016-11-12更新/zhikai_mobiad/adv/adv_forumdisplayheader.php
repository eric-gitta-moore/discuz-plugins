<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class adv_forumdisplayheader {

	var $version = '1.0';
	var $name = 'forumdisplayheader_name';
	var $description = 'forumdisplayheader_desc';
	var $copyright = 'zhikai_mobiad_copyright';
	var $targets = array('forum');
	var $imagesizes = array('320x40','320x50','468x40','468x60');

	function getsetting() {
		global $_G;
		$settings = array(
			'fids' => array(
				'title' => 'forumdisplayheader_fids',
				'type' => 'mselect',
				'value' => array(),
			),
			
		);
		loadcache(array('forums', 'grouptype'));
		$settings['fids']['value'][]  = array(0, '&nbsp;');
		if(empty($_G['cache']['forums'])) $_G['cache']['forums'] = array();
		foreach($_G['cache']['forums'] as $fid => $forum) {
			$settings['fids']['value'][] = array($fid, ($forum['type'] == 'forum' ? str_repeat('&nbsp;', 4) : ($forum['type'] == 'sub' ? str_repeat('&nbsp;', 8) : '')).$forum['name']);
		}
		return $settings;
	}

	function setsetting(&$advnew, &$parameters) {
		global $_G;
		if(is_array($advnew['targets'])) {
			$advnew['targets'] = implode("\t", $advnew['targets']);
		}
		if(is_array($parameters['extra']['fids']) && in_array(0, $parameters['extra']['fids'])) {
			$parameters['extra']['fids'] = array();
		}

	}

	function evalcode($adv) {
		return array(
			'check' => '
			if($_G[\'basescript\'] == \'forum\' && $parameter[\'fids\'] && !(!defined(\'IN_ARCHIVER\') && (in_array($_G[\'fid\'], $parameter[\'fids\']) || CURMODULE == \'index\' && in_array(-1, $parameter[\'fids\'])) || defined(\'IN_ARCHIVER\') && in_array(-2, $parameter[\'fids\']))
			) {
				$checked = false;
			}',
			'create' => '
				$adid = $adids[array_rand($adids)];
				$extra = $parameters[$adid][\'height\'] ? \' style="line-height:\'.$parameters[$adid][\'height\'].\'px;height:\'.$parameters[$adid][\'height\'].\'px"\' : \'\';
				$adcode = $codes[$adid];
			',
		);
	}

}

?>