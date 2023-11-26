<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: config.inc.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$appVer = 'X2.5';//$_G['setting']['version'];
define(APPP_BRAND_DOMAIN_APPHOOK, APPP_BRAND_DOMAIN_APPH.$appVer.'/');
$actfile = APPP_BRAND_DOMAIN_APPHOOK.'hook.class.php';
require_once $actfile;
?>