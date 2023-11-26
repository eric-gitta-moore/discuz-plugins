<?php
 
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
if ($_GET['deldate'] && $_GET['formhash'] == formhash()) {
	$olddate = $_G['timestamp'] - intval($_GET['deldate']) * 86400;
	C::t('#e6_propaganda#e6_pro_credit')->delete_by_log($olddate);
	cpmsg($e6_lang['success'], cpurl(false, array('deldate')), 'succeed');
} elseif (submitcheck('dellog')) {
	if (is_array($_GET['log_id'])) {
		C::t('#e6_propaganda#e6_pro_credit')->delete($_GET['log_id']);
		cpmsg($e6_lang['success'], cpurl(false), 'succeed');
	}
}
showformheader('plugins&identifier=e6_propaganda&pmod=admin_log');
$html = $e6_lang['fast_clear_log'].
		'<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_log&deldate=30&formhash='.FORMHASH.'">'.$e6_lang['clear_moth_log'].'</a> | '.
		'<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_log&deldate=7&formhash='.FORMHASH.'">'.$e6_lang['clear_week_log'].'</a> | '.
		'<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_log&deldate=1&formhash='.FORMHASH.'">'.$e6_lang['clear_day_log'].'</a>';
showtableheader($html);
$type_option = "<option value=''>{$e6_lang['all']}</option>";
foreach ($_G['setting']['extcredits'] as $k => $v) {
	$type_option .= "<option value=\"{$k}\">{$v['title']}</option>";
}
$log_type = pro_log_type();
$logtype_option = "<option value=''>{$e6_lang['all']}</option>";
foreach ($log_type as $k => $v) {
	$logtype_option .= "<option value=\"{$k}\">{$v}</option>";
}
echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
showtablerow('',
	array('width="125"', 'width="125"', 'width="150"', 'width="320"'),
	array(
		$e6_lang['username'].': <input type="text" name="username" style="width:65px;">',
		$e6_lang['money_type'].': <select name="type">'.$type_option.'</select>',
		$e6_lang['log_add_type'].': <select name="logtype">'.$logtype_option.'</select>',
		$e6_lang['log_add_date'].': <input type="text" name="sdate" style="width: 108px;" onclick="showcalendar(event, this)"> -- <input type="text" name="edate" style="width: 108px;" onclick="showcalendar(event, this)">',
        "<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />"
	)
);
showtablefooter();
showtableheader();
$tabletop = array(
	'ID',
	$e6_lang['username'],
	$e6_lang['type'],
	$e6_lang['changes_begin'],
	$e6_lang['changes_value'],
	$e6_lang['changes_end'],
	$e6_lang['log_add_type'],
	$e6_lang['date'],
	'IP',
	$e6_lang['describe'],
	$e6_lang['del']
);
showsubtitle($tabletop);
$perpage = 20;
$start = ($page - 1) * $perpage;
if ($_GET['username']) {
	$uid = C::t('common_member')->fetch_uid_by_username($_GET['username']);
	$conditions .= " AND c.uid='{$uid}'";
	$theurl .= '&username='.$_GET['username'];
}
if ($_GET['type'] != '') {
	$conditions .= " AND `type`='".dintval($_GET['type'])."'";
	$theurl .= '&type='.$_GET['type'];
}
if ($_GET['logtype'] != '') {
	$conditions .= " AND `logtype`='".dintval($_GET['logtype'])."'";
	$theurl .= '&logtype='.$_GET['logtype'];
}
if ($_GET['sdate']) {
	$sdate = strtotime($_GET['sdate']);
	$conditions .= " AND `date`>'".strtotime($_GET['sdate'])."'";
	$theurl .='&sdate='.$_GET['sdate'];
}
if ($_GET['edate']) {
	$edate = strtotime($_GET['edate']);
	$conditions .= " AND `date`<'".strtotime($_GET['edate'])."'";
	$theurl .='&edate='.$_GET['edate'];
}
$logcount = C::t('#e6_propaganda#e6_pro_credit')->count_by_search($conditions, TRUE);
if ($logcount) {
	$n = ($page - 1) * $perpage + 1;
	foreach (C::t('#e6_propaganda#e6_pro_credit')->fetch_all_by_search($conditions, $start, $perpage, TRUE) as $v) {
		showtablerow('', '', array(
			$n,
			$v['username'],
			$_G['setting']['extcredits'][$v['type']]['title'],
			$v['smoney'],
			$v['change'],
			$v['emoney'],
			$log_type[$v['logtype']],
			dgmdate($v['date']),
			$v['ip'],
			$v['describe'],
			'<input class="checkbox" type="checkbox" id="log_id" name="log_id[]" value="'.$v['id'].'" />'
		));
		$n++;
	}
	$multi = multi($logcount, $perpage, $page, ADMINSCRIPT."?".cpurl(false).$theurl);
}
showtablefooter();
showsubmit('', '', '', '<input type="checkbox" name="chkall" id="chkall" class="checkbox" onclick="checkAll(\'prefix\', this.form, \'log_id\')" /><label for="chkall">'.cplang('select_all').'</label>&nbsp;&nbsp;<input type="submit" class="btn" name="dellog" value="'.$e6_lang['del'].'" />', $multi);
showformfooter();
?>