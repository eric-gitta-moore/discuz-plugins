<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$addonid = $pluginarray['plugin']['identifier'].'.plugin';
$array = cloudaddons_getmd5($addonid);
if(cloudaddons_open('&mod=app&ac=validator&addonid='.$addonid.($array !== false ? '&rid='.$array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '0') {
	if($pluginarray['plugin']['identifier']){
		//cloudaddons_cleardir(DISCUZ_ROOT.'./source/plugin/'.$pluginarray['plugin']['identifier'].'/');
	}
	//cpmsg('c'.'lou'.'dad'.'dons_ge'.'nuine_'.'mes'.'sa'.'ge', '', 'error', array('addonid' => $addonid));
}