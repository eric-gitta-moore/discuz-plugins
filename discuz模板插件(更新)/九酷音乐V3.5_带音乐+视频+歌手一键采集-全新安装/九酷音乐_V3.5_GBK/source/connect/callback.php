<?php
require_once('../global/global_conn.php');
global $db;
$openid = $_GET['openid'];
$pass = substr($_GET['openid'],0,20);
$user = base64_decode($_GET['user']);
$img = $_GET['img'];
if($row = $db->getrow("select cd_id,cd_name,cd_password from ".tname('user')." where cd_lock=0 and cd_qqopen='".$openid."'")) {
	$db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".getonlineip()."',cd_logintime='".date('Y-m-d H:i:s')."' where cd_id=".$row['cd_id']);
	$db->query("delete from ".tname('session')." where cd_uid=".$row['cd_id']);
	$db->query("Insert ".tname('session')." (cd_uid,cd_uname,cd_uip,cd_logintime) values (".$row['cd_id'].",'".$row['cd_name']."','".getonlineip()."','".time()."')");
	setcookie("cd_id",$row['cd_id'],time()+86400,cd_cookiepath);
	setcookie("cd_name",$row['cd_name'],time()+86400,cd_cookiepath);
	setcookie("cd_password",$row['cd_password'],time()+86400,cd_cookiepath);
}else{
	$db->query("insert into `".tname('user')."` (cd_name,cd_nicheng,cd_password,cd_regdate,cd_loginnum,cd_grade,cd_lock,cd_points,cd_hits,cd_isbest,cd_friendnum,cd_rank,cd_uhits,cd_weekhits,cd_musicnum,cd_fansnum,cd_idolnum,cd_favnum,cd_qqprivacy,cd_groupnum,cd_checkmm,cd_checkmusic,cd_review,cd_sign,cd_signcumu,cd_ucenter,cd_skinid,cd_vipgrade,cd_viprank,cd_ulevel,cd_qqopen,cd_qqimg) values ('".$user."','".$user."','".substr(md5($pass),8,16)."','".date('Y-m-d H:i:s')."','0','0','0','".cd_points."','0','0','0','".cd_userrank."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','".$openid."','".$img."')");
	if($rows = $db->getrow("select * from ".tname('user')." where cd_lock=0 and cd_qqopen='".$openid."'")) {
		$db->query("update ".tname('user')." set cd_loginnum=cd_loginnum+1,cd_loginip='".getonlineip()."',cd_logintime='".date('Y-m-d H:i:s')."' where cd_id=".$rows['cd_id']);
		$db->query("delete from ".tname('session')." where cd_uid=".$rows['cd_id']);
		$db->query("Insert ".tname('session')." (cd_uid,cd_uname,cd_uip,cd_logintime) values (".$rows['cd_id'].",'".$rows['cd_name']."','".getonlineip()."','".time()."')");
		setcookie("cd_id",$rows['cd_id'],time()+86400,cd_cookiepath);
		setcookie("cd_name",$rows['cd_name'],time()+86400,cd_cookiepath);
		setcookie("cd_password",$rows['cd_password'],time()+86400,cd_cookiepath);
		$setarr = array(
			'cd_uid' => 0,
			'cd_uname' => '系统提示',
			'cd_uids' => $rows['cd_id'],
			'cd_unames' => $rows['cd_name'],
			'cd_icon' => 'wall',
			'cd_data' => '欢迎使用QQ注册。您的登录密码为：'.$pass.'，请及时修改！',
			'cd_dataid' => 0,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('notice', $setarr, 1);
	}
}
echo "<script type=\"text/javascript\">opener.closeChildWindow();</script>";
?>