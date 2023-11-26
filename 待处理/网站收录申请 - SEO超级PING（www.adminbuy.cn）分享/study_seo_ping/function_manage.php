<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('http://127.0.0.1/');
}

function study_subtitle($menus, $type, $mid){
	if(is_array($menus)) {
		if(!$mid){
				$actives[$type] = ' class="active"';
				showtableheader('','study_tb');
				$s .='<div class="study_tab study_tab_min">';
				foreach($menus as $k => $menu){
						$s .= '<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$menu[1].'" '.$actives[$menu[1]].'><i></i><ins></ins>'.$menu[0].'</a>';
				}              
				$s .= '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier='.trim($_GET['identifier']).'&pmod=feedback"><i></i><ins></ins><font style="color:#FC4'.'E0B">&#x95EE;&#x9898;&#x53CD;&#x9988;</font></a>';                             
				$s .= '</div>';
				showtablerow('', array(''), array($s));
				showtablefooter();
		}else{
				$actives[$mid] = ' class="current" ';
				showtableheader('', 'study_tb');
				$s = '<div class="study_tab_mid"><ul class="tab1">';
				foreach($menus as $k => $menu){
						$s .= '
						<li '.$actives[$menu[1]].'>
						<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type.'&mid='.$menu[1].'">
						<span>'.$menu[0].'</span>
						</a>
						</li>';
				}
				$s .= '</ul></div>';
				//echo "\n".'<tr><th style="height:5px; padding:5px 0 0;"></th></tr>';
				showtitle($s);
				showtablefooter();
		}
	}
	if(!file_exists(DISCUZ_ROOT.'./source/plugin/study_seo_ping/thank.inc.php')){
			exit;
	}
	if(!file_exists(DISCUZ_ROOT.'./source/plugin/study_seo_ping/pluginvar.func.php')){
			exit;
	}
}


?>