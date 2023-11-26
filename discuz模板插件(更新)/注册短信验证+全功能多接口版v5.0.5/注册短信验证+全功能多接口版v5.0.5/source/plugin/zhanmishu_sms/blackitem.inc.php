<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
cpheader();
include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';



$input = daddslashes($_GET);

if (submitcheck('add_black')) {
	if (!$_GET['mobile'] || $input['mobile'] != ($input['mobile']+0) ) {
		cpmsg('mobile_is_error');
	}

	
	$data = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_by_fields(array('mobile'=>$input['mobile']));
	if (!empty($data)) {
		echo $input['mobile'];
		C::t("#zhanmishu_sms#zhanmishu_sms")->set_black_mobile($input['mobile']);
	}else{
		C::t("#zhanmishu_sms#zhanmishu_sms")->insert(array('mobile'=>$input['mobile'],'isblack'=>'1'));
	}

	cpmsg('success',dreferer());
}else if ($input['act'] == 'delblack' &&  formhash() == $input['formhash']) {

	if (!$input['mobile']) {
		cpmsg('mobile_is_error');
	}

	C::t("#zhanmishu_sms#zhanmishu_sms")->set_black_mobile($input['mobile'],'0');
	cpmsg('success');
}


showtips(lang('plugin/zhanmishu_sms', 'add_blackmobile_tips_intro'),'',true,lang('plugin/zhanmishu_sms', 'add_blackmobile_tips'));

showtableheader();
	showformheader('plugins&operation=config&do=60&identifier=zhanmishu_sms&pmod=blackitem');
	
	showtablerow('', array(''), array(
		'<input type="text" class="text" name="mobile" value="'.$mobile.'" onfocus="if (value ==\''.lang('plugin/zhanmishu_sms', 'blackitem').'\'){value =\'\'}"onblur="if (value ==\'\'){value=\''.lang('plugin/zhanmishu_sms', 'blackitem').'\'}" />'.
		'&nbsp;&nbsp;'.
		'&nbsp;&nbsp;<input type="submit" class="btn" id="add_black" name="add_black" title="" value="'.lang('plugin/zhanmishu_sms', 'add').'">'
	));
	showformfooter();
showtablefooter();
$num = C::t('#zhanmishu_sms#zhanmishu_sms')->get_count_by_field(array('isblack'=>'1'),'','mobile');
$perpage=20;
$curpage = ($_GET['page'] + 0) > 0 ? ($_GET['page'] + 0) : 1;
$mpurl=ADMINSCRIPT.'?action=plugins&operation=config&do=47&identifier=zhanmishu_sms&pmod=blackitem';
$pages= ceil($num / $perpage);
$start = $num - ($num - $perpage*$curpage+$perpage);

$blacks = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_all_black_mobiles($start, $perpage, '','',$field=array('isblack'=>'1'));

$blacks_fmt = array();
foreach ($blacks as $key => $value) {
	$blacks_fmt[$key]['sid'] = $value['sid'];
	$blacks_fmt[$key]['uid'] = $value['uid'];
	$blacks_fmt[$key]['username'] = $value['username'];
	$blacks_fmt[$key]['mobile'] = $value['mobile'];
	$blacks_fmt[$key]['isblack'] = $value['isblack'] ? lang('plugin/zhanmishu_sms','black') : lang('plugin/zhanmishu_sms','isnot_black');
	$blacks_fmt[$key]['act'] = '<a href="'.$mpurl.'&act=delblack&formhash='.FORMHASH.'&mobile='.$value['mobile'].'">'.lang('plugin/zhanmishu_sms','delblack').'</a>';
}
showtableheader();
	showsubtitle(array(lang('plugin/zhanmishu_sms', 'sid'),lang('plugin/zhanmishu_sms', 'uid'),lang('plugin/zhanmishu_sms', 'username'),lang('plugin/zhanmishu_sms', 'mobile'),lang('plugin/zhanmishu_sms', 'isblack'),lang('plugin/zhanmishu_sms', 'act')));
	foreach ($blacks_fmt as $key => $value) {
		showtablerow('class="partition"',array('class="td15"', 'class="td28"'),$value);
	}
showtablefooter();

$multi = multi($num, $perpage, $curpage, $mpurl, '0', '10');
echo $multi;