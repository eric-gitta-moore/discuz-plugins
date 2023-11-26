<?php
$uc=SafeRequest("uc","get");
if($uc=="o_in"){
        global $userlogined;
        if($userlogined){
	        if(cd_ucenter==1){
		        require_once _qianwei_root_.'./client/ucenter.php';
		        require_once _qianwei_root_.'./client/client.php';
		        global $qianwei_in_username,$qianwei_in_ucenter;
		        $ucid = uc_get_user($qianwei_in_username);
		        if($qianwei_in_ucenter>0 && $qianwei_in_ucenter==$ucid[0]){
			        echo uc_user_synlogin($ucid[0]);
		        }
	        }
	        echo "<script type=\"text/javascript\">location.href='".cd_webpath."';</script>";
        }
}elseif($uc=="o_out"){
	if(cd_ucenter==1){
		require_once _qianwei_root_.'./client/ucenter.php';
		require_once _qianwei_root_.'./client/client.php';
	        echo uc_user_synlogout();
        }
        echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}elseif($uc=="c_in"){
        global $userlogined;
        if($userlogined){
	        if(cd_ucenter==1){
		        require_once _qianwei_root_.'./client/ucenter.php';
		        require_once _qianwei_root_.'./client/client.php';
		        global $qianwei_in_username,$qianwei_in_ucenter;
		        $ucid = uc_get_user($qianwei_in_username);
		        if($qianwei_in_ucenter>0 && $qianwei_in_ucenter==$ucid[0]){
			        echo uc_user_synlogin($ucid[0]);
		        }
	        }
	        echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
        }
}elseif($uc=="c_out"){
	if(cd_ucenter==1){
		require_once _qianwei_root_.'./client/ucenter.php';
		require_once _qianwei_root_.'./client/client.php';
	        echo uc_user_synlogout();
        }
        echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}
?>