<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
$config = $_G['cache']['plugin']['jneggv2'];
$navtitle = lang('plugin/jneggv2','MJXD');
$metakeywords = lang('plugin/jneggv2','MJXD');
$metadescription = lang('plugin/jneggv2','metaMJXD');
$g_adminids=explode('|',$config['jn_adminids']);//管理员权限
$g_onoff = $config['jn_onoff']; //开关
$g_buyext = 'extcredits'.$config['jn_buyext']; //购买母鸡积分
$g_costbuy = $config['jn_costbuy']; //母鸡价格
$g_costbuyext = $_G['setting']['extcredits'][$config[jn_buyext]]['title']; //
$g_egg = $config['jn_egg']; //下蛋，日
$g_eggexttitle = $_G['setting']['extcredits'][$config[jn_eggext]]['title']; //
$g_usergroup = unserialize($config['jn_usergroup']); //可进入用户组
$g_luck = $config['jn_luck']; //运气开关
$g_goldegg = $config['jn_goldegg']; //普通成功率
$g_vip = unserialize($config['jn_vip']); //vip用户组
$g_mtrand = explode(',',$config['jn_mtrand']);//金蛋获得数量
$g_vipgoldegg = $config['jn_vipgoldegg']; //vip金蛋获得成功率
$g_chicext = $_G['setting']['extcredits'][$config[jn_chic]]['title']; 
$g_eggextratio = $config['jn_ratio']; //金钱换鸡蛋兑换率
$g_bonus = $config['jn_bonus']; //收成多少粒蛋增加产量?
$g_bonusmax = $config['jn_bonusmax']; //最多可增加多少?
$g_goldeggprice = $config['jn_goldeggprice']; //金蛋兑出价值
$g_goldeggmin = $config['jn_goldeggmin']; //最低金蛋兑出数
$g_eggmin = $config['jn_eggmin']; //最低鸡蛋兑出数
$g_maxget = $config['jn_maxget']; //单日可领取最高次数
//$g_eggout = $config['jn_eggout']; //单日可领取最高次数
$g_chicdie = $config['jn_chicdie']; //鸡只死亡开关
$g_chictime = $config['jn_chictime']; //死亡周期
$g_zhouqi = $config['jn_zhouqi']; //生产周期，分钟
$g_eggcredit = 'extcredits'.$config['jn_eggcredit']; //鸡蛋兑出积分
$g_goldcredit = 'extcredits'.$config['jn_goldcredit']; //金蛋兑出积分
$g_eggcreditext = $_G['setting']['extcredits'][$config[jn_eggcredit]]['title']; //鸡蛋兑出积分名
$g_goldcreditext = $_G['setting']['extcredits'][$config[jn_goldcredit]]['title']; //金蛋兑出积分名
$g_bonusof = $config['jn_bonusof']; //昨日生产加成开关

if (!in_array($_G['uid'],$g_adminids)){
	showmessage('jneggv2:jnegg39');
}
$userid = dintval($_GET['userid']);

