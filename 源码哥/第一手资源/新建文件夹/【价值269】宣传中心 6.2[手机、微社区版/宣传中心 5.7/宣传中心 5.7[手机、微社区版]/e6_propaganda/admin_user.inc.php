<?php
 
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
if ($id = intval($_GET['id'])) {
	if (submitcheck('edit_user')) {
		for ($n=1; $n<=10; $n++) {
			if ($_GET['e6_user']['username'.$n]) {
				$uid = C::t('common_member')->fetch_uid_by_username($_GET['e6_user']['username'.$n]);
				if ($uid) {
					$e6_data['fuid'.$n] = $uid;
				} else {
					$no_fusername[] = $_GET['e6_user']['username'.$n];
				}
			} else {
				$e6_data['fuid'.$n] = '';
			}
		}
		$old_fuid = C::t('#e6_propaganda#e6_pro_user')->fetch($id);
		C::t('#e6_propaganda#e6_pro_user')->update($id, $e6_data);
		if ($e6_data['fuid1'] != $old_fuid['fuid1']) {
			C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($old_fuid['fuid1'], '`register`=`register`-1');
			C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($e6_data['fuid1'], '`register`=`register`+1');
			if (!C::t('#e6_propaganda#e6_pro_user')->fetch($e6_data['fuid1'])) {
				add_prouser($e6_data['fuid1']);
				C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($e6_data['fuid1'], '`register`=1');
			}
		}
		if ($no_fusername) {
			$username = implode(',', $no_fusername);
			cpmsg(pro_lang('no_fusername', array('username'=>$username)), cpurl(false), 'succeed');
		} else {
			cpmsg($e6_lang['success'], cpurl(false, array('id')), 'succeed');
		}
	} else {
		$user = C::t('common_member')->fetch($id);
		$user_arr = C::t('#e6_propaganda#e6_pro_user')->fetch($id);
		showtableheader(pro_lang('edit_user', array('username'=>$user['username'])));
		showformheader('plugins&identifier=e6_propaganda&pmod=admin_user&id='.$id);
		for ($i = 1; $i <= 10; $i++) {
			if ($user_arr['fuid'.$i]) {
				$fuser = C::t('common_member')->fetch($user_arr['fuid'.$i]);
			} else {
				$fuser = array();
			}
			showtablerow('', array('width="65"'), array(pro_lang('num_fuser', array('n'=>$i)),
			"<input name=\"e6_user[username{$i}]\" value=\"{$fuser['username']}\" type=\"text\" class=\"txt\">"));
		}
		showsubmit('edit_user');
		showformfooter();
		showtablefooter();
	}
	dexit();
}
if (submitcheck('deluser')) {
	if (is_array($_GET['del_id'])) {
		del_pro_user($_GET['del_id']);
		cpmsg($e6_lang['success'], cpurl(false), 'succeed');
	}
}
showformheader('plugins&identifier=e6_propaganda&pmod=admin_user');
showtableheader($e6_lang['user_comment']);
${'selected'.$_GET['type']} = 'selected';
showtablerow('',
	array('width="200"', 'width="125"'),
	array(
		"{$e6_lang['username']}: <input type=\"text\" name=\"username\" value=\"{$_GET['username']}\" style=\"width:140px;\">",
		"{$e6_lang['type']}: <select name=\"type\">
			<option value=\"1\" {$selected1}>{$e6_lang['user_recommend']}</option>
			<option value=\"2\" {$selected2}>{$e6_lang['user_by_recommend']}</opion></select>",
        "<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />"
	)
);
showtablefooter();
showtableheader();
$tabletop[] = 'ID';
$tabletop[] = $e6_lang['username'];
for($n=1; $n<=10; $n++) {
	$tabletop[] = $n.$e6_lang['user_num_recommend'];
}
$tabletop[] = $e6_lang['edit'];
$tabletop[] = $e6_lang['del'];
showsubtitle($tabletop);
$perpage = 20;
$start = ($page - 1) * $perpage;
if ($_GET['username']) {
	$uid = C::t('common_member')->fetch_uid_by_username($_GET['username']);
	if ($uid) {
		if ($_GET['type'] == 2) {
			$conditions .= " AND `uid`='{$uid}'";
		} else {
			$conditions .= " AND (fuid1='{$uid}' or fuid2='{$uid}' or fuid3='{$uid}' ".
			"or fuid4='{$uid}' or fuid5='{$uid}' or fuid6='{$uid}' or ".
			"fuid7='{$uid}' or fuid8='{$uid}' or fuid9='{$uid}' or fuid10='{$uid}')";
		}
	} else {
		$conditions .= " AND `uid`='no' ";
	}
	$theurl .= '&username='.$_GET['username'].'&type='.$_GET['type'];
}
$usercount = C::t('#e6_propaganda#e6_pro_user')->count_by_search($conditions);
if (!$usercount && $_GET['type'] == 2 && $uid) {
	add_prouser($uid);
	$usercount = 1;
}
if ($usercount) {
	$n = ($page - 1) * $perpage + 1;
	$user_list = array();
	foreach (C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_search($conditions, $start, $perpage) as $v) {
		$user_list[$v['uid']] = $v['uid'];
		for ($i = 1; $i <= 10; $i++) {
			if ($v['fuid'.$i]) {
				$user_list[$v['fuid'.$i]] = $v['fuid'.$i];
			}
		}
		$list[] = $v;
	}
	$user_arr = C::t('common_member')->fetch_all_username_by_uid($user_list);
	foreach ($list as $v) {
		$table_list = array();
		$table_list[] = $n;
		$table_list[] = $user_arr[$v['uid']];
		for ($i = 1; $i <= 10; $i++) {
			$table_list[] = $v['fuid'.$i] ? '<a href="admin.php?action=plugins&identifier=e6_propaganda&pmod=admin_user&username='.$user_arr[$v['fuid'.$i]].'">'.$user_arr[$v['fuid'.$i]].'</a>' : '';
		}
		$table_list[] = '<a href="admin.php?action=plugins&identifier=e6_propaganda&pmod=admin_user&id='.$v['uid'].'">'.$e6_lang['edit'].'</a>';
		$table_list[] = "<input class=\"checkbox\" type=\"checkbox\" id=\"del_id\" name=\"del_id[]\" value=\"{$v['uid']}\" />";
		showtablerow('', '', $table_list);
		$n++;
	}
	$multi = multi($usercount, $perpage, $page, ADMINSCRIPT."?".cpurl(false).$theurl);
}
showtablefooter();
showsubmit('', '', '', '<input type="checkbox" name="chkall" id="chkall" class="checkbox" onclick="checkAll(\'prefix\', this.form, \'del_id\')" /><label for="chkall">'.cplang('select_all').'</label>&nbsp;&nbsp;<input type="submit" class="btn" name="deluser" value="'.$e6_lang['del'].'" />', $multi);
showformfooter();
?>