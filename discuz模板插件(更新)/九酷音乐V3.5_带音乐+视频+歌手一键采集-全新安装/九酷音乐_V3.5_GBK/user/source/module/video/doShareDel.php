<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("did","get");
		$sql="select * from ".tname('video')." where CD_ID=".$cd_id;
		if($row=$db->getrow($sql)){
                        @unlink(_qianwei_root_.$row['CD_Play']);
                        @unlink(_qianwei_root_.$row['CD_Pic']);
		}
		$db->query("delete from ".tname('feed')." where cd_icon='video' and cd_dataid=".$cd_id);
		$db->query("delete from ".tname('video')." where CD_User='".$qianwei_in_username."' and CD_ID = '$cd_id'");
		echo $_GET['callback'].'({"error":10000})';
	}else{
		echo $_GET['callback'].'({"error":20001})';
	}
?>