<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
cpheader();
include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';

	$u = array();
	$input = daddslashes($_GET);
	if ($input['key'] && $input['key'] == lang('plugin/zhanmishu_sms', 'searchtips')) {
		unset($input['key']);
	}else if ($input['key']) {
		//ismobile ?
		if (verify_mobile_number($input['key'])) {
			$u['mobile'] = $input['key'];
		}else if (verify_ip_check($input['key'])) {
			$ip = explode('.', $input['key']);
			$u['ip1'] = $ip['0'];
			$u['ip2'] = $ip['1'];
			$u['ip3'] = $ip['2'];
			$u['ip4'] = $ip['3'];
		}else{
			loaducenter();
			$user = uc_get_user($input['key']);
			if ($user['0'] > 0) {
				$u['uid'] = $user['0'];
			}
		}
	}
	if ($input['type'] || strlen($input['status'])) {
		
		if ($input['type'] =='1' || ($input['status'] >= 0 && $input['status'] < 10 && strlen($input['status']) > 0)) {
			$u['isregsuccess'] = $input['status'] ? $input['status'] : '0';
			$u['type'] ='1';
		}else if ($input['type'] =='2' || ($input['status'] >=10 && $input['status'] < 20)) {
			$u['isverify'] = ($input['status'] >= 10) ? ($input['status'] -10) : '0';
			$u['type'] ='2';
		}else if ($input['type'] =='3' || ($input['status'] >= 20)) {
			$u['ischangepwd'] = ($input['status'] >= 20) ? $input['status'] -20 : '0';
			$u['type'] ='3';
		}else if ($input['type'] =='4') {
			$u['type'] ='4';
		}else if ($input['type'] =='6') {
			$u['type'] ='6';
		}else{
			$u['type'] ='5';
		}
	}
	if (strlen($input['issuccess'])) {
		$u['issuccess'] = $input['issuccess'];
	}
else if ($input['type'] =='4') {
			$u['type'] ='4';
		}
$input = array_merge($input,$u);
$search = array();
if ($input['key']) {$search['key'] = $input['key'];}
if ($input['type']) {$search['type'] = $input['type'];}
if ($input['status']) {$search['status'] = $input['status'];}
if (strlen($input['issuccess'])) {$search['issuccess'] = $input['issuccess'];}
$getdata = '';
if (!empty($search)) {
	$ukey = array_keys($search);
	$nkv = array();
	foreach ($ukey as $key => $value) {
		$nkv[] = $value.'='.$search[$value];
	}
	$getdata = '&'.implode('&', $nkv);
}


$num = C::t('#zhanmishu_sms#zhanmishu_sms')->get_count_by_field($u);

$perpage=20;
$curpage = ($_GET['page'] + 0) > 0 ? ($_GET['page'] + 0) : 1;
$mpurl=ADMINSCRIPT.'?action=plugins&operation=config&do=47&identifier=zhanmishu_sms&pmod=report'.$getdata;
$pages= ceil($num / $perpage);
$start = $num - ($num - $perpage*$curpage+$perpage);

$config = getconfig();
$sms = new zhanmishu_sms($config);
$smses = $sms->get_type_smses($start, $perpage,'desc','',$u);
$smsesfmt=array();
foreach ($smses as $key => $value) {
	$smsesfmt[$key]['sid'] = $value['sid'];
	$smsesfmt[$key]['uid'] = $value['uid']?$value['uid']:'';
	if ($value['uid']) {
		$user = getuserbyuid($value['uid']);
		$smsesfmt[$key]['username'] = '<a href="home.php?mod=space&uid='.$value[uid].'&do=profile" target="_blank">'.$user['username'].'</a>';
	}else{
		$smsesfmt[$key]['username'] = '';
	}
	$smsesfmt[$key]['mobile'] = $value['mobile'];
	$smsesfmt[$key]['issuccess'] = $value['issuccess']?lang('plugin/zhanmishu_sms', 'sendsuccess'):lang('plugin/zhanmishu_sms', 'sendunsuccess');
	switch ($value['type']) {
		case '1':
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'user_register');
			break;
		case '2':
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'user_verify');
			break;
		case '3':
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'user_getpasswd');
			break;
		case '4':
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'smsnotice');
			break;
		case '5':
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'smsgroupnotice');
			break;
		case '6':
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'sms_sce_verify');
			break;
		default:
			$smsesfmt[$key]['type'] = lang('plugin/zhanmishu_sms', 'other');
			break;
	}
	$smsesfmt[$key]['verify'] = $value['verify'] ? $value['verify'] : '';
	$smsesfmt[$key]['dateline'] = dgmdate($value['dateline'],"Y-m-d H:i:s");
	$smsesfmt[$key]['carrier'] = $value['carrier'] ? $value['carrier'] : $sms->get_carrier_by_mobile($value['mobile']);
	$smsesfmt[$key]['ip'] = $value['ip1'].'.'.$value['ip2'].'.'.$value['ip3'].'.'.$value['ip4'];
	$smsesfmt[$key]['sub_msg'] = $value['sub_msg'];
}

