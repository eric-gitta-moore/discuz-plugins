<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
cpheader();
include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_template.php';


$template = new zhanmishu_template();
$templatevars = $template->get_templatevar_config();
$templates = $templatevars['templates'];
$select_templates = array();
foreach ($templates as $key => $value) {
	$select_templates[]= array($value['tid'],$value['templatename'].'----'.lang('plugin/zhanmishu_sms', 'signleft').$value['sign'].lang('plugin/zhanmishu_sms', 'signright').'----'.$value['templateid'].'----'.$value['templateintro']);
}
if(submitcheck('mobileaddsubmit')) {
	$input = daddslashes($_GET);
	$mobiles = zmssmsstrtoarray_tomobile($input['mobiles']);
	if (empty($mobiles) || !$input['templateid']) {
		cpmsg(lang('plugin/zhanmishu_sms', 'dataerror'),'','error');
	}
	foreach ($mobiles as $key => $value) {
		$data = array();
		$data['mobile'] =$value;
		$data['templateid'] = $input['templateid'];
		$data['issendgroupsms'] = '1';
		$data['dateline'] = TIMESTAMP;

		C::t("#zhanmishu_sms#zhanmishu_notice")->insert($data,false,false);
	}
	cpmsg(lang('plugin/zhanmishu_sms', 'add_groupsms_done'),'','success');
}else{
	showformheader('plugins&operation=config&do=58&identifier=zhanmishu_sms&pmod=mobilesend');
	showtableheader();
	showsetting(lang('plugin/zhanmishu_sms', 'mobiles'), 'mobiles', '', 'textarea','','',lang('plugin/zhanmishu_sms', 'mobiles_desc'),'size="10"');
	// showsetting(lang('plugin/zhanmishu_sms', 'templateid'), 'templateid', '', 'text','','',lang('plugin/zhanmishu_sms', 'templateid_desc'));
	showsetting(lang('plugin/zhanmishu_sms', 'templateid'),array('templateid',$select_templates),'','select','','',lang('plugin/zhanmishu_sms', 'templatevartips'));
	showsubmit('mobileaddsubmit');
	showtablefooter();
	showformfooter();	
}


?>