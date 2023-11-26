<?php
	include "../source/global/global_inc.php";
	global $db,$userlogined;
	$db->query("delete from ".tname('session')." where cd_uid=".$qianwei_in_userid);
	setcookie("cd_id","",time()-1,cd_cookiepath);
	setcookie("cd_name","",time()-1,cd_cookiepath);
	setcookie("cd_password","",time()-1,cd_cookiepath);
	if(cd_ucenter==1){
		require_once _qianwei_root_.'./client/ucenter.php';
		require_once _qianwei_root_.'./client/client.php';
	        echo uc_user_synlogout();
        }
	echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
?>