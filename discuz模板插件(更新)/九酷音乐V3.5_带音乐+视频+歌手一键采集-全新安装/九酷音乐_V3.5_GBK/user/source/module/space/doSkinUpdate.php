<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_path = SafeRequest("skinPath","post");
	$cd_showtype = SafeRequest("showType","post");

	if($cd_showtype){
		$sql="select cd_id,cd_points from ".tname('skin')." where cd_path='$cd_path'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			if($qianwei_in_points<cd_webpoints){
				die('20005');
			}else{
				$db->query("update ".tname('user')." set cd_skinid='".$row['cd_id']."' where cd_id='$qianwei_in_userid'");
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_webpoints." where cd_id='$qianwei_in_userid'");
				die('10000');
			}
		}else{
			die('10004');
		}
	}else{
		$db->query("update ".tname('user')." set cd_skinid='0' where cd_id='$qianwei_in_userid'");
		die('10000');
	}
}else{
	die('20001');
}
?>