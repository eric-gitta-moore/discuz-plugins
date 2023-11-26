<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_fgid = SafeRequest("fgid","post");
	$cd_fgName = unescape(SafeRequest("fg_name","post"));

	if($cd_fgName == ''){
		exit('10007');
	}

	if(mb_strlen($cd_fgName,'UTF8') > 7){
		exit('10006');
	}

	$db->query("update ".tname('friendgroup')." set cd_name='".$cd_fgName."' where cd_uid='".$qianwei_in_userid."' and cd_id='".$cd_fgid."'");
	echo $cd_fgName;
}else{
	exit('20001');
}
?>