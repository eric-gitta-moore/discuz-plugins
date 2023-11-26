<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$topicid = dintval($_GET['topic']);
if(!$topicid || $_GET['formhash'] != FORMHASH) cpmsg(lang('plugin/zhikai_topic', 'lang002'),'','error');
C::t("#zhikai_topic#topic")->delete($topicid);
cpmsg("groups_setting_succeed",'action=plugins&operation=config&do='.$_GET['do'].'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod'],"succeed");
?>