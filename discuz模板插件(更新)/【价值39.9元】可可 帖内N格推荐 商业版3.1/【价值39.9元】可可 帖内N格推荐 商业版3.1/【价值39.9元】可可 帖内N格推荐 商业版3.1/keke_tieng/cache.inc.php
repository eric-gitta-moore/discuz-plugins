<?php

defined('IN_DISCUZ') ||  exit('Access Denied');
if(defined('IN_ADMINCP')){

}

global $_G;

$info[7]=0;
require_once libfile('function/cache');
savecache('keke_tieng', $info);

cpmsg(lang('plugin/keke_tieng', 'ok'));
