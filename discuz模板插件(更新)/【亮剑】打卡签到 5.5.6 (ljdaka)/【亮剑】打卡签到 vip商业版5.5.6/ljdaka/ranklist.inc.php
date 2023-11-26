<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : 魔趣吧：www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : 魔趣吧(QQ：10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              魔趣吧出品 必属精品。
 *              魔趣吧源码论坛 全网首发 http://www.moqu8.com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
if(file_exists($settingfile)){
	include $settingfile;
}

require_once DISCUZ_ROOT.'source/plugin/ljdaka/class/qrcode.class.php';
if (!file_exists("source/plugin/ljdaka/images/ljdaka_qrcode.jpg")) {
	$file = 'ljdaka_qrcode.jpg';	 QRcode::png($_G['siteurl'].'plugin.php?id=ljdaka:ranklist', 'source/plugin/ljdaka/images/'.$file, QR_MODE_STRUCTURE, 8);
}
$navtitle = lang('plugin/ljdaka', 'daka1');
$metakeywords = lang('plugin/ljdaka', 'daka1');
$metadescription = lang('plugin/ljdaka', 'daka1');
$uid = $_G['uid'];
$config = $_G['cache']['plugin']['ljdaka'];
$gg = $config['gg'];
$gg = str_replace('{zong}', C::t('#ljdaka#plugin_daka_user')->count(), $gg);
$gg = str_replace('{jin}', C::t('#ljdaka#plugin_daka_user')->count_by_timestamp(), $gg);
$tips = $config['tips'];
$banquan = $config['banquan'];
$timestamp = $_G['timestamp'];
$jljifen = $config['jljifen'];
$zhouqi = $config['zhouqi'];
$beishu = $config['beishu'];
$mytime = $timestamp;
$mytime = date('Y-m-d', $mytime);

$day = date('d');
$mon = date('m');
$year = date('Y');
$today = date('N');
$start = date('Y-m-d', mktime(0, 0, 0, $mon, $day - $today + 1, $year));
$end = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon, $day - $today + 7, $year));
$tomon_s = date('Y-m-d H:i:s', mktime(0, 0, 0, $mon, 1, $year));
$tomon_e = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon + 1, 0, $year));
$s_tomon_s = date('Y-m-d H:i:s', mktime(0, 0, 0, $mon-1, 1, $year));
$x_tomon_e = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon , 0, $year));
if ($wcache['x4'] && $wcache['cleartime'] != date('Ymd')) {
	$time = date('Y-m-d H:i:s', mktime(0, 0, 0, $mon-$wcache['jiankong'], 1, $year));
	$sql="delete from ".DB::table("plugin_daka")." where timestamp<'".strtotime($time)."'";
	DB::query($sql);
	$wcache['cleartime'] = gmdate('Ymd',TIMESTAMP+8*3600);
	require_once libfile('function/cache');
	writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache))); //将管理中心配置项写入缓存
} 
if ($_GET['mod'] == 'all') {
    $currpage = intval($_GET['page']) ? intval($_GET['page']) : 1;
    $perpage = 25;
    $curnum = ($currpage - 1) * $perpage;
    $num = C::t('#ljdaka#plugin_daka_user')->count();
    $query_all = C::t('#ljdaka#plugin_daka_user')->fetch_all_by_allday($curnum, $perpage);

    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=ljdaka:ranklist&mod=all', 0, 10, false, false);
} else if ($_GET['mod'] == 'z') {
    $currpage = intval($_GET['page']) ? intval($_GET['page']) : 1;
    $perpage = 25;
    $curnum = ($currpage - 1) * $perpage;
    $num = DB :: result_first("select count(*) from " . DB :: table('plugin_daka_user_z') . " where  timestamp>='" . strtotime($start) . "' and timestamp<='" . strtotime($end) . "'");
    $query_z = DB :: fetch_all("select * from " . DB :: table('plugin_daka_user_z'). " where  timestamp>='" . strtotime($start) . "' and timestamp<='" . strtotime($end) . "' order by zhouday desc,zhoumoney desc limit $curnum,$perpage");
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=ljdaka:ranklist&mod=z', 0, 10, false, false);
} else if ($_GET['mod'] == 'y') {
    $currpage = intval($_GET['page']) ? intval($_GET['page']) : 1;
    $perpage = 25;
    $curnum = ($currpage - 1) * $perpage;
    $num = DB :: result_first("select count(*) from " . DB :: table('plugin_daka_user_y'). " where  timestamp>='" . strtotime($tomon_s) . "' and timestamp<='" . strtotime($tomon_e)."'");
    $query_y = DB :: fetch_all("select * from " . DB :: table('plugin_daka_user_y'). " where  timestamp>='" . strtotime($tomon_s) . "' and timestamp<='" . strtotime($tomon_e)."' order by yueday desc,yuemoney desc limit $curnum,$perpage");
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=ljdaka:ranklist&mod=y', 0, 10, false, false);
} else if ($_GET['mod'] == 's_y') {
    $currpage = intval($_GET['page']) ? intval($_GET['page']) : 1;
    $perpage = 25;
    $curnum = ($currpage - 1) * $perpage;
    $num = DB :: fetch_all("select uid,count(uid) x,sum(jinbi) v from " . DB :: table('plugin_daka') . " where  timestamp>='" . strtotime($s_tomon_s) . "' and timestamp<='" . strtotime($x_tomon_e) . "' group by uid ");
    $num = count($num);
    //debug($num);
    $query_s_y = DB :: fetch_all("select uid,count(uid) x,sum(jinbi) v from " . DB :: table('plugin_daka') . " where  timestamp>='" . strtotime($s_tomon_s) . "' and timestamp<='" . strtotime($x_tomon_e) . "' group by uid order by count(uid) desc,v desc limit $curnum,$perpage");
	
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=ljdaka:ranklist&mod=s_y', 0, 10, false, false);
}else if ($_GET['mod'] == 'cs') {
    $currpage = intval($_GET['page']) ? intval($_GET['page']) : 1;
    $perpage = 50;
    $curnum = ($currpage - 1) * $perpage;
    $num = DB :: fetch_all("select * from " . DB :: table('plugin_daka') . " where timestamp >='".strtotime(date('Y-m-d 00:00:00'))."' order by timestamp desc");
    $query_cs = DB :: fetch_all("select * from " . DB :: table('plugin_daka') . " where timestamp >='".strtotime(date('Y-m-d 00:00:00'))."' order by timestamp desc limit $curnum,$perpage");
	
    //$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=ljdaka:ranklist&mod=cs', 0, 10, false, false);
} else {
    $currpage = intval($_GET['page']) ? intval($_GET['page']) : 1;
    $perpage = $config['pnum'];
    $curnum = ($currpage - 1) * $perpage;
    $num = DB :: result_first("select count(*) from " . DB :: table('plugin_daka_user') . " where timestamp>=".strtotime(date('Y-m-d 00:00:00')));
    $query_all = C::t('#ljdaka#plugin_daka_user')->fetch_all_by_uid('where timestamp>='.strtotime(date('Y-m-d 00:00:00')).' order by timestamp asc', $curnum, $perpage);
	//debug($query);
    $paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=ljdaka:ranklist', 0, 10, false, false);
}
//$query_br = DB::result_first('select orderNo from (select (@rowNum:=@rowNum+1) orderNo , uid,allday from '.DB::table('plugin_daka').',(Select (@rowNum :=0) ) b
 //order by allday desc)t where t.uid='.$uid);
