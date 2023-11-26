<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("did","get");
		$sql="select * from ".tname('music')." where CD_ID=".$cd_id;
		if($row=$db->getrow($sql)){
                        @unlink(_qianwei_root_.$row['CD_Url']);
                        @unlink(_qianwei_root_.$row['CD_Pic']);
                        @unlink(_qianwei_root_.$row['CD_Lrc']);
		}
		$db->query("delete from ".tname('feed')." where cd_icon='dance' and cd_dataid=".$cd_id);
		$db->query("delete from ".tname('comment')." where cd_channel=4 and cd_dataid=".$cd_id);
		$db->query("delete from ".tname('music')." where CD_UserID='".$qianwei_in_userid."' and CD_ID = '$cd_id'");
		echo $_GET['callback'].'({"error":10000})';
	}else{
		echo $_GET['callback'].'({"error":20001})';
	}
?>