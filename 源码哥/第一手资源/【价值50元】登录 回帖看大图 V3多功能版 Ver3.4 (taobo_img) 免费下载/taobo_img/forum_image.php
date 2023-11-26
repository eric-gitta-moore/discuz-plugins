<?php



/*
 *Դ  ��  ��     y    m g    6     .     c o  m
 *������ҵ���/ģ��������� ����Դ ��  ��
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */

chdir('../../../');

define('SUB_DIR', '/source/plugin/taobo_img/');

// ����Ӧ�� ID

define('APPTYPEID', 2);

define('CURSCRIPT', 'forum');

//====================================

// �����ļ����룬 �������������ļ����ܲ���Ҫ

// class_forum.php �� function_forum.php

// �����ʵ����Ҫȷ���Ƿ�����

//====================================

require './source/class/class_core.php';



require './source/function/function_forum.php';

$mod = 'image';

//�����峣��, ��̳�Լ�ģ�����ʱ����Ҫ

define('CURMODULE', $mod);

//====================================

// ���Ĵ���

//====================================



$discuz = & discuz_core::instance();

//�������ֹrobot����

$discuz->reject_robot();

//====================================

// ���غ��Ĵ���

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