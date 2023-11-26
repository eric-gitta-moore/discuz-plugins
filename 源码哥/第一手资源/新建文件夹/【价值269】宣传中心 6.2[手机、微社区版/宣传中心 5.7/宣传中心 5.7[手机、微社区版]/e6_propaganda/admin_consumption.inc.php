<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
showformheader('plugins&identifier=e6_propaganda&pmod=admin_consumption');
showtableheader($e6_lang['consumption_comment']);
$pay_type = pay_type();
$type_option = "<option value=''>{$e6_lang['all']}</option>";
foreach ($pay_type as $k => $v) {
	$type_option .= "<option value=\"{$k}\">{$v}</option>";
}
echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
showtablerow('',
	array('width="125"', 'width="150"', 'width="185"', 'width="320"'),
	array(
		$e6_lang['username'].': <input type="text" name="username" style="width:65px;">',
		$e6_lang['pay_type'].': <select name="type">'.$type_option.'</select>',
		$e6_lang['order_number'].': <input type="text" name="order" style="width:120px;">',
		$e6_lang['pay_date'].': <input type="text" name="sdate" style="width: 108px;" onclick="showcalendar(event, this)"> -- <input type="text" name="edate" style="width: 108px;" onclick="showcalendar(event, this)">',
        "<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />"
	)
);
showtablefooter();
$tabletop = array(
	'ID',
	$e6_lang['username'],
	$e6_lang['pay_type'],
	$e6_lang['order_number'],
	$e6_lang['pay_money'],
	$e6_lang['pay_date'],
	$e6_lang['pay_state'],
	$e6_lang['pay_multi']
);
showtableheader();
showsubtitle($tabletop);
$perpage = 20;
$start = ($page - 1) * $perpage;
if ($_GET['username']) {
	$uid = C::t('common_member')->fetch_uid_by_username($_GET['username']);
	$conditions .= " AND c.uid='{$uid}'";
	$theurl .= '&username='.$_GET['username'];
}
if ($_GET['type'] != '') {
	$conditions .= " AND c.type='".dintval($_GET['type'])."'";
	$theurl .= '&type='.$_GET['type'];
}
if ($_GET['order']) {
	$conditions .= " AND c.orderid='".$_GET['order']."'";
	$theurl .= '&order='.$_GET['order'];
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
$paycount = C::t('#e6_propaganda#e6_pro_clientorder')->count_by_search($conditions);
$pay_arr = array($e6_lang['pay_noreward'], '<font color="blue">' . $e6_lang['pay_yesreward'] . '</font>');
if ($paycount) {
	$n = ($page - 1) * $perpage + 1;
	foreach (C::t('#e6_propaganda#e6_pro_clientorder')->fetch_all_by_search($conditions, $start, $perpage) as $v) {
		if ($v['type'] == 0) {
			$v['arr'] = C::t('forum_order')->fetch($v['orderid']);
			$v['status'] = $v['arr']['status'];
		}
		if ($v['type'] == 0 && $v['status'] == 1) {
			$v['status'] = $e6_lang['pay_unpaid'];
		} else {
			$v['status'] = '<font color="blue">' . $e6_lang['pay_payment'] . '</font>';
		}
		showtablerow('', '', array(
			$n,
			$v['username'],
			$pay_type[$v['type']],
			$v['orderid'],
			$v['price'],
			dgmdate($v['date']),
			$v['status'],
			$pay_arr[$v['pay']]
		));
		$n++;
	}
	$multi = multi($paycount, $perpage, $page, ADMINSCRIPT."?".cpurl(false).$theurl);
}
showtablefooter();
echo $multi;
showformfooter();
?>