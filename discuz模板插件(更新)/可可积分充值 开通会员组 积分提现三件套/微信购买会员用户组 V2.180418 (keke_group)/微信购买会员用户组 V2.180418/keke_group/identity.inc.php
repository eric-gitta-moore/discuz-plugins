<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


global $_G;
if(!$_G['cache']['plugin']){
    loadcache('plugin');
}


define('K_SITEURL', 'http://www.moqu8.com/');
define('K_SITEID','776F2E39-4304-B456-B4DB-69FE9B201838');
define('K_QQID', 'F20181D0-C1E1-4D96-FCB4-985F379E2018');
define('K_SITEKEY', 'cf76c201861c4743b1cfcdf3c6201897');
define('K_AUTHKEY', $_G['config']['security']['authkey']);