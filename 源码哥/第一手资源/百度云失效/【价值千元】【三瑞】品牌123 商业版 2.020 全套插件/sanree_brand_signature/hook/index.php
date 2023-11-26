<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: index.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$appVer = $_G['setting']['version'];
define(SANREE_BRAND_signature_APPHOOK, SANREE_BRAND_signature_APPH.$appVer.'/');
$actfile = SANREE_BRAND_signature_APPHOOK.'hook.class.php';
require_once $actfile;
?>