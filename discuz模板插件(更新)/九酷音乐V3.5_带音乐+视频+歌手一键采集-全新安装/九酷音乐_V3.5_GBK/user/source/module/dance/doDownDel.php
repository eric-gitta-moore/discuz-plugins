<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("did","get");
		$db->query("delete from ".tname('down')." where cd_uid='".$qianwei_in_userid."' and cd_musicid = '$cd_id'");
		$db->query("delete from ".tname('feed')." where cd_icon='down' and cd_dataid=".$cd_id);
		$db->query("update ".tname('music')." set CD_DownHits=CD_DownHits-1 where CD_DownHits>=1 and CD_ID='".$cd_id."'");
		echo $_GET['callback'].'({"error":10000})';
	}else{
		echo $_GET['callback'].'({"error":20001})';
	}
?>