<?php


/*
 *Դ    ��  �� y m     g 6  . c  o    m
 *������ҵ���/ģ��������� ����Դ   ��    ��
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */

if (!defined('IN_DISCUZ')) {
	exit ('Access Denied');
}
//���峣��
$identifier = 'mxi_aplay';
$setting = $_G['cache']['plugin'][$identifier];
define('PDIR_APLAY', "./source/plugin/$identifier/");
$mods = array (
	'waveform',
	'compress',
	'play'
);

$auditiondir = DISCUZ_ROOT . $setting['auditiondir'];
$waveformdir = DISCUZ_ROOT . $setting['waveformdir'];
$isremote = $setting['isremote'];
$remote_server = $setting['remote_server'];
$remote_token = $setting['remote_token'];

$m = $_GET['mod'];
include_once DISCUZ_ROOT . PDIR_APLAY . 'module/aplay_waveform.php';
include_once DISCUZ_ROOT . PDIR_APLAY . 'function/function_aplay.php';

if ($m == 'play') {
	@ list ($_GET['aid'], $_GET['k'], $_GET['t'], $_GET['uid'], $_GET['tableid']) = daddslashes(explode('|', base64_decode($_GET['aid'])));
 	
	$aid = intval($_GET['aid']);
	if (!$aid) {
		exit ();
	}
	$tableid = 'aid:' . $aid;
	$attach = C :: t('forum_attachment_n')->fetch($tableid, $aid);
	if ($attach) {
		$attach_ext = explode('.',$attach['attachment']);
		$attach_ext = $attach_ext[1];
		if (!in_array($attach_ext, array ('mp3','wma'))) {
			exit('not allow file type');
		}
		$source = $_G['setting']['attachdir'] . 'forum/' . $attach['attachment'];
		if ($attach['remote'] && $setting['remoteftp']) {
			dheader('Location:'.$setting['remoteftp'] . 'forum/' . $attach['attachment']);
		}
		//reade streame
		$attachment = $_G['setting']['attachurl'] . 'forum/' . $attach['attachment'];	
		 dheader('Location:'.$attachment);
	 $brake = readaudio($attachment, 0);
	 $filename = "t.mp3";
	 
	dheader('Content-Encoding: none');
	dheader('Content-Type: application/octet-stream'); 
	dheader('Content-Disposition: attachment; filename='.$filename);
	
	dheader('Pragma: no-cache');	
	dheader('Expires: 0');
	echo $brake;
	}
//	
} else {
	exit ('attach miss!' . $tableid	);	
}

function readaudio($file, $len = 0) {
	if (file_exists($file)) {
		$file_size = filesize($file);
		if ($len == $file_size || $len == 0) {
			$brake = file_get_contents($file);
		}
		elseif ($len > 100 && $len < $file_size) {
			$audio = fopen($file, "r");
			$brake = fread($audio, $len);
		}
		return $brake;
	} else {
		return $file . "inot exist";
	}

}
?>