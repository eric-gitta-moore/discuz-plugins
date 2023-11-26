<?php
/*
 *Դ    ��     ��   y m    g 6   .  c o    m
 *������ҵ���/ģ��������� ����Դ    �� ��
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */
function lang_aplay($key){ 
	global $_G;
	return lang('plugin/mxi_aplay', $key);
}
function mx_debug($log, $identifier = "mxisky") {
	//Э�����ߵ��ԣ����û��ֶ�����,һ�㲻д�ļ�
	global $_G;
	
}
function attach_path($attach) {
	if ($attach) {
		$paths = explode('/', $attach);
		array_pop($paths);
		$paths = implode('/', $paths) . '/';
		return $paths;
	}
}
function makesign($aid, $token) {
	global $_G;
	$timestamp = $_G["timestamp"];
	$tmpArr = array (
		$aid,
		$timestamp,
		$token
	);
	sort($tmpArr);
	$tmpStr = implode($tmpArr);
	$tmpStr = sha1($tmpStr);
	return $tmpStr;
}
function audition_getremotefile($file) {
	global $_G;
	global $setting;
	@set_time_limit(0);
	if(!@readfile($_G['setting']['ftp']['attachurl'].$setting['remote_auditiondir'].$file)) {
		$ftp = ftpcmd('object');
		$tmpfile = @tempnam($_G['setting']['attachdir'], '');
		if($ftp->ftp_get($tmpfile, $setting['remote_auditiondir'].$file, FTP_BINARY)) {
			@readfile($tmpfile);
			@unlink($tmpfile);
		} else {
			@unlink($tmpfile);
			return FALSE;
		}
	}
	return TRUE;
}
function audition_ftpcmd($cmd, $arg1 = '',$type='mp3') {
	static $ftp;
	global $setting;
	$ftpon = getglobal('setting/ftp/on');
	if(!$ftpon) {
		return $cmd == 'error' ? -101 : 0;
	} elseif($ftp == null) {
		$ftp = & discuz_ftp::instance();
	}
	if(!$ftp->enabled) {
		return $ftp->error();
	} elseif($ftp->enabled && !$ftp->connectid) {
		$ftp->connect();
	}
	if($type=='mp3'){
		$source = DISCUZ_ROOT . $setting['auditiondir']. $arg1;
		$target = $setting['remote_auditiondir'].$arg1;
	}elseif($type=='wave'){
		$source = DISCUZ_ROOT . $setting['waveformdir']. $arg1;
		$target = $setting['remote_wavedir']. $arg1;
	}
	switch ($cmd) {
		case 'upload' : return $ftp->upload($source, $target); break;
		case 'delete' : return $ftp->ftp_delete($arg1); break;
		case 'close'  : return $ftp->ftp_close(); break;
		case 'error'  : return $ftp->error(); break;
		case 'object' : return $ftp; break;
	}	 
}
function audioinfo($file) {
		global $_G;
		require_once DISCUZ_ROOT . "./source/plugin/mxi_aplay/class/getid/getid3.php";
		require_once DISCUZ_ROOT . "./source/plugin/mxi_aplay/class/class_audioexif.php";
		$au = new AudioInfo();
		if (file_exists($file)) {
			$audioinfo = $au->Info($file);
			$ext = strtolower($audioinfo['format_name']);
			$audioinfo['ext'] = $ext;
			$audioinfo['filesize'] = sizecount($audioinfo['filesize']);
			$audioinfo['playtimes'] = floor($audioinfo['playing_time'] / 60) . '"' . $audioinfo['playing_time'] % 60 . "'";
			$audioinfo['bitrate'] = $audioinfo['avg_bit_rate'] ? intval($audioinfo['avg_bit_rate']) / 1000 : 0;
			return $audioinfo;
		}
		return array ('bitrate'=>'128KBS','playtimes'=>'0:00','filesize'=>'Unkonw');
	} 
?>