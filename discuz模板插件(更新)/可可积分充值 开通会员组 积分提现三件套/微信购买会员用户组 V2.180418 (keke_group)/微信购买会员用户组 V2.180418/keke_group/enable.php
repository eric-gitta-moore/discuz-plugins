<?php

if(!defined('IN_ADMINCP')) {
exit('Access Denied');
}
$addonid = $pluginarray['plugin']['identifier'].'.plugin';
$array = cloudaddons_getmd5($addonid);
if(1) {
	$val = 1;
	C::t('common_plugin')->update($_GET['pluginid'], array('available' => $val));
	cpmsg('plugins_'.$operation.'_succeed', 'action=plugins'.(!empty($_GET['system']) ? '&system=1' : ''), 'succeed');
}