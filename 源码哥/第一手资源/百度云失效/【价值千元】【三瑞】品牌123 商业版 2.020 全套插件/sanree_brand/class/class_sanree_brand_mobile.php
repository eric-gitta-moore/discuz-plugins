<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: class_sanree_brand_mobile.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class sanree_brand_mobile{

	function __construct(){
	
		$this->sanree_brand_mobile();
				
	}
    function sanree_brand_mobile() {
		if ($this->chkwap()) {
			define('IN_SANREE_MOBILE', TRUE);
			$GLOBALS['curtime']= dgmdate(TIMESTAMP);
		}
	}
	function chkwap() {
	    
		if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0) {// Check whether the browser/gateway says it accepts WML.
			$br = "WML";
		} else {
			$browser=substr(trim($_SERVER['HTTP_USER_AGENT']),0,4);
			if ($browser=="Noki" || // Nokia phones and emulators
			$browser=="Eric" || // Ericsson WAP phones and emulators
			$browser=="WapI" || // Ericsson WapIDE 2.0
			$browser=="MC21" || // Ericsson MC218
			$browser=="AUR"  || // Ericsson R320
			$browser=="R380" || // Ericsson R380
			$browser=="UP.B" || // UP.Browser
			$browser=="WinW" || // WinWAP browser
			$browser=="UPG1" || // UP.SDK 4.0
			$browser=="upsi" || // another kind of UP.Browser ??
			$browser=="QWAP" || // unknown QWAPPER browser
			$browser=="Jigs" || // unknown JigSaw browser
			$browser=="Java" || // unknown Java based browser
			$browser=="Alca" || // unknown Alcatel-BE3 browser (UP based?)
			$browser=="MITS" || // unknown Mitsubishi browser
			$browser=="MOT-" || // unknown browser (UP based?)
			$browser=="My S" ||//  unknown Ericsson devkit browser ?
			$browser=="WAPJ" || //  Virtual WAPJAG www.wapjag.de
			$browser=="fetc" || //  fetchpage.cgi Perl script from www.wapcab.de
			$browser=="ALAV" || //  yet another unknown UP based browser ?
			$browser=="Wapa" || //  another unknown browser (Web based "Wapalyzer"?)
			$browser=="Oper") // Opera   
			{
				$br = "WML";
			} else {
				$br = "HTML";
			}
		}
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($useragent, 'iphone') >0 || strpos($useragent, 'ios') >0) {
			$br = "WML";
			
		} elseif(strpos($useragent, 'android') >0) {
			$br = "WML";
		} elseif(strpos($useragent, 'windows phone') >0) {
			$br = "WML";
		}	
		if($br == "WML"){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
//From:www_YMG6_COM
?>