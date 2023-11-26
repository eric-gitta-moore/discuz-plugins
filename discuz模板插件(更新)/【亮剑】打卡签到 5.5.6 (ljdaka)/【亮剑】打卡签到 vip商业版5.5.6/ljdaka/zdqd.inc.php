<?php
/*
 * 作者：亮剑
 * 联系QQ:578933760
 * 自动签到
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
$config = $_G['cache']['plugin']['ljdaka'];
$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
if(file_exists($settingfile)){
	include $settingfile;
}
$zd_time = $wcache['zd_time'];

if ($_G['timestamp'] < ($zd_time + $config['zd_time']) ){
	exit;
}
$wcache['zd_time'] = $_G['timestamp'];
require_once libfile('function/cache');
writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache))); //将管理中心配置项写入缓存
require_once 'source/plugin/ljdaka/function/function_core.php';

$r1 = explode("\n", str_replace("\r", "", $config['bq']));
foreach ($r1 as $k => $v) {
	$tmp = explode('|', $v);
	$ra1[$tmp[0]]['id'] = $tmp[0];
	$ra1[$tmp[0]]['name'] = $tmp[1];
	$ra1[$tmp[0]]['desc'] = $tmp[2];
	$ra1[$tmp[0]]['img'] = $tmp[3];
}
$con=array_rand($ra1,1);
if(!$config['zd_groups']){
	exit;
}
$zd_groups=unserialize($config['zd_groups']);


if(count($zd_groups)<2){
	$gid=0;
}else{
	$gid=array_rand($zd_groups,1);
}
if(!$zd_groups[$gid]){
	exit;
}
$gnum = DB::result_first ( ' select count(*) from ' . DB::table ( 'common_member' ) . " where groupid= ".$zd_groups[$gid] );

if(!$gnum){
	exit;
}
if($gnum<2){
	$randnum=0;
}else{
	$randnum=rand(0, $gnum);
}
$uids = DB::fetch_first ( ' select uid,username from ' . DB::table ( 'common_member' ) . " where groupid= ".$zd_groups[$gid]." limit $randnum,1" );
$uid=$uids['uid'];
$username=$uids['username'];
if(!$uid){
	exit;
}

$check = C :: t('#ljdaka#plugin_daka')->fetch_by_uid($uid);
if (!$check) {
	$timestamp = $_G['timestamp'];
	$jljifen = $config['jljifen'];
	$zhouqi = $config['zhouqi'];
	$beishu = $config['beishu'];
	$mytime = $timestamp - 86400;
	$mytime = gmdate('Y-m-d', $mytime + 3600 * 8);
	$alldays = C :: t('#ljdaka#plugin_daka')->fetch_by_uid_yesterday($uid, $mytime);
	$countday = intval($alldays + 1);
	if (!$alldays || ($alldays >= $zhouqi && $zhouqi)) {
		$alldays = 0;
	}
	$jljifen1 = ($alldays + 1) * $beishu + rand($config['sjljifen'],$jljifen);
	if($jljifen1>$config['bigmoney']&&$config['bigmoney']){
		$jljifen1=$config['bigmoney'];
	}
	$money = intval($jljifen1);
	$creditname = $_G['setting']['extcredits'][$config['leixing']]['title'];
	$jljifen2 = $jljifen1 . $creditname;
	
	$leixing = 'extcredits' . $config['leixing'];
	
	updatemembercount($uid, array($leixing => $jljifen1));
	$myall = $alldays + 1;
	$mall = ($myall + 1) * $beishu + $jljifen;
	$small = ($myall + 1) * $beishu + $config['sjljifen'];
	if($mall>$config['bigmoney']&&$config['bigmoney']){
		$mall=$config['bigmoney'];
		$biglang=lang('plugin/ljdaka', 'daka46');
	}
	$mall .= $creditname;
	$record = array('uid' => $uid, 'timestamp' => $timestamp, 'jinbi' => $jljifen1, 'alldays' => $myall);
	$check = C :: t('#ljdaka#plugin_daka')->fetch_by_uid($uid);
	if($check){
		showmessage(lang('plugin/ljdaka', 'daka3'));
	}
	DB :: insert('plugin_daka', $record);
	if (!C :: t('#ljdaka#plugin_daka_user')->fetch_by_uid($uid)) {
		DB :: insert('plugin_daka_user', array('uid' => $uid,
			'username' => $username,
			'timestamp' => $_G['timestamp'],
			'money' => $money,
			'allday' => $countday,
			'day' => $myall,
			'fen' => $mall,
				), true);
	} else {
		C :: t('#ljdaka#plugin_daka_user')->update_by_uid($uid, $money, $myall, $mall, $_G['timestamp']);
	}
	$message = lang('plugin/ljdaka', 'daka19');
	if ($_GET['mobile'] == 1 || $_GET['mobile'] == 2 || $_GET['mobile'] == 'yes') {
		$message = str_replace('{con1}', lang('plugin/ljdaka', 'daka44'), $message);
		$message = str_replace('{con3}', lang('plugin/ljdaka', 'daka45'), $message);
	} else {
		$message = str_replace('{con1}', $ra1[$con]['name'], $message);
		$message = str_replace('{con3}', $ra1[$con]['desc'], $message);
	}
	if($config['is_thread']){
		if (!C :: t('#ljdaka#plugin_daka_thread')->fetch_by_dateline()) {
			$fid = $config['fid'];
			if (!$fid) {
				showmessage(lang('plugin/ljdaka', 'daka22'));
			}
			$subject = date(lang('plugin/ljdaka', 'time'));
			if ($fid) {
				$desc = lang('plugin/ljdaka', 'daka20');
				$message = str_replace('{desc}', $desc, $message);
				$tid = generatethread($subject, $message, $_G['clientip'], $uid, '', $fid);
				$daytime = gmdate('Ymd',TIMESTAMP+8*3600);
				DB :: insert('plugin_daka_thread', array('tid' => $tid, 'dateline' => $daytime));
				$rid = 1;
			}
		} else {
			$subject = date(lang('plugin/ljdaka', 'time'));
			$desc = lang('plugin/ljdaka', 'daka6') . "$myall" . lang('plugin/ljdaka', 'daka7') . lang('plugin/ljdaka', 'daka10') . $jljifen2 . ',' . lang('plugin/ljdaka', 'daka8') . $mall;
			$message = str_replace('{desc}', $desc, $message);
			$tid = C :: t('#ljdaka#plugin_daka_thread')->fetch_tid_by_dateline();
			if ($tid) {
				generatepost($message, $uid, $tid, '', '', $subject,$_G['clientip']);
				$rid = 1;
			}
		}
	}
}
?>