<?php
/****
*
*   @QQ群550494646 By:NVBING5
*	以下代码请勿随意修改、避免出错！
*
****/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$telgo=intval($_GET['telgo']);
if($telgo==2){
    header('Location: admin.php?action=adv&operation=ad');
    exit;
}else{
	showtips(lang('plugin/zhikai_mobiad','zhikai_mobiad_adwms'));
	$advs = getadvs();
	showtableheader('', 'fixpadding');
	$row = 4;
	$rowwidth = 1 / $row * 100;
	$ads = array();
	foreach(C::t('common_advertisement')->fetch_all_type() as $ad) {
		$ads[$ad['type']] = $ad['count'];
	}
	if($advs) {
		$i = $row;
		foreach($advs as $adv) {
			if($i == $row) {
				echo '<tr>';
			}
				echo '<td width="'.$rowwidth.'%" class="hover" align="center"><a href="'.ADMINSCRIPT.'?action=adv&operation=ad&type='.$adv['class'].'">';
				$eclass = explode(':', $adv['class']);
		
				if(count($eclass) > 1) {
					echo file_exists(DISCUZ_ROOT.'./source/plugin/'.$eclass[0].'/adv/adv_'.$eclass[1].'.gif') ? '<img src="source/plugin/'.$eclass[0].'/adv/adv_'.$eclass[1].'.gif" /><br />' : '';
				} 
				echo $adv['name'].($ads[$adv['class']] ? '('.$ads[$adv['class']].')' : '').($adv['filemtime'] > TIMESTAMP - 86400 ? '<font color="red">[手机版]</font>' : '');
				echo '</a></td>';
		
			$i--;
			if(!$i) {
				$i = $row;
			}
		}
		if($i != $row) {
			echo str_repeat('<td></td>', $i);
		}
	} else {
		showtablerow('', '', lang('plugin/zhikai_mobiad','error_noadv'));
	}

	echo '<tr>'.str_repeat('<td width="'.$rowwidth.'%"></td>', $row).'</tr>';
	showtablefooter();

}

function getadvs() {
	global $_G;
	$name_plugin='zhikai_mobiad';
	$advs = array();
	$dir=DISCUZ_ROOT.'./source/plugin/'.$name_plugin.'/adv';
		if(!file_exists($dir)) {
			return array();
		}
		$advdir = dir($dir);
		while($entry = $advdir->read()) {
			if(!in_array($entry, array('.', '..')) && preg_match("/^adv\_[\w\.]+$/", $entry) && substr($entry, -4) == '.php' && strlen($entry) < 30 && is_file($dir.'/'.$entry)) {
				include_once $dir.'/'.$entry;
				$advclass = substr($entry, 0, -4);
				if(class_exists($advclass)) {

					$adv = new $advclass();
					$script = substr($advclass, 4);
	
					$script = ($name_plugin ? $name_plugin.':' : '').$script;

					$advs[$entry] = array(
						'class' => $script,
						'name' => lang('adv/'.$script, $adv->name),
						'version' => $adv->version,
						'copyright' => lang('adv/'.$script, $adv->copyright),
						'filemtime' => @filemtime($dir.'/'.$entry)
					);
				}
			}
		
	}
	uasort($advs, 'filemtimesort');

	return $advs;
}

?>