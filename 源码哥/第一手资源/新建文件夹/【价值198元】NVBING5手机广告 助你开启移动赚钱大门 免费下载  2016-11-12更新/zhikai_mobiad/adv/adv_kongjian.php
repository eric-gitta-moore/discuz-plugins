<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class adv_kongjian {

	var $version = '1.0';
	var $name = 'kongjian_name';
	var $description = 'kongjian_desc';
	var $copyright = 'zhikai_mobiad_copyright';
	var $targets = array('home');
	var $imagesizes = array('320x40','320x50','468x40','468x60');

	function getsetting() {}

	function setsetting(&$advnew, &$parameters) {
		global $_G;
		if(is_array($advnew['targets'])) {
			$advnew['targets'] = implode("\t", $advnew['targets']);
		}
	}

	function evalcode() {
		return array(
			'check' => '',
			'create' => '$adcode = $codes[$adids[array_rand($adids)]];',
		);
	}

}

?>