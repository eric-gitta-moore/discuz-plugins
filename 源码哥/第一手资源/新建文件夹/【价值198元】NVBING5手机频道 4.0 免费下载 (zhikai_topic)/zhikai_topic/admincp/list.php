<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
loadcache("plugin");
$rewrite = $_G['cache']['plugin']['zhikai_topic']['rewrite'];
$perpage = 15;
$page = intval ( $_GET['page'] ) ? intval ( $_GET['page'] ) : 1;
$start = ($page - 1) * $perpage;
if ($start < 0) $start = 0;
$count = C::t("#zhikai_topic#topic")->count();
$multi=	multi($count, $perpage, $page, ADMINSCRIPT.'?action=plugins&operation=config&do='.$_GET['do'].'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod']);
$list = C::t("#zhikai_topic#topic")->fetch_all($start,$perpage);

showtableheader(lang('plugin/zhikai_topic', 'lang003'));
$href = ADMINSCRIPT.'?action=plugins&operation=config&do='.$_GET['do'].'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod']."&formhash=".FORMHASH;
showsubtitle(array(lang('plugin/zhikai_topic', 'lang004'),lang('plugin/zhikai_topic', 'lang005'),""));
if(!count($list)){
	showtablerow('',array('colspan=3 '), array(lang('plugin/zhikai_topic', 'lang006')));
}else{
	foreach($list as $topic){//From ww w.ymg 6.com
		showtablerow('',
			array('width="400"','width="100"',''), 
			array(
				"<a href='".($rewrite?"nvbing5_".$topic['entitle'].".html":"plugin.php?id=zhikai_topic:topic&topic=".$topic['entitle'])."' target=\"_blank\">".$topic['title']."</a>",
				"<a href='{$href}&op=edit&topic={$topic['topicid']}'>".lang('plugin/zhikai_topic', 'lang007')."</a> &nbsp;&nbsp;".
				"<a href='{$href}&op=delete&topic={$topic['topicid']}'>".lang('plugin/zhikai_topic', 'lang008')."</a>",''
			)
		);
	}
}
showtablerow('',array('width="400"','colspan=2 style="text-align: right;"'), 
	array("<a href='{$href}&op=add' class='addtr'>".lang('plugin/zhikai_topic', 'lang009')."</a>",
		$multi)
	);
showtablefooter();
?>