<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_nickname = unescape(SafeRequest("nickname","post"));
	$sql="select * from ".tname(user)." where cd_id<>'$qianwei_in_userid' and cd_nicheng='".$cd_nickname."'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		exit('10002');
	}else{
		$db->query("update ".tname('user')." set cd_nicheng='".$cd_nickname."' where cd_id='$qianwei_in_userid'");
		$db->query("update ".tname('music')." set CD_UserNicheng='".$cd_nickname."' where CD_UserID='$qianwei_in_userid'");

		$setarrs = array(
			'cd_uid' => $qianwei_in_userid,
			'cd_uname' => $qianwei_in_username,
			'cd_icon' => 'setting',
			'cd_title' => '修改了昵称',
			'cd_data' => '将昵称从【'.$qianwei_in_nicheng.'】 修改为 【'.$cd_nickname.'】。',
			'cd_image' => '',
			'cd_imagelink' => '',
			'cd_dataid' => $row['cd_id'],
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('feed', $setarrs, 1);
		exit('10000');
	}
}else{
	exit('20001');
}
?>