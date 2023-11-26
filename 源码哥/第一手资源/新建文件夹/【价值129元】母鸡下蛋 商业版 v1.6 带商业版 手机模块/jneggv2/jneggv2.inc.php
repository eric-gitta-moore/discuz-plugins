<?php
/*
 * CopyRight  : [fx8.cc!] (C)2014-2016
 * Document   : 源码哥：www.fx8.cc，www.ymg6.com
 * Created on : 2016-04-24,10:22:10
 * Author     : 源码哥(QQ：154606914) wWw.fx8.cc $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              源码哥出品 必属精品。
 *              源码哥分享吧 全网首发 http://www.fx8.cc；
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
};
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
$g_limitbuy = $config['jn_limitbuy']; //购买鸡只限制

$quser = DB::query("SELECT * FROM ".DB::table('game_jneggv2_user')." WHERE uid = '$_G[uid]'");
while($ruser = DB::fetch($quser)){
	$qchicken = DB::query("SELECT sum(chickenqty) AS chicken FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$_G[uid]' AND status = '1'");
	while($rchicken = DB::fetch($qchicken)){
		$chicext = $rchicken['chicken'];
	}
	$g_eggext = $ruser['jidan']; //EXTCREDITs
	$g_goldext = $ruser['jindan'];
	$g_luckext = $ruser['luck'];
	$usermat[] = $ruser;
}

$qMleft = DB::query("SELECT * FROM ".DB::table('common_member_count')." WHERE uid = '$_G[uid]'");
while($rMleft = DB::fetch($qMleft)){
	$buyext = $rMleft[$g_buyext]; //EXTCREDITs
	//$luckext = $rMleft[$g_luckext];
	//$chicext = $rMleft[$g_chic];
}
if (in_array($_G['uid'],$g_adminids)){
	$admincpbtn = "<li><a href=\"plugin.php?id=jneggv2:admincp\"><span>".lang('plugin/jneggv2','jnegg1')."</span></a></li>";
}
if(!$g_onoff){
	showmessage('jneggv2:jnegg5');
}
if(!in_array($_G['group']['groupid'],$g_usergroup)){
	showmessage('jneggv2:jnegg3');
}
if($g_buyext == ''){
	showmessage('jneggv2:jnegg4');
}
if($g_luck == '1' && $config['jn_luckext'] == '0'){
	showmessage('jneggv2:jnegg5');
}

$jifentitle = $_G['setting']['extcredits'][$jifen]['title']; //
foreach($_G['setting']['extcredits'] as $key => $value){
	$ext = 'extcredits'.$key;
	getuserprofile($ext);
	$person['extcredits'][$key]['title'] = $value['title'];
	$person['extcredits'][$key]['value'] = $_G['member'][$ext];
	$person['extcredits'][$key]['unit'] = $value['unit'];
}

$page = $_G['page'];
$tpp = 50;
$total = DB::result_first("SELECT count(*) cnt FROM ".DB::table('game_jneggv2_log')."");
if(@ceil($total/$tpp) < $page) 	$page = 1;
$start_limit = ($page - 1) * $tpp;

$qEgglist = DB::query("SELECT t1.*,t1.id AS sid,t2.username FROM ".DB::table('game_jneggv2_log')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON (t1.uid = t2.uid) ORDER BY t1.id DESC limit {$start_limit},{$tpp}");
$qEgglistC = mysql_num_rows(DB::query("SELECT * FROM ".DB::table('game_jneggv2_log').""));
while($rEgglist = DB::fetch($qEgglist)){
	$tid = $rEgglist['sid'];
	if($rEgglist['acdo'] == '1'){
		$rEgglist['desc'] = "".lang('plugin/jneggv2','jnegg6')." <font color='red'>".number_format($rEgglist['cost']).$g_costbuyext."</font> ".lang('plugin/jneggv2','jnegg7')." <font color='blue'>".number_format($rEgglist['qty'])."</font> ".lang('plugin/jneggv2','jnegg8')."";
	}
	if($rEgglist['acdo'] == '2'){
		$rEgglist['desc'] = "".lang('plugin/jneggv2','jnegg9')." <font color='red'>".number_format($rEgglist['qty'])."</font> ".lang('plugin/jneggv2','jnegg10')."";
	}
	if($rEgglist['acdo'] == '3'){
		$rEgglist['desc'] = "".lang('plugin/jneggv2','jnegg11')." <font color='red'>".number_format($rEgglist['qty'])."</font> ".lang('plugin/jneggv2','jnegg12')."";
	}
	if($rEgglist['acdo'] == '4'){
		$rEgglist['desc'] = lang('plugin/jneggv2','jnegg13');
	}
	if($rEgglist['acdo'] == '5'){
		$rEgglist['desc'] = lang('plugin/jneggv2','jnegg14');
	}
	if($rEgglist['acdo'] == '6'){
		$rEgglist['desc'] = "".lang('plugin/jneggv2','jnegg16')." <font color='red'>".number_format($rEgglist['qty'])."</font> ".lang('plugin/jneggv2','jnegg17')."".number_format($rEgglist['qty']*$g_goldeggprice).$g_goldcreditext."".lang('plugin/jneggv2','jnegg19')."";
	}
	if($rEgglist['acdo'] == '7'){
		$rEgglist['desc'] = "".lang('plugin/jneggv2','jnegg16')." <font color='red'>".number_format($rEgglist['qty'])."</font> ".lang('plugin/jneggv2','jnegg18')."".number_format($rEgglist['qty']/$g_eggextratio).$g_eggcreditext."".lang('plugin/jneggv2','jnegg19')."";
	}
	if($rEgglist['acdo'] == '8'){
		$rEgglist['desc'] = "".lang('plugin/jneggv2','jnegg47').$rEgglist['qty'].lang('plugin/jneggv2','jnegg48')."";
	}
	$rEgglist['timestamp'] = date("Y-m-d H:i:s",($rEgglist['timestamp']));
	$Egglist[] = $rEgglist;
};
array_multisort($tid, SORT_ASC, $Egglist);
$multipage = multi($total, $tpp, $page, "plugin.php?id=jneggv2:jneggv2", $_G['setting']['threadmaxpages']);

$qCrank = DB::query("SELECT sum(t1.chickenqty) AS chicken1,t2.username FROM ".DB::table('game_jneggv2_chicken')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON (t1.uid = t2.uid) WHERE t1.status = '1' GROUP BY t1.uid ORDER BY chicken1 DESC LIMIT 10");
while($rCrank = DB::fetch($qCrank)){
	$ChickRank[] = $rCrank;
}
$qJrank = DB::query("SELECT t1.*,t2.username FROM ".DB::table('game_jneggv2_user')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON (t1.uid = t2.uid) GROUP BY t1.uid ORDER BY t1.jindan DESC LIMIT 10");
while($rJrank = DB::fetch($qJrank)){
	$JindanRank[] = $rJrank;
}
$qTrank = DB::query("SELECT sum(t1.qty) AS qty,t2.username FROM ".DB::table('game_jneggv2_log')." t1 LEFT JOIN ".DB::table('common_member')." t2 ON (t1.uid = t2.uid) WHERE t1.acdo	= '2' GROUP BY t1.uid ORDER BY qty DESC LIMIT 10");
while($rTrank = DB::fetch($qTrank)){
	$TQRank[] = $rTrank;
}
//周期
$zhouqi = $g_zhouqi * 60;

//当前产量
$qProduct = DB::query("SELECT * FROM ".DB::table('game_jneggv2_log')." WHERE uid = '$_G[uid]' AND acdo = '2' ORDER BY timestamp DESC limit 1");
$nProduct = mysql_num_rows($qProduct);
$qJoin = DB::query("SELECT * FROM ".DB::table('game_jneggv2_user')." WHERE uid = '$_G[uid]'"); //acdo 1 == buychic
$nJoin = mysql_num_rows($qJoin);
if($_G['uid'] > 0){
	if($nProduct == '0'){
		$qJoin1 = DB::query("SELECT * FROM ".DB::table('game_jneggv2_log')." WHERE uid = '$_G[uid]' AND acdo = '1' ORDER BY timestamp ASC limit 1"); //acdo 1 == buychic
		//$nJoin1 = mysql_num_rows($qJoin1);
		while($rJoin = DB::fetch($qJoin1)){ //加入了，但未领取过
			$productime = $rJoin['timestamp'];
		}
	}else{
		while($rProduct = DB::fetch($qProduct)){ //加入了，也领取过了
			$productime = $rProduct['timestamp'];
		}
	}
}
$yesterday = date("Y-m-d",((strtotime(date("Y-m-d",($_G['timestamp']))))-86400));
$todaydate = date("Y-m-d",($_G['timestamp']));
$ytimemin = ((strtotime(date("Y-m-d",($_G['timestamp']))))-86400);
$ytimemax = strtotime(date("Y-m-d",($_G['timestamp'])));
$estimate = dintval($g_egg * $chicext);
//昨日总收成
$qYpro = DB::query("SELECT sum(qty) AS totalqty FROM ".DB::table('game_jneggv2_log')." WHERE acdo = '2' AND timestamp > $ytimemin AND timestamp < $ytimemax");
while($rYpro = DB::fetch($qYpro)){
	$Ypro = $rYpro['totalqty'];
	$Ypro1 = number_format($Ypro);
}
$bonusP = dintval($Ypro / $g_bonus);
if($bonusP >= $g_bonusmax){
	$bonusP = $g_bonusmax;
}
if(!$g_bonusof){
	$bonusP == '0';
}
if(($_G['timestamp'] - $productime) > $zhouqi){
	$productnow = number_format(($g_egg * $chicext) / 86400 * $zhouqi,0,'.','');
}else{
	$productnow = number_format((($_G['timestamp'] - $productime) * $g_egg * $chicext) / 86400,0,'.','');
}
if($g_bonusof == '1'){
	$extrabonus = number_format($productnow*($bonusP*0.01));
}
if($_GET['do'] == 'buychic'){
	include template('jneggv2:jneggv2_pop');
	exit;
}
if($_GET['do'] == 'changeout'){
	include template('jneggv2:jneggv2_pop');
	exit;
}
if(submitcheck('changeoutsubmit')) {
	if (!$_G['uid']) showmessage('not_loggedin','',array(), array('login' => true));
	if($_GET['formhash'] == $_G['formhash']){
		$paymount = dintval($_POST['paymount']);
		if(!$paymount || $paymount < '0') {
			showmessage('jneggv2:jnegg20','',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		}elseif($paymount < $g_goldeggmin) {
			showmessage('jneggv2:jnegg25','',array('g_goldeggmin'=>$g_goldeggmin),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		}else{
			$totaladd = $paymount * $g_goldeggprice;
			$goldeggdeduct = $g_goldext - $paymount;
			if($g_goldext >= $paymount){
				DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp) VALUES ('6','".daddslashes($paymount)."','$_G[uid]','$_G[timestamp]')");
				DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jindan = '".daddslashes($goldeggdeduct)."' WHERE uid = '$_G[uid]'");
				$creditsarray[$g_goldcredit] = '+'.$totaladd; //增加积分
				updatemembercount($_G['uid'], $creditsarray, true, '', 0, '',lang('plugin/jneggv2','MJXD'),lang('plugin/jneggv2','jnegg26',array('paymount'=>$paymount)));
				showmessage('jneggv2:jnegg24','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
			}else{
				showmessage('jneggv2:jnegg27','',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
			}
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if($_GET['do'] == 'changeegg'){
	include template('jneggv2:jneggv2_pop');
	exit;
}
if(submitcheck('changeeggsubmit')) {
	if (!$_G['uid']) showmessage('not_loggedin','',array(), array('login' => true));
	if($_GET['formhash'] == $_G['formhash']){
		$paymount = dintval($_POST['paymount']);
		if(!$paymount || $paymount < '0') {
			showmessage('jneggv2:jnegg20','',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		}elseif($paymount < $g_eggextratio) {
			showmessage('jneggv2:jnegg25','',array('g_goldeggmin'=>$g_eggextratio),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		}else{
			$totaladd = $paymount / $g_eggextratio;
			$eggdeduct = $g_eggext - $paymount;
			if($g_eggext >= $paymount){
				DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp) VALUES ('7','".daddslashes($paymount)."','$_G[uid]','$_G[timestamp]')");
				DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($eggdeduct)."' WHERE uid = '$_G[uid]'");
				$creditsarray[$g_eggcredit] = '+'.$totaladd; //增加积分
				updatemembercount($_G['uid'], $creditsarray, true, '', 0, '',lang('plugin/jneggv2','MJXD'),lang('plugin/jneggv2','jnegg28',array('paymount'=>$paymount)));
				showmessage('jneggv2:jnegg24','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
			}else{
				showmessage('jneggv2:jnegg29','',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
			}
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if(submitcheck('buychicsubmit')) {
	if (!$_G['uid']) showmessage('not_loggedin','',array(), array('login' => true));
	if($productnow > $g_limitbuy){
		showmessage('jneggv2:jnegg51','',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
	}
	if($_GET['formhash'] == $_G['formhash']){
		$paymount = dintval($_POST['paymount']);
		if(!$paymount || $paymount < '0') {
			showmessage('jneggv2:jnegg20','',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		}else{
			$totalcost = $paymount * $g_costbuy;
			$chickenadd = $chicext + $paymount;
			if($buyext >= $totalcost){
				DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('1','".daddslashes($paymount)."','$_G[uid]','$_G[timestamp]','".daddslashes($totalcost)."')");
				DB::query("REPLACE INTO ".DB::table('game_jneggv2_chicken')." (uid,chickenqty,buytime,status) VALUES ('$_G[uid]','".daddslashes($paymount)."','$_G[timestamp]','1')");
				//DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET chicken = '".daddslashes($chickenadd)."' WHERE uid = '$_G[uid]'");
				$creditsarray[$g_buyext] = '-'.$totalcost; //减少金钱
				updatemembercount($_G['uid'], $creditsarray, true, '', 0, '',lang('plugin/jneggv2','MJXD'),lang('plugin/jneggv2','jnegg15',array('totalcost'=>$totalcost,'g_costbuyext'=>$g_costbuyext,'paymount'=>$paymount)));
				showmessage('jneggv2:jnegg21','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
			}else{
				showmessage('jneggv2:jnegg22','',array('paymount'=>$paymount,'totalcost'=>$totalcost,'g_costbuyext'=>$g_costbuyext,'buyext'=>$buyext),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
			}
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
if($_GET['do'] == 'openaccount'){
	if (!$_G['uid']) showmessage('not_loggedin','',array(), array('login' => true));
	if($_GET['formhash'] == $_G['formhash']){
		if($nJoin == '0'){
			DB::query("REPLACE INTO ".DB::table('game_jneggv2_user')." (uid,jidan,jindan,chicken,jointime) VALUES ('$_G[uid]','0','0','0','$_G[timestamp]')");
			DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,uid,timestamp) VALUES ('4','$_G[uid]','$_G[timestamp]')");
			showmessage('jneggv2:jnegg30','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
		}else{
			showmessage('jneggv2:jnegg31');
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
	
}
if($_GET['do'] == 'viewchic'){
	if (!$_G['uid']) showmessage('not_loggedin','',array(), array('login' => true));
	$timelimit = $_G['timestamp'] - ($g_chictime * 60 * 2);
	$page = $_G['page'];
	$tpp = 10;
	$total = DB::result_first("SELECT count(*) cnt FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$_G[uid]' AND buytime > '$timelimit'");
	if(@ceil($total/$tpp) < $page) 	$page = 1;
	$start_limit = ($page - 1) * $tpp;
	
	$qchic = DB::query("SELECT * FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$_G[uid]' AND buytime > '$timelimit' ORDER BY id DESC limit {$start_limit},{$tpp}");
	while($rchic = DB::fetch($qchic)){
		$rchic['dietime'] = date("Y-m-d H:i",($rchic['buytime'] + ($g_chictime * 60)));
		$rchic['buytime'] = date("Y-m-d H:i",($rchic['buytime']));
		$chiclist[] = $rchic;
	}
	array_multisort($tid, SORT_ASC, $rchic);
	$multipage = multi($total, $tpp, $page, "plugin.php?id=jneggv2:jneggv2&do=viewchic", $_G['setting']['threadmaxpages']);
	include template('jneggv2:jneggv2_pop');
	exit;
}
if($_GET['do'] == 'getegg'){
	if (!$_G['uid']) showmessage('not_loggedin','',array(), array('login' => true));
	if($_GET['formhash'] == $_G['formhash']){
		$finalproduct = $productnow*(1+($bonusP*0.01));
		if($finalproduct < $g_eggmin){
			showmessage('jneggv2:jnegg32','plugin.php?id=jneggv2',array('g_eggmin'=>$g_eggmin),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		};
		$todaystampmin = strtotime(date("Y-m-d",($_G['timestamp'])));
		$todaystampmax = $todaystampmin + 86400;
		$qTodayget = DB::query("SELECT * FROM ".DB::table('game_jneggv2_log')." WHERE acdo = '2' AND timestamp > $todaystampmin AND timestamp < $todaystampmax AND uid = '$_G[uid]'");
		$nTodayget = mysql_num_rows($qTodayget);
		if($nTodayget >= $g_maxget){
			showmessage('jneggv2:jnegg33','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error'));
		}
		if($g_chicdie == '1'){//鸡只死亡开关开启
			$qchic = DB::query("SELECT * FROM ".DB::table('game_jneggv2_chicken')." WHERE uid = '$_G[uid]' AND status = '1'");
			while($rchic = DB::fetch($qchic)){
				if(($rchic['buytime'] + ($g_chictime * 60)) <= $_G['timestamp']){
					DB::query("UPDATE ".DB::table('game_jneggv2_chicken')." SET status = '2' WHERE id = '$rchic[id]'"); //add egg
					DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp) VALUES ('8','".daddslashes($rchic[chickenqty])."','$_G[uid]','$_G[timestamp]')");
				}
			}
		}
		if($g_luck == '1'){ //开启运气金蛋
			if(in_array($_G['group']['groupid'],$g_vip)){ //vip用户组
				$success = mt_rand(1,100);
				if($g_luckext/100 >= '20'){
					$userluck = $g_vipgoldegg + '20';
				}else{
					$userluck = $g_vipgoldegg + ($g_luckext/100);
				}
				$finalproduct = $productnow*(1+($bonusP*0.01));
				if($userluck >= $success){ //运气大于随机数字，获得！
					$g_mt = mt_rand($g_mtrand[0],$g_mtrand[1]);
					$addegg = $g_eggext + $finalproduct;
					$addgoldegg = $g_goldext + $g_mt;
					$addluck = $g_luckext + 1;
					if($success >= '95'){
						if($addluck > '2000'){
							$addluck = '2000';
							DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('3','".daddslashes($g_mt)."','$_G[uid]','$_G[timestamp]','0')");
							DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."', jindan = '".daddslashes($addgoldegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
							showmessage('jneggv2:jnegg34','plugin.php?id=jneggv2',array('g_mt'=>$g_mt),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
						}
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."', jindan = '".daddslashes($addgoldegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('3','".daddslashes($g_mt)."','$_G[uid]','$_G[timestamp]','0'),('5','1','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg35','plugin.php?id=jneggv2',array('g_mt'=>$g_mt),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}else{
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."', jindan = '".daddslashes($addgoldegg)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('3','".daddslashes($g_mt)."','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg34','plugin.php?id=jneggv2',array('g_mt'=>$g_mt),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}
				}else{
					$addegg = $g_eggext + $finalproduct;
					$addluck = $g_luckext + 1;
					if($success >= '95'){
						if($addluck > '2000'){
							$addluck = '2000';
							DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
							DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0')");
							showmessage('jneggv2:jnegg36','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
						}
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('5','1','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg37','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}else{
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg36','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}
				}
			}elseif(in_array($_G['group']['groupid'],$g_usergroup)){//普通用户组
				$success = mt_rand(1,100);
				if($g_luckext/100 >= '20'){
					$userluck = $g_goldegg + '20';
				}else{
					$userluck = $g_goldegg + ($g_luckext/100);
				}
				$finalproduct = $productnow*(1+($bonusP*0.01));
				if($userluck >= $success){ //运气大于随机数字，获得！
					$g_mt = mt_rand($g_mtrand[0],$g_mtrand[1]);
					$addegg = $g_eggext + $finalproduct;
					$addgoldegg = $g_goldext + $g_mt;
					$addluck = $g_luckext + 1;
					if($success >= '95'){
						if($addluck > '2000'){
							$addluck = '2000';
							DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."', jindan = '".daddslashes($addgoldegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
							DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('3','".daddslashes($g_mt)."','$_G[uid]','$_G[timestamp]','0')");
							showmessage('jneggv2:jnegg34','plugin.php?id=jneggv2',array('g_mt'=>$g_mt),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
						}
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."', jindan = '".daddslashes($addgoldegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('3','".daddslashes($g_mt)."','$_G[uid]','$_G[timestamp]','0'),('5','1','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg35','plugin.php?id=jneggv2',array('g_mt'=>$g_mt),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}else{
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."', jindan = '".daddslashes($addgoldegg)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('3','".daddslashes($g_mt)."','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg34','plugin.php?id=jneggv2',array('g_mt'=>$g_mt),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}
				}else{
					$addegg = $g_eggext + $finalproduct;
					$addluck = $g_luckext + 1;
					if($success >= '95'){
						if($addluck > '2000'){
							$addluck = '2000';
							DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
							DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0')");
							showmessage('jneggv2:jnegg36','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
						}
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."',luck = '".daddslashes($addluck)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0'),('5','1','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg37','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}else{
						DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."' WHERE uid = '$_G[uid]'"); //add egg
						DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0')");
						showmessage('jneggv2:jnegg36','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
					}
				}
			}else{
				showmessage('jneggv2:jnegg38','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'error', 'locationtime' => true));
			}
		}else{ //没有开启运气金蛋
			$addegg = $g_eggext + $finalproduct;
			DB::query("UPDATE ".DB::table('game_jneggv2_user')." SET jidan = '".daddslashes($addegg)."' WHERE uid = '$_G[uid]'"); //add egg
			DB::query("REPLACE INTO ".DB::table('game_jneggv2_log')." (acdo,qty,uid,timestamp,cost) VALUES ('2','".daddslashes($finalproduct)."','$_G[uid]','$_G[timestamp]','0')");
			showmessage('jneggv2:jnegg36','plugin.php?id=jneggv2',array(),array('showdialog' => 1, 'showmsg' => true, 'alert' => 'right', 'locationtime' => true));
		}
	}else{
		showmessage('jneggv2:jnegg23');
	}
}
include template('diy:jneggv2', 0, 'source/plugin/jneggv2/template');

?>