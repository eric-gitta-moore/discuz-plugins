<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_sex = unescape(SafeRequest("sex","post"));
	$cd_year = SafeRequest("year","post");
	$cd_month = SafeRequest("month","post");
	$cd_day = SafeRequest("day","post");
	$cd_birthday = $cd_year."-".$cd_month."-".$cd_day;
	$cd_address = unescape(SafeRequest("address","post"));
	$cd_qq = SafeRequest("qq","post");
	$cd_email = SafeRequest("email","post");
	$cd_qqprivacy = SafeRequest("qqPrivacy","post");
	$cd_introduce = unescape(SafeRequest("selfIntroduce","post"));

	if($cd_address == ""){
		exit('10004');
	}

	$db->query("update ".tname('user')." set cd_sex='$cd_sex',cd_birthday='$cd_birthday',cd_address='".$cd_address."',cd_qq='".$cd_qq."',cd_email='".$cd_email."',cd_qqprivacy='".$cd_qqprivacy."',cd_introduce='".$cd_introduce."' where cd_id='$qianwei_in_userid'");
	exit('10000');
}else{
	exit('20001');
}
?>