<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: domain.php $
 *      
 */
if(!defined('IN_SANREE_BRAND')) {
	exit('Access Denied');
}
$allowdomain = '{allowdomain}';
if ($allowdomain == 1) {
	$_ENV['curapp'] = 'plugin';
	$_GET['id'] = 'sanree_brand';
	$_GET['mod'] = 'item';
	$_GET['tid'] = '{bid}';
	require './plugin.php';
	exit();
}
//From:www_YMG6_COM
?>