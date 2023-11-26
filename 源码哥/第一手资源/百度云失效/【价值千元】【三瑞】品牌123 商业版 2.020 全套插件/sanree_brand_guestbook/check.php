<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: check.php sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if (!in_array('sanree_brand', $_G['setting']['plugins']['available'])) {
	cpmsg($installlang['Error_Install_brand'], '', 'error');
}
if ($_G['setting']['plugins']['version']['sanree_brand']<2.007) {
	cpmsg($installlang['plugin_error_version'], '', 'error');
}
$finish = TRUE;
?>