<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	global $_G;
	loadcache('plugin');
	$keke_group = $_G['cache']['plugin']['keke_group'];
	include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
	
	if (submitcheck("forumset")) {
		if(is_array($_GET['delete'])) {
				C::t('#keke_group#keke_group')->delete($_GET['delete']);
		}
		cpmsg(lang('plugin/keke_huati', 'f006'), 'action=plugins&operation=config&identifier=keke_group&pmod=admin_group', 'succeed');
	}
	
	
	if($_GET['ac']){
		if($_GET['formhash'] != $_G['formhash']) {
			exit('Access Denied');
		}
		$buygorupid=intval($_GET['buygorupid']);
		$buygorupdata = getbuygroupdata($buygorupid);
		
		if($_GET['ac']=='edit'){
			if (submitcheck("editsubmit")) {
				$data = array('extid' => 1);
				$pic=$_FILES['gropic'] ? 'data/attachment/common/'.upload_icon_banner($data, $_FILES['gropic']) : $_GET['gropic'];
				
				if(!$_GET['moneys'] ||  !$_GET['friend'] || !$_GET['times'] ){
					cpmsg('Input incomplete!', '', 'error');
				}
				$arr=array(
					'groupid'=> intval($_GET['friend']),
					'groupname'=> daddslashes(dhtmlspecialchars($_GET['text'])),
					'ico'=> daddslashes($pic),
					'tequan'=> daddslashes(dhtmlspecialchars($_GET['tequan'])),
					'money'=> intval($_GET['moneys']*100),
					'time'=> intval($_GET['times']),
					'display'=> intval($_GET['displays']),
				);
				if($buygorupdata['id']){
					C::t('#keke_group#keke_group')->update($buygorupid,$arr);
				}else{
					C::t('#keke_group#keke_group')->insert($arr);
				}
				cpmsg(lang('plugin/keke_group', 'lang18'), 'action=plugins&operation=config&identifier=keke_group&pmod=admin_group&formhash='.FORMHASH, 'succeed');
			}
			
			showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin_group&ac=edit", 'enctype');
			showtableheader(lang('plugin/keke_group', 'lang34'));
			showsetting(lang('plugin/keke_group', 'lang35'),'text',$buygorupdata['groupname'],'text');
			showsetting(lang('plugin/keke_group', 'lang36'), '', $buygorupdata['groupid'], "<select name='friend'>"._getusergroupopt($buygorupdata)."</select>");
			showsetting(lang('plugin/keke_group', 'lang37'),'gropic',$buygorupdata['ico'],'filetext');
			showsetting(lang('plugin/keke_group', 'lang38'),'moneys',($buygorupdata['money']/100),'text','','',lang('plugin/keke_group', 'lang39'));
			showsetting(lang('plugin/keke_group', 'lang40'),'times',$buygorupdata['time'],'text','','',lang('plugin/keke_group', 'lang41'));
			showsetting(lang('plugin/keke_group', 'lang42'),'tequan',$buygorupdata['tequan'],'textarea','','',lang('plugin/keke_group', 'lang43'));
			showsetting(lang('plugin/keke_group', 'lang44'),'displays',$buygorupdata['display'],'text','','',lang('plugin/keke_group', 'lang45'));
			echo '<input name="buygorupid" type="hidden" value="'.$buygorupdata['id'].'" />';
			showsubmit('editsubmit', 'submit', '');
			showtablefooter();
   			showformfooter();
			exit();
		}
		cpmsg(lang('plugin/keke_group', 'lang18'), 'action=plugins&operation=config&identifier=keke_group&pmod=admin_group', 'succeed');
	}//fr om w w  w.mo qu  8.co m
	
	
    showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin_group");
    showtableheader(lang('plugin/keke_group', 'lang46'));
    showsubtitle(array(lang('plugin/keke_group', 'lang47'),lang('plugin/keke_group', 'lang36'),lang('plugin/keke_group', 'lang38'),lang('plugin/keke_group', 'lang40'),lang('plugin/keke_group', 'lang42'),lang('plugin/keke_group', 'lang48'),lang('plugin/keke_group', 'lang49')));
	$query = _getallgro();
	
	foreach($query as $k=>$v){
		$table = array();
        $table[0] = '<input type="checkbox" class="checkbox" name="delete[]" value="'.$v['id'].'" />';
        $table[1] = '<b>'.$v['groupname'].'</b>';
		$table[2] = ($v['money']/100).' '.lang('plugin/keke_group', 'lang50');
		$table[3] = $v['time'].' '.lang('plugin/keke_group', 'lang51');
		$table[4] = '<span style="color:#999">'.$v['tequan'].'</span>';
		$table[5] = $v['display'];
		$table[6] = '<a href="admin.php?action=plugins&operation=config&identifier=keke_group&pmod=admin_group&ac=edit&buygorupid='.$v['id'].'&formhash='.FORMHASH.'">'.lang('plugin/keke_group', 'lang52').'</a>';
        showtablerow('',array(), $table);
	}
	showsubmit('forumset', 'submit', 'del',' <a href="admin.php?action=plugins&operation=config&identifier=keke_group&pmod=admin_group&ac=edit&formhash='.FORMHASH.'" class="addtr">'.lang('plugin/keke_group', 'lang53').'</a>');
    showtablefooter();
    showformfooter();