if(submitcheck('editusersubmit')){
	if($_GET['formhash'] == $_G['formhash']){
		if(!$userid){
			showmessage('jneggv2:jnegg40');
		}
		$chicken = dintval($_GET['chicken']);
		$jidan = dintval($_GET['jidan']);
		$luck = dintval($_GET['luck']);
		DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET chicken = '".daddslashes($chicken)."', jidan = '".daddslashes($jidan)."', luck = '".daddslashes($luck)."' WHERE uid = '$userid'");
		showmessage('jneggv2:jnegg41','plugin.php?id=jneggv2:admincp',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if(submitcheck('deletebigsubmit')){
	$howmanydayago = dintval($_GET['time']);
	if(!$howmanydayago){
		showmessage('jneggv2:jnegg42');
	}
	$totimetamp = strtotime(date("Y-m-d",($_G['timestamp'])));
	$deletetime = $totimetamp - ($howmanydayago * 86400);
	if($_GET['formhash'] == $_G['formhash']){
		$nlog = mysql_num_rows(DB::query("SELECT* FROM ".DB::table('game_jneggv2_log')." WHERE timestamp < '".daddslashes($deletetime)."'"));
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_log')." WHERE timestamp < '".daddslashes($deletetime)."'");
		showmessage('jneggv2:jnegg43','plugin.php?id=jneggv2:admincp&do=viewlog',array('nlog'=>$nlog),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if(submitcheck('searchuserlog1submit')){
	$userid = dintval($_GET['userid']);
	if(!$userid){
		showmessage('jneggv2:jnegg40');
	}
	if($_GET['formhash'] == $_G['formhash']){
		$nUSER = mysql_num_rows(DB::query("SELECT * FROM ".DB::table('game_jneggv2_log')." WHERE uid = '".$userid."'"));
		if($nUSER > '0'){
			showmessage('jneggv2:jnegg49','plugin.php?id=jneggv2:admincp&do=searchuserlog&userid='.$userid,array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
		}else{
			showmessage('jneggv2:jnegg50');
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if(submitcheck('editchicsubmit')){
	$userid = dintval($_GET['userid']);
	$chickid = dintval($_GET['chickid']);
	$buytime = dintval(strtotime($_GET['buytime']));
	$chickenqty = dintval($_GET['chickenqty']);
	if(!$userid){
		showmessage('jneggv2:jnegg40');
	}
	if(!$chickid || !$buytime || !$chickenqty){
		showmessage('jneggv2:jnegg38');
	}
	if($_GET['formhash'] == $_G['formhash']){
		$nUSER = mysql_num_rows(DB::query("SELECT * FROM ".DB::table('game_jneggv2_chicken')." WHERE id = '".$chickid."' AND uid = '".$userid."'"));
		if($nUSER == '1'){
			DB::query("UPDATE ".DB::table('game_jneggv2_chicken')." SET chickenqty = '".daddslashes($chickenqty)."', buytime = '".daddslashes($buytime)."' WHERE id = '".$chickid."' AND uid = '".$userid."'");
			showmessage('jneggv2:jnegg41','plugin.php?id=jneggv2:admincp',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
		}else{
			showmessage('jneggv2:jnegg38');
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if(($_GET['do'] == 'user') && ($userid > '0')){
	$qUSER = DB::query("SELECT t1.*, t2.username FROM ".DB::table('game_jneggv2_user')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON t1.uid=t2.uid WHERE t1.uid = '$userid'");
	while($rUSER = DB::fetch($qUSER)) {
		$qchic = DB::query("SELECT sum(chickenqty) AS chick FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$userid' AND status = '1'");
		while($rchic = DB::fetch($qchic)) {
			$rUSER['chicken'] = $rchic['chick'];
		}
		$rUSER['jointime'] = date("Y-m-d H:i",($rUSER['jointime']));
		$userinfo[] = $rUSER;
	}
	include template('jneggv2:admincp');
	exit;
}
if(($_GET['do'] == 'checkchic') && ($userid > '0')){
	$page = $_G['page'];
	$tpp = 10;
	$total = DB::result_first("SELECT count(*) cnt FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$userid'");
	if(@ceil($total/$tpp) < $page) 	$page = 1;
	$start_limit = ($page - 1) * $tpp;
	
	$qchic = DB::query("SELECT * FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$userid' ORDER BY id DESC limit {$start_limit},{$tpp}");
	while($rchic = DB::fetch($qchic)){
		$rchic['dietime'] = date("Y-m-d H:i",($rchic['buytime'] + ($g_chictime * 60)));
		$rchic['buytime'] = date("Y-m-d H:i",($rchic['buytime']));
		$chiclist[] = $rchic;
	}
	array_multisort($tid, SORT_ASC, $rchic);
	$multipage = multi($total, $tpp, $page, "plugin.php?id=jneggv2:admincp&do=checkchic&userid=".$userid, $_G['setting']['threadmaxpages']);
	
	include template('jneggv2:admincp_pop');
	exit;
}
if(($_GET['do'] == 'editchic') && ($userid > '0')){
	$chickid = dintval($_GET['chickid']);
	$qchic = DB::query("SELECT t1.*,t2.username FROM ".DB::table('game_jneggv2_chicken')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON (t1.uid = t2.uid) WHERE t1.id = '$chickid' AND t1.uid = '$userid'");
	$nchic = mysql_num_rows($qchic);
	if($nchic == '1'){
		while($rchic = DB::fetch($qchic)){
			$rchic['dietime'] = date("Y-m-d H:i",($rchic['buytime'] + ($g_chictime * 60)));
			$rchic['buytime'] = date("Y-m-d H:i",($rchic['buytime']));
			$chiclist[] = $rchic;
		}
		include template('jneggv2:admincp_pop');
		exit;
	}else{
		showmessage('jneggv2:jnegg38');
	}
}
if(($_GET['do'] == 'searchuserlog') && ($userid > '0')){
	$qUSER = DB::query("SELECT t1.*, t2.username FROM ".DB::table('game_jneggv2_log')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON (t1.uid=t2.uid) WHERE t1.uid = '$userid' ORDER BY t1.timestamp DESC");
	while($rUSER = DB::fetch($qUSER)) {
		$userid = $rUSER['uid'];
		$username = $rUSER['username'];
		if($rUSER['acdo'] == '1'){
			$rUSER['desc'] = "".lang('plugin/jneggv2','jnegg6')." <font color='red'>".number_format($rUSER['cost']).$g_costbuyext."</font> ".lang('plugin/jneggv2','jnegg7')." <font color='blue'>".number_format($rUSER['qty'])."</font> ".lang('plugin/jneggv2','jnegg8')."";
		}
		if($rUSER['acdo'] == '2'){
			$rUSER['desc'] = "".lang('plugin/jneggv2','jnegg9')." <font color='red'>".number_format($rUSER['qty'])."</font> ".lang('plugin/jneggv2','jnegg10')."";
		}
		if($rUSER['acdo'] == '3'){
			$rUSER['desc'] = "".lang('plugin/jneggv2','jnegg11')." <font color='red'>".number_format($rUSER['qty'])."</font> ".lang('plugin/jneggv2','jnegg12')."";
		}
		if($rUSER['acdo'] == '4'){
			$rUSER['desc'] = lang('plugin/jneggv2','jnegg13');
		}
		if($rUSER['acdo'] == '5'){
			$rUSER['desc'] = lang('plugin/jneggv2','jnegg14');
		}
		if($rUSER['acdo'] == '6'){
			$rUSER['desc'] = "".lang('plugin/jneggv2','jnegg16')." <font color='red'>".number_format($rUSER['qty'])."</font> ".lang('plugin/jneggv2','jnegg17')."".number_format($rUSER['qty']*$g_goldeggprice).$g_goldcreditext."".lang('plugin/jneggv2','jnegg19')."";
		}
		if($rUSER['acdo'] == '7'){
			$rUSER['desc'] = "".lang('plugin/jneggv2','jnegg16')." <font color='red'>".number_format($rUSER['qty'])."</font> ".lang('plugin/jneggv2','jnegg18')."".number_format($rUSER['qty']/$g_eggout).$g_eggcreditext."".lang('plugin/jneggv2','jnegg19')."";
		}
		if($rUSER['acdo'] == '8'){
			$rUSER['desc'] = "".lang('plugin/jneggv2','jnegg47').$rUSER['qty'].lang('plugin/jneggv2','jnegg48')."";
		}
		$rUSER['timestamp'] = date("Y-m-d H:i",($rUSER['timestamp']));
		$userlog[] = $rUSER;
	}
	include template('jneggv2:admincp');
	exit;
}
if($_GET['do'] == 'viewlog'){
	$page = $_G['page'];
	$tpp = 100;
	$total = DB::result_first("SELECT count(*) cnt FROM ".DB::table('game_jneggv2_log'));
	if(@ceil($total/$tpp) < $page) 	$page = 1;
	$start_limit = ($page - 1) * $tpp;
	$qLog = DB::query("SELECT t1.*, t2.username FROM ".DB::table('game_jneggv2_log')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON t1.uid=t2.uid ORDER by t1.timestamp desc limit {$start_limit},{$tpp}");
	while($rLog = DB::fetch($qLog)) {
		if($rLog['acdo'] == '1'){
			$rLog['desc'] = "".lang('plugin/jneggv2','jnegg6')." <font color='red'>".number_format($rLog['cost']).$g_costbuyext."</font> ".lang('plugin/jneggv2','jnegg7')." <font color='blue'>".number_format($rLog['qty'])."</font> ".lang('plugin/jneggv2','jnegg8')."";
		}
		if($rLog['acdo'] == '2'){
			$rLog['desc'] = "".lang('plugin/jneggv2','jnegg9')." <font color='red'>".number_format($rLog['qty'])."</font> ".lang('plugin/jneggv2','jnegg10')."";
		}
		if($rLog['acdo'] == '3'){
			$rLog['desc'] = "".lang('plugin/jneggv2','jnegg11')." <font color='red'>".number_format($rLog['qty'])."</font> ".lang('plugin/jneggv2','jnegg12')."";
		}
		if($rLog['acdo'] == '4'){
			$rLog['desc'] = lang('plugin/jneggv2','jnegg13');
		}
		if($rLog['acdo'] == '5'){
			$rLog['desc'] = lang('plugin/jneggv2','jnegg14');
		}
		if($rLog['acdo'] == '6'){
			$rLog['desc'] = "".lang('plugin/jneggv2','jnegg16')." <font color='red'>".number_format($rLog['qty'])."</font> ".lang('plugin/jneggv2','jnegg17')."".number_format($rLog['qty']*$g_goldeggprice).$g_goldcreditext."".lang('plugin/jneggv2','jnegg19')."";
		}
		if($rLog['acdo'] == '7'){
			$rLog['desc'] = "".lang('plugin/jneggv2','jnegg16')." <font color='red'>".number_format($rLog['qty'])."</font> ".lang('plugin/jneggv2','jnegg18')."".number_format($rLog['qty']/$g_eggout).$g_eggcreditext."".lang('plugin/jneggv2','jnegg19')."";
		}
		if($rLog['acdo'] == '8'){
			$rLog['desc'] = "".lang('plugin/jneggv2','jnegg47').$rLog['qty'].lang('plugin/jneggv2','jnegg48')."";
		}
		$rLog['timestamp'] = date("Y-m-d H:i:s",($rLog['timestamp']));
		$Loginfo[] = $rLog;
	}
	array_multisort($tid, SORT_ASC, $Loginfo);
	$multipage = multi($total, $tpp, $page, "plugin.php?id=jneggv2:admincp&do=viewlog", $_G['setting']['threadmaxpages']);
	include template('jneggv2:admincp');
	exit;
}
if($_GET['do'] == 'deletelog'){
	$deleteid = dintval($_GET['logid']);
	if(!$deleteid){
		showmessage('jneggv2:jnegg44');
	}
	if($_GET['formhash'] == $_G['formhash']){
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_log')." WHERE id = '".daddslashes($deleteid)."'");
		showmessage('jneggv2:jnegg46','plugin.php?id=jneggv2:admincp&do=viewlog',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
	}else{
		showmessage('jneggv2:jnegg23');
	}
	include template('jneggv2:admincp');
	exit;
}
if($_GET['do'] == 'deleteuser'){
	if(!$userid){
		showmessage('jneggv2:jnegg45');
	}
	if($_GET['formhash'] == $_G['formhash']){
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_log')." WHERE uid = '".daddslashes($userid)."' AND acdo = '4'");
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_user')." WHERE uid = '".daddslashes($userid)."'");
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_chicken')." WHERE uid = '".daddslashes($userid)."'");
		showmessage('jneggv2:jnegg46','plugin.php?id=jneggv2:admincp',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
	}else{
		showmessage('jneggv2:jnegg23');
	}
	include template('jneggv2:admincp');
	exit;
}
if($_GET['do'] == 'deleteuserlog'){
	if(!$userid){
		showmessage('jneggv2:jnegg45');
	}
	if($_GET['formhash'] == $_G['formhash']){
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_log')." WHERE uid = '".daddslashes($userid)."' AND acdo = '1' OR uid = '".daddslashes($userid)."' AND acdo = '2' OR uid = '".daddslashes($userid)."' AND acdo = '3' OR uid = '".daddslashes($userid)."' AND acdo = '5' OR uid = '".daddslashes($userid)."' AND acdo = '6' OR uid = '".daddslashes($userid)."' AND acdo = '7' OR uid = '".daddslashes($userid)."' AND acdo = '8'");
		showmessage('jneggv2:jnegg46','plugin.php?id=jneggv2:admincp&do=viewlog',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
	}else{
		showmessage('jneggv2:jnegg23');
	}
	include template('jneggv2:admincp');
	exit;
}
if($_GET['do'] == 'deletechick'){
	if(!$userid){
		showmessage('jneggv2:jnegg45');
	}
	$chickid = dintval($_GET['chickid']);
	if(!$chickid){
		showmessage('jneggv2:jnegg38');
	}
	if($_GET['formhash'] == $_G['formhash']){
		DB::query("DELETE FROM  ".DB::table('game_jneggv2_chicken')." WHERE id = '".daddslashes($chickid)."'");
		showmessage('jneggv2:jnegg46','plugin.php?id=jneggv2:admincp&do=user&userid='.$userid,array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
	}else{
		showmessage('jneggv2:jnegg23');
	}
	include template('jneggv2:admincp');
	exit;
}
$page = $_G['page'];
$tpp = 100;
$total = DB::result_first("SELECT count(*) cnt FROM ".DB::table('game_jneggv2_user'));
if(@ceil($total/$tpp) < $page) 	$page = 1;
$start_limit = ($page - 1) * $tpp;
	
$query = DB::query("SELECT pl.*, cm.username FROM ".DB::table('game_jneggv2_user')." pl LEFT JOIN ".DB::table('common_member')." cm ON pl.uid=cm.uid ORDER BY id desc limit {$start_limit},{$tpp}");
while($row = DB::fetch($query)) {
	$qchic = DB::query("SELECT sum(chickenqty) AS chick FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$row[uid]' AND status = '1'");
	while($rchic = DB::fetch($qchic)) {
		$row['chicken'] = $rchic['chick'];
	}
	$row['jointime'] = date("Y-m-d H:i:s",($row['jointime']));
	$userlist[] = $row;
}
array_multisort($tid, SORT_ASC, $userlist);
//multipage
$multipage = multi($total, $tpp, $page, "plugin.php?id=jneggv2:admincp", $_G['setting']['threadmaxpages']);
include template('jneggv2:admincp');
//分.享.吧全网首发
?>