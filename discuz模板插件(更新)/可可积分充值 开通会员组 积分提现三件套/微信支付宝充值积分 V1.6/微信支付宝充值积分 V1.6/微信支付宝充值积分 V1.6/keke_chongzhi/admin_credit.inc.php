<?php
/*
 *魔趣吧：www.moqu8.com
 *更多商业插件/模版免费下载 就在魔趣吧
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	global $_G;
	$keke_chongzhi = $_G['cache']['plugin']['keke_chongzhi'];
	if (submitcheck("forumset")) {
		$data = daddslashes($_GET['form']);
		if($data) {
			foreach($data as $creditid => $val) {
				if($data[$creditid]){
					C::t('#keke_chongzhi#keke_chongzhi_credit')->insert(array('creditid' => $creditid,'bili' => $val['bili'],'state' => $val['state'],'shunxu' => $val['shunxu']), false, true);
				}
			}
		}
		require_once libfile('function/cache');
		savecache('keke_chongzhi_credit', $data);
		cpmsg(lang('plugin/keke_chongzhi', 'lang27'), 'action=plugins&operation=config&identifier=keke_chongzhi&pmod=admin_credit', 'succeed');
	}
    showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin_credit");
    showtableheader(lang('plugin/keke_chongzhi', 'lang28'));
    showsubtitle(array(lang('plugin/keke_chongzhi', 'lang29'),lang('plugin/keke_chongzhi', 'lang30'),lang('plugin/keke_chongzhi', 'lang31'),lang('plugin/keke_chongzhi', 'lang32')));
	loadcache('keke_chongzhi_credit');
	$creditdata=$_G['cache']['keke_chongzhi_credit'] ? $_G['cache']['keke_chongzhi_credit'] : '';$creditdata=C::t('#keke_chongzhi#keke_chongzhi_credit')->fetchall_credit();	
	foreach($_G['setting']['extcredits'] as $k=>$v){
		$checke= $creditdata[$k]['state'] ? 'checked="checked"' : '';
		$table = array();
        $table[0] = $v['title'].'<input name="form['.$k.'][creditid]" type="hidden" value="'.$k.'" />';
        $table[1] = '1'.lang('plugin/keke_chongzhi', 'lang03').'= <input name="form['.$k.'][bili]" value="'.dhtmlspecialchars($creditdata[$k]['bili']).'" style="width:50px"> '.$v['title'];
		$table[2] = '<input class="checkbox" type="checkbox" name="form['.$k.'][state]" '.$checke.'  value="1">';
		$table[3] = '<input name="form['.$k.'][shunxu]" value="'.dhtmlspecialchars($creditdata[$k]['shunxu']).'" style="width:50px"> ';
        showtablerow('',array('width="200"', 'width="250"','width="250"'), $table);
	}
	
    showsubmit('forumset', 'submit', '', '');
    showtablefooter();
    showformfooter();
