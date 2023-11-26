<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_weixin_index.php sanree $
 */
if(!defined('IN_DISCUZ')) {
	exit('201406121473tEY7raAi||19249||1402027202');
}
require_once libfile('class/'.$plugin['identifier'].'_api','plugin/'.$plugin['identifier']);

$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
?>