<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


global $_G;
if(!$_G['cache']['plugin']){
    loadcache('plugin');
}


define('K_SITEURL', 'http://www.moqu8.com/');
define('K_SITEID','3GG257AF-7914-6C76-F5F8-721FG78A10A6');
define('K_QQID', '92G3T76C-1FE1-C1D8-3A40-52FBF9201277');
define('K_XZH_SITEKEY', '281a55a2d724e0cbc255538d0cdcfb6a');
define('K_AUTHKEY', $_G['config']['security']['authkey']);