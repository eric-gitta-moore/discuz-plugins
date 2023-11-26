<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}


$dirname = DISCUZ_ROOT."/data/sysdata/qu_app_cache"; 
$dirname2 = DISCUZ_ROOT."/data/attachment/qu_app"; 
rmdirr($dirname);
rmdirr($dirname2);
function rmdirr($dirname){
	if (!file_exists($dirname)) {
		return false;
	}
	if (is_file($dirname) || is_link($dirname)) {
		return unlink($dirname);
	}
	$dir = dir($dirname);
	while (false !== $entry = $dir->read()) {
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
	}
	$dir->close();
	return rmdir($dirname);
}

?>