<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_checkcode.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214b98wB3Bomz||7247||1422453601');
}
session_start();
function srmake_seccode($idhash){
	global $_G;
	$seccode = random(6, 1);
	$seccodeunits = '';
	if($_G['setting']['seccodedata']['type'] == 1) {
		$lang = lang('seccode');
		$len = strtoupper(CHARSET) == 'GBK' ? 2 : 3;
		$code = array(substr($seccode, 0, 3), substr($seccode, 3, 3));
		$seccode = '';
		for($i = 0; $i < 2; $i++) {
			$seccode .= substr($lang['chn'], $code[$i] * $len, $len);
		}
	} elseif($_G['setting']['seccodedata']['type'] == 3) {
		$s = sprintf('%04s', base_convert($seccode, 10, 20));
		$seccodeunits = 'CEFHKLMNOPQRSTUVWXYZ';
	} else {
		$s = sprintf('%04s', base_convert($seccode, 10, 24));
		$seccodeunits = 'BCEFGHJKMPQRTVWXY2346789';
	}
	if($seccodeunits) {
		$seccode = '';
		for($i = 0; $i < 4; $i++) {
			$unit = ord($s{$i});
			$seccode .= ($unit >= 0x30 && $unit <= 0x39) ? $seccodeunits[$unit - 0x30] : $seccodeunits[$unit - 0x57];
		}
	}
	return $seccode;
}

$refererhost = parse_url($_SERVER['HTTP_REFERER']);
$refererhost['host'] .= !empty($refererhost['port']) ? (':'.$refererhost['port']) : '';
$_G['setting']['seccodestatus'] = 1;
$seccode = srmake_seccode(1);

if(!$_G['setting']['nocacheheaders']) {
	@header("Expires: -1");
	@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
	@header("Pragma: no-cache");
}

require_once libfile('class/seccode');

$code = new seccode();
$_SESSION[check_seccodeverify]=$seccode;
$code->code = $seccode;
$code->type = 0;//$_G['setting']['seccodedata']['type'];
$code->width = 120;//$_G['setting']['seccodedata']['width'];
$code->height = 30;//$_G['setting']['seccodedata']['height'];
$code->background = 1;//$_G['setting']['seccodedata']['background'];
$code->adulterate = 1;//$_G['setting']['seccodedata']['adulterate'];
$code->ttf = 0;//$_G['setting']['seccodedata']['ttf'];
$code->angle = 0;//$_G['setting']['seccodedata']['angle'];
$code->warping = 0;//$_G['setting']['seccodedata']['warping'];
$code->scatter = '';//$_G['setting']['seccodedata']['scatter'];
$code->color = 1;//$_G['setting']['seccodedata']['color'];
$code->size = 0;//$_G['setting']['seccodedata']['size'];
$code->shadow = 1;//$_G['setting']['seccodedata']['shadow'];
$code->animator = 0;//$_G['setting']['seccodedata']['animator'];
$code->fontpath = DISCUZ_ROOT.'./static/image/seccode/font/';
$code->datapath = DISCUZ_ROOT.'./static/image/seccode/';
$code->includepath = DISCUZ_ROOT.'./source/class/';

$code->display();
?>