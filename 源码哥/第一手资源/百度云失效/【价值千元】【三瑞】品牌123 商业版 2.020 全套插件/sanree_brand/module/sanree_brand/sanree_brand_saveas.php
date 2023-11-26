<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_saveas.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$bid = intval($_G['sr_tid']);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	showmessage('error');
}
$myhomeurl = !empty($brandresult['brandno']) ? getbrandnourl($brandresult['brandno']) : getmyburl_by_bid($brandresult['bid']);
$icourl = $_G['siteurl'].'favicon.ico';
$Shortcut = <<<EOF
[DEFAULT]
BASEURL=$myhomeurl
[InternetShortcut]
URL=$myhomeurl
IDList=
IconFile=$icourl
IconIndex=1
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2
EOF;
$ua = $_SERVER["HTTP_USER_AGENT"]; 
$filename = $brandresult['name'].".url"; 
$encoded_filename = (CHARSET=='utf-8') ? urlencode($filename) : $filename;
$encoded_filename = str_replace("+", "%20", $encoded_filename); 
session_start();
header("Content-Type: application/octet-stream");
if(preg_match("/MSIE/", $ua)){     
	header('Content-Disposition: attachment; filename="'.$encoded_filename.'"'); 
}elseif(preg_match("/Firefox/", $ua)){     
	header('Content-Disposition: attachment; filename="'.$filename.'"');
}else{     
	header('Content-Disposition: attachment; filename="'.$filename.'"');
}
ob_clean();
flush();
echo $Shortcut;
exit();
?>