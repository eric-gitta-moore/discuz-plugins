<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: domain.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 *      
 */
if(!defined('IN_SANREE_BRAND')) {
	exit('');
}
if ($_SERVER['HTTP_HOST'] == '{branddomain}') {

	$_ENV['curapp'] = 'plugin';
	$_GET = array('id'=>'sanree_brand');
	require './plugin.php';
	exit();

}
//From:www_YMG6_COM
?>