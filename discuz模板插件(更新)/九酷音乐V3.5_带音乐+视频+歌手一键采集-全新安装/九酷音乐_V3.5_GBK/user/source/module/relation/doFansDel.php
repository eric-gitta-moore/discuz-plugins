<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","get");
	$sql="select cd_id,cd_uids,cd_unames from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid'";
	if($row=$db->getrow($sql)){
		$db->query("delete from ".tname('friend')." where cd_id='".$row['cd_id']."'");
		$db->query("update ".tname('friend')." set cd_lock=0 where cd_uid='$cd_uid' and cd_uids='$qianwei_in_userid'");
		$db->query("update ".tname('user')." set cd_fansnum=cd_fansnum-1 where cd_fansnum>=1 and cd_id='$cd_uid'");
		$db->query("update ".tname('user')." set cd_idolnum=cd_idolnum-1 where cd_idolnum>=1 and cd_id='$qianwei_in_userid'");

		//提交通知
		$setarr = array(
			'cd_uid' => $qianwei_in_userid,
			'cd_uname' => $qianwei_in_username,
			'cd_uids' => $row['cd_uids'],
			'cd_unames' => $row['cd_unames'],
			'cd_icon' => 'fans',
			'cd_data' => '已取消对您的关注&nbsp;<a href="'.linkweburl($qianwei_in_userid,$qianwei_in_username).'" target="_blank">立即查看</a>',
			'cd_dataid' => 0,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('notice', $setarr, 1);

		exit($_GET['callback'].'({"error":10000})');
	}else{
		exit($_GET['callback'].'({"error":10004})');
	}
}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>