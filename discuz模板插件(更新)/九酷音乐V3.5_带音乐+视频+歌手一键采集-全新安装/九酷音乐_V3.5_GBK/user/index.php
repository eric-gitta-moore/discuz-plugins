<?php
header("Content-type: text/html;charset=gb2312");
include "../source/global/global_conn.php";
include "source/include/function_common.php";
$ps = array('user', 'system', 'miniblog', 'relation', 'space', 'wall', 'dance', 'special', 'singer', 'video', 'feed', 'album', 'message', 'account', 'home');
$p = !empty($_GET['p']) && in_array($_GET['p'], $ps) ? $_GET['p'] : 'system';
$as = SafeRequest("a","get");
$a = !empty($as) ? $as : 'index';
include_once('source/module/'.$p.'/'.$a.'.php');
?>