<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	$cd_email = unescape(SafeRequest("email","post"));
	if(checkEmail($cd_email)){
		$email = $db->getone("select cd_id from ".tname('user')." where cd_id<>'$qianwei_in_userid' and cd_email='".$cd_email."'");
		if($email){
			echo '20011';
		}else{
			echo '10000';
		}
	}else{
		echo '1';
	}
?>