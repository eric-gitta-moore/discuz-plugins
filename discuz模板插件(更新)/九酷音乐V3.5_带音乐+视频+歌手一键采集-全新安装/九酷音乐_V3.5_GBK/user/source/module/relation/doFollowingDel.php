<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_friend_uid = SafeRequest("friend_uid","post");
	$cd_uid = SafeRequest("uid","post");
	if($qianwei_in_userid != $cd_uid){
		exit('20002');
	}
	$sql="select cd_id,cd_unames from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_friend_uid'";
	if($row=$db->getrow($sql)){
		$db->query("delete from ".tname('friend')." where cd_id='".$row['cd_id']."'");
		$db->query("update ".tname('user')." set cd_fansnum=cd_fansnum-1 where cd_fansnum>=1 and cd_id='$cd_friend_uid'");
		$db->query("update ".tname('user')." set cd_idolnum=cd_idolnum-1 where cd_idolnum>=1 and cd_id='$qianwei_in_userid'");
	}else{
		exit('10000');
	}
}else{
	exit('20001');
}
?>