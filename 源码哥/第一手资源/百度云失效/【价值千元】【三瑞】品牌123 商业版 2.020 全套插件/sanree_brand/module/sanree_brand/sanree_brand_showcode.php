<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_we_codehome.php zs $
 */
if(!defined('IN_DISCUZ')) {
	exit('');
}

$logo = $_G['sr_logo'] ? $_G['sr_logo'] : false;

if ($_G['sr_tel']) {

	srcode2show('tel:'.$_G['sr_tel'],$_G['siteurl'].$_G['sr_logo']);

}

if ($_G['sr_codemode']) {

	$cmod = '_brand';

	if ($_G['sr_codemode'] != 'brand') {

		$codemod = '_'.$_G['sr_codemode'];

	}

	if ($_G['sr_codemode'] == 'tel114') {

		$cmod = '_';
		$codemod = $_G['sr_codemode'];

	}

	srcode2show($_G['siteurl'].'plugin.php?id=sanree'.$cmod.$codemod,$logo);

}



?>