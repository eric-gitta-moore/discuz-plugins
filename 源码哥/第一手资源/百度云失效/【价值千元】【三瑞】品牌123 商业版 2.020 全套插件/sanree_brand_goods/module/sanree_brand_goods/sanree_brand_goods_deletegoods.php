<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_deletegoods.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}

$gid = intval($_G['sr_gid']);

$goodsresult = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_gid($gid);
if (!$goodsresult) {
	showmessage(goods_modlang('nogoodsshow'));
}
if ($_G[uid]!=$goodsresult[uid]) {
	showmessage(goods_modlang('erroruser'));
}
$tids = array();
foreach (C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_tid_by_gids($gid) as $val) {

	$tids[] = $val[tid];
	
}
require_once libfile('function/forum');
require_once libfile('function/delete');
deletethread($tids);
C::t('#sanree_brand_goods#sanree_brand_goods')->delete($gid);
$rurl='plugin.php?id=sanree_brand_goods&mod=mygoods';
showmessage(goods_modlang('succeed'),$rurl);
?>