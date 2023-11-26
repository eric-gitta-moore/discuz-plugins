<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_newfgid = SafeRequest("newfgid","post");
	$cd_oldfgid = SafeRequest("oldfgid","post");
	$cd_uid = SafeRequest("friend_uid","post");
	$cd_isquietly = SafeRequest("is_quietly","post");

	$query = "select cd_id from ".tname('friend')." where cd_uid='".$qianwei_in_userid."' and cd_uids='$cd_uid'";
	if($row = $db->getrow($query)){
		$db->query("update ".tname('friend')." set cd_group='$cd_newfgid' where cd_id='".$row['cd_id']."'");
		if($cd_isquietly){
			$db->query("update ".tname('friend')." set cd_hidden=1 where cd_uids='".$cd_uid."' and cd_uid='".$qianwei_in_userid."'");
		}else{
			$db->query("update ".tname('friend')." set cd_hidden=0 where cd_uids='".$cd_uid."' and cd_uid='".$qianwei_in_userid."'");
		}
		$db->query("update ".tname('friendgroup')." set cd_count=cd_count+1 where cd_uid='".$qianwei_in_userid."' and cd_id='$cd_newfgid'");
		$db->query("update ".tname('friendgroup')." set cd_count=cd_count-1 where cd_uid='".$qianwei_in_userid."' and cd_id='$cd_oldfgid'");
	}
	$sql = "select cd_id,cd_name from ".tname('friendgroup')." where cd_id='$cd_newfgid'";
	if($rows = $db->getrow($sql)){
		echo $rows['cd_name'];
	}else{
		echo 'ฮดทึื้';
	}
}else{
	exit('20001');
}
?>