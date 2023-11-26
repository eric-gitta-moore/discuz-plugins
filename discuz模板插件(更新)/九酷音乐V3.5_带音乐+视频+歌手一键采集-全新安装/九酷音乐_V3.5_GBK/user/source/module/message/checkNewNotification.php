<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$query = "select * from ".tname('notice')." where cd_state=1 and cd_uids='$qianwei_in_userid' order by cd_addtime desc";
	$result = $db->query($query);
	$cd_mnew = $db->num_rows($result);

        $cookies = md5("check_notice_$qianwei_in_userid_$cd_mnew");
	if($_COOKIE[$cookies]=="yes"){
		$cd_sound = 0;
	}else{
		$cd_sound = 1;
		setcookie($cookies,"yes",time()+86400);
	}
	echo $_GET['callback'].'({"sound":'.$cd_sound.',"mnew":'.$cd_mnew.',"fnew":0,"error":0})';
}else{
	echo $_GET['callback'].'({"error":20001})';
}
?>