//debug($query_br);
/*$ranklist_br = array();
$i = 1;
foreach ($query_br as $k => $rank_br) {
    $ranklist_br[$rank_br[uid]]['rank_br'] = $i;
    $ranklist_br[$rank_br[uid]]['alldays'] = $rank_br['allday'];
    $ranklist_br[$rank_br[uid]]['jljifen1'] = $rank_br['money'];
    $creditname = $_G['setting']['extcredits'][$config['leixing']]['title'];
    $ranklist_br[$rank_br[uid]]['jljifen2'] = $rank_br['fen'];
    $ranklist_br[$rank_br[uid]]['money'] = $rank_br['money'];
    $ranklist_br[$rank_br[uid]]['day'] = $rank_br['day'];
    $i++;
}*/
$allday_uid = DB::result_first('select allday from %t where uid=%d',array('plugin_daka_user',$uid)); 
$ph_uid=DB::result_first('select count(*) from %t where allday > %d',array('plugin_daka_user',$allday_uid));
//debug($ph_uid);
$leixing = 'extcredits' . $config['leixing'];
$check = C::t('#ljdaka#plugin_daka')->fetch_by_uid($uid);

$nc = array(0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine');
$rarr = str_split($ph_uid+1);

$userdata = C::t('#ljdaka#plugin_daka_user')->fetch_by_uid1($_G['uid']);
$count = C::t('#ljdaka#plugin_daka_user')->count_by_timestamp();
$ms=C::t('#ljdaka#plugin_daka_user')->count();
$first = C::t('#ljdaka#plugin_daka_user')->fetch_by_first();
$first = getuserbyuid($first['uid']);
$firstname = $first['username'];
if ($config['new']) {
    $_G['setting']['switchwidthauto'] = 0;
    $_G['setting']['allowwidthauto'] = 1;
    include template('ljdaka:index');
} else {
    include template('ljdaka:ranklist');
}
?>