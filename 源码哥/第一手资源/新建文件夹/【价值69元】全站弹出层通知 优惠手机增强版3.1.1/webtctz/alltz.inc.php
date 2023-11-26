<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$act = $_GET['act'];
global $_G, $lang;

$webtctzfile = DISCUZ_ROOT.'./source/plugin/webtctz/webtctz.class.php';
require_once $webtctzfile;
$webtctzclass = 'plugin_webtctz';

if($act=='add'){
	if(submitcheck('submit')){
	
		$tz = $_GET['tz'];
		$dtz = array('dateline'=>TIMESTAMP);
		$dtz['title'] = addslashes(trim($tz['title']));
		$dtz['isopen'] = addslashes(trim($tz['isopen']));
		$dtz['isopenborder'] = addslashes(trim($tz['isopenborder']));
		$dtz['isclosetime'] = addslashes(trim($tz['isclosetime']));
		$dtz['isanimatestart'] = addslashes(trim($tz['isanimatestart']));
		$dtz['iscloseshow'] = addslashes(trim($tz['iscloseshow']));
		$dtz['isbg'] = addslashes(trim($tz['isbg']));
		$dtz['isfloat'] = addslashes(trim($tz['isfloat']));
		$dtz['zindex'] = addslashes(trim($tz['zindex']));
		$dtz['contentbg'] = addslashes(trim($tz['contentbg']));
		$dtz['targets'] = json_encode($tz['targets']);
		$dtz['plugins'] = addslashes(trim($tz['plugins']));
		$dtz['starttime'] = addslashes($tz['starttime']) ? strtotime(addslashes($tz['starttime'])) : 0;
		$dtz['endtime'] = addslashes($tz['endtime']) ? strtotime(addslashes($tz['endtime'])) : 0;	
		$dtz['fids'] =  json_encode($tz['fids']);
		$dtz['usergroup'] = json_encode($tz['groupid']);
		$dtz['groups'] = json_encode($tz['groups']);
		$dtz['category'] = json_encode($tz['category']);
		$dtz['users'] = addslashes(trim($tz['users']));
		$dtz['tids'] = addslashes(trim($tz['tids']));
		$dtz['aids'] = addslashes(trim($tz['aids']));
		$dtz['type'] = addslashes(trim($tz['type']));
		//$dtz['cimg'] = trim($tz['cimg']);
		$dtz['ctext'] = addslashes(trim($tz['ctext']));
		$dtz['curl'] = addslashes(trim($tz['curl']));
		$dtz['ciframe'] = addslashes(trim($tz['ciframe']));
		$dtz['chtml'] = stripslashes($tz['chtml']);
		$dtz['height'] = addslashes(trim($tz['height']));
		$dtz['width'] = addslashes(trim($tz['width']));
		$dtz['position'] = addslashes(trim($tz['position']));
		$dtz['pyright'] = addslashes(trim($tz['pyright']));
		$dtz['pybottom'] = addslashes(trim($tz['pybottom']));
		$dtz['transparency'] = addslashes(trim($tz['transparency']));
		$dtz['count'] = dintval(addslashes($tz['count']));
		$dtz['closetime'] = dintval(addslashes($tz['closetime']));
		$dtz['interval'] = dintval(addslashes($tz['interval']));
		$dtz['delay'] = dintval(addslashes($tz['delay']));
		$dtz['closepyright'] = addslashes(trim($tz['closepyright']));
		$dtz['closepybottom'] = addslashes(trim($tz['closepybottom']));
		$dtz['closeheight'] = addslashes(trim($tz['closeheight']));
		$dtz['closewidth'] = addslashes(trim($tz['closewidth']));
	
		if($_FILES['cimg']) {
			if(file_exists(libfile('class/upload'))){
				require_once libfile('class/upload');
			}else{
				require_once libfile('discuz/upload', 'class');
			}
			$upload = new discuz_upload();
			if($upload->init($_FILES['cimg'], 'common') && $upload->save(1)) {
				$dtz['cimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
			}
		} else {
			$dtz['cimg'] = !empty($_GET['cimg'])?trim($_GET['cimg']):"";
		}
		
		if(empty($dtz['title'])){
			cpmsg('webtctz:tznotitle', '', 'error');
		}elseif(strlen($dtz['title']) > 50) {
			cpmsg('webtctz:tz_title_more', '', 'error');
		}
		
		if(!empty($dtz['starttime']) && !empty($dtz['endtime'])) {
			if($dtz['endtime'] <= TIMESTAMP || $dtz['endtime'] <= $dtz['starttime']) {
				cpmsg('webtctz:tz_endtime_invalid', '', 'error');
			}
		}
		if($tz['targets'] == NULL || empty($tz['targets'])){
			cpmsg('webtctz:tznotargets', '', 'error');
		}
		if($tz['groupid'] == NULL || empty($tz['groupid'])){
			if($tz['users'] == NULL || empty($tz['users'])){
			   cpmsg('webtctz:tznogroupid', '', 'error');
			}
		}
		if(in_array('2',$tz['targets'])){
			if($tz['fids'] == NULL || empty($tz['fids'])){
				if($tz['tids'] == NULL || empty($tz['tids'])){
				   cpmsg('webtctz:tznofids', '', 'error');
				}
			}
			/*
			if(count($tz['fids']) == 1 && in_array('0',$tz['fids'])){
				cpmsg('webtctz:tznofids', '', 'error');
			}
			*/
		}
		if(in_array('3',$tz['targets'])){
			if($tz['groups'] == NULL || empty($tz['groups'])){
				if($tz['tids'] == NULL || empty($tz['tids'])){
				   cpmsg('webtctz:tznogroups', '', 'error');
				}
			}
		}
		if(in_array('1',$tz['targets'])){
			if($tz['category'] == NULL || empty($tz['category'])){
				if($tz['aids'] == NULL || empty($tz['aids'])){
				   cpmsg('webtctz:tznocategory', '', 'error');
				}
			}
		}
		if(in_array('5',$tz['targets'])){
			if($tz['plugins'] == NULL || empty($tz['plugins'])){
				cpmsg('webtctz:tznoplugins', '', 'error');
			}else{
				$lastplugins = mb_substr($dtz['plugins'], -1);
				if($lastplugins == ','){
					$dtz['plugins'] = rtrim($dtz['plugins'],',');
				}
				$dtz['plugins'] = explode(",", $dtz['plugins']);
				$dtz['plugins'] = json_encode($dtz['plugins']);
			}
		}
		if($dtz['type'] == '0' && empty($dtz['cimg'])){
			cpmsg('webtctz:tznocimg', '', 'error');
		}
	    if($dtz['type'] == '1' && empty($dtz['ctext'])){
			cpmsg('webtctz:tznoctext', '', 'error');
		}
		if($dtz['type'] == '2' && empty($dtz['ciframe'])){
			cpmsg('webtctz:tznociframe', '', 'error');
		}
		if($dtz['type'] == '3' && empty($dtz['chtml'])){
			cpmsg('webtctz:tznochtml', '', 'error');
		}
		if(!is_numeric($dtz['pyright'])){
			cpmsg('webtctz:tznotnum', '', 'error');
		}
	    if(!is_numeric($dtz['pybottom'])){
			cpmsg('webtctz:tznotnum', '', 'error');
		}
		if(!is_numeric($dtz['transparency'])){
			cpmsg('webtctz:tztransparencynotnum', '', 'error');
		}
		if($dtz['users'] != NULL && !empty($dtz['users'])){
			$lastusers = mb_substr($dtz['users'], -1);
			if($lastusers == ','){
				$dtz['users'] = rtrim($dtz['users'],',');
			}
			$dtz['users'] = explode(",", $dtz['users']);
			$dtz['users'] = json_encode($dtz['users']);
			$dtz['usergroup'] = json_encode('');
		}
		if($dtz['tids'] != NULL && !empty($dtz['tids'])){
			$lasttids = mb_substr($dtz['tids'], -1);
			if($lasttids == ','){
				$dtz['tids'] = rtrim($dtz['tids'],',');
			}
			$dtz['tids'] = explode(",", $dtz['tids']);
			$dtz['tids'] = json_encode($dtz['tids']);
			$dtz['fids'] = json_encode('');
			$dtz['groups'] = json_encode('');
		}
		if($dtz['aids'] != NULL && !empty($dtz['aids'])){
			$lastaids = mb_substr($dtz['aids'], -1);
			if($lastaids == ','){
				$dtz['aids'] = rtrim($dtz['aids'],',');
			}
			$dtz['aids'] = explode(",", $dtz['aids']);
			$dtz['aids'] = json_encode($dtz['aids']);
			$dtz['category'] = json_encode('');
		}
		
		if($_FILES['ccloseimg']) {
		    if(file_exists(libfile('class/upload'))){
		        require_once libfile('class/upload');
		    }else{
		        require_once libfile('discuz/upload', 'class');
		    }
		    $upload = new discuz_upload();
		    if($upload->init($_FILES['ccloseimg'], 'common') && $upload->save(1)) {
		        $dtz['ccloseimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
		    }
		} else {
		    $dtz['ccloseimg'] = !empty($_GET['ccloseimg'])?trim($_GET['ccloseimg']):"";
		}
		
		if(C::t('#webtctz#webtctz_lists')->insert($dtz,true)){
			cpmsg('webtctz:addok', 'action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz', 'succeed');
		}else{
			cpmsg('webtctz:error', '', 'error');
		}
	}
	
	echo '<div class="colorbox"><h4>'.plang('aboutforum').'</h4>'.
		 '<table cellspacing="0" cellpadding="3"><tr>'.
	     '<td valign="top">'.plang('description').'</td></tr></table>'.
		 '<div style="width:95%" align="right">'.plang('copyright').'</div></div>';
	
	echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
	
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=add', 'enctype');
	showtableheader(plang('addtz'), '');
	showsetting(plang('tztitle'),'tz[title]','','text','','',plang('tztitle_msg'));
	showsetting(plang('tzisopen'),'tz[isopen]','1','radio','','',plang('tzisopen_msg'));
	showsetting(plang('tztargets'), array('tz[targets]', array(
		array('1', plang('tztargetscategory')),
		array('2', plang('tztargetsfids')),
		array('3', plang('tztargetsgroups')),
		array('4', plang('tztargetshome')),
		array('5', plang('tztargetsplugin')),
	)), array('2'), 'mcheckbox');
	showsetting(plang('tzplugins'),'tz[plugins]','','text','','',plang('tzplugins_msg'),'','tzplugins');
	showsetting(plang('tzstarttime'),'tz[starttime]','','calendar','',0,plang('tzstarttime_msg'),1,'tzstarttime');
	showsetting(plang('tzendtime'),'tz[endtime]','','calendar','',0,plang('tzendtime_msg'),1,'tzendtime');

	//--
	$select ='';
	$tztype = plang('tztype');
	foreach($tztype as $k =>$v){
		$select .= '<option value="'.$k.'">'.$v.'</option>';
	}
	showsetting(plang('tztypetitle'),'tz[type]','','<select name="tz[type]">'.$select.'</select>');
	
	//--
	showsetting(plang('tzisopenborder'),'tz[isopenborder]','1','radio','','',plang('tzisopenborder_msg'));
	
	showsetting(plang('tzisclosetime'),'tz[isclosetime]','1','radio','','',plang('tzisclosetime_msg'));
	showsetting(plang('tzisanimatestart'),'tz[isanimatestart]','1','radio','','',plang('tzisanimatestart_msg'));
	showsetting(plang('tziscloseshow'),'tz[iscloseshow]','1','radio','','',plang('tziscloseshow_msg'));
	showsetting(plang('tzisfloat'),'tz[isfloat]','1','radio','','',plang('tzisfloat_msg'));	
	showsetting(plang('tzisbg'),'tz[isbg]','1','radio','','',plang('tzisbg_msg'));
	
	showsetting(plang('tzcimg'), 'cimg', '', 'filetext','','',plang('tzcimg_msg'),'','tzcimg');
	
	
	
	//showsetting(plang('tzcimg'),'tz[cimg]','','text','','',plang('tzcimg_msg'),'','tzcimg');
	showsetting(plang('tzctext'),'tz[ctext]','','textarea','','',plang('tzctext_msg'),'','tzctext');
	showsetting(plang('tzcurl'),'tz[curl]','','text','','',plang('tzcurl_msg'),'','tzcurl');
	showsetting(plang('tzciframe'),'tz[ciframe]','','text','','',plang('tzciframe_msg'),'','tzciframe');
	showsetting(plang('tzchtml'),'tz[chtml]','','textarea','','',plang('tzchtml_msg'),'','tzchtml');
	

	
	
	if(class_exists($webtctzclass)) {
		$webtctzclass = new $webtctzclass();
		$webtctzsetting = $webtctzclass->getsetting();
		if(is_array($webtctzsetting)) {
			foreach($webtctzsetting as $settingvar => $setting) {
				if(!empty($setting['value']) && is_array($setting['value'])) {
					foreach($setting['value'] as $k => $v) {
						$setting['value'][$k][1] = plang($setting['value'][$k][1]);
					}
				}
				$varname = in_array($setting['type'], array('mradio', 'mcheckbox', 'select', 'mselect')) ?
				($setting['type'] == 'mselect' ? array('tz['.$settingvar.'][]', $setting['value']) : array('tz['.$settingvar.']', $setting['value']))
				: 'tz['.$settingvar.']';
				
				$comment = plang($setting['comment']);
				showsetting(plang($setting['title']).':', $varname, '', $setting['type'], '', 0, $comment);
			}
		}
	}
	//--
	$groupselect = array();
	//$query = C::t('common_usergroup')->fetch_all_not(array(6, 7), true);
	$query = C::t('common_usergroup')->fetch_all_not(array(), true);
	foreach($query as $group) {
		$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
		$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" ".(in_array($group['groupid'], $usergroupid) ? 'selected' : '').">$group[grouptitle]</option>\n";
	}
	$groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
		($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
		($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
		'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';
	
	showsetting(plang('tzusergroupstitle'), '', '', '<select name="tz[groupid][]" multiple="multiple" size="10">'.$groupselect.'</select>', '', 0, plang('tzusergroupscomment'));
	
	showsetting(plang('tzusers'),'tz[users]','','text','','',plang('tzusers_msg'),'','tzusers');
	showsetting(plang('tztids'),'tz[tids]','','text','','',plang('tztids_msg'),'','tztids');
	showsetting(plang('tzaids'),'tz[aids]','','text','','',plang('tzaids_msg'),'','tzaids');
	
	showsetting(plang('tzheight'),'tz[height]','480','text','','',plang('tzheight_msg'),'','tzheight');
	showsetting(plang('tzwidth'),'tz[width]','450','text','','',plang('tzwidth_msg'),'','tzwidth');
	showsetting(plang('tzcount'),'tz[count]','3','text','','',plang('tzcount_msg'),'','tzcount');
	
	//--
	$select ='';
	$tzposition = plang('tzposition');
	foreach($tzposition as $k =>$v){
		$select .= '<option value="'.$k.'">'.$v.'</option>';
	}
	showsetting(plang('tzpositiontitle'),'tz[position]','','<select name="tz[position]">'.$select.'</select>');
	
	//--
	showsetting(plang('tzpyright'),'tz[pyright]','0','text','','',plang('tzpyright_msg'),'','tzpyright');
	showsetting(plang('tzpybottom'),'tz[pybottom]','0','text','','',plang('tzpybottom_msg'),'','tzpybottom');
	showsetting(plang('tztransparency'),'tz[transparency]','1','text','','',plang('tztransparency_msg'),'','tztransparency');
	
	showsetting(plang('tzclosetime'),'tz[closetime]','30','text','','',plang('tzclosetime_msg'),'','tzclosetime');
	showsetting(plang('tzinterval'),'tz[interval]','0','text','','',plang('tzinterval_msg'),'','tzinterval');
	
	showsetting(plang('tzdelay'),'tz[delay]','0','text','','',plang('tzdelay_msg'),'','tzdelay');
	
	showsetting(plang('tzzindex'),'tz[zindex]','999','text','','',plang('tzzindex_msg'));
	
	showsetting(plang('tzcontentbg'),'tz[contentbg]','#fff','text','','',plang('tzcontentbg_msg'));
	
	showsetting(plang('tzccloseimg'), 'ccloseimg', '', 'filetext','','',plang('tzccloseimg_msg'),'','tzccloseimg');
	showsetting(plang('tzcloseheight'),'tz[closeheight]','','text','','',plang('tzcloseheight_msg'),'','tzcloseheight');
	showsetting(plang('tzclosewidth'),'tz[closewidth]','','text','','',plang('tzclosewidth_msg'),'','tzclosewidth');
	showsetting(plang('tzclosepyright'),'tz[closepyright]','0','text','','',plang('tzclosepyright_msg'),'','tzclosepyright');
	showsetting(plang('tzclosepybottom'),'tz[closepybottom]','0','text','','',plang('tzclosepybottom_msg'),'','tzclosepybottom');
	
	showsubmit('submit', 'submit');
	showtablefooter();
	showformfooter();
	
	
	dexit();
}elseif($act=='delete'){
	$id = dintval($_GET['id']);
	$tz = C::t('#webtctz#webtctz_lists')->fetch($id);
	if(empty($tz))
		cpmsg('webtctz:empty', '', 'error');
	if(submitcheck('submit')){
		C::t('#webtctz#webtctz_lists')->delete($id);
		cpmsg('webtctz:delok', 'action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz', 'succeed');
	}
	cpmsg('webtctz:deltz','action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=delete&id='.$id.'&submit=yes','form',array('title' => $tz['title']));
}elseif($act=='details'){
	$id = dintval($_GET['id']);
	$tz = C::t('#webtctz#webtctz_lists')->fetch($id);
	if(empty($tz))
		cpmsg('webtctz:empty', '', 'error');
	$webtctzclass = new $webtctzclass();
	echo "<strong>".plang("tztitle").":</strong>".$tz['title']."<br/>"
		 ."<strong>".plang("tzisopen").":</strong>".($tz['isopen']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tzisopenborder").":</strong>".($tz['isopenborder']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tzisclosetime").":</strong>".($tz['isclosetime']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tzisanimatestart").":</strong>".($tz['isanimatestart']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tziscloseshow").":</strong>".($tz['iscloseshow']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tzisfloat").":</strong>".($tz['isfloat']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tzisbg").":</strong>".($tz['tzisbg']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("tzzindex").":</strong>".$tz['zindex']."<br/>"
		 ."<strong>".plang("tztargets").":</strong>".$webtctzclass->gettargetsname(json_decode($tz['targets']))."<br/>"
		 ."<strong>".plang("tzplugins").":</strong>".implode(",",json_decode($tz['plugins']))."<br/>"
		 ."<strong>".plang("tzfidstitle").":</strong>".$webtctzclass->getforumsname(null,json_decode($tz['fids']),true)."<br/>"
		 ."<strong>".plang("tzusergroupstitle").":</strong>".$webtctzclass->getusergroupname(null,json_decode($tz['usergroup']),true)."<br/>"
		 ."<strong>".plang("tzgroupstitle").":</strong>".$webtctzclass->getgroupsname(null,json_decode($tz['groups']),true)."<br/>"
		 ."<strong>".plang("tzcategorytitle").":</strong>".$webtctzclass->getcategoryname(null,json_decode($tz['category']),true)."<br/>"
		 ."<strong>".plang("tzusers").":</strong>".implode(",",json_decode($tz['users']))."<br/>"
		 ."<strong>".plang("tztids").":</strong>".implode(",",json_decode($tz['tids']))."<br/>"
		 ."<strong>".plang("tzaids").":</strong>".implode(",",json_decode($tz['aids']))."<br/>"
		 ."<strong>".plang("tztypetitle").":</strong>".$webtctzclass->gettypename($tz['type'])."<br/>"
		 ."<strong>".plang("tzcimg").":</strong>".$tz['cimg']."<br/>"
		 ."<strong>".plang("tzctext").":</strong>".$tz['ctext']."<br/>"
		 ."<strong>".plang("tzcurl").":</strong>".$tz['curl']."<br/>"
		 ."<strong>".plang("tzciframe").":</strong>".$tz['ciframe']."<br/>"
		 ."<strong>".plang("tzchtml").":</strong>".$tz['chtml']."<br/>"
		 ."<strong>".plang("tzheight").":</strong>".$tz['height']."px<br/>"
		 ."<strong>".plang("tzwidth").":</strong>".$tz['width']."px<br/>"
		 ."<strong>".plang("tzpositiontitle").":</strong>".$webtctzclass->getpositionname($tz['position'])."<br/>"
		 ."<strong>".plang("tzpyright").":</strong>".$tz['pyright']."px<br/>"
		 ."<strong>".plang("tzpybottom").":</strong>".$tz['pybottom']."px<br/>"
		 ."<strong>".plang("tztransparency").":</strong>".$tz['transparency']."<br/>"
		 ."<strong>".plang("tzcount").":</strong>".$tz['count']."<br/>"
		 ."<strong>".plang("tzclosetime").":</strong>".$tz['closetime']."<br/>"
		 ."<strong>".plang("tzinterval").":</strong>".$tz['interval']."<br/>"
		 ."<strong>".plang("tzdelay").":</strong>".$tz['delay']."<br/>"
		 ."<strong>".plang("tzcontentbg").":</strong>".$tz['contentbg']."<br/>"
		 ."<strong>".plang("tzccloseimg").":</strong>".$tz['ccloseimg']."<br/>"
		 ."<strong>".plang("tzcloseheight").":</strong>".$tz['closeheight']."px<br/>"
		 ."<strong>".plang("tzclosewidth").":</strong>".$tz['closewidth']."px<br/>"
		 ."<strong>".plang("tzclosepyright").":</strong>".$tz['closepyright']."px<br/>"
		 ."<strong>".plang("tzclosepybottom").":</strong>".$tz['closepybottom']."px<br/>"
		 ."<strong>".plang("tzstarttime").":</strong>".dgmdate($tz['starttime'])."<br/>"
		 ."<strong>".plang("tzendtime").":</strong>".dgmdate($tz['endtime'])."<br/>"
		 ."<strong>".plang("tzdateline").":</strong>".dgmdate($tz['dateline'])."<br/>";
	dexit();
}elseif($act=='edit'){
	$id = dintval($_GET['id']);
	$tz = C::t('#webtctz#webtctz_lists')->fetch($id);
	if(empty($tz))
		cpmsg('webtctz:empty', '', 'error');
	if(submitcheck('submit')){
	    $tz = $_GET['tz'];
		$dtz = array('dateline'=>TIMESTAMP);
		$dtz['title'] = addslashes(trim($tz['title']));
		$dtz['isopen'] = addslashes(trim($tz['isopen']));
		$dtz['isopenborder'] = addslashes(trim($tz['isopenborder']));
		$dtz['isclosetime'] = addslashes(trim($tz['isclosetime']));
		$dtz['isanimatestart'] = addslashes(trim($tz['isanimatestart']));
		$dtz['iscloseshow'] = addslashes(trim($tz['iscloseshow']));
		$dtz['isbg'] = addslashes(trim($tz['isbg']));
		$dtz['isfloat'] = addslashes(trim($tz['isfloat']));
		$dtz['zindex'] = addslashes(trim($tz['zindex']));
		$dtz['contentbg'] = addslashes(trim($tz['contentbg']));
		$dtz['targets'] = json_encode($tz['targets']);
		$dtz['plugins'] = addslashes(trim($tz['plugins']));
		$dtz['starttime'] = addslashes($tz['starttime']) ? strtotime(addslashes($tz['starttime'])) : 0;
		$dtz['endtime'] = addslashes($tz['endtime']) ? strtotime(addslashes($tz['endtime'])) : 0;	
		$dtz['fids'] =  json_encode($tz['fids']);
		$dtz['usergroup'] = json_encode($tz['groupid']);
		$dtz['groups'] = json_encode($tz['groups']);
		$dtz['category'] = json_encode($tz['category']);
		$dtz['users'] = addslashes(trim($tz['users']));
		$dtz['tids'] = addslashes(trim($tz['tids']));
		$dtz['aids'] = addslashes(trim($tz['aids']));
		$dtz['type'] = addslashes(trim($tz['type']));
		//$dtz['cimg'] = trim($tz['cimg']);
		$dtz['ctext'] = addslashes(trim($tz['ctext']));
		$dtz['curl'] = addslashes(trim($tz['curl']));
		$dtz['ciframe'] = addslashes(trim($tz['ciframe']));
		$dtz['chtml'] = stripslashes($tz['chtml']);
		$dtz['height'] = addslashes(trim($tz['height']));
		$dtz['width'] = addslashes(trim($tz['width']));
		$dtz['position'] = addslashes(trim($tz['position']));
		$dtz['pyright'] = addslashes(trim($tz['pyright']));
		$dtz['pybottom'] = addslashes(trim($tz['pybottom']));
		$dtz['transparency'] = addslashes(trim($tz['transparency']));
		$dtz['count'] = dintval(addslashes($tz['count']));
		$dtz['closetime'] = dintval(addslashes($tz['closetime']));
		$dtz['interval'] = dintval(addslashes($tz['interval']));
		$dtz['delay'] = dintval(addslashes($tz['delay']));
		$dtz['closepyright'] = addslashes(trim($tz['closepyright']));
		$dtz['closepybottom'] = addslashes(trim($tz['closepybottom']));
		$dtz['closeheight'] = addslashes(trim($tz['closeheight']));
		$dtz['closewidth'] = addslashes(trim($tz['closewidth']));
		
		if($_FILES['cimg']) {
			if(file_exists(libfile('class/upload'))){
				require_once libfile('class/upload');
			}else{
				require_once libfile('discuz/upload', 'class');
			}
			$upload = new discuz_upload();
			if($upload->init($_FILES['cimg'], 'common') && $upload->save(1)) {
				$dtz['cimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
			}
		} else {
			$dtz['cimg'] = !empty($_GET['cimg'])?trim($_GET['cimg']):"";
		}
		
		
		if(empty($dtz['title'])){
			cpmsg('webtctz:tznotitle', '', 'error');
		}elseif(strlen($dtz['title']) > 50) {
			cpmsg('webtctz:tz_title_more', '', 'error');
		}
		
		if(!empty($dtz['starttime']) && !empty($dtz['endtime'])) {
			if($dtz['endtime'] <= TIMESTAMP || $dtz['endtime'] <= $dtz['starttime']) {
				cpmsg('webtctz:tz_endtime_invalid', '', 'error');
			}
		}
		if($tz['targets'] == NULL || empty($tz['targets'])){
			cpmsg('webtctz:tznotargets', '', 'error');
		}
	if($tz['groupid'] == NULL || empty($tz['groupid'])){
			if($tz['users'] == NULL || empty($tz['users'])){
			   cpmsg('webtctz:tznogroupid', '', 'error');
			}
		}
		if(in_array('2',$tz['targets'])){
			if($tz['fids'] == NULL || empty($tz['fids'])){
				if($tz['tids'] == NULL || empty($tz['tids'])){
				   cpmsg('webtctz:tznofids', '', 'error');
				}
			}
			/*
			if(count($tz['fids']) == 1 && in_array('0',$tz['fids'])){
				cpmsg('webtctz:tznofids', '', 'error');
			}
			*/
		}
		if(in_array('3',$tz['targets'])){
			if($tz['groups'] == NULL || empty($tz['groups'])){
				if($tz['tids'] == NULL || empty($tz['tids'])){
				   cpmsg('webtctz:tznogroups', '', 'error');
				}
			}
		}
		if(in_array('1',$tz['targets'])){
			if($tz['category'] == NULL || empty($tz['category'])){
				if($tz['aids'] == NULL || empty($tz['aids'])){
				   cpmsg('webtctz:tznocategory', '', 'error');
				}
			}
		}
	    if(in_array('5',$tz['targets'])){
			if($tz['plugins'] == NULL || empty($tz['plugins'])){
				cpmsg('webtctz:tznoplugins', '', 'error');
			}else{
				$lastplugins = substr($dtz['plugins'], -1);
				if($lastplugins == ','){
					$dtz['plugins'] = rtrim($dtz['plugins'],',');
				}
				$dtz['plugins'] = explode(",", $dtz['plugins']);
				$dtz['plugins'] = json_encode($dtz['plugins']);
			}
		}
		if($dtz['type'] == '0' && empty($dtz['cimg'])){
			cpmsg('webtctz:tznocimg', '', 'error');
		}
	    if($dtz['type'] == '1' && empty($dtz['ctext'])){
			cpmsg('webtctz:tznoctext', '', 'error');
		}
		if($dtz['type'] == '2' && empty($dtz['ciframe'])){
			cpmsg('webtctz:tznociframe', '', 'error');
		}
		if($dtz['type'] == '3' && empty($dtz['chtml'])){
			cpmsg('webtctz:tznochtml', '', 'error');
		}
		if(!is_numeric($dtz['pyright'])){
			cpmsg('webtctz:tznotnum', '', 'error');
		}
	    if(!is_numeric($dtz['pybottom'])){
			cpmsg('webtctz:tznotnum', '', 'error');
		}
		if(!is_numeric($dtz['transparency'])){
			cpmsg('webtctz:tztransparencynotnum', '', 'error');
		}
		if($dtz['users'] != NULL && !empty($dtz['users'])){
			$lastusers = substr($dtz['users'], -1);
			if($lastusers == ','){
				$dtz['users'] = rtrim($dtz['users'],',');
			}
			$dtz['users'] = explode(",", $dtz['users']);
			$dtz['users'] = json_encode($dtz['users']);
			$dtz['usergroup'] = json_encode('');
		}
		if($dtz['tids'] != NULL && !empty($dtz['tids'])){
			$lasttids = substr($dtz['tids'], -1);
			if($lasttids == ','){
				$dtz['tids'] = rtrim($dtz['tids'],',');
			}
			$dtz['tids'] = explode(",", $dtz['tids']);
			$dtz['tids'] = json_encode($dtz['tids']);
			$dtz['fids'] = json_encode('');
			$dtz['groups'] = json_encode('');
		}
		if($dtz['aids'] != NULL && !empty($dtz['aids'])){
			$lastaids = substr($dtz['aids'], -1);
			if($lastaids == ','){
				$dtz['aids'] = rtrim($dtz['aids'],',');
			}
			$dtz['aids'] = explode(",", $dtz['aids']);
			$dtz['aids'] = json_encode($dtz['aids']);
			$dtz['category'] = json_encode('');
		}
		
		if($_FILES['ccloseimg']) {
		    if(file_exists(libfile('class/upload'))){
		        require_once libfile('class/upload');
		    }else{
		        require_once libfile('discuz/upload', 'class');
		    }
		    $upload = new discuz_upload();
		    if($upload->init($_FILES['ccloseimg'], 'common') && $upload->save(1)) {
		        $dtz['ccloseimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
		    }
		} else {
		    $dtz['ccloseimg'] = !empty($_GET['ccloseimg'])?trim($_GET['ccloseimg']):"";
		}
		
		if(C::t('#webtctz#webtctz_lists')->update($id,$dtz)){
			cpmsg('webtctz:editok', 'action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz', 'succeed');
		}else{
			cpmsg('webtctz:error', '', 'error');
		}
		
	
	}
	echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
	
	echo '<div class="colorbox"><h4>'.plang('aboutforum').'</h4>'.
			'<table cellspacing="0" cellpadding="3"><tr>'.
			'<td valign="top">'.plang('description').'</td></tr></table>'.
			'<div style="width:95%" align="right">'.plang('copyright').'</div></div>';
	
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=edit', 'enctype');
	echo'<input type="hidden" value="'.$tz['id'].'" name="id"/>';
	showtableheader(plang('edittz'), '');
	showsetting(plang('tztitle'),'tz[title]',$tz['title'],'text','','',plang('tztitle_msg'));
	showsetting(plang('tzisopen'),'tz[isopen]',$tz['isopen'],'radio','','',plang('tzisopen_msg'));
	showsetting(plang('tztargets'), array('tz[targets]', array(
	    array('1', plang('tztargetscategory')),
		array('2', plang('tztargetsfids')),
		array('3', plang('tztargetsgroups')),
		array('4', plang('tztargetshome')),
		array('5', plang('tztargetsplugin')),
	)), json_decode($tz['targets']), 'mcheckbox');
	$tz['plugins']=implode(",",json_decode($tz['plugins']));
	showsetting(plang('tzplugins'),'tz[plugins]',$tz['plugins'],'text','','',plang('tzplugins_msg'),'','tzplugins');
	showsetting(plang('tzstarttime'),'tz[starttime]',dgmdate($tz['starttime']),'calendar','',0,plang('tzstarttime_msg'),1,'tzstarttime');
	showsetting(plang('tzendtime'),'tz[endtime]',dgmdate($tz['endtime']),'calendar','',0,plang('tzendtime_msg'),1,'tzendtime');

	//--
	$select ='';
	$tztype = plang('tztype');
	foreach($tztype as $k =>$v){
		$select .= '<option value="'.$k.'" '.($k==$tz['type']?'selected':'').'>'.$v.'</option>';
	}
	showsetting(plang('tztypetitle'),'tz[type]',$tz['type'],'<select name="tz[type]">'.$select.'</select>');
	
	//--
	showsetting(plang('tzisopenborder'),'tz[isopenborder]',$tz['isopenborder'],'radio','','',plang('tzisopenborder_msg'));
	//showsetting(plang('tzcimg'),'tz[cimg]',$tz['cimg'],'text','','',plang('tzcimg_msg'),'','tzcimg');
	
	showsetting(plang('tzisclosetime'),'tz[isclosetime]',$tz['isclosetime'],'radio','','',plang('tzisclosetime_msg'));
	showsetting(plang('tzisanimatestart'),'tz[isanimatestart]',$tz['isanimatestart'],'radio','','',plang('tzisanimatestart_msg'));
	showsetting(plang('tziscloseshow'),'tz[iscloseshow]',$tz['iscloseshow'],'radio','','',plang('tziscloseshow_msg'));
	showsetting(plang('tzisfloat'),'tz[isfloat]',$tz['isfloat'],'radio','','',plang('tzisfloat_msg'));
	showsetting(plang('tzisbg'),'tz[isbg]',$tz['isbg'],'radio','','',plang('tzisbg_msg'));
	
	showsetting(plang('tzcimg'), 'cimg', $tz['cimg'], 'filetext','','',plang('tzcimg_msg'),'','tzcimg');
	
	
	showsetting(plang('tzctext'),'tz[ctext]',$tz['ctext'],'textarea','','',plang('tzctext_msg'),'','tzctext');
	showsetting(plang('tzcurl'),'tz[curl]',$tz['curl'],'text','','',plang('tzcurl_msg'),'','tzcurl');
	showsetting(plang('tzciframe'),'tz[ciframe]',$tz['ciframe'],'text','','',plang('tzciframe_msg'),'','tzciframe');
	showsetting(plang('tzchtml'),'tz[chtml]',$tz['chtml'],'textarea','','',plang('tzchtml_msg'),'','tzchtml');
	
	if(class_exists($webtctzclass)) {
		$webtctzclass = new $webtctzclass();
		$webtctzsetting = $webtctzclass->getsetting();
		if(is_array($webtctzsetting)) {
			foreach($webtctzsetting as $settingvar => $setting) {
				if(!empty($setting['value']) && is_array($setting['value'])) {
					foreach($setting['value'] as $k => $v) {
						$setting['value'][$k][1] = plang($setting['value'][$k][1]);
					}
				}
				$varname = in_array($setting['type'], array('mradio', 'mcheckbox', 'select', 'mselect')) ?
				($setting['type'] == 'mselect' ? array('tz['.$settingvar.'][]', $setting['value']) : array('tz['.$settingvar.']', $setting['value']))
				: 'tz['.$settingvar.']';
				$value = json_decode($tz[$settingvar]) != '' ? json_decode($tz[$settingvar]) : $setting['default'];
				$comment = plang($setting['comment']);
				showsetting(plang($setting['title']).':', $varname, $value, $setting['type'], '', 0, $comment);
			}
		}
	}
	//--
	$groupselect = array();
	//$query = C::t('common_usergroup')->fetch_all_not(array(6, 7), true);
	$query = C::t('common_usergroup')->fetch_all_not(array(), true);
	foreach($query as $group) {
		$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
		$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" ".(in_array($group['groupid'], json_decode($tz['usergroup'])) ? 'selected' : '').">$group[grouptitle]</option>\n";
	}
	$groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
		($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
		($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
		'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';
	
	showsetting(plang('tzusergroupstitle'), '', '', '<select name="tz[groupid][]" multiple="multiple" size="10">'.$groupselect.'</select>', '', 0, plang('tzusergroupscomment'));
	
	$tz['users']=implode(",",json_decode($tz['users']));
	showsetting(plang('tzusers'),'tz[users]',$tz['users'],'text','','',plang('tzusers_msg'),'','tzusers');
	$tz['tids']=implode(",",json_decode($tz['tids']));
	showsetting(plang('tztids'),'tz[tids]',$tz['tids'],'text','','',plang('tztids_msg'),'','tztids');
	$tz['aids']=implode(",",json_decode($tz['aids']));
	showsetting(plang('tzaids'),'tz[aids]',$tz['aids'],'text','','',plang('tzaids_msg'),'','tzaids');
	
	
	showsetting(plang('tzheight'),'tz[height]',$tz['height'],'text','','',plang('tzheight_msg'),'','tzheight');
	showsetting(plang('tzwidth'),'tz[width]',$tz['width'],'text','','',plang('tzwidth_msg'),'','tzwidth');
	showsetting(plang('tzcount'),'tz[count]',$tz['count'],'text','','',plang('tzcount_msg'),'','tzcount');
	
	//--
	$select ='';
	$tzposition = plang('tzposition');
	foreach($tzposition as $k =>$v){
		$select .= '<option value="'.$k.'" '.($k==$tz['position']?'selected':'').'>'.$v.'</option>';
	}
	showsetting(plang('tzpositiontitle'),'tz[position]','','<select name="tz[position]">'.$select.'</select>');
	
	//--
	showsetting(plang('tzpyright'),'tz[pyright]',$tz['pyright'],'text','','',plang('tzpyright_msg'),'','tzpyright');
	showsetting(plang('tzpybottom'),'tz[pybottom]',$tz['pybottom'],'text','','',plang('tzpybottom_msg'),'','tzpybottom');
	showsetting(plang('tztransparency'),'tz[transparency]',$tz['transparency'],'text','','',plang('tztransparency_msg'),'','tztransparency');
	
	
	showsetting(plang('tzclosetime'),'tz[closetime]',$tz['closetime'],'text','','',plang('tzclosetime_msg'),'','tzclosetime');
	showsetting(plang('tzinterval'),'tz[interval]',$tz['interval'],'text','','',plang('tzinterval_msg'),'','tzinterval');
	showsetting(plang('tzdelay'),'tz[delay]',$tz['delay'],'text','','',plang('tzdelay_msg'),'','tzdelay');
	
	showsetting(plang('tzzindex'),'tz[zindex]',$tz['zindex'],'text','','',plang('tzzindex_msg'));
	
	showsetting(plang('tzcontentbg'),'tz[contentbg]',$tz['contentbg'],'text','','',plang('tzcontentbg_msg'));
	
	showsetting(plang('tzccloseimg'), 'ccloseimg', $tz['ccloseimg'], 'filetext','','',plang('tzccloseimg_msg'),'','tzccloseimg');
	showsetting(plang('tzcloseheight'),'tz[closeheight]',$tz['closeheight'],'text','','',plang('tzcloseheight_msg'),'','tzcloseheight');
	showsetting(plang('tzclosewidth'),'tz[closewidth]',$tz['closewidth'],'text','','',plang('tzclosewidth_msg'),'','tzclosewidth');
	showsetting(plang('tzclosepyright'),'tz[closepyright]',$tz['closepyright'],'text','','',plang('tzclosepyright_msg'),'','tzclosepyright');
	showsetting(plang('tzclosepybottom'),'tz[closepybottom]',$tz['closepybottom'],'text','','',plang('tzclosepybottom_msg'),'','tzclosepybottom');
	
	showsubmit('submit', 'submit');
	showtablefooter();
	showformfooter();
	dexit();
}
loadcache('plugin');

$page = intval($_GET['page']);
$page = $page > 0 ? $page : 1;
$pagesize = 15;
$start = ($page - 1) * $pagesize;

$alltzs = C::t('#webtctz#webtctz_lists')->range($start,$pagesize,'DESC');
$count = C::t('#webtctz#webtctz_lists')->count();
showtableheader(plang('tzlist').'(  <a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=add" style="color:red;">'.plang('add').'</a>  )', '');
showsubtitle(plang('tzlisttitle'));
$webtctzclass = new $webtctzclass();
foreach($alltzs as $d){
	showtablerow('', array('width="80"'), array(
	$d['id'],
	'<span title="'.$d['title'].'">'.mb_substr($d['title'],0,20).'</span>',
	$d['isopen']?plang('yes'):plang('no'),
	'<span title="'.$webtctzclass->gettargetsname(json_decode($d['targets'])).'">'.mb_substr($webtctzclass->gettargetsname(json_decode($d['targets'])),0,20).'...</span>',
	'<span title="'.$webtctzclass->getforumsname(null,json_decode($d['fids']),true).'">'.mb_substr($webtctzclass->getforumsname(null,json_decode($d['fids']),true),0,20).'...</span>',
	'<span title="'.$webtctzclass->getusergroupname(null,json_decode($d['usergroup']),true).'">'.mb_substr($webtctzclass->getusergroupname(null,json_decode($d['usergroup']),true),0,20).'...</span>',
	$webtctzclass->gettypename($d['type']),
	dgmdate($d['dateline']),
	'<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=details&id='.$d['id'].'">'.plang('details').'</a>&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=edit&id='.$d['id'].'">'.plang('edit').'</a>&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz&act=delete&id='.$d['id'].'">'.plang('delete').'</a>')
	);
}
$mpurl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=alltz';
$multipage = multi($count, $pagesize, $page, $mpurl);
showsubmit('', '', '', '', $multipage);
showtablefooter();

function plang($str) {
	return lang('plugin/webtctz', $str);
}
//From:www_FX8_co
?>