<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_password = SafeRequest("password","post");
	$cd_question = unescape(SafeRequest("question","post"));
	$cd_answer = unescape(SafeRequest("answer","post"));
	if($cd_question == $cd_answer){
		exit('1014');
	}
	$sql= "select cd_id from ".tname('user')." where cd_name='".$qianwei_in_username."' and cd_password='".substr(md5($cd_password),8,16)."'";
        $cd_id= $db->getone($sql);
	if($cd_id){
		$db->query("update ".tname('user')." set cd_question='".$cd_question."',cd_answer='".substr(md5($cd_answer),8,16)."' where cd_id='$qianwei_in_userid'");
	}else{
		exit('1015');
	}
}else{
	exit('1001');
}
?>