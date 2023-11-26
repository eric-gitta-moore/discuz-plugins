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
define(SANREE_BRAND_GOODS_APPHOOK, SANREE_BRAND_GOODS_APPH.$appVer.'/');
$actfile = SANREE_BRAND_GOODS_APPHOOK.'hook.class.php';
require_once $actfile;
?>