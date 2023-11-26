<?php

/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'/source/plugin/xiaomy_buyvipgroup/field.cfg.php';

$cp= daddslashes($_GET['op']);

loadcache("usergroups");
loadcache("plugin");


$xmlcfg = $_G['cache']['plugin']['xiaomy_buyvipgroup'];

if($cp=='review'){
	
	if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
		cpmsg('error');
	}
	$rtype = intval($_GET['type']);
	$reviewid = intval($_GET['reviewid']);
	$idinfo  = C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->fetch_by_id($reviewid);
	if(!$idinfo || $idinfo['status']!=1){
		cpmsg('error');
	}
	if($rtype == 1){
		$status = array(
			'status'=>2,
			'vdateline'=>$_G['timestamp'],
		);
		C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->update(array('id'=>$reviewid),$status);
		$str=lang('plugin/xiaomy_buyvipgroup', 'astr114');
		
		//设置用户组
		$member=C::t('common_member')->fetch($idinfo['uid'], false, 1);
		
		if(count($member)==0){
			$isinarchive = '_inarchive';
		}else{
			$isinarchive = '';
		}
		
		if($idinfo['cyclecount'] == 0){
			C::t('common_member'.$isinarchive)->update($idinfo['uid'], array('groupid'=>$idinfo['groupid']));
		}elseif (is_numeric($idinfo['cyclecount']) && $idinfo['cyclecount']>0) {
			$validity = $idinfo['cyclecount']*30;
			$groupexpiryTime = TIMESTAMP +	$validity*86400;
			if($idinfo['groupid'] == $member['groupid']){
				$groupexpiryTime = $member['groupexpiry'] + $validity*86400;
			}
			C::t('common_member'.$isinarchive)->update($idinfo['uid'], array('groupid'=>$idinfo['groupid'],'groupexpiry'=>$groupexpiryTime));
			$groupterms['main'] = array('time' => $groupexpiryTime,'groupid' => $xmlcfg['expiredgroup']);
			$groupterms['ext'][$idinfo['groupid']] = $groupexpiryTime;
			C::t('common_member_field_forum'.$isinarchive)->update($idinfo['uid'],array('groupterms' => serialize($groupterms)));
		}
		C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->update(array('id'=>$reviewid),$status);
	}else{
		$status = array(
			'status'=>3,
			'vdateline'=>$_G['timestamp'],
		);
		$str=lang('plugin/xiaomy_buyvipgroup', 'astr115');
		C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->update(array('id'=>$reviewid),$status);
	}
	//发送通知
	notification_add($idinfo['uid'], 'system', $str, $notevars = array(), $system = 0);
}

if($cp=='delete'){

	if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
		cpmsg('error');
	}
	$did = daddslashes($_GET['did']);
	C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->delete_by_id($did);
}

$cur_page=intval(getgpc('page'));
if($cur_page<1){
	$cur_page=1;
}
$curUrl=ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=xiaomy_buyvipgroup&pmod=admincp";
showtips(lang('plugin/xiaomy_buyvipgroup', 'tips'));
showtableheader(lang('plugin/xiaomy_buyvipgroup', 'kminfo'));

showtablerow("",'',array(
			lang('plugin/xiaomy_buyvipgroup', 'astr001'),
			lang('plugin/xiaomy_buyvipgroup', 'astr01'),
					lang('plugin/xiaomy_buyvipgroup', 'astr0002'),
			lang('plugin/xiaomy_buyvipgroup', 'astr02'),
	
			lang('plugin/xiaomy_buyvipgroup', 'astr03'),
			lang('plugin/xiaomy_buyvipgroup', 'astr04'),
			lang('plugin/xiaomy_buyvipgroup', 'astr05'),
			lang('plugin/xiaomy_buyvipgroup', 'astr06'),
			lang('plugin/xiaomy_buyvipgroup', 'astr07'),
			lang('plugin/xiaomy_buyvipgroup', 'astr08'),
			lang('plugin/xiaomy_buyvipgroup', 'astr09'),
));


	$showNum=15;
	$alldata = 	C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->fetch_page_data(($cur_page-1)*$showNum,$showNum);
	$count=C::t('#xiaomy_buyvipgroup#xiaomy_buyvipgroup')->count();
	
	foreach($alldata as $value){
			$value['dateline']  = dgmdate($value['dateline']);
			
			if($value['vdateline'] ){
				$value['vdateline']  = dgmdate($value['vdateline']);
			}else {
				$value['vdateline']  ='--';
			}
			if($value['status'] == 1){
				$cpstr =  "<a href='".ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=xiaomy_buyvipgroup&pmod=admincp&op=review&type=1&reviewid=".$value['id'] ."&formhash=".formhash()."'>".lang('plugin/xiaomy_buyvipgroup', 'astr11')."</a> | ";
				$cpstr .= "<a href='".ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=xiaomy_buyvipgroup&pmod=admincp&op=review&type=2&reviewid=".$value['id'] ."&formhash=".formhash()."'>".lang('plugin/xiaomy_buyvipgroup', 'astr13')."</a> | ";
			}
			$cpstr .= "<a href='".ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=xiaomy_buyvipgroup&pmod=admincp&op=delete&did=".$value['id'] ."&formhash=".formhash()."'>".lang('plugin/xiaomy_buyvipgroup', 'astr12')."</a>";
			$value['typecount'] = $value['icount'] ."  ".$_G['setting']['extcredits'][$value['itype'] ]['title'];
			if(!$value['cyclecount']){
				$value['cyclecount'] =lang('plugin/xiaomy_buyvipgroup', 'shstr2');
			}else{
				$value['cyclecount'] =$value['cyclecount'].lang('plugin/xiaomy_buyvipgroup', 'htmlstr02');
			}
			showtablerow("",'',array(
				$value['username'],
				$_G['cache']['usergroups'][$value['groupid']]['grouptitle'],
				$value['cyclecount'],
				$value['payrmb'],
				$value['payaccount'],
				$value['tnumber'],
				$value['payment'],
				$paystatus[$value['status']],
				$value['dateline'] ,
				$value['vdateline'],
				$cpstr
			));
			$cpstr ="";
	}
		$pagenav=multi($count, $showNum, $cur_page, $curUrl);
		echo $pagenav;
		showtablefooter();
?>