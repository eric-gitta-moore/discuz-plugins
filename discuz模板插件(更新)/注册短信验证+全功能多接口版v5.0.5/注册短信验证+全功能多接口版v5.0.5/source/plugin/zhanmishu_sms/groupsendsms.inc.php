<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
cpheader();
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_template.php';


$template = new zhanmishu_template();
$templatevars = $template->get_templatevar_config();
$templates = $templatevars['templates'];
$select_templates = array();
foreach ($templates as $key => $value) {
	$select_templates[]= array($value['tid'],$value['templatename'].'----'.lang('plugin/zhanmishu_sms', 'signleft').$value['sign'].lang('plugin/zhanmishu_sms', 'signright').'----'.$value['templateid'].'----'.$value['templateintro']);
}
if(submitcheck('searchsubmit')) {
	$input = daddslashes($_GET);
	$searchgroupid = $input['searchgroupid'];
	if (empty($searchgroupid)) {
		cpmsg(lang('plugin/zhanmishu_sms', 'please_choose_group'),'','error');
	}

	$ids = implode(',', $searchgroupid);
	$num = DB::fetch_first('select count(distinct mobile) as num from '.DB::table('common_member').' m left join '.DB::table('common_member_profile').' p on m.uid=p.uid where m.groupid in ('.$ids.') and  p.mobile != \'\'');
	
	cpmsg(lang('plugin/zhanmishu_sms', 'groupsms_addtips',array('num'=>$num['num'])), 'action=plugins&operation=config&do=60&identifier=zhanmishu_sms&pmod=groupsendsms', 'form', array(), '<br /><label><input type="checkbox" name="dosend" value="1" class="checkbox" checked />'.lang('plugin/zhanmishu_sms', 'add_into_sms').'</label><input type="hidden" name="ids" value="'.$ids.'" ><input type="hidden" name="num" value="'.$num['num'].'"><input type="hidden" name="templateid" value="'.$_GET['templateid'].'">', TRUE, 'admin.php?action=plugins&operation=config&do=60&identifier=zhanmishu_sms&pmod=groupsendsms');

}else if ($_GET['dosend']) {
	$input = daddslashes($_GET);
	$num = $input['num'];
	$perpage=20;
	$curpage = ($input['page'] + 0) > 0 ? ($input['page'] + 1) : 1;
	$pages= ceil($num / $perpage);
	$start = $num - ($num - $perpage*$curpage+$perpage);
	$url = 'action=plugins&operation=config&do=60&identifier=zhanmishu_sms&pmod=groupsendsms&submit=yes&dosend=1&num='.$input['num'].'&templateid='.$input['templateid'];
	$url .= '&ids='.$input['ids'];
	$url .= '&page='.$curpage;

	//set
	$mobiles = DB::fetch_all('select mobile,m.uid from '.DB::table('common_member').' m left join '.DB::table('common_member_profile').' p on m.uid=p.uid where m.groupid in ('.$input['ids'].') and  p.mobile != \'\' group by p.mobile '.DB::limit($start, $perpage),array());
	if (!$input['templateid']) {
		cpmsg(lang('plugin/zhanmishu_sms', 'please_choose_template'),'','error');
	}
	foreach ($mobiles as $key => $value) {
		$mobiles[$key]['templateid'] = $input['templateid'];
		$mobiles[$key]['issendgroupsms'] = '1';
		$mobiles[$key]['dateline'] = TIMESTAMP;
		C::t("#zhanmishu_sms#zhanmishu_notice")->insert($mobiles[$key],false,false);
	}
	if ($curpage > $pages) {
		cpmsg(lang('plugin/zhanmishu_sms', 'add_groupsms_done'),'action=plugins&operation=config&do=60&identifier=zhanmishu_sms&pmod=groupsendsms','success');
	}else{
		cpmsg(lang('plugin/zhanmishu_sms', 'step_tips',array('curpage'=>$curpage,'pages'=>$pages)),$url);
	}

}else{ 
	$groupselect = array();
	$query = C::t('common_usergroup')->range();
	foreach($query as $group) {
		if (in_array($group['groupid'], array(4,5,6,7))) {
			continue;
		}
		$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
		if($group['type'] == 'member' && $group['creditshigher'] == 0) {
			$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" selected>$group[grouptitle]</option>\n";
		} else {
			$groupselect[$group['type']] .= "<option value=\"$group[groupid]\">$group[grouptitle]</option>\n";
		}
	}
	$groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
		($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
		($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
		'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';
	showformheader('plugins&operation=config&do=58&identifier=zhanmishu_sms&pmod=groupsendsms');
	showtableheader();
	showsetting('usergroup', '', '', '<select name="searchgroupid[]"  multiple="multiple" size="10">'.$groupselect.'</select>');
	showsetting(lang('plugin/zhanmishu_sms', 'templateid'),array('templateid',$select_templates),'','select','','',lang('plugin/zhanmishu_sms', 'templatevartips'));

	showsubmit('searchsubmit');
	showtablefooter();
	showformfooter();	
}




?>