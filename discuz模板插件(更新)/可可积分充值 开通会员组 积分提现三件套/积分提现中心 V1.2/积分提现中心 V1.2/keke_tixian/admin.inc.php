<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	require_once DISCUZ_ROOT .'./source/plugin/keke_tixian/function/function_core.php';
	$keke_tixian = $_G['cache']['plugin']['keke_tixian'];
	if (submitcheck("forumset")) {
		$data = daddslashes($_GET['form']);
		if($data) {
			foreach($data as $creditid => $val) {
				if($data[$creditid]){
					C::t('#keke_tixian#keke_tixian_credit')->insert(array('creditid' => $creditid,'bili' => $val['bili'],'min' => $val['min'],'max' => $val['max'],'sxf' => $val['sxf'],'state' => $val['state']), false, true);
				}
			}
		}
		require_once libfile('function/cache');
		savecache('keke_tixian', $data);
		cpmsg(lang('plugin/keke_tixian', 'lang01'), 'action=plugins&operation=config&identifier=keke_tixian&pmod=admin', 'succeed');
	}
	
    showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin");
    showtableheader(lang('plugin/keke_tixian', 'lang02'));
    showsubtitle(array(lang('plugin/keke_tixian', 'lang05'), lang('plugin/keke_tixian', 'lang06'), lang('plugin/keke_tixian', 'lang07'),lang('plugin/keke_tixian', 'lang08'),lang('plugin/keke_tixian', 'lang09'), lang('plugin/keke_tixian', 'lang10')));
	loadcache('keke_tixian');
	$creditdata=$_G['cache']['keke_tixian'] ? $_G['cache']['keke_tixian'] : C::t('#keke_tixian#keke_tixian_credit')->fetchall_credit();	
	foreach($_G['setting']['extcredits'] as $k=>$v){
		$checke= $creditdata[$k]['state'] ? 'checked="checked"' : '';
		$table = array();
        $table[0] = $v['title'];
        $table[1] = '1'.$v['title'].'= <input name="form['.$k.'][bili]" value="'.dhtmlspecialchars($creditdata[$k]['bili']).'" style="width:50px"> '.lang('plugin/keke_tixian', 'lang03');
		$table[2] = '<input name="form['.$k.'][min]" value="'.dhtmlspecialchars($creditdata[$k]['min']).'" style="width:50px"> '.$v['title'];
		$table[3] = '<input name="form['.$k.'][max]" value="'.dhtmlspecialchars($creditdata[$k]['max']).'" style="width:50px"> '.$v['title'];
		$table[4] = '<input name="form['.$k.'][sxf]" value="'.dhtmlspecialchars($creditdata[$k]['sxf']).'" style="width:50px"> %';
		$table[5] = '<input class="checkbox" type="checkbox" name="form['.$k.'][state]" '.$checke.'  value="1">';
        showtablerow('',array(), $table);
	}
	
    showsubmit('forumset', 'submit', '', '');
    showtablefooter();
    showformfooter();
?>