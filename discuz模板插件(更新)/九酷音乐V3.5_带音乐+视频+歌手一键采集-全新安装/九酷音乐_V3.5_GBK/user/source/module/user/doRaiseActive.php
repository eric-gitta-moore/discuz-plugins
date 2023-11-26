<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$sql="select cd_id,cd_points from ".tname('user')." where cd_lock=0 and DateDiff(DATE(cd_logintime),'".date('Y-m-d')."')>=-3 and cd_id='$qianwei_in_userid'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		if($row['cd_points']<10){
			exit($_GET['callback'].'({"error":20005})');
		}else{
			$db->query("update ".tname('user')." set cd_points=cd_points-10,cd_hits=cd_hits+10 where cd_id='".$row['cd_id']."'");

			//记录账单
			$setarr = array(
				'cd_type' => 0, //1为加,0为减
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_icon' => 'active',
				'cd_title' => '提升活跃用户',
				'cd_points' => 10,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('bill', $setarr, 1);

			exit($_GET['callback'].'({"error":10000})');
		}
	}else{
		exit($_GET['callback'].'({"error":10011})');
	}
}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>