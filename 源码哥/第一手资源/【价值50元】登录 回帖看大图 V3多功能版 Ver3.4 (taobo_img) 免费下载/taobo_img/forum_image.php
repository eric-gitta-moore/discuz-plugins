<?php



/*
 *源  码  哥     y    m g    6     .     c o  m
 *更多商业插件/模版免费下载 就在源 码  哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

chdir('../../../');

define('SUB_DIR', '/source/plugin/taobo_img/');

// 定义应用 ID

define('APPTYPEID', 2);

define('CURSCRIPT', 'forum');

//====================================

// 基础文件引入， 其他程序引导文件可能不需要

// class_forum.php 和 function_forum.php

// 请根据实际需要确定是否引入

//====================================

require './source/class/class_core.php';



require './source/function/function_forum.php';

$mod = 'image';

//并定义常量, 论坛以及模板解析时候需要

define('CURMODULE', $mod);

//====================================

// 核心处理

//====================================



$discuz = & discuz_core::instance();

//本程序禁止robot访问

$discuz->reject_robot();

//====================================

// 加载核心处理

//====================================

$discuz->cachelist = array();



$discuz->init();



if(!defined('IN_DISCUZ') || empty($_GET['aid']) || empty($_GET['size']) || empty($_GET['key'])) {

	header('location: '.$_G['siteurl'].'static/image/common/none.gif');

	exit;

}



require './source/plugin/taobo_img/taobo_img.class.php';



$nocache = !empty($_GET['nocache']) ? 1 : 0;

$daid = intval($_GET['aid']);

$type = !empty($_GET['type']) ? $_GET['type'] : '1';

list($w, $h) = explode('x', $_GET['size']);

$dw = intval($w);

$dh = intval($h);

$thumbfile = plugin_taobo_img::thumbpatch($daid, $dw, $dh);

$parse = parse_url($_G['setting']['attachurl']);

$attachurl = !isset($parse['host']) ? $_G['siteurl'].$_G['setting']['attachurl'] : $_G['setting']['attachurl'];

if(!$nocache) {

	if(file_exists($_G['setting']['attachdir'].$thumbfile)) {

		dheader('location: '.$attachurl.$thumbfile);

	}

}



define('NOROBOT', TRUE);



$id = !empty($_GET['atid']) ? $_GET['atid'] : $daid;

if(plugin_taobo_img::dsign($id.'|'.$dw.'|'.$dh) != $_GET['key']) {

	dheader('location: '.$_G['siteurl'].'static/image/common/none.gif');

}



if($_G['setting']['version'] === 'X2') {

	$attach = DB::fetch(DB::query("SELECT * FROM ".DB::table(getattachtablebyaid($daid))." WHERE aid='$daid' AND isimage IN ('1', '-1')"));

} else {

	$attach = C::t('forum_attachment_n')->fetch('aid:'.$daid, $daid, array(1, -1));

}

if($attach) {

	if(!$dw && !$dh && $attach['tid'] != $id) {

	       dheader('location: '.$_G['siteurl'].'static/image/common/none.gif');

	}

        dheader('Expires: '.gmdate('D, d M Y H:i:s', TIMESTAMP + 3600).' GMT');

	if($attach['remote']) {

		$filename = $_G['setting']['ftp']['attachurl'].'forum/'.$attach['attachment'];

	} else {

		$filename = $_G['setting']['attachdir'].'forum/'.$attach['attachment'];

	}

	require_once libfile('class/image');

	$img = new image;

	if($img->Thumb($filename, $thumbfile, $w, $h, $type)) {

		if($nocache) {

			dheader('Content-Type: image');

			@readfile($_G['setting']['attachdir'].$thumbfile);

			@unlink($_G['setting']['attachdir'].$thumbfile);

		} else {

			dheader('location: '.$attachurl.$thumbfile);

		}

	} else {

		dheader('Content-Type: image');

		@readfile($filename);

	}

}





?>