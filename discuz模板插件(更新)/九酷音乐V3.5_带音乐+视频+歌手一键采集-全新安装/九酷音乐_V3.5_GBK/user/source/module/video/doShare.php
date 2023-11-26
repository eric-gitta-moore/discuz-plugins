<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$CD_Name = unescape(SafeRequest("videoName","post"));
	$CD_SingerID = unescape(SafeRequest("SingerID","post"));
	$CD_ClassID = SafeRequest("classId","post");
	$CD_Play = unescape(SafeRequest("Play","post"));
	$CD_Pic = unescape(SafeRequest("Pic","post"));
	$setarr = array(
		'CD_ClassID' => $CD_ClassID,
		'CD_Name' => $CD_Name,
		'CD_User' => $qianwei_in_username,
		'CD_Pic' => $CD_Pic,
		'CD_SingerID' => $CD_SingerID,
		'CD_Play' => $CD_Play,
		'CD_Hits' => 0,
		'CD_IsIndex' => 1,
		'CD_IsBest' => 0,
		'CD_Color' => '',
		'CD_AddTime' => date('Y-m-d H:i:s')
	);
	inserttable('video', $setarr, 1);
	$row = $db->getrow("select * from ".tname('video')." where CD_User='$qianwei_in_username' and CD_Name='".$CD_Name."' and CD_Pic='".$CD_Pic."' order by CD_ID desc");
	$setarrs = array(
		'cd_uid' => $qianwei_in_userid,
		'cd_uname' => $qianwei_in_username,
		'cd_icon' => 'video',
		'cd_title' => '发布了视频',
		'cd_data' => '发布了《'.$CD_Name.'》<a href="'.LinkUrl("video",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">播放</a>',
		'cd_image' => '',
		'cd_imagelink' => '',
		'cd_dataid' => $row['CD_ID'],
		'cd_addtime' => date('Y-m-d H:i:s')
	);
	inserttable('feed', $setarrs, 1);
}else{
	exit('1001');
}
?>