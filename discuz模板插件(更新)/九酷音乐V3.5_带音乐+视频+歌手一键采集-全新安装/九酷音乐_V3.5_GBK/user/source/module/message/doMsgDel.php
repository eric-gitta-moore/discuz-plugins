<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_fromUid = SafeRequest("fromUid","post");
	$cd_toUid = SafeRequest("toUid","post");
	$cd_type = SafeRequest("type","post");

	if($cd_type==0){
		$db->query("delete from ".tname('message')." where cd_uids='".$qianwei_in_userid."'");
	}else{
		$sql="select * from ".tname('message')." where cd_uid='$cd_toUid' and cd_uids='$cd_fromUid'";
		if($row=$db->getrow($sql)){
			$db->query("delete from ".tname('message')." where cd_id='".$row['cd_id']."'");
			$db->query("delete from ".tname('message')." where cd_dataid='".$row['cd_id']."'");
		}else{
			exit('20002');
		}
	}
}else{
	exit('20001');
}
?>