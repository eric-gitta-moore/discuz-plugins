<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
cpheader();

include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_mobileverify.php';

$verify = new zhanmishu_mobileverify($config);
$input = daddslashes($_GET);
if ($_GET['act'] == 'setverify') {
	$return = $verify->set_verify(($_GET['uid'] + 0),false,$input['mobile'],'1');

	if ($return['code'] == '1') {
		cpmsg($verify->diconv_back($return['msg']),dreferer(),'success');
	}else{
		cpmsg($verify->diconv_back($return['msg']),dreferer(),'error');
	}
	exit;
}else if ($_GET['act'] == 'clearverify') {
	
	$return = $verify->set_verify(($_GET['uid'] + 0),false,$input['mobile'],'-1');

	cpmsg(lang('plugin/zhanmishu_sms', 'clear_verify_success'),dreferer(),'success');

	exit;
}

$u = array();
if ($input['key'] && $input['key'] == lang('plugin/zhanmishu_sms', 'searchtipsnoip')) {
	unset($input['key']);
}else if ($input['key']) {
	//ismobile ?
	if (verify_mobile_number($input['key'])) {
		$u['mobile'] = $input['key'];
	}else{
		loaducenter();
		$user = uc_get_user($input['key']);
		if ($user['0'] > 0) {
			$u['uid'] = $user['0'];
		}
	}
}
if ($input['isverify']) {
	$u['isverify'] = $input['isverify'];
}

$search = array();
if ($input['key']) {$search['key'] = $input['key'];}
if ($input['isverify']) {$search['isverify'] = $input['isverify'];}
$getdata = '';
if (!empty($search)) {
	$ukey = array_keys($search);
	$nkv = array();
	foreach ($ukey as $key => $value) {
		$nkv[] = $value.'='.$search[$value];
	}
	$getdata = '&'.implode('&', $nkv);
}

$num = $verify->count_verify($u['uid'],$u['mobile'],$u['isverify']);
$perpage=20;
$curpage = ($_GET['page'] + 0) > 0 ? ($_GET['page'] + 0) : 1;
$mpurl=ADMINSCRIPT.'?action=plugins&operation=config&do=47&identifier=zhanmishu_sms&pmod=verifyadmin'.$getdata;
$pages= ceil($num / $perpage);
$start = $num - ($num - $perpage*$curpage+$perpage);

showtips(lang('plugin/zhanmishu_sms', 'verify_servicetips'),'',true,lang('plugin/zhanmishu_sms', 'servicetiptitle'));
$users =  $verify->get_all_member($u['uid'],$u['mobile'],$u['isverify'],$start,$perpage);
$groups = C::t('common_usergroup')->range();

foreach ($users as $key => $value) {
	$users[$key]['groupid'] = $groups[$value['groupid']]['grouptitle'];
	$users[$key]['mobile'] = '<input type="text" name="mobile['.$value['uid'].']" value="'.$value['mobile'].'"><input type="hidden" name="uid['.$value['uid'].']" value="'.$value['uid'].'"';
	$users[$key]['carrier'] = $value['carrier'] ? $value['carrier'] : $verify->get_carrier_by_mobile($value['mobile']);
	$users[$key]['dateline'] =$value['dateline'] ? dgmdate($value['dateline'],"Y-m-d H:i:s") : '';
	$users[$key]['verifyststus'] = $value['verifyststus'] > 0 ? lang('plugin/zhanmishu_sms', 'colorverify_success') : lang('plugin/zhanmishu_sms', 'colorverify_unsuccess');
	$users[$key]['do'] = '<a href="javascript:;" onclick="setverify('.$value['uid'].')">'.lang('plugin/zhanmishu_sms', 'edit_verify').'</a>';
	$users[$key]['do'] .= '&nbsp;&nbsp;<a href="javascript:;" onclick="clearverify('.$value['uid'].')">'.lang('plugin/zhanmishu_sms', 'clear_verify').'</a>';
}


showtableheader();
	showformheader('plugins&operation=config&do=60&identifier=zhanmishu_sms&pmod=verifyadmin');
	$keywords = $input["key"]?$input["key"]:lang('plugin/zhanmishu_sms', 'searchtipsnoip');
	$setype = array($input['type'] => ' selected');
	$seissuccess = array($input['issuccess'] => ' selected');
	$sestatus = array($input['status'] => ' selected');
	showtablerow('', array(''), array(
		lang('plugin/zhanmishu_sms', 'searchtitle').
		'<input type="text" class="text" name="key" value="'.$keywords.'" onfocus="if (value ==\''.lang('plugin/zhanmishu_sms', 'searchtipsnoip').'\'){value =\'\'}"onblur="if (value ==\'\'){value=\''.lang('plugin/zhanmishu_sms', 'searchtipsnoip').'\'}" />'.
		'&nbsp;&nbsp;'.lang('plugin/zhanmishu_sms', 'verifystatus').'<select name="isverify">
		  <option value ="">'.lang('plugin/zhanmishu_sms', 'verifycheck').'</option>
		  <option style="color:green;" value ="1"'.$seissuccess['1'].'>'.lang('plugin/zhanmishu_sms', 'verify_success').'</option>
		  <option value ="-1"'.$seissuccess['-1'].'>'.lang('plugin/zhanmishu_sms', 'verify_unsuccess').'</option>
		</select>'.
		'&nbsp;&nbsp;<input type="submit" class="btn" id="submit_verifysearchsubmit" name="submit_verifysearchsubmit" title="" value="'.lang('plugin/zhanmishu_sms', 'search').'">'
	));
	showformfooter();
showtablefooter();


showtableheader();
	showsubtitle(array(lang('plugin/zhanmishu_sms', 'uid'),lang('plugin/zhanmishu_sms', 'username'),lang('plugin/zhanmishu_sms', 'condition'),lang('plugin/zhanmishu_sms', 'groupid'),lang('plugin/zhanmishu_sms', 'mobile'),lang('plugin/zhanmishu_sms', 'dateline'),lang('plugin/zhanmishu_sms', 'carrier'),lang('plugin/zhanmishu_sms', 'doact')));
	foreach ($users as $key => $value) {
		showtablerow('class="partition"',array('class="td15"', 'class="td28"'),$value);
	}
showtablefooter();

$multi = multi($num, $perpage, $curpage, $mpurl, 0, '10');

include template("zhanmishu_sms:admin/verifyadmin");
echo $multi;
?>