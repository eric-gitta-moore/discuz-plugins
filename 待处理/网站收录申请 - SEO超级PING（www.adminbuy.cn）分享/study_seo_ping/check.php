<?php

if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$addonid = $pluginarray['plugin']['identifier'].'.plugin';
$array = cloudaddons_getmd5($addonid);
if(cloudaddons_open('&mod=app&ac=validator&addonid='.$addonid.($array !== false ? '&rid='.$array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '0') {
	/*cpmsg('cloudaddons_genuine_message', '', 'error', array('addonid' => $addonid));*/
}
?>