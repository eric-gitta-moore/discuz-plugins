<?php
/*
 * 主页：Www.fx8.cc
 * 源码哥源码论坛 全网首发 http://www.fx8.cc
 * 技术支持/更新维护：QQ 154606914
 * From www_FX8_co
 */
 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
loadcache('plugin');
echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
if($_GET['start']) $start=strtotime($_GET['start'].':00');
else $start=strtotime(date('Y-m',time()).'-1 00:00:00');
if($_GET['end']) $end=strtotime($_GET['end'].':00');
else $end=time();
showformheader("plugins&operation=config&identifier=baidusitemap&pmod=logs");
showtableheader(lang('plugin/baidusitemap','s_title'), 'nobottom');
showsetting(lang('plugin/baidusitemap','s_start'), 'start',date('Y-m-d H:i',$start), 'calendar', '', 0,'', 1);	
showsetting(lang('plugin/baidusitemap','s_end'), 'end',date('Y-m-d H:i',$end), 'calendar', '', 0,'', 1);	
showsubmit('editsubmit');
showtablefooter();
showformfooter();
$where="todate>$start and todate<$end";
if(DISCUZ_VERSION=='X2'){
	$filepath=DISCUZ_ROOT.'./data/cache/cache_baidusitemap_remain.php';
}else{
	$filepath=DISCUZ_ROOT.'./data/sysdata/cache_baidusitemap_remain.php';
}
if(file_exists($filepath)){
	@require_once $filepath;
	$doing=true;
}else{
	$doing=false;
}

$pagenum=50;
$page=max(1,intval($_GET['page']));
$count=DB::result_first("select count(*) from ".DB::table('forum_thread')." where tobaidu=1 and $where");

if($doing){
	$addtitle=lang('plugin/baidusitemap','addtitle',array(
		'max'=>$max,
		'remain'=>$remain,
	));
}else{
	$addtitle=lang('plugin/baidusitemap','addtitle2');
}

showtableheader(lang('plugin/baidusitemap','title').$addtitle);
showsubtitle(array(
	lang('plugin/baidusitemap','subject'),
	lang('plugin/baidusitemap','todate'),
));

$list=DB::fetch_all("select tid,subject,todate from ".DB::table('forum_thread')." where tobaidu=1 and $where order by todate desc ".DB::limit(($page-1)*$pagenum,$pagenum));
foreach($list as $data) {
	showtablerow('', array('class="td_k"', 'class="td_k"', 'class="td_l"'), array(
		'<a href="javascript:;" onclick="window.open(\'forum.php?mod=viewthread&tid='.$data['tid'].'\')" target="_blank">'.$data['subject'].'</a>',
		date('Y-m-d H:i:s',$data['todate']),
	));
}
showtablefooter();
echo multi($count,$pagenum,$page,ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=baidusitemap&pmod=logs&start=".date('Y-m-d H:i',$start).'&end='.date('Y-m-d H:i',$end));
//WWW.fx8.cc 分.享.吧
?>