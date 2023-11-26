<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_type = SafeRequest("type","post");
	$cd_month = SafeRequest("month","post");
	if($qianwei_in_userid == $cd_uid){
		if($cd_type){
			if($cd_month){
				$db->query("delete from ".tname('notice')." where cd_icon='$cd_type' and DateDiff(DATE(cd_addtime),'".date('Y-m-d')."')<=-30 and cd_uids='".$cd_uid."'");
			}else{
				$db->query("delete from ".tname('notice')." where cd_icon='$cd_type' and cd_uids='".$cd_uid."'");
			}
		}else{
			if($cd_month){
				$db->query("delete from ".tname('notice')." where DateDiff(DATE(cd_addtime),'".date('Y-m-d')."')<=-30 and cd_uids='".$cd_uid."'");
			}else{
				$db->query("delete from ".tname('notice')." where cd_uids='".$cd_uid."'");
			}
		}
		exit('10000');
	}else{
		exit('20002');
	}
}else{
	exit('20001');
}
?>