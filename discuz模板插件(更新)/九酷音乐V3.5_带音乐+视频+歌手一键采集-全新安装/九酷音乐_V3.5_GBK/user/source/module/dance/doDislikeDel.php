<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("did","get");
		$db->query("delete from ".tname('dislike')." where cd_uid='".$qianwei_in_userid."' and cd_musicid = '$cd_id'");
		$db->query("update ".tname('music')." set CD_BadHits=CD_BadHits-1 where CD_BadHits>=1 and CD_ID='".$cd_id."'");
		echo $_GET['callback'].'({"error":10000})';
	}else{
		echo $_GET['callback'].'({"error":20001})';
	}
?>