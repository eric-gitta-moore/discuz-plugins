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
$redomain = {redomain};
if ($redomain == 1) {
	$domainfile = 'data/cachedomain/cache_'.md5($_SERVER['HTTP_HOST']).'.php';
	file_exists($domainfile) && @require $domainfile;
}
//From:www_YMG6_COM
?>