$send_num = C::t("#zhanmishu_sms#zhanmishu_sms")->get_send_success_num();
$register_num = C::t("#zhanmishu_sms#zhanmishu_sms")->get_register_success_num();
showtableheader(lang('plugin/zhanmishu_sms', 'sendlog').lang('plugin/zhanmishu_sms', 'report',array('num'=>$num,'send_num'=>$send_num,'register_num'=>$register_num)));
showtablefooter();
showtableheader();
	showformheader('plugins&operation=config&do=59&identifier=zhanmishu_sms&pmod=report');
	$keywords = $input["key"]?$input["key"]:lang('plugin/zhanmishu_sms', 'searchtips');
	$setype = array($input['type'] => ' selected');
	$seissuccess = array($input['issuccess'] => ' selected');
	$sestatus = array($input['status'] => ' selected');
	showtablerow('', array(''), array(
		lang('plugin/zhanmishu_sms', 'searchtitle').
		'<input type="text" class="text" name="key" value="'.$keywords.'" onfocus="if (value ==\''.lang('plugin/zhanmishu_sms', 'searchtips').'\'){value =\'\'}"onblur="if (value ==\'\'){value=\''.lang('plugin/zhanmishu_sms', 'searchtips').'\'}" />'.
		'&nbsp;&nbsp;'.lang('plugin/zhanmishu_sms', 'cat').'<select name="type">
		  <option value ="">'.lang('plugin/zhanmishu_sms', 'choosetip').'</option>
		  <option value ="1"'.$setype['1'].'>'.lang('plugin/zhanmishu_sms', 'user_register').'</option>
		  <option value ="2"'.$setype['2'].'>'.lang('plugin/zhanmishu_sms', 'user_verify').'</option>
		  <option value="3"'.$setype['3'].'>'.lang('plugin/zhanmishu_sms', 'user_getpasswd').'</option>
		  <option value="4"'.$setype['4'].'>'.lang('plugin/zhanmishu_sms', 'smsnotice').'</option>
		  <option value="5"'.$setype['5'].'>'.lang('plugin/zhanmishu_sms', 'smsgroupnotice').'</option>
		  <option value="6"'.$setype['6'].'>'.lang('plugin/zhanmishu_sms', 'sms_sce_verify').'</option>
		</select>'.
		'&nbsp;&nbsp;'.lang('plugin/zhanmishu_sms', 'sendstatus').'<select name="issuccess">
		  <option value ="">'.lang('plugin/zhanmishu_sms', 'cat').'</option>
		  <option style="color:green;" value ="1"'.$seissuccess['1'].'>'.lang('plugin/zhanmishu_sms', 'sendsuccess').'</option>
		  <option value ="0"'.$seissuccess['0'].'>'.lang('plugin/zhanmishu_sms', 'sendunsuccess').'</option>
		</select>'.
		'&nbsp;&nbsp;'.lang('plugin/zhanmishu_sms', 'usestatus').'<select name="status">
		  <option value ="">'.lang('plugin/zhanmishu_sms', 'cat').'</option>
		  <option value ="0"'.$sestatus['0'].'>'.lang('plugin/zhanmishu_sms', 'register_unsuccess').'</option>
		  <option style="color:green;" value="1"'.$sestatus['1'].'>'.lang('plugin/zhanmishu_sms', 'register_success').'</option>
		  <option value="11"'.$sestatus['10'].'>'.lang('plugin/zhanmishu_sms', 'verify_unsuccess').'</option>
		  <option style="color:green;" value="11"'.$sestatus['11'].'>'.lang('plugin/zhanmishu_sms', 'verify_success').'</option>
		  <option value="20"'.$sestatus['20'].'>'.lang('plugin/zhanmishu_sms', 'getpwd_unsuccess').'</option>
		  <option style="color:green;" value="21"'.$sestatus['21'].'>'.lang('plugin/zhanmishu_sms', 'getpwd_success').'</option>
		</select>'.
		'&nbsp;&nbsp;<input type="submit" class="btn" id="submit_verifysearchsubmit" name="submit_verifysearchsubmit" title="" value="'.lang('plugin/zhanmishu_sms', 'search').'">'
	));
	showformfooter();
showtablefooter();

showtableheader();
	showsubtitle(array(lang('plugin/zhanmishu_sms', 'sid'),lang('plugin/zhanmishu_sms', 'uid'),lang('plugin/zhanmishu_sms', 'username'),lang('plugin/zhanmishu_sms', 'mobile'),lang('plugin/zhanmishu_sms', 'issuccess'),lang('plugin/zhanmishu_sms', 'type'),lang('plugin/zhanmishu_sms', 'verifycode'),lang('plugin/zhanmishu_sms', 'dateline'),lang('plugin/zhanmishu_sms', 'carrier'),lang('plugin/zhanmishu_sms', 'ip'),lang('plugin/zhanmishu_sms', 'error_msg')));
	foreach ($smsesfmt as $key => $value) {
		showtablerow('class="partition"',array('class="td15"', 'class="td28"'),$value);
	}
showtablefooter();

$multi = multi($num, $perpage, $curpage, $mpurl, '0', '10');
echo $multi;


?>