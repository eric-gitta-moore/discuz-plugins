<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$CD_Name = unescape(SafeRequest("singerName","post"));
	$CD_Area = unescape(SafeRequest("Area","post"));
	$CD_Pic = unescape(SafeRequest("Pic","post"));
	$CD_Intro = unescape(SafeRequest("Intro","post"));
	$setarr = array(
		'CD_Name' => $CD_Name,
		'CD_User' => $qianwei_in_username,
		'CD_Pic' => $CD_Pic,
		'CD_Area' => $CD_Area,
		'CD_Intro' => $CD_Intro,
		'CD_Hits' => 0,
		'CD_IsBest' => 0,
		'CD_Passed' => 1,
		'CD_AddTime' => date('Y-m-d H:i:s')
	);
	inserttable('singer', $setarr, 1);
	$row = $db->getrow("select * from ".tname('singer')." where CD_User='$qianwei_in_username' and CD_Name='".$CD_Name."' and CD_Pic='".$CD_Pic."' order by CD_ID desc");
	$setarrs = array(
		'cd_uid' => $qianwei_in_userid,
		'cd_uname' => $qianwei_in_username,
		'cd_icon' => 'singer',
		'cd_title' => '创建了歌手',
		'cd_data' => '创建了《'.$CD_Name.'》<a href="'.LinkUrl("singer",$row['CD_ID'],1,$row['CD_ID']).'" target="_blank">查看</a>',
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