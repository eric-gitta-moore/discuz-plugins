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
$appVer = 'X2.5';//$_G['setting']['version'];
define(sanree_brand_forumname_APPHOOK, sanree_brand_forumname_APPH.$appVer.'/');
$actfile = sanree_brand_forumname_APPHOOK.'hook.class.php';
require_once $actfile;
?>