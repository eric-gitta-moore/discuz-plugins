<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class adv_forumdisplayarr {

	var $version = '1.0';
	var $name = 'forumdisplayarr_name';
	var $description = 'forumdisplayarr_desc';
	var $copyright = 'zhikai_mobiad_copyright';
	var $targets = array('forum');
	var $imagesizes = array('320x40','320x50','468x40','468x60');

function getsetting() {
		global $_G;
		$settings = array(
			'fids' => array(
				'title' => 'forumdisplayarr_fids',
				'type' => 'mselect',
				'value' => array(),
			),

			'pnumber' => array(
				'title' => 'forumdisplayarr_pnumber',
				'type' => 'mselect',
				'value' => array(),
				'default' => array(0),
			),
		);
		loadcache(array('forums', 'grouptype'));
		$settings['fids']['value'][] = array(0, '&nbsp;');
		if(empty($_G['cache']['forums'])) $_G['cache']['forums'] = array();
		foreach($_G['cache']['forums'] as $fid => $forum) {
			$settings['fids']['value'][] = array($fid, ($forum['type'] == 'forum' ? str_repeat('&nbsp;', 4) : ($forum['type'] == 'sub' ? str_repeat('&nbsp;', 8) : '')).$forum['name']);
		}

		for($i = 1;$i <= $_G['setting']['mobile']['mobiletopicperpage'];$i++) {
			$settings['pnumber']['value'][$i] = array($i, '> #'.$i);
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

	function evalcode() {
		return array(
			'check' => '
			$parameter[\'pnumber\'] = $parameter[\'pnumber\'] ? $parameter[\'pnumber\'] : array(1);
			if(!in_array($params[2] + 1, (array)$parameter[\'pnumber\'])
			|| $_G[\'basescript\'] == \'forum\' && $parameter[\'fids\'] && !in_array($_G[\'fid\'], $parameter[\'fids\'])

			) {
				$checked = false;
			}',
			'create' => '$adcode = $codes[$adids[array_rand($adids)]];',
		);
	}

}

?>