<?php


/*
 *源 码 哥    y m    g     6  .  c    o m
 *更多商业插件/模版免费下载 就在源 码   哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit ('Access Denied');
}
loadcache('plugin');
$identifier = 'mxi_aplay';
$mxi_aplay = $_G['cache']['plugin'][$identifier];
include_once DISCUZ_ROOT . "./source/plugin/mxi_aplay/function/function_aplay.php";

$auditiondir = DISCUZ_ROOT . $mxi_aplay['auditiondir'];
$waveformdir = DISCUZ_ROOT . $mxi_aplay['waveformdir'];
if(!submitcheck('optionsubmit')){
	if (is_dir($auditiondir)) {
		if ($dh = opendir($auditiondir)) {
			while (($file = readdir($dh)) !== false) {
				if ($file != "." && $file != ".." && !is_dir($auditiondir . $file) && preg_match('/^copy_aid_(\d+)_(\w+)\.mp3/', $file, $match)) {
					$count++;
					$attachs[] = array ('aid' => $match[1],'file' => $file);
				}
			}
		}
	
		if ($attachs) {
			$i = 0;
			foreach ($attachs as $key => $attach) {
				$aid = intval($attach['aid']);
				if (!$aid) {
					continue;
				}
				$tableid = 'aid:' . $aid;
				$attach = C :: t('forum_attachment_n')->fetch($tableid, $aid);
				if ($attach) {
					$path = attach_path($attach['attachment']);
					$newfile = "copy_aid_{$aid}_" . md5(md5($aid)) . '.mp3';
					$aid = base64_encode(implode('|', array ($aid,$path,$newfile)));
						
					if ($attach['remote']) {
						$api = $_G['siteurl'] . "plugin.php?id=mxi_aplay&mod=compress&aid=" . $aid;
					} else {
						$api = $_G['siteurl'] . "plugin.php?id=mxi_aplay&mod=waveform&aid=" . $attach['aid'];
					}
					$attachs[$key]['api'] = $api;
					$attachs[$key]['remote'] = $attach['remote'];
				} else {
					$count_invalid++;
					unset ($attachs[$key]);
					@ unlink($auditiondir . $file);
				}
			}
		}
	}
	showformheader('plugins&operation=config&do=154&identifier=mxi_aplay&pmod=admincp_attach');
	showtableheader();
	showsubtitle(array (
			'',		 
			'aid',
			$lang['dispaly_order'],
			'setting_attach_remote',
			$lang['operation'],
			
			
			
		));
	if ($attachs) {
		$i = 0;
		foreach ($attachs as $key => $attach) {
			showtablerow('', array('class="td25"', 'class="td28"'), array(
		'<input type="checkbox" class="checkbox" name="delete[]" value="'.$attach['aid'].'" />',
		'<input type="text" class="txt" name="displayordernew['.$key.']" value="'.$attach['aid'].'" size="2" />',
		cplang($attach['remote']  ? 'yes' : 'no'),
		"<a href=\"".$attach['api']."\" target=\"_blank\">".lang_aplay('manulcompress')."</a>",
		 
		 
	));
		}
	}
	showsubmit('optionsubmit', 'submit', 'del');
	 
	showtablefooter();
	showformfooter();
}else{
	$aids=$_GET['delete'];
	foreach($aids as $aid){
		$newfile = "copy_aid_{$aid}_" . md5(md5($aid)) . '.mp3';
		unlink ($auditiondir .'./'.$newfile);
	}
	cpmsg('patch_successful', '', 'success');
}
?>