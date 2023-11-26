<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class adv_gerenzj {

	var $version = '1.0';
	var $name = 'gerenzj_name';
	var $description = 'gerenzj_desc';
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