<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_module.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function weixin_writefile($data, $file) {
	global $_G;
    $data = stripcslashes($data);
	$config = $_G['cache']['plugin'][$pidentifier];
	if($fp = @fopen(DISCUZ_ROOT.'sanree_'.$file.'.php', 'wb')) {
		fwrite($fp, $data);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/cachedomain/ .');
	}
}

function weixin_url($ufilename) {
	$filename =  DISCUZ_ROOT.'/plugin.php';
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize ($filename));
	fclose($handle);
$tmpstr = <<<SANREEEOF
define('CURSCRIPT', 'plugin');
define('IN_SANREE_WEIXIN', TRUE);
#_GET['id'] = 'sanree_weixin';
if (#_GET['debug']==1) {
	#_GET['WXPOST'] ='<xml><ToUserName><![CDATA[gh_sanree]]></ToUserName>
	<FromUserName><![CDATA[sanree]]></FromUserName>
	<CreateTime>123456789</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[@sanree]]></Content>
	<MsgId>5877603486912217299</MsgId>
	</xml>';
} else {
	#_GET['WXPOST'] = #GLOBALS["HTTP_RAW_POST_DATA"];
}
SANREEEOF;
$contents = str_replace("define('CURSCRIPT', 'plugin');", $tmpstr, $contents);
$contents = str_replace("#","$",$contents);
$contents = str_replace("\\","\\\\",$contents);
	weixin_writefile($contents, $ufilename);	
}
//www-FX8-co
?>