<?php
$a = SafeRequest("a","get");
$a = empty($a)?'index':$a;
$cd_id = SafeRequest("id","get");
$cd_uid = SafeRequest("uid","get");
$cd_pid = SafeRequest("pid","get");
global $db,$userlogined;
if(!$userlogined){
	$qianwei_in_userid = 0;
}
if($a == 'skin'){
	$cd_uid = $qianwei_in_userid;
}

if(!IsNul($cd_uid)){
	exit(include "error.php");
}else{
	$sql="select * from ".tname('user')." where cd_lock=0 and cd_id='$cd_uid'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		$qianwei_web_userid = $row['cd_id'];
		$qianwei_web_username = $row['cd_name'];
		$qianwei_web_sex = $row['cd_sex'];
		$qianwei_web_nicheng = $row['cd_nicheng'];
		$qianwei_web_grade = $row['cd_grade'];
		$qianwei_web_address = $row['cd_address'];
		$qianwei_web_hits = $row['cd_hits'];
		$qianwei_web_logintime = $row['cd_logintime'];
		$qianwei_web_regdate = $row['cd_regdate'];
		$qianwei_web_points = $row['cd_points'];
		$qianwei_web_birthday = $row['cd_birthday'];
		$qianwei_web_qq = $row['cd_qq'];
		$qianwei_web_email = $row['cd_email'];
		$qianwei_web_uhits = $row['cd_uhits'];
		$qianwei_web_musicnum = $row['cd_musicnum'];
		$qianwei_web_fansnum = $row['cd_fansnum'];
		$qianwei_web_idolnum = $row['cd_idolnum'];
		$qianwei_web_favnum = $row['cd_favnum'];
		$qianwei_web_qqprivacy = $row['cd_qqprivacy'];
		$qianwei_web_introduce = $row['cd_introduce'];
		$qianwei_web_checkmm = $row['cd_checkmm'];
		$qianwei_web_rank = $row['cd_rank'];
		$qianwei_web_weekhits = $row['cd_weekhits'];
		$qianwei_web_sign = $row['cd_sign'];
		$qianwei_web_checkmm = $row['cd_checkmm'];
		$qianwei_web_checkmusic = $row['cd_checkmusic'];
		$qianwei_web_review = $row['cd_review'];
		$qianwei_web_viprank = $row['cd_viprank'];

		if($row['cd_skinid']){
			$qianwei_web_skinid = GetAlias("qianwei_skin","cd_path","cd_id",$row['cd_skinid']);
		}else{
			$qianwei_web_skinid = 't0';
		}
		//人气
        	$cookies = md5("webhits_".getonlineip()."_".$cd_uid);
		if(!$_COOKIE[$cookies]=="yes"){
			setcookie($cookies,"yes",time()+86400);
			$db->query("update ".tname('user')." set cd_hits=cd_hits+1 where cd_id='$cd_uid'");
		}

	}else{
		exit(include "error.php");
	}

	if($qianwei_web_userid == $qianwei_in_userid){
		$qianwei_web_callname = "我";
	}else{
		if($qianwei_web_sex == 1){
			$qianwei_web_callname = "他";
		}else{
			$qianwei_web_callname = "她";
		}
	}
}
?>