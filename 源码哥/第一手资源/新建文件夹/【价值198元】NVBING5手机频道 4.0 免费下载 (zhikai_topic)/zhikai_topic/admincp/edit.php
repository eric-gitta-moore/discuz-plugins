<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$topicid = dintval($_GET['topic']);
$topic = C::t("#zhikai_topic#topic")->fetch($topicid);
if(!$topicid || !$topic) cpmsg(lang('plugin/zhikai_topic', 'lang002'),'','error');
if (submitcheck('submit')) {
	$get = $_GET['set'];
	$data = array();
	$data['title'] = daddslashes($get['title']); if(!$data['title']) cpmsg(lang('plugin/zhikai_topic', 'lang010').lang('plugin/zhikai_topic', 'lang011'),'','error');
	$data['entitle'] = daddslashes($get['entitle']); if(!$data['entitle'] || !ctype_alnum($data['entitle'])) cpmsg(lang('plugin/zhikai_topic', 'lang012').lang('plugin/zhikai_topic', 'lang013'),'','error');
	$check = C::t("#zhikai_topic#topic")->fetch_by_entitle($data['entitle']);
	if( $check && $check['topicid'] != $topicid ) cpmsg(lang('plugin/zhikai_topic', 'lang014'),'','error');
	$data['color'] = daddslashes($get['color']);
	if(!preg_match('/^#[0-9a-fA-F]{6}$/',$data['color']) && !preg_match('/^#[0-9a-fA-F]{3}$/',$data['color']) ) cpmsg(lang('plugin/zhikai_topic', 'lang012').lang('plugin/zhikai_topic', 'lang015'),'','error');
	$data['type'] = $get['type'] == 1?1:2;
	$data['blocks'] = daddslashes($get['blocks']);  if(!$data['blocks'] && $data['type'] == 1) cpmsg(lang('plugin/zhikai_topic', 'lang010').lang('plugin/zhikai_topic', 'lang016'),'','error');//From www .ymg 6.com
	$data['html'] = daddslashes($get['html']); if(!$data['html'] && $data['type'] == 2) cpmsg(lang('plugin/zhikai_topic', 'lang010').lang('plugin/zhikai_topic', 'lang017'),'','error');
	$seo = array();
	$seo['title'] = $get['seo']['title']?daddslashes($get['seo']['title']):$data['title'];
	$seo['keywords'] = daddslashes($get['seo']['keywords']);
	$seo['description'] = daddslashes($get['seo']['description']);
	$data['seo'] = serialize($seo);
	C::t("#zhikai_topic#topic")->update($topicid,$data);
	cpmsg('groups_setting_succeed', 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=' . $_GET['identifier'] . '&pmod=admincp', 'succeed');
} else {
	$seo = dunserialize($topic['seo']);
	$topic = dstripslashes($topic);
    showformheader('plugins&operation=config&do=' . $_GET['do'] . '&identifier=' . $_GET['identifier'] . '&pmod=admincp&op=' . $op.'&topic='.$topicid);
    showtableheader();
    showsetting(lang('plugin/zhikai_topic', 'lang011'), 'set[title]', $topic['title'], 'text');
    showsetting(lang('plugin/zhikai_topic', 'lang013'), 'set[entitle]', $topic['entitle'], 'text',0,0,lang('plugin/zhikai_topic', 'lang018'));
    showsetting(lang('plugin/zhikai_topic', 'lang015'), 'set[color]',$topic['color'], 'color');
	showsetting(lang('plugin/zhikai_topic', 'lang019'), array('set[type]', array(
		array(1,lang('plugin/zhikai_topic', 'lang020')),
		array(2,lang('plugin/zhikai_topic', 'lang021')),
	)), $topic['type'], 'mradio');
    showsetting(lang('plugin/zhikai_topic', 'lang016'), 'set[blocks]', $topic['blocks'], 'textarea',0,0,lang('plugin/zhikai_topic', 'lang022'));
    showsetting(lang('plugin/zhikai_topic', 'lang017'), 'set[html]', $topic['html'], 'textarea');
    showsetting(lang('plugin/zhikai_topic', 'lang023'), 'set[seo][title]', $seo['title'], 'text');
    showsetting(lang('plugin/zhikai_topic', 'lang024'), 'set[seo][keywords]', $seo['keywords'], 'text');
    showsetting(lang('plugin/zhikai_topic', 'lang025'), 'set[seo][description]',  $seo['description'], 'textarea');
    showsubmit('submit', 'submit');
    showtablefooter();//From ww w.ymg 6.com
    showformfooter();
    
}
?>