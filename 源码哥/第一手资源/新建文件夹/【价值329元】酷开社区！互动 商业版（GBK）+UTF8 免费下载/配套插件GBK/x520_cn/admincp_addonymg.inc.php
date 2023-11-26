<?php

/**
 *      [Discuz!] (C)2001-2099 Ymg6 Inc.
 *      This is NOT a freeware, use is subject to license terms'
 *
 *      $Id: admincp_addonymg.php 34498 2014-05-12 02:51:02Z nemohou $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(in_array($_GET['poperation'],array('download'))){
$poperation=$_GET['poperation'];
	}else{
$poperation='';		
		}
$_config['addonsource'] = 'xx1';
$_config['addon'] = array(
    'xx1' => array(
	'website_url' => 'http://www.ymg6.com/addon.php',
	'download_url' => 'http://www.ymg6.com/addon.php',
	'download_ip' => '',
    )
);
$addon = $_config['addon']['xx1'];
define('PCLOUDADDONS_WEBSITE_URL', $addon['website_url']);
define('PCLOUDADDONS_DOWNLOAD_URL', $addon['download_url']);
define('PCLOUDADDONS_DOWNLOAD_IP', $addon['download_ip']);

function pcloudaddons_md5($file) {
	return dfsockopen(pcloudaddons_url('&ac=check&file=').$file, 0, '', '', false, PCLOUDADDONS_DOWNLOAD_IP, 60);
}

function pcloudaddons_getuniqueid() {
	global $_G;
	if(PCLOUDADDONS_WEBSITE_URL == 'http://www.ymg6.com/addon.php') {
		return $_G['setting']['siteuniqueid'] ? $_G['setting']['siteuniqueid'] : C::t('common_setting')->fetch('siteuniqueid');
	} else {
		if(!$_G['setting']['addon_uniqueid']) {
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			$addonuniqueid = $chars[date('y')%60].$chars[date('n')].$chars[date('j')].$chars[date('G')].$chars[date('i')].$chars[date('s')].substr(md5($_G['clientip'].TIMESTAMP), 0, 4).random(6);
			C::t('common_setting')->update('addon_uniqueid', $addonuniqueid);
			require_once libfile('function/cache');
			updatecache('setting');
		}
		return $_G['setting']['addon_uniqueid'];
	}
}
function pcloudaddons_url($extra) {
	global $_G;
	require_once DISCUZ_ROOT.'./source/discuz_version.php';
	$data = 'siteuniqueid='.rawurlencode(pcloudaddons_getuniqueid()).'&siteurl='.rawurlencode($_G['siteurl']).'&sitever='.DISCUZ_VERSION.'/'.DISCUZ_RELEASE.'&sitecharset='.CHARSET.'&mysiteid='.$_G['setting']['my_siteid'];
	$param = 'data='.rawurlencode(base64_encode($data));
	$param .= '&md5hash='.substr(md5($data.TIMESTAMP), 8, 8).'&timestamp='.TIMESTAMP;
	return PCLOUDADDONS_DOWNLOAD_URL.'?froms=bbs&'.$param.$extra.'&pdo='.$_GET['do'].'&pidentifier='.$_GET['identifier'];

}

function pcloudaddons_check() {
	if(!function_exists('gzuncompress')) {
		cpmsg('cloudaddons_check_gzuncompress_error', '', 'error');
	}
	foreach(array('download', 'addonmd5') as $path) {
		$tmpdir = DISCUZ_ROOT.'./data/'.$path.'/'.random(5);
		$tmpfile = $tmpdir.'/index.html';
		dmkdir($tmpdir, 0777);
		if(!is_dir($tmpdir) || !file_exists($tmpfile)) {
			cpmsg('cloudaddons_check_write_error', '', 'error');
		}
		@unlink($tmpfile);
		@rmdir($tmpdir);
		if(is_dir($tmpdir) || file_exists($tmpfile)) {
			cpmsg('cloudaddons_check_write_error', '', 'error');
		}
	}
}

function pcloudaddons_open($extra, $post = '', $timeout = 30) {
	return dfsockopen(pcloudaddons_url('&from=s').$extra, 0, $post, '', false, PCLOUDADDONS_DOWNLOAD_IP, $timeout);
}

function pcloudaddons_getmd5($md5file) {
	$array = array();
	if(preg_match('/^[a-z0-9_\.]+$/i', $md5file) && file_exists(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml')) {
		require_once libfile('class/xml');
		$xml = implode('', @file(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml'));
		$array = xml2array($xml);
	} else {
		return false;
	}
	return $array;
}

function pcloudaddons_savemd5($md5file, $end, $md5) {
	global $_G;
	parse_str($end, $r);
	require_once libfile('class/xml');
	$xml = implode('', @file(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml'));
	$array = xml2array($xml);
	$ridexists = false;
	$data = array();
	if($array['RevisionID']) {
		foreach(explode(',', $array['RevisionID']) as $i => $rid) {
			$sns = explode(',', $array['SN']);
			$datalines = explode(',', $array['RevisionDateline']);
			$data[$rid]['SN'] = $sns[$i];
			$data[$rid]['RevisionDateline'] = $datalines[$i];
		}
	}
	$data[$r['RevisionID']]['SN'] = $r['SN'];
	$data[$r['RevisionID']]['RevisionDateline'] = $r['RevisionDateline'];
	$array['Title'] = 'Discuz! Addon MD5';
	$array['ID'] = $r['ID'];
	$array['RevisionDateline'] = $array['SN'] = $array['RevisionID'] = array();
	foreach($data as $rid => $tmp) {
		$array['RevisionID'][] = $rid;
		$array['SN'][] = $tmp['SN'];
		$array['RevisionDateline'][] = $tmp['RevisionDateline'];
	}
	$array['RevisionID'] = implode(',', $array['RevisionID']);
	$array['SN'] = implode(',', $array['SN']);
	$array['RevisionDateline'] = implode(',', $array['RevisionDateline']);
	$array['Data'] = $array['Data'] ? array_merge($array['Data'], $md5) : $md5;
	if(!isset($_G['siteftp'])) {
		dmkdir(DISCUZ_ROOT.'./data/addonmd5/', 0777, false);
		$fp = fopen(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml', 'w');
		fwrite($fp, array2xml($array));
		fclose($fp);
	} else {
		$localfile = DISCUZ_ROOT.'./data/'.random(5);
		$fp = fopen($localfile, 'w');
		fwrite($fp, array2xml($array));
		fclose($fp);
		dmkdir(DISCUZ_ROOT.'./data/addonmd5/', 0777, false);
		siteftp_upload($localfile, 'data/addonmd5/'.$md5file.'.xml');
		@unlink($localfile);
	}
}

function pcloudaddons_comparetree($new, $old, $basedir, $md5file ='', $first = 0) {
	global $_G;
	if($first && file_exists(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml')) {
		require_once libfile('class/xml');
		$xml = implode('', @file(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml'));
		$array = xml2array($xml);
		$_G['treeop']['md5old'] = $array['Data'];
	}

	$dh = opendir($new);
	while(($file = readdir($dh)) !== false) {
		if($file != '.' && $file != '..') {
			$newfile = $new.'/'.$file;
			$oldfile = $old.'/'.$file;
			if(is_file($newfile)) {
				$oldfile = preg_replace('/\._addons_$/', '', $oldfile);
				$md5key = str_replace($basedir, '', preg_replace('/\._addons_$/', '', $newfile));
				$newmd5 = md5_file($newfile);
				$oldmd5 = file_exists($oldfile) ? md5_file($oldfile) : '';
				if(isset($_G['treeop']['md5old'][$md5key]) && $_G['treeop']['md5old'][$md5key] != $oldmd5 && $oldmd5) {
					$_G['treeop']['oldchange'][] = $md5key;
				}
				if($newmd5 != $oldmd5) {
					$_G['treeop']['copy'][] = $newfile;
				}
				$_G['treeop']['md5'][$md5key] = $newmd5;
			} else {
				pcloudaddons_comparetree($newfile, $oldfile, $basedir);
			}
		}
	}
}

function pcloudaddons_copytree($from, $to) {
	global $_G;
	$dh = opendir($from);
	while(($file = readdir($dh)) !== false) {
		if($file != '.' && $file != '..') {
			$readfile = $from.'/'.$file;
			$writefile = $to.'/'.$file;
			if(is_file($readfile)) {
				if(!in_array($readfile, $_G['treeop']['copy'])) {
					continue;
				}
				if(!isset($_G['siteftp'])) {
					$content = -1;
					if($fp = @fopen($readfile, 'r')) {
						$startTime = microtime();
						do {
							$canRead = flock($fp, LOCK_SH);
							if(!$canRead) {
								usleep(round(rand(0, 100) * 1000));
							}
						} while ((!$canRead) && ((microtime() - $startTime) < 1000));

						if(!$canRead) {
							cpmsg('cloudaddons_file_read_error', '', 'error');
						}
						$content = fread($fp, filesize($readfile));
						flock($fp, LOCK_UN);
						fclose($fp);
					}
					if($content < 0) {
						cpmsg('cloudaddons_file_read_error', '', 'error');
					}
					dmkdir(dirname($writefile), 0777, false);
					$writefile = preg_replace('/\._addons_$/', '', $writefile);
					if($fp = fopen($writefile, 'w')) {
						$startTime = microtime();
						do {
							$canWrite = flock($fp, LOCK_EX);
							if(!$canWrite) {
								usleep(round(rand(0, 100) * 1000));
							}
						} while ((!$canWrite) && ((microtime() - $startTime) < 1000));

						if(!$canWrite) {
							cpmsg('cloudaddons_file_write_error', '', 'error');
						}
						fwrite($fp, $content);
						flock($fp, LOCK_UN);
						fclose($fp);
					}
					if(!$canWrite) {
						cpmsg('cloudaddons_file_write_error', '', 'error');
					}
				} else {
					$writefile = preg_replace('/\._addons_$/', '', $writefile);
					siteftp_upload($readfile, preg_replace('/^'.preg_quote(DISCUZ_ROOT).'/', '', $writefile));
				}
				if(md5_file($readfile) != md5_file($writefile)) {
					cpmsg('cloudaddons_file_write_error', '', 'error');
				}
			} else {
				pcloudaddons_copytree($readfile, $writefile);
			}

		}
	}
}

function pcloudaddons_deltree($dir) {
	if($directory = @dir($dir)) {
		while($entry = $directory->read()) {
			if($entry == '.' || $entry == '..') {
				continue;
			}
			$filename = $dir.'/'.$entry;
			if(is_file($filename)) {
				@unlink($filename);
			} else {
				pcloudaddons_deltree($filename);
			}
		}
		$directory->close();
		@rmdir($dir);
	}
}

function pcloudaddons_cleardir($dir) {
	if(is_dir($dir)) {
		pcloudaddons_deltree($dir);
	}
}

function pcloudaddons_dirwriteable($basedir, $dir, $sourcedir) {
	$checkdirs = array($dir);
	pcloudaddons_getsubdirs($sourcedir, $dir, $checkdirs);
	$return = array();
	foreach($checkdirs as $k => $dir) {
		$writeable = false;
		$checkdir = $basedir.'/'.$dir;
		if(!is_dir($checkdir)) {
			@mkdir($checkdir, 0777);
		}
		if(is_dir($checkdir)) {
			$fp = fopen($checkdir.'/test.txt', 'w');
			if($fp) {
				fclose($fp);
				unlink($checkdir.'/test.txt');
				$writeable = true;
			} else {
				$writeable = false;
			}
		}
		if(!$writeable && $dir) {
			$return[] = $dir;
		}
	}
	return $return;
}

function pcloudaddons_getsubdirs($dir, $root, &$return) {
	static $prefix = false;
	if($prefix === false) {
		$prefix = strlen($dir) + 1;
	}
	$dh = opendir($dir);
	while(($file = readdir($dh)) !== false) {
		if($file != '.' && $file != '..') {
			$readfile = $dir.'/'.$file;
			if(is_dir($readfile)) {
				$return[] = $root.'/'.substr($readfile, $prefix);
				pcloudaddons_getsubdirs($readfile, $root, $return);
			}
		}
	}
}

function pcloudaddons_http_build_query($formdata, $numeric_prefix = null, $key = null) {
	$res = array();
	foreach((array) $formdata as $k => $v) {
		$tmp_key = urlencode(is_int($k) ? $numeric_prefix . $k : $k);
		if ($key) {
			$tmp_key = $key.'['.$tmp_key.']';
		}
		if (is_array($v) || is_object($v)) {
			$res[] = pcloudaddons_http_build_query($v, null, $tmp_key);
		} else {
			$res[] = $tmp_key.'='.urlencode($v);
		}
	}
	return implode('&', $res);
}

function pcloudaddons_clear($type, $id) {
	global $_G;
	if(isset($_G['config']['plugindeveloper']) && $_G['config']['plugindeveloper'] > 0) {
		return;
	}
	$dirs = array('plugin' => array('plugin', './source/plugin/'), 'template' => array('style', './template/'));
	if($dirs[$type] && pcloudaddons_getmd5($id.'.'.$type)) {
		$entrydir = DISCUZ_ROOT.$dirs[$type][1].$id;
		$d = dir($entrydir);
		$filedeleted = false;
		while($f = $d->read()) {
			if(preg_match('/^discuz\_'.$dirs[$type][0].'\_'.$id.'(\_\w+)?\.xml$/', $f)) {
				@unlink($entrydir.'/'.$f);
				if($type == 'plugin' && !$filedeleted) {
					@unlink($entrydir.'/'.$f);
					$importtxt = @implode('', file($entrydir.'/'.$f));
					$pluginarray = getimportdata('Discuz! Plugin');
					if($pluginarray['installfile']) {
						@unlink($entrydir.'/'.$pluginarray['installfile']);
					}
					if($pluginarray['upgradefile']) {
						@unlink($entrydir.'/'.$pluginarray['upgradefile']);
					}
					$filedeleted = true;
				}
			}
		}
	}
}

function pversioncompatible($versions) {
	global $_G;
	list($currentversion) = explode(' ', trim(strip_tags($_G['setting']['version'])));
	$versions = strip_tags($versions);
	foreach(explode(',', $versions) as $version) {
		list($version) = explode(' ', trim($version));
		if($version && ($currentversion === $version || $version === 'X3' || $version === 'X3.1' || $version === 'X3.2')) {
			return true;
		}
	}
	return false;
}

if(!$admincp->isfounder) {
	cpmsg('noaccess_isfounder', '', 'error');
}

if(!$poperation) {
	pcloudaddons_check();
	$url = pcloudaddons_url($extra).'&padmin='.ADMINSCRIPT;
	if($_G['isHTTPS']) {
		echo '<script type="text/javascript">window.open(\''.$url.'\');</script>';
	} else {
		echo '<script type="text/javascript">location.href=\''.$url.'\';</script>';
	}

}elseif($poperation=='download'){
	$step = intval($_GET['step']);
	$addoni = intval($_GET['i']);
	if(!$_GET['md5hash'] || md5($_GET['addonids'].md5(pcloudaddons_getuniqueid().$_GET['timestamp'])) != $_GET['md5hash']) {
		cpmsg('cloudaddons_validator_error', '', 'error');
	}
	$addonids = explode(',', $_GET['addonids']);
	list($_GET['key'], $_GET['type'], $_GET['rid']) = explode('.', isset($addonids[$addoni]) ? $addonids[$addoni] : $addonids[0]);
	if($step == 0) {
		cpmsg('cloudaddons_downloading', "action=plugins&operation=config&do={$_GET['do']}&identifier={$_GET['identifier']}&poperation=download&pmod=admincp_addonymg&addonids=$_GET[addonids]&i=$addoni&step=1&md5hash=".$_GET['md5hash'].'&timestamp='.$_GET['timestamp'], 'loading', array('addonid' => $_GET['key'].'.'.$_GET['type']), '<div>0%</div>', FALSE);
	} elseif($step == 1) {
		$packnum = isset($_GET['num']) ? $_GET['num'] : 0;
		$tmpdir = DISCUZ_ROOT.'./data/download/'.$_GET['rid'];
		$end = '';
		$md5tmp = DISCUZ_ROOT.'./data/download/'.$_GET['rid'].'.md5';  
		if($packnum) {
			list($md5total, $md5s) = unserialize(implode('', @file($md5tmp)));
			dmkdir($tmpdir, 0777, false);
		} else {
			pdir_clear($tmpdir);
			@unlink($md5tmp);
			dmkdir($tmpdir, 0777, false);
			$md5total = '';
			$md5s = array();
		}
		$data = pcloudaddons_open('&mod=app&ac=download&rid='.$_GET['rid'].'&packnum='.$packnum);
		$_GET['importtxt'] = $data;
		$array = getimportdata('Discuz! File Pack');
		if(!$array['Status']) {
			list($_cur, $_max) = explode('/', $array['part']);
			$percent = intval($_cur/$_max * 100);
			if($array['type'] != $_GET['type'] || $array['key'] != $_GET['key'] || !$array['files']) {
				pdir_clear($tmpdir);
				@unlink($md5tmp);
				cpmsg('cloudaddons_download_error', '', 'error', array('ErrorCode' => 100));
			}
			foreach($array['files'] as $file => $data) {
				$filename = $tmpdir.'/'.$file.'._addons_';
				$dirname = dirname($filename);
				dmkdir($dirname, 0777, false);
				$fp = fopen($filename, !$data['Part'] ? 'w' : 'a');
				if(!$fp) {
					pdir_clear($tmpdir);
					@unlink($md5tmp);
					cpmsg('cloudaddons_download_write_error', '', 'error');
				}
				fwrite($fp, gzuncompress(base64_decode($data['Data'])));
				fclose($fp);
				if($data['MD5']) {
					$md5total .= $data['MD5'];
					$md5s[$filename] = $data['MD5'];
				}
			}
			$fp = fopen($md5tmp, 'w');
			fwrite($fp, serialize(array($md5total, $md5s)));
			fclose($fp);
		} elseif($array['Status'] == 'Error') {
			pdir_clear($tmpdir);
			@unlink($md5tmp);
			cpmsg('cloudaddons_install_error', '', 'error', array('ErrorCode' => $array['ErrorCode']));
		} else {
			@unlink($md5tmp);
			$end = rawurlencode(pcloudaddons_http_build_query($array));
		}
		if(!$end) {
			$packnum++;
			cpmsg('cloudaddons_downloading', "action=plugins&operation=config&do={$_GET['pdo']}&identifier={$_GET['identifier']}&poperation=download&pmod=admincp_addonymg&addonids=$_GET[addonids]&i=$addoni&step=1&md5hash=".$_GET['md5hash'].'&timestamp='.$_GET['timestamp'].'&num='.$packnum, 'loading', array('addonid' => $_GET['key'].'.'.$_GET['type']), '<div>'.$percent.'%</div>', FALSE);
		} else {
			cpmsg('cloudaddons_installing', "action=plugins&operation=config&do={$_GET['pdo']}&identifier={$_GET['identifier']}&poperation=download&pmod=admincp_addonymg&addonids=$_GET[addonids]&i=$addoni&end=$end&step=2&md5hash=".$_GET['md5hash'].'&timestamp='.$_GET['timestamp'], 'loading', array('addonid' => $_GET['key'].'.'.$_GET['type']), FALSE);
		}
	} elseif($step == 2) {
		$tmpdir = DISCUZ_ROOT.'./data/download/'.$_GET['rid'];
		if(!file_exists($tmpdir)) {
			pdir_clear($tmpdir);
			cpmsg('cloudaddons_download_error', '', 'error', array('ErrorCode' => 103));
		}
		$typedir = array(
		    'plugin' => 'source/plugin',
		    'template' => 'template',
		    'pack' => '.',
		);
		if(!$typedir[$_GET['type']]) {
			pdir_clear($tmpdir);
			cpmsg('cloudaddons_download_error', '', 'error', array('ErrorCode' => 104));
		}
		if($_GET['type'] != 'pack') {
			$descdir = DISCUZ_ROOT.$typedir[$_GET['type']].'/';
			$subdir = $_GET['key'];
		} else {
			$descdir = DISCUZ_ROOT;
			$subdir = '';
		}
		$unwriteabledirs = pcloudaddons_dirwriteable($descdir, $subdir, $tmpdir);
		if($unwriteabledirs) {
			if(!submitcheck('settingsubmit')) {
				showtips(cplang('pcloudaddons_unwriteabledirs', array('basedir' => $typedir[$_GET['type']] != '.' ? $typedir[$_GET['type']] : '/', 'unwriteabledirs' => implode(', ', $unwriteabledirs))));
				siteftp_form("action=plugins&operation=config&do={$_GET['pdo']}&identifier={$_GET['identifier']}&poperation=download&pmod=admincp_addonymg&addonids=$_GET[addonids]&i=$addoni&end=".rawurlencode($_GET['end'])."&step=2&md5hash=".$_GET['md5hash'].'&timestamp='.$_GET['timestamp']);
				exit;
			} else {
				siteftp_check($_GET['siteftp'], $typedir[$_GET['type']]);
			}
		}
		$descdir .= $subdir;
		pcloudaddons_comparetree($tmpdir, $descdir, $tmpdir, $_GET['key'].'.'.$_GET['type'], 1);
		if(!empty($_G['treeop']['oldchange']) && empty($_GET['confirmed'])) {
			cpmsg('cloudaddons_install_files_changed', '', 'form', array('files' => implode('<br />', $_G['treeop']['oldchange'])));
		}
		pcloudaddons_copytree($tmpdir, $descdir);
		pcloudaddons_savemd5($_GET['key'].'.'.$_GET['type'], $_GET['end'], $_G['treeop']['md5']);
		pcloudaddons_deltree($tmpdir);
		if(count($addonids) - 1 > $addoni) {
			$addoni++;
			cpmsg('cloudaddons_downloading', "action=plugins&operation=config&do={$_GET['pdo']}&identifier={$_GET['identifier']}&poperation=download&pmod=admincp_addonymg&&addonids=$_GET[addonids]&i=$addoni&step=1&md5hash=".$_GET['md5hash'].'&timestamp='.$_GET['timestamp'], 'loading', array('addonid' => $_GET['key'].'.'.$_GET['type']), FALSE);
		}
		list($_GET['key'], $_GET['type'], $_GET['rid']) = explode('.', $addonids[0]);
		if($_GET['type'] == 'plugin') {
			$plugin = C::t('common_plugin')->fetch_by_identifier($_GET['key']);
			if(!$plugin['pluginid']) {
				dheader('location: '.ADMINSCRIPT.'?action=plugins&operation=import&dir='.$_GET['key']);
			} else {
				dheader('location: '.ADMINSCRIPT.'?action=plugins&operation=upgrade&pluginid='.$plugin['pluginid']);
			}
		} elseif($_GET['type'] == 'template') {
			dheader('location: '.ADMINSCRIPT.'?action=styles&operation=import&dir='.$_GET['key']);
		} else {
			if(file_exists(DISCUZ_ROOT.'./data/addonpack/'.$_GET['key'].'.php')) {
				dheader('location: '.$_G['siteurl'].'data/addonpack/'.$_GET['key'].'.php');
			}
			cpmsg('cloudaddons_pack_installed', '', 'succeed');
		}
	}
}

function pdir_clear($dir) {
	if($directory = @dir($dir)) {
		while($entry = $directory->read()) {
			if($entry == '.' || $entry == '..') {
				continue;
			}
			$filename = $dir.'/'.$entry;
			if(is_file($filename)) {
				@unlink($filename);
			} else {
				pdir_clear($filename);
			}
		}
		$directory->close();
		@rmdir($dir);
	}
}