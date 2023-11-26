<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$keke_group = $_G['cache']['plugin']['keke_group'];
$orderid=daddslashes(dhtmlspecialchars($_GET['orderid']));
$orderdata= C::t('#keke_group#keke_group_orderlog')->fetch($orderid);
exit(json_encode(array('state' =>$orderdata['state'])));