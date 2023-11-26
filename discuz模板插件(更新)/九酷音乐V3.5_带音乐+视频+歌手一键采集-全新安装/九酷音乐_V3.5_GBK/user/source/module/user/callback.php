<?php
include "../source/global/global_inc.php";
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
	        echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
        }
}elseif($uc=="l_in"){
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
	        echo "<script type=\"text/javascript\">location.href='".cd_upath.rewrite_url('index.php?p=system&a=home')."';</script>";
        }
}
?>