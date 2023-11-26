<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_hint.php zs $
 */
if(!defined('IN_DISCUZ')) {
	exit('');
}

if ($_G['sr_enter'] == 1) {

	$update = C::t('#sanree_brand#sanree_brand_hint')->update_by_uid($_G['uid'],array('enter'=>1));

	if (!$update) {

		C::t('#sanree_brand#sanree_brand_hint')->insert(array('uid'=>$_G['uid'], 'enter'=>1), TRUE);

	}

}
//www-FX8-co
?>