<?php
if(!defined('IN_ADMINCP')) {
exit('Access Denied');
}
C::t('common_plugin')->update($_GET['pluginid'], array('available' => 1));
cpmsg('&#35759;&#24187;&#32593;&#x63d0;&#x9192;&#xff1a;&#x63d2;&#x4ef6;&#x5f00;&#x542f;&#x6210;&#x529f;', 'action=plugins'.(!empty($_GET['system']) ? '&system=1' : ''), 'succeed');