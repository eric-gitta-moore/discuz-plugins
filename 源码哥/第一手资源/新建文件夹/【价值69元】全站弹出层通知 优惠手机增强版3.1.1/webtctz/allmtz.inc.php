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

$webtctzfile = DISCUZ_ROOT.'./source/plugin/webtctz/mobile.class.php';
require_once $webtctzfile;
$webtctzclass = 'mobileplugin_webtctz';

if($act=='add'){
	if(submitcheck('submit')){
	
		$mtz = $_GET['mtz'];
		$dmtz = array('dateline'=>TIMESTAMP);
		$dmtz['title'] = addslashes(trim($mtz['title']));
		$dmtz['isopen'] = addslashes(trim($mtz['isopen']));
		$dmtz['isopenborder'] = addslashes(trim($mtz['isopenborder']));
		$dmtz['isclosetime'] = addslashes(trim($mtz['isclosetime']));
		$dmtz['isanimatestart'] = addslashes(trim($mtz['isanimatestart']));
		$dmtz['iscloseshow'] = addslashes(trim($mtz['iscloseshow']));
		$dmtz['isbg'] = addslashes(trim($mtz['isbg']));
		$dmtz['isfloat'] = addslashes(trim($mtz['isfloat']));
		$dmtz['zindex'] = addslashes(trim($mtz['zindex']));
		$dmtz['contentbg'] = addslashes(trim($mtz['contentbg']));
		$dmtz['targets'] = json_encode($mtz['targets']);
		$dmtz['plugins'] = addslashes(trim($mtz['plugins']));
		$dmtz['starttime'] = addslashes($mtz['starttime']) ? strtotime(addslashes($mtz['starttime'])) : 0;
		$dmtz['endtime'] = addslashes($mtz['endtime']) ? strtotime(addslashes($mtz['endtime'])) : 0;	
		$dmtz['fids'] =  json_encode($mtz['fids']);
		$dmtz['usergroup'] = json_encode($mtz['groupid']);
		$dmtz['groups'] = json_encode($mtz['groups']);
		$dmtz['category'] = json_encode($mtz['category']);
		$dmtz['users'] = addslashes(trim($mtz['users']));
		$dmtz['tids'] = addslashes(trim($mtz['tids']));
		$dmtz['aids'] = addslashes(trim($mtz['aids']));
		$dmtz['type'] = addslashes(trim($mtz['type']));
		//$dmtz['cimg'] = trim($mtz['cimg']);
		$dmtz['ctext'] = addslashes(trim($mtz['ctext']));
		$dmtz['curl'] = addslashes(trim($mtz['curl']));
		$dmtz['ciframe'] = addslashes(trim($mtz['ciframe']));
		$dmtz['chtml'] = stripslashes(trim($mtz['chtml']));
		$dmtz['height'] = addslashes(trim($mtz['height']));
		$dmtz['width'] = addslashes(trim($mtz['width']));
		$dmtz['position'] = addslashes(trim($mtz['position']));
		$dmtz['pyright'] = addslashes(trim($mtz['pyright']));
		$dmtz['pybottom'] = addslashes(trim($mtz['pybottom']));
		$dmtz['transparency'] = addslashes(trim($mtz['transparency']));
		$dmtz['count'] = dintval(addslashes($mtz['count']));
		$dmtz['closetime'] = dintval(addslashes($mtz['closetime']));
		$dmtz['interval'] = dintval(addslashes($mtz['interval']));
		$dmtz['delay'] = dintval(addslashes($mtz['delay']));
		$dmtz['closepyright'] = addslashes(trim($mtz['closepyright']));
		$dmtz['closepybottom'] = addslashes(trim($mtz['closepybottom']));
		$dmtz['closeheight'] = addslashes(trim($mtz['closeheight']));
		$dmtz['closewidth'] = addslashes(trim($mtz['closewidth']));
	
		if($_FILES['cimg']) {
			if(file_exists(libfile('class/upload'))){
				require_once libfile('class/upload');
			}else{
				require_once libfile('discuz/upload', 'class');
			}
			$upload = new discuz_upload();
			if($upload->init($_FILES['cimg'], 'common') && $upload->save(1)) {
				$dmtz['cimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
			}
		} else {
			$dmtz['cimg'] = !empty($_GET['cimg'])?trim($_GET['cimg']):"";
		}
		
		if(empty($dmtz['title'])){
			cpmsg('webtctz:mtznotitle', '', 'error');
		}elseif(strlen($dmtz['title']) > 50) {
			cpmsg('webtctz:mtz_title_more', '', 'error');
		}
		
		if(!empty($dmtz['starttime']) && !empty($dmtz['endtime'])) {
			if($dmtz['endtime'] <= TIMESTAMP || $dmtz['endtime'] <= $dmtz['starttime']) {
				cpmsg('webtctz:mtz_endtime_invalid', '', 'error');
			}
		}
		if($mtz['targets'] == NULL || empty($mtz['targets'])){
			cpmsg('webtctz:mtznotargets', '', 'error');
		}
		if($mtz['groupid'] == NULL || empty($mtz['groupid'])){
			if($mtz['users'] == NULL || empty($mtz['users'])){
			   cpmsg('webtctz:mtznogroupid', '', 'error');
			}
		}
		if(in_array('2',$mtz['targets'])){
			if($mtz['fids'] == NULL || empty($mtz['fids'])){
				if($mtz['tids'] == NULL || empty($mtz['tids'])){
				   cpmsg('webtctz:mtznofids', '', 'error');
				}
			}
			/*
			if(count($mtz['fids']) == 1 && in_array('0',$mtz['fids'])){
				cpmsg('webtctz:mtznofids', '', 'error');
			}
			*/
		}
		if(in_array('3',$mtz['targets'])){
			if($mtz['groups'] == NULL || empty($mtz['groups'])){
				if($mtz['tids'] == NULL || empty($mtz['tids'])){
				   cpmsg('webtctz:mtznogroups', '', 'error');
				}
			}
		}
		if(in_array('1',$mtz['targets'])){
			if($mtz['category'] == NULL || empty($mtz['category'])){
				if($mtz['aids'] == NULL || empty($mtz['aids'])){
				   cpmsg('webtctz:mtznocategory', '', 'error');
				}
			}
		}
		if(in_array('5',$mtz['targets'])){
			if($mtz['plugins'] == NULL || empty($mtz['plugins'])){
				cpmsg('webtctz:mtznoplugins', '', 'error');
			}else{
				$lastplugins = mb_substr($dmtz['plugins'], -1);
				if($lastplugins == ','){
					$dmtz['plugins'] = rtrim($dmtz['plugins'],',');
				}
				$dmtz['plugins'] = explode(",", $dmtz['plugins']);
				$dmtz['plugins'] = json_encode($dmtz['plugins']);
			}
		}
		if($dmtz['type'] == '0' && empty($dmtz['cimg'])){
			cpmsg('webtctz:mtznocimg', '', 'error');
		}
	    if($dmtz['type'] == '1' && empty($dmtz['ctext'])){
			cpmsg('webtctz:mtznoctext', '', 'error');
		}
		if($dmtz['type'] == '2' && empty($dmtz['ciframe'])){
			cpmsg('webtctz:mtznociframe', '', 'error');
		}
		if($dmtz['type'] == '3' && empty($dmtz['chtml'])){
			cpmsg('webtctz:mtznochtml', '', 'error');
		}
		if(!is_numeric($dmtz['pyright'])){
			cpmsg('webtctz:mtznotnum', '', 'error');
		}
	    if(!is_numeric($dmtz['pybottom'])){
			cpmsg('webtctz:mtznotnum', '', 'error');
		}
		if(!is_numeric($dmtz['transparency'])){
			cpmsg('webtctz:mtztransparencynotnum', '', 'error');
		}
		if($dmtz['users'] != NULL && !empty($dmtz['users'])){
			$lastusers = mb_substr($dmtz['users'], -1);
			if($lastusers == ','){
				$dmtz['users'] = rtrim($dmtz['users'],',');
			}
			$dmtz['users'] = explode(",", $dmtz['users']);
			$dmtz['users'] = json_encode($dmtz['users']);
			$dmtz['usergroup'] = json_encode('');
		}
		if($dmtz['tids'] != NULL && !empty($dmtz['tids'])){
			$lasttids = mb_substr($dmtz['tids'], -1);
			if($lasttids == ','){
				$dmtz['tids'] = rtrim($dmtz['tids'],',');
			}
			$dmtz['tids'] = explode(",", $dmtz['tids']);
			$dmtz['tids'] = json_encode($dmtz['tids']);
			$dmtz['fids'] = json_encode('');
			$dmtz['groups'] = json_encode('');
		}
		if($dmtz['aids'] != NULL && !empty($dmtz['aids'])){
			$lastaids = mb_substr($dmtz['aids'], -1);
			if($lastaids == ','){
				$dmtz['aids'] = rtrim($dmtz['aids'],',');
			}
			$dmtz['aids'] = explode(",", $dmtz['aids']);
			$dmtz['aids'] = json_encode($dmtz['aids']);
			$dmtz['category'] = json_encode('');
		}
		
		if($_FILES['ccloseimg']) {
		    if(file_exists(libfile('class/upload'))){
		        require_once libfile('class/upload');
		    }else{
		        require_once libfile('discuz/upload', 'class');
		    }
		    $upload = new discuz_upload();
		    if($upload->init($_FILES['ccloseimg'], 'common') && $upload->save(1)) {
		        $dmtz['ccloseimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
		    }
		} else {
		    $dmtz['ccloseimg'] = !empty($_GET['ccloseimg'])?trim($_GET['ccloseimg']):"";
		}
		
		if(C::t('#webtctz#webtctz_mobilelists')->insert($dmtz,true)){
			cpmsg('webtctz:addok', 'action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz', 'succeed');
		}else{
			cpmsg('webtctz:error', '', 'error');
		}
	}
	
	echo '<div class="colorbox"><h4>'.plang('maboutforum').'</h4>'.
		 '<table cellspacing="0" cellpadding="3"><tr>'.
	     '<td valign="top">'.plang('description').'</td></tr></table>'.
		 '<div style="width:95%" align="right">'.plang('copyright').'</div></div>';
	
	echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
	
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=add', 'enctype');
	showtableheader(plang('addmtz'), '');
	showsetting(plang('mtztitle'),'mtz[title]','','text','','',plang('mtztitle_msg'));
	showsetting(plang('mtzisopen'),'mtz[isopen]','1','radio','','',plang('mtzisopen_msg'));
	showsetting(plang('mtztargets'), array('mtz[targets]', array(
		array('1', plang('mtztargetscategory')),
		array('2', plang('mtztargetsfids')),
		array('3', plang('mtztargetsgroups')),
		array('4', plang('mtztargetshome')),
		array('5', plang('mtztargetsplugin')),
	)), array('2'), 'mcheckbox');
	showsetting(plang('mtzplugins'),'mtz[plugins]','','text','','',plang('mtzplugins_msg'),'','mtzplugins');
	showsetting(plang('mtzstarttime'),'mtz[starttime]','','calendar','',0,plang('mtzstarttime_msg'),1,'mtzstarttime');
	showsetting(plang('mtzendtime'),'mtz[endtime]','','calendar','',0,plang('mtzendtime_msg'),1,'mtzendtime');

	//--
	$select ='';
	$mtztype = plang('mtztype');
	foreach($mtztype as $k =>$v){
		$select .= '<option value="'.$k.'">'.$v.'</option>';
	}
	showsetting(plang('mtztypetitle'),'mtz[type]','','<select name="mtz[type]">'.$select.'</select>');
	
	//--
	showsetting(plang('mtzisopenborder'),'mtz[isopenborder]','1','radio','','',plang('mtzisopenborder_msg'));
	
	showsetting(plang('mtzisclosetime'),'mtz[isclosetime]','1','radio','','',plang('mtzisclosetime_msg'));
	showsetting(plang('mtzisanimatestart'),'mtz[isanimatestart]','1','radio','','',plang('mtzisanimatestart_msg'));
	showsetting(plang('mtziscloseshow'),'mtz[iscloseshow]','1','radio','','',plang('mtziscloseshow_msg'));
	showsetting(plang('mtzisfloat'),'mtz[isfloat]','1','radio','','',plang('mtzisfloat_msg'));	
	showsetting(plang('mtzisbg'),'mtz[isbg]','1','radio','','',plang('mtzisbg_msg'));
	
	showsetting(plang('mtzcimg'), 'cimg', '', 'filetext','','',plang('mtzcimg_msg'),'','mtzcimg');
	
	
	
	//showsetting(plang('mtzcimg'),'mtz[cimg]','','text','','',plang('mtzcimg_msg'),'','mtzcimg');
	showsetting(plang('mtzctext'),'mtz[ctext]','','textarea','','',plang('mtzctext_msg'),'','mtzctext');
	showsetting(plang('mtzcurl'),'mtz[curl]','','text','','',plang('mtzcurl_msg'),'','mtzcurl');
	showsetting(plang('mtzciframe'),'mtz[ciframe]','','text','','',plang('mtzciframe_msg'),'','mtzciframe');
	showsetting(plang('mtzchtml'),'mtz[chtml]','','textarea','','',plang('mtzchtml_msg'),'','mtzchtml');
	

	
	
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
				($setting['type'] == 'mselect' ? array('mtz['.$settingvar.'][]', $setting['value']) : array('mtz['.$settingvar.']', $setting['value']))
				: 'mtz['.$settingvar.']';
				
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
	
	showsetting(plang('mtzusergroupstitle'), '', '', '<select name="mtz[groupid][]" multiple="multiple" size="10">'.$groupselect.'</select>', '', 0, plang('mtzusergroupscomment'));
	
	showsetting(plang('mtzusers'),'mtz[users]','','text','','',plang('mtzusers_msg'),'','mtzusers');
	showsetting(plang('mtztids'),'mtz[tids]','','text','','',plang('mtztids_msg'),'','mtztids');
	showsetting(plang('mtzaids'),'mtz[aids]','','text','','',plang('mtzaids_msg'),'','mtzaids');
	
	showsetting(plang('mtzheight'),'mtz[height]','80','text','','',plang('mtzheight_msg'),'','mtzheight');
	showsetting(plang('mtzwidth'),'mtz[width]','100','text','','',plang('mtzwidth_msg'),'','mtzwidth');
	showsetting(plang('mtzcount'),'mtz[count]','3','text','','',plang('mtzcount_msg'),'','mtzcount');
	
	//--
	$select ='';
	$mtzposition = plang('mtzposition');
	foreach($mtzposition as $k =>$v){
		$select .= '<option value="'.$k.'">'.$v.'</option>';
	}
	showsetting(plang('mtzpositiontitle'),'mtz[position]','','<select name="mtz[position]">'.$select.'</select>');
	
	//--
	showsetting(plang('mtzpyright'),'mtz[pyright]','0','text','','',plang('mtzpyright_msg'),'','mtzpyright');
	showsetting(plang('mtzpybottom'),'mtz[pybottom]','0','text','','',plang('mtzpybottom_msg'),'','mtzpybottom');
	showsetting(plang('mtztransparency'),'mtz[transparency]','1','text','','',plang('mtztransparency_msg'),'','mtztransparency');
	
	showsetting(plang('mtzclosetime'),'mtz[closetime]','30','text','','',plang('mtzclosetime_msg'),'','mtzclosetime');
	showsetting(plang('mtzinterval'),'mtz[interval]','0','text','','',plang('mtzinterval_msg'),'','mtzinterval');
	
	showsetting(plang('mtzdelay'),'mtz[delay]','0','text','','',plang('mtzdelay_msg'),'','mtzdelay');
	
	showsetting(plang('mtzzindex'),'mtz[zindex]','999','text','','',plang('mtzzindex_msg'));
	
	showsetting(plang('mtzcontentbg'),'mtz[contentbg]','#fff','text','','',plang('mtzcontentbg_msg'));
	
	showsetting(plang('mtzccloseimg'), 'ccloseimg', '', 'filetext','','',plang('mtzccloseimg_msg'),'','mtzccloseimg');
	showsetting(plang('mtzcloseheight'),'mtz[closeheight]','','text','','',plang('mtzcloseheight_msg'),'','mtzcloseheight');
	showsetting(plang('mtzclosewidth'),'mtz[closewidth]','','text','','',plang('mtzclosewidth_msg'),'','mtzclosewidth');
	showsetting(plang('mtzclosepyright'),'mtz[closepyright]','0','text','','',plang('mtzclosepyright_msg'),'','mtzclosepyright');
	showsetting(plang('mtzclosepybottom'),'mtz[closepybottom]','0','text','','',plang('mtzclosepybottom_msg'),'','mtzclosepybottom');
	
	showsubmit('submit', 'submit');
	showtablefooter();
	showformfooter();
	
	
	dexit();
}elseif($act=='delete'){
	$id = dintval($_GET['id']);
	$mtz = C::t('#webtctz#webtctz_mobilelists')->fetch($id);
	if(empty($mtz))
		cpmsg('webtctz:empty', '', 'error');
	if(submitcheck('submit')){
		C::t('#webtctz#webtctz_mobilelists')->delete($id);
		cpmsg('webtctz:delok', 'action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz', 'succeed');
	}
	cpmsg('webtctz:delmtz','action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=delete&id='.$id.'&submit=yes','form',array('title' => $mtz['title']));
}elseif($act=='details'){
	$id = dintval($_GET['id']);
	$mtz = C::t('#webtctz#webtctz_mobilelists')->fetch($id);
	if(empty($mtz))
		cpmsg('webtctz:empty', '', 'error');
	$webtctzclass = new $webtctzclass();
	echo "<strong>".plang("mtztitle").":</strong>".$mtz['title']."<br/>"
		 ."<strong>".plang("mtzisopen").":</strong>".($mtz['isopen']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtzisopenborder").":</strong>".($mtz['isopenborder']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtzisclosetime").":</strong>".($mtz['isclosetime']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtzisanimatestart").":</strong>".($mtz['isanimatestart']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtziscloseshow").":</strong>".($mtz['iscloseshow']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtzisfloat").":</strong>".($mtz['isfloat']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtzisbg").":</strong>".($mtz['mtzisbg']?plang('yes'):plang('no'))."<br/>"
		 ."<strong>".plang("mtzzindex").":</strong>".$mtz['zindex']."<br/>"
		 ."<strong>".plang("mtztargets").":</strong>".$webtctzclass->gettargetsname(json_decode($mtz['targets']))."<br/>"
		 ."<strong>".plang("mtzplugins").":</strong>".implode(",",json_decode($mtz['plugins']))."<br/>"
		 ."<strong>".plang("mtzfidstitle").":</strong>".$webtctzclass->getforumsname(null,json_decode($mtz['fids']),true)."<br/>"
		 ."<strong>".plang("mtzusergroupstitle").":</strong>".$webtctzclass->getusergroupname(null,json_decode($mtz['usergroup']),true)."<br/>"
		 ."<strong>".plang("mtzgroupstitle").":</strong>".$webtctzclass->getgroupsname(null,json_decode($mtz['groups']),true)."<br/>"
		 ."<strong>".plang("mtzcategorytitle").":</strong>".$webtctzclass->getcategoryname(null,json_decode($mtz['category']),true)."<br/>"
		 ."<strong>".plang("mtzusers").":</strong>".implode(",",json_decode($mtz['users']))."<br/>"
		 ."<strong>".plang("mtztids").":</strong>".implode(",",json_decode($mtz['tids']))."<br/>"
		 ."<strong>".plang("mtzaids").":</strong>".implode(",",json_decode($mtz['aids']))."<br/>"
		 ."<strong>".plang("mtztypetitle").":</strong>".$webtctzclass->gettypename($mtz['type'])."<br/>"
		 ."<strong>".plang("mtzcimg").":</strong>".$mtz['cimg']."<br/>"
		 ."<strong>".plang("mtzctext").":</strong>".$mtz['ctext']."<br/>"
		 ."<strong>".plang("mtzcurl").":</strong>".$mtz['curl']."<br/>"
		 ."<strong>".plang("mtzciframe").":</strong>".$mtz['ciframe']."<br/>"
		 ."<strong>".plang("mtzchtml").":</strong>".$mtz['chtml']."<br/>"
		 ."<strong>".plang("mtzheight").":</strong>".$mtz['height']."px<br/>"
		 ."<strong>".plang("mtzwidth").":</strong>".$mtz['width']."px<br/>"
		 ."<strong>".plang("mtzpositiontitle").":</strong>".$webtctzclass->getpositionname($mtz['position'])."<br/>"
		 ."<strong>".plang("mtzpyright").":</strong>".$mtz['pyright']."px<br/>"
		 ."<strong>".plang("mtzpybottom").":</strong>".$mtz['pybottom']."px<br/>"
		 ."<strong>".plang("mtztransparency").":</strong>".$mtz['transparency']."<br/>"
		 ."<strong>".plang("mtzcount").":</strong>".$mtz['count']."<br/>"
		 ."<strong>".plang("mtzclosetime").":</strong>".$mtz['closetime']."<br/>"
		 ."<strong>".plang("mtzinterval").":</strong>".$mtz['interval']."<br/>"
		 ."<strong>".plang("mtzdelay").":</strong>".$mtz['delay']."<br/>"
		 ."<strong>".plang("mtzcontentbg").":</strong>".$mtz['contentbg']."<br/>"
		 ."<strong>".plang("mtzccloseimg").":</strong>".$mtz['ccloseimg']."<br/>"
		 ."<strong>".plang("mtzcloseheight").":</strong>".$mtz['closeheight']."px<br/>"
		 ."<strong>".plang("mtzclosewidth").":</strong>".$mtz['closewidth']."px<br/>"
		 ."<strong>".plang("mtzclosepyright").":</strong>".$mtz['closepyright']."px<br/>"
		 ."<strong>".plang("mtzclosepybottom").":</strong>".$mtz['closepybottom']."px<br/>"
		 ."<strong>".plang("mtzstarttime").":</strong>".dgmdate($mtz['starttime'])."<br/>"
		 ."<strong>".plang("mtzendtime").":</strong>".dgmdate($mtz['endtime'])."<br/>"
		 ."<strong>".plang("mtzdateline").":</strong>".dgmdate($mtz['dateline'])."<br/>";
	dexit();
}elseif($act=='edit'){
	$id = dintval($_GET['id']);
	$mtz = C::t('#webtctz#webtctz_mobilelists')->fetch($id);
	if(empty($mtz))
		cpmsg('webtctz:empty', '', 'error');
	if(submitcheck('submit')){
	$mtz = $_GET['mtz'];
		$dmtz = array('dateline'=>TIMESTAMP);
		$dmtz['title'] = addslashes(trim($mtz['title']));
		$dmtz['isopen'] = addslashes(trim($mtz['isopen']));
		$dmtz['isopenborder'] = addslashes(trim($mtz['isopenborder']));
		$dmtz['isclosetime'] = addslashes(trim($mtz['isclosetime']));
		$dmtz['isanimatestart'] = addslashes(trim($mtz['isanimatestart']));
		$dmtz['iscloseshow'] = addslashes(trim($mtz['iscloseshow']));
		$dmtz['isbg'] = addslashes(trim($mtz['isbg']));
		$dmtz['isfloat'] = addslashes(trim($mtz['isfloat']));
		$dmtz['zindex'] = addslashes(trim($mtz['zindex']));
		$dmtz['contentbg'] = addslashes(trim($mtz['contentbg']));
		$dmtz['targets'] = json_encode($mtz['targets']);
		$dmtz['plugins'] = addslashes(trim($mtz['plugins']));
		$dmtz['starttime'] = addslashes($mtz['starttime']) ? strtotime(addslashes($mtz['starttime'])) : 0;
		$dmtz['endtime'] = addslashes($mtz['endtime']) ? strtotime(addslashes($mtz['endtime'])) : 0;	
		$dmtz['fids'] =  json_encode($mtz['fids']);
		$dmtz['usergroup'] = json_encode($mtz['groupid']);
		$dmtz['groups'] = json_encode($mtz['groups']);
		$dmtz['category'] = json_encode($mtz['category']);
		$dmtz['users'] = addslashes(trim($mtz['users']));
		$dmtz['tids'] = addslashes(trim($mtz['tids']));
		$dmtz['aids'] = addslashes(trim($mtz['aids']));
		$dmtz['type'] = addslashes(trim($mtz['type']));
		//$dmtz['cimg'] = trim($mtz['cimg']);
		$dmtz['ctext'] = addslashes(trim($mtz['ctext']));
		$dmtz['curl'] = addslashes(trim($mtz['curl']));
		$dmtz['ciframe'] = addslashes(trim($mtz['ciframe']));
		$dmtz['chtml'] = stripslashes(trim($mtz['chtml']));
		$dmtz['height'] = addslashes(trim($mtz['height']));
		$dmtz['width'] = addslashes(trim($mtz['width']));
		$dmtz['position'] = addslashes(trim($mtz['position']));
		$dmtz['pyright'] = addslashes(trim($mtz['pyright']));
		$dmtz['pybottom'] = addslashes(trim($mtz['pybottom']));
		$dmtz['transparency'] = addslashes(trim($mtz['transparency']));
		$dmtz['count'] = dintval(addslashes($mtz['count']));
		$dmtz['closetime'] = dintval(addslashes($mtz['closetime']));
		$dmtz['interval'] = dintval(addslashes($mtz['interval']));
		$dmtz['delay'] = dintval(addslashes($mtz['delay']));
		$dmtz['closepyright'] = addslashes(trim($mtz['closepyright']));
		$dmtz['closepybottom'] = addslashes(trim($mtz['closepybottom']));
		$dmtz['closeheight'] = addslashes(trim($mtz['closeheight']));
		$dmtz['closewidth'] = addslashes(trim($mtz['closewidth']));
		
		if($_FILES['cimg']) {
			if(file_exists(libfile('class/upload'))){
				require_once libfile('class/upload');
			}else{
				require_once libfile('discuz/upload', 'class');
			}
			$upload = new discuz_upload();
			if($upload->init($_FILES['cimg'], 'common') && $upload->save(1)) {
				$dmtz['cimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
			}
		} else {
			$dmtz['cimg'] = !empty($_GET['cimg'])?trim($_GET['cimg']):"";
		}
		
		
		if(empty($dmtz['title'])){
			cpmsg('webtctz:mtznotitle', '', 'error');
		}elseif(strlen($dmtz['title']) > 50) {
			cpmsg('webtctz:mtz_title_more', '', 'error');
		}
		
		if(!empty($dmtz['starttime']) && !empty($dmtz['endtime'])) {
			if($dmtz['endtime'] <= TIMESTAMP || $dmtz['endtime'] <= $dmtz['starttime']) {
				cpmsg('webtctz:mtz_endtime_invalid', '', 'error');
			}
		}
		if($mtz['targets'] == NULL || empty($mtz['targets'])){
			cpmsg('webtctz:mtznotargets', '', 'error');
		}
	if($mtz['groupid'] == NULL || empty($mtz['groupid'])){
			if($mtz['users'] == NULL || empty($mtz['users'])){
			   cpmsg('webtctz:mtznogroupid', '', 'error');
			}
		}
		if(in_array('2',$mtz['targets'])){
			if($mtz['fids'] == NULL || empty($mtz['fids'])){
				if($mtz['tids'] == NULL || empty($mtz['tids'])){
				   cpmsg('webtctz:mtznofids', '', 'error');
				}
			}
			/*
			if(count($mtz['fids']) == 1 && in_array('0',$mtz['fids'])){
				cpmsg('webtctz:mtznofids', '', 'error');
			}
			*/
		}
		if(in_array('3',$mtz['targets'])){
			if($mtz['groups'] == NULL || empty($mtz['groups'])){
				if($mtz['tids'] == NULL || empty($mtz['tids'])){
				   cpmsg('webtctz:mtznogroups', '', 'error');
				}
			}
		}
		if(in_array('1',$mtz['targets'])){
			if($mtz['category'] == NULL || empty($mtz['category'])){
				if($mtz['aids'] == NULL || empty($mtz['aids'])){
				   cpmsg('webtctz:mtznocategory', '', 'error');
				}
			}
		}
	    if(in_array('5',$mtz['targets'])){
			if($mtz['plugins'] == NULL || empty($mtz['plugins'])){
				cpmsg('webtctz:mtznoplugins', '', 'error');
			}else{
				$lastplugins = mb_substr($dmtz['plugins'], -1);
				if($lastplugins == ','){
					$dmtz['plugins'] = rtrim($dmtz['plugins'],',');
				}
				$dmtz['plugins'] = explode(",", $dmtz['plugins']);
				$dmtz['plugins'] = json_encode($dmtz['plugins']);
			}
		}
		if($dmtz['type'] == '0' && empty($dmtz['cimg'])){
			cpmsg('webtctz:mtznocimg', '', 'error');
		}
	    if($dmtz['type'] == '1' && empty($dmtz['ctext'])){
			cpmsg('webtctz:mtznoctext', '', 'error');
		}
		if($dmtz['type'] == '2' && empty($dmtz['ciframe'])){
			cpmsg('webtctz:mtznociframe', '', 'error');
		}
		if($dmtz['type'] == '3' && empty($dmtz['chtml'])){
			cpmsg('webtctz:mtznochtml', '', 'error');
		}
		if(!is_numeric($dmtz['pyright'])){
			cpmsg('webtctz:mtznotnum', '', 'error');
		}
	    if(!is_numeric($dmtz['pybottom'])){
			cpmsg('webtctz:mtznotnum', '', 'error');
		}
		if(!is_numeric($dmtz['transparency'])){
			cpmsg('webtctz:mtztransparencynotnum', '', 'error');
		}
		if($dmtz['users'] != NULL && !empty($dmtz['users'])){
			$lastusers = mb_substr($dmtz['users'], -1);
			if($lastusers == ','){
				$dmtz['users'] = rtrim($dmtz['users'],',');
			}
			$dmtz['users'] = explode(",", $dmtz['users']);
			$dmtz['users'] = json_encode($dmtz['users']);
			$dmtz['usergroup'] = json_encode('');
		}
		if($dmtz['tids'] != NULL && !empty($dmtz['tids'])){
			$lasttids = mb_substr($dmtz['tids'], -1);
			if($lasttids == ','){
				$dmtz['tids'] = rtrim($dmtz['tids'],',');
			}
			$dmtz['tids'] = explode(",", $dmtz['tids']);
			$dmtz['tids'] = json_encode($dmtz['tids']);
			$dmtz['fids'] = json_encode('');
			$dmtz['groups'] = json_encode('');
		}
		if($dmtz['aids'] != NULL && !empty($dmtz['aids'])){
			$lastaids = mb_substr($dmtz['aids'], -1);
			if($lastaids == ','){
				$dmtz['aids'] = rtrim($dmtz['aids'],',');
			}
			$dmtz['aids'] = explode(",", $dmtz['aids']);
			$dmtz['aids'] = json_encode($dmtz['aids']);
			$dmtz['category'] = json_encode('');
		}
		
		if($_FILES['ccloseimg']) {
		    if(file_exists(libfile('class/upload'))){
		        require_once libfile('class/upload');
		    }else{
		        require_once libfile('discuz/upload', 'class');
		    }
		    $upload = new discuz_upload();
		    if($upload->init($_FILES['ccloseimg'], 'common') && $upload->save(1)) {
		        $dmtz['ccloseimg'] = (!strstr($_G['setting']['attachurl'], '://') ? $_G['siteurl'] : '').$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
		    }
		} else {
		    $dmtz['ccloseimg'] = !empty($_GET['ccloseimg'])?trim($_GET['ccloseimg']):"";
		}
		
		if(C::t('#webtctz#webtctz_mobilelists')->update($id,$dmtz)){
			cpmsg('webtctz:editok', 'action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz', 'succeed');
		}else{
			cpmsg('webtctz:error', '', 'error');
		}
		
	
	}
	echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
	
	echo '<div class="colorbox"><h4>'.plang('maboutforum').'</h4>'.
			'<table cellspacing="0" cellpadding="3"><tr>'.
			'<td valign="top">'.plang('description').'</td></tr></table>'.
			'<div style="width:95%" align="right">'.plang('copyright').'</div></div>';
	
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=edit', 'enctype');
	echo'<input type="hidden" value="'.$mtz['id'].'" name="id"/>';
	showtableheader(plang('editmtz'), '');
	showsetting(plang('mtztitle'),'mtz[title]',$mtz['title'],'text','','',plang('mtztitle_msg'));
	showsetting(plang('mtzisopen'),'mtz[isopen]',$mtz['isopen'],'radio','','',plang('mtzisopen_msg'));
	showsetting(plang('mtztargets'), array('mtz[targets]', array(
	    array('1', plang('mtztargetscategory')),
		array('2', plang('mtztargetsfids')),
		array('3', plang('mtztargetsgroups')),
		array('4', plang('mtztargetshome')),
		array('5', plang('mtztargetsplugin')),
	)), json_decode($mtz['targets']), 'mcheckbox');
	$mtz['plugins']=implode(",",json_decode($mtz['plugins']));
	showsetting(plang('mtzplugins'),'mtz[plugins]',$mtz['plugins'],'text','','',plang('mtzplugins_msg'),'','mtzplugins');
	showsetting(plang('mtzstarttime'),'mtz[starttime]',dgmdate($mtz['starttime']),'calendar','',0,plang('mtzstarttime_msg'),1,'mtzstarttime');
	showsetting(plang('mtzendtime'),'mtz[endtime]',dgmdate($mtz['endtime']),'calendar','',0,plang('mtzendtime_msg'),1,'mtzendtime');

	//--
	$select ='';
	$mtztype = plang('mtztype');
	foreach($mtztype as $k =>$v){
		$select .= '<option value="'.$k.'" '.($k==$mtz['type']?'selected':'').'>'.$v.'</option>';
	}
	showsetting(plang('mtztypetitle'),'mtz[type]',$mtz['type'],'<select name="mtz[type]">'.$select.'</select>');
	
	//--
	showsetting(plang('mtzisopenborder'),'mtz[isopenborder]',$mtz['isopenborder'],'radio','','',plang('mtzisopenborder_msg'));
	//showsetting(plang('mtzcimg'),'mtz[cimg]',$mtz['cimg'],'text','','',plang('mtzcimg_msg'),'','mtzcimg');
	
	showsetting(plang('mtzisclosetime'),'mtz[isclosetime]',$mtz['isclosetime'],'radio','','',plang('mtzisclosetime_msg'));
	showsetting(plang('mtzisanimatestart'),'mtz[isanimatestart]',$mtz['isanimatestart'],'radio','','',plang('mtzisanimatestart_msg'));
	showsetting(plang('mtziscloseshow'),'mtz[iscloseshow]',$mtz['iscloseshow'],'radio','','',plang('mtziscloseshow_msg'));
	showsetting(plang('mtzisfloat'),'mtz[isfloat]',$mtz['isfloat'],'radio','','',plang('mtzisfloat_msg'));
	showsetting(plang('mtzisbg'),'mtz[isbg]',$mtz['isbg'],'radio','','',plang('mtzisbg_msg'));
	
	showsetting(plang('mtzcimg'), 'cimg', $mtz['cimg'], 'filetext','','',plang('mtzcimg_msg'),'','mtzcimg');
	
	
	showsetting(plang('mtzctext'),'mtz[ctext]',$mtz['ctext'],'textarea','','',plang('mtzctext_msg'),'','mtzctext');
	showsetting(plang('mtzcurl'),'mtz[curl]',$mtz['curl'],'text','','',plang('mtzcurl_msg'),'','mtzcurl');
	showsetting(plang('mtzciframe'),'mtz[ciframe]',$mtz['ciframe'],'text','','',plang('mtzciframe_msg'),'','mtzciframe');
	showsetting(plang('mtzchtml'),'mtz[chtml]',$mtz['chtml'],'textarea','','',plang('mtzchtml_msg'),'','mtzchtml');
	
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
				($setting['type'] == 'mselect' ? array('mtz['.$settingvar.'][]', $setting['value']) : array('mtz['.$settingvar.']', $setting['value']))
				: 'mtz['.$settingvar.']';
				$value = json_decode($mtz[$settingvar]) != '' ? json_decode($mtz[$settingvar]) : $setting['default'];
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
		$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" ".(in_array($group['groupid'], json_decode($mtz['usergroup'])) ? 'selected' : '').">$group[grouptitle]</option>\n";
	}
	$groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
		($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
		($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
		'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';
	
	showsetting(plang('mtzusergroupstitle'), '', '', '<select name="mtz[groupid][]" multiple="multiple" size="10">'.$groupselect.'</select>', '', 0, plang('mtzusergroupscomment'));
	
	$mtz['users']=implode(",",json_decode($mtz['users']));
	showsetting(plang('mtzusers'),'mtz[users]',$mtz['users'],'text','','',plang('mtzusers_msg'),'','mtzusers');
	$mtz['tids']=implode(",",json_decode($mtz['tids']));
	showsetting(plang('mtztids'),'mtz[tids]',$mtz['tids'],'text','','',plang('mtztids_msg'),'','mtztids');
	$mtz['aids']=implode(",",json_decode($mtz['aids']));
	showsetting(plang('mtzaids'),'mtz[aids]',$mtz['aids'],'text','','',plang('mtzaids_msg'),'','mtzaids');
	
	
	showsetting(plang('mtzheight'),'mtz[height]',$mtz['height'],'text','','',plang('mtzheight_msg'),'','mtzheight');
	showsetting(plang('mtzwidth'),'mtz[width]',$mtz['width'],'text','','',plang('mtzwidth_msg'),'','mtzwidth');
	showsetting(plang('mtzcount'),'mtz[count]',$mtz['count'],'text','','',plang('mtzcount_msg'),'','mtzcount');
	
	//--
	$select ='';
	$mtzposition = plang('mtzposition');
	foreach($mtzposition as $k =>$v){
		$select .= '<option value="'.$k.'" '.($k==$mtz['position']?'selected':'').'>'.$v.'</option>';
	}
	showsetting(plang('mtzpositiontitle'),'mtz[position]','','<select name="mtz[position]">'.$select.'</select>');
	
	//--
	showsetting(plang('mtzpyright'),'mtz[pyright]',$mtz['pyright'],'text','','',plang('mtzpyright_msg'),'','mtzpyright');
	showsetting(plang('mtzpybottom'),'mtz[pybottom]',$mtz['pybottom'],'text','','',plang('mtzpybottom_msg'),'','mtzpybottom');
	showsetting(plang('mtztransparency'),'mtz[transparency]',$mtz['transparency'],'text','','',plang('mtztransparency_msg'),'','mtztransparency');
	
	
	showsetting(plang('mtzclosetime'),'mtz[closetime]',$mtz['closetime'],'text','','',plang('mtzclosetime_msg'),'','mtzclosetime');
	showsetting(plang('mtzinterval'),'mtz[interval]',$mtz['interval'],'text','','',plang('mtzinterval_msg'),'','mtzinterval');
	showsetting(plang('mtzdelay'),'mtz[delay]',$mtz['delay'],'text','','',plang('mtzdelay_msg'),'','mtzdelay');
	
	showsetting(plang('mtzzindex'),'mtz[zindex]',$mtz['zindex'],'text','','',plang('mtzzindex_msg'));
	
	showsetting(plang('mtzcontentbg'),'mtz[contentbg]',$mtz['contentbg'],'text','','',plang('mtzcontentbg_msg'));
	
	showsetting(plang('mtzccloseimg'), 'ccloseimg', $mtz['ccloseimg'], 'filetext','','',plang('mtzccloseimg_msg'),'','mtzccloseimg');
	showsetting(plang('mtzcloseheight'),'mtz[closeheight]',$mtz['closeheight'],'text','','',plang('mtzcloseheight_msg'),'','mtzcloseheight');
	showsetting(plang('mtzclosewidth'),'mtz[closewidth]',$mtz['closewidth'],'text','','',plang('mtzclosewidth_msg'),'','mtzclosewidth');
	showsetting(plang('mtzclosepyright'),'mtz[closepyright]',$mtz['closepyright'],'text','','',plang('mtzclosepyright_msg'),'','mtzclosepyright');
	showsetting(plang('mtzclosepybottom'),'mtz[closepybottom]',$mtz['closepybottom'],'text','','',plang('mtzclosepybottom_msg'),'','mtzclosepybottom');
	
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

$allmtzs = C::t('#webtctz#webtctz_mobilelists')->range($start,$pagesize,'DESC');
$count = C::t('#webtctz#webtctz_mobilelists')->count();
showtableheader(plang('mtzlist').'(  <a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=add" style="color:red;">'.plang('add').'</a>  )', '');
showsubtitle(plang('mtzlisttitle'));
$webtctzclass = new $webtctzclass();
foreach($allmtzs as $d){
	showtablerow('', array('width="80"'), array(
	$d['id'],
	'<span title="'.$d['title'].'">'.mb_substr($d['title'],0,20).'</span>',
	$d['isopen']?plang('yes'):plang('no'),
	'<span title="'.$webtctzclass->gettargetsname(json_decode($d['targets'])).'">'.mb_substr($webtctzclass->gettargetsname(json_decode($d['targets'])),0,20).'...</span>',
	'<span title="'.$webtctzclass->getforumsname(null,json_decode($d['fids']),true).'">'.mb_substr($webtctzclass->getforumsname(null,json_decode($d['fids']),true),0,20).'...</span>',
	'<span title="'.$webtctzclass->getusergroupname(null,json_decode($d['usergroup']),true).'">'.mb_substr($webtctzclass->getusergroupname(null,json_decode($d['usergroup']),true),0,20).'...</span>',
	$webtctzclass->gettypename($d['type']),
	dgmdate($d['dateline']),
	'<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=details&id='.$d['id'].'">'.plang('details').'</a>&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=edit&id='.$d['id'].'">'.plang('edit').'</a>&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz&act=delete&id='.$d['id'].'">'.plang('delete').'</a>')
	);
}
$mpurl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=webtctz&pmod=allmtz';
$multipage = multi($count, $pagesize, $page, $mpurl);
showsubmit('', '', '', '', $multipage);
showtablefooter();

function plang($str) {
	return lang('plugin/webtctz', $str);
}
//From:www_FX8_co
?>