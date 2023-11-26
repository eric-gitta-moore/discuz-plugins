<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_pid = SafeRequest("pid","post");
		$cd_uid = SafeRequest("uid","post");
		$cd_nameContent = unescape(SafeRequest("text","post"));
		$sql="select cd_id,cd_uid from ".tname('pic')." where cd_id='$cd_pid'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			if($row['cd_uid'] == $qianwei_in_userid){
				$db->query("update ".tname('pic')." set cd_title='".$cd_nameContent."' where cd_id='$cd_pid'");
				echo $cd_nameContent;
			}else{
				die('20002');
			}
		}else{
			die('30000');
		}
	}else{
		die('20001');
	}
?>