<?php
if(!defined('IN_ADMINCP')) {
exit('Access Denied');
}
C::t('common_plugin')->update($_GET['pluginid'], array('available' => 0));
updatecache(array('plugin', 'setting', 'styles'));
cleartemplatecache();
updatemenu('plugin');
cpmsg('&#x63d2;&#x4ef6;&#x5df2;&#x5173;&#x95ed;&#xff0c;&#x53bb;&#35759;&#24187;&#32593;&#x770b;&#x770b;&#x5427;', 'http://www.xhkj5.com', 'succeed');