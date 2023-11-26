<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

loadcache('plugin');

if(submitcheck("submit")){
	$plugin = C::t("common_plugin")->fetch_by_identifier("zhikai_n5appgl");
	$pluginvarid = DB::result_first("SELECT pluginvarid FROM %t WHERE pluginid=%d AND variable= 'forumstyle'",array("common_pluginvar",$plugin['pluginid']));
	$pluginvars = array();
	foreach($_GET['ext'] as $fid=>$extid){
		if(dintval($fid) && dintval($extid)){
			$pluginvars[$pluginvarid][dintval($fid)] = $extid;
		}
	}
	set_pluginsetting($pluginvars);
	updatecache('plugin');//更新缓存
	cpmsg('groups_setting_succeed','action=plugins&operation=config&do='.$_GET['do'].'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod'], 'succeed');
}else{
	loadcache("forums");
	$cache = forumtree();
	$forums = $cache['forums'];
	showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod']);
	showtableheader();
	showsubtitle(array(lang('plugin/zhikai_n5appgl','lang404'),lang('plugin/zhikai_n5appgl','lang402')));
	$tablestyle = array('width="400"', '');
	foreach($forums as $gid=>$group){
		showtablerow('', 
			$tablestyle,
			array(
				'<div class="parentboard"><input type="text" disabled readonly value="'.$group['data']['name'].'" class="txt"></div>', 
				""
			)
		);
		foreach($group['sub'] as $fid=>$forum){
			showtablerow('', 
				$tablestyle,
				array(
					'<div class="board"><input type="text" disabled readonly value="'.$forum['name'].'" class="txt"></div>', 
					showsettingselect($fid)
				)
			);
			foreach($forum['sub'] as $sid=>$sub){
				showtablerow('', 
					$tablestyle,
					array(
						'<div class="lastchildboard"><input type="text" disabled readonly value="'.$sub['name'].'" class="txt"></div>', 
						showsettingselect($sid)
					)
				);
			}
		}

	}
	echo '<tr><td colspan=2><div class="lastboard"><input type="submit" class="btn" id="submit_submit" name="submit" value="'.lang('plugin/zhikai_n5appgl','lang405').'"></div></td></tr>';
	showtablefooter();
	showformfooter();
	
}

function showsettingselect($fid){
	global $_G;
	
	$setting = dunserialize( $_G['cache']['plugin']['zhikai_n5appgl']['forumstyle'] );
	$style = dintval($setting[$fid]);
	$return = '<select name="ext['.$fid.']" class="ps">';
	foreach(explode('|',lang('plugin/zhikai_n5appgl','lang403')) as $id=>$name){
		$idval = $id+1;
		$return .= '<option '.($idval == $style?'selected="selected"':"").' value="'.$idval.'">'.$name.'</option>';
	}
	$return .= '</select>';
	return $return;
}

function forumtree(){
	global $_G;
	$return = array("forums"=>array(),"fids"=>array());
	foreach($_G['cache']['forums'] as $forum){
		$fid = $return['fids'][] = $forum['fid'];
		$fup = $forum['fup'];
		if($forum['type'] == 'group'){
			$return['forums'][$fid]['data'] = $forum;
		}elseif($forum['type'] == 'forum'){
			$return['forums'][$fup]['sub'][$fid] = $forum;
		}else{
			$gid = $_G['cache']['forums'][$fup]['fup'];
			$return['forums'][$gid]['sub'][$fup]['sub'][$fid] = $forum;
		}
	}
	return $return;
}
?>