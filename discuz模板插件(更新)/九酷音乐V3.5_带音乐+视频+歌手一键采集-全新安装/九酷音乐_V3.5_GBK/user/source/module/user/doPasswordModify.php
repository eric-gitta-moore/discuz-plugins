<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_oldPassword = SafeRequest("oldPassword","post");
	$cd_password = SafeRequest("password","post");
	$cd_password2 = SafeRequest("password2","post");
	if($cd_password != $cd_password2){
		exit('20021');
	}
	$sql= "select cd_id from ".tname('user')." where cd_name='".$qianwei_in_username."' and cd_password='".substr(md5($cd_oldPassword),8,16)."'";
        $cd_id= $db->getone($sql);
	if($cd_id){
		$db->query("update ".tname('user')." set cd_password='".substr(md5($cd_password2),8,16)."' where cd_id='$qianwei_in_userid'");
		setcookie("cd_id",$cd_id,time()+86400,cd_cookiepath);
		setcookie("cd_name",$qianwei_in_username,time()+86400,cd_cookiepath);
		setcookie("cd_password",substr(md5($cd_password2),8,16),time()+86400,cd_cookiepath);
		exit('10000');
	}else{
		exit('20022');
	}
}else{
	exit('20001');
}
?>