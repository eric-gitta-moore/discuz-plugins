<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_searchword.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$_G['sr_keyword'] = C::t('#sanree_brand#sanree_brand_searchword')->getkewword_by_id(intval($_G['sr_sid']));
$mod = 'hello';
require_once sanree_libfile('module/'.$plugin['identifier'].'/'.$mod, $plugin['identifier']);
?>