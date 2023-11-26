<?php

if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
}

global $_G;
$splugin_setting = $_G['cache']['plugin']['study_index'];

include template("study_index:study_index");


?>