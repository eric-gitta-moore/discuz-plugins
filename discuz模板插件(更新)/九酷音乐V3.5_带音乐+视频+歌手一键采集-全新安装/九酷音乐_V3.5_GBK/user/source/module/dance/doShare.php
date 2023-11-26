<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$CD_Name = unescape(SafeRequest("danceName","post"));
	$CD_SingerID = unescape(SafeRequest("SingerID","post"));
	$CD_ClassID = SafeRequest("classId","post");
	$CD_SpecialID = SafeRequest("SpecialID","post");
	$CD_Url = unescape(SafeRequest("Url","post"));
	$CD_Server = SafeRequest("Server","post");
	$CD_Pic = unescape(SafeRequest("Pic","post"));
	$CD_Lrc = unescape(SafeRequest("Lrc","post"));
	$CD_Note = unescape(SafeRequest("note","post"));
	$setarr = array(
		'CD_Name' => $CD_Name,
		'CD_ClassID' => $CD_ClassID,
		'CD_SpecialID' => $CD_SpecialID,
		'CD_SingerID' => $CD_SingerID,
		'CD_UserID' => $qianwei_in_userid,
		'CD_User' => $qianwei_in_username,
		'CD_UserNicheng' => $qianwei_in_nicheng,
		'CD_Pic' => $CD_Pic,
		'CD_Url' => $CD_Url,
		'CD_DownUrl' => $CD_Url,
		'CD_Word' => $CD_Note,
		'CD_Lrc' => $CD_Lrc,
		'CD_Hits' => 0,
		'CD_DownHits' => 0,
		'CD_FavHits' => 0,
		'CD_DianGeHits' => 0,
		'CD_GoodHits' => 0,
		'CD_BadHits' => 0,
		'CD_AddTime' => date('Y-m-d H:i:s'),
		'CD_Server' => $CD_Server,
		'CD_Deleted' => 0,
		'CD_IsBest' => 0,
		'CD_Error' => 0,
		'CD_Passed' => 1,
		'CD_Points' => 0,
		'CD_Grade' => 3,
		'CD_Color' => '',
		'CD_Skin' => 'play.html'
	);
	inserttable('music', $setarr, 1);
	$row = $db->getrow("select * from ".tname('music')." where CD_User='$qianwei_in_username' and CD_Name='".$CD_Name."' and CD_Url='".$CD_Url."' order by CD_ID desc");
	$setarrs = array(
		'cd_uid' => $qianwei_in_userid,
		'cd_uname' => $qianwei_in_username,
		'cd_icon' => 'dance',
		'cd_title' => '分享了音乐',
		'cd_data' => '分享了《'.$CD_Name.'》<a href="'.LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">试听</a>',
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