<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(defined('IN_MOBILE')) {
	require 'mobile.inc.php';
} else {
	require 'pc.inc.php';
}
dexit();
?>