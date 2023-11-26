<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("did","get");
		$db->query("delete from ".tname('fav')." where cd_uid='".$qianwei_in_userid."' and cd_musicid = '$cd_id'");
		$db->query("delete from ".tname('feed')." where cd_icon='favorites' and cd_dataid=".$cd_id);
		$db->query("update ".tname('user')." set cd_favnum=cd_favnum-1 where cd_id=".$qianwei_in_userid);
		$db->query("update ".tname('music')." set CD_FavHits=CD_FavHits-1 where CD_FavHits>=1 and CD_ID='".$cd_id."'");
		echo $_GET['callback'].'({"error":10000})';
	}else{
		echo $_GET['callback'].'({"error":20001})';
	}
?>