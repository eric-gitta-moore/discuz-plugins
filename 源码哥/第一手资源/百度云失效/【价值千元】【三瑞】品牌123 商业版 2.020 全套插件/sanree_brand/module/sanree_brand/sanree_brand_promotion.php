<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_attention_addattention.php sanree checkedby.liuhuan.2014-04-18 $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

$valid= $_G['sr_valid'];
$valid_result = C::t('#sanree_brand#sanree_brand_group')->get_by_order(intval($valid));
if($_G['sr_flag'] == $valid_result['groupid']) {
	$valid_result = 0;
}
if($valid_result) {
	$maxorder = C::t('#sanree_brand#sanree_brand_group')->get_by_maxorder();
	echo ++$maxorder['order'];
}else {
	echo '';
}



?>