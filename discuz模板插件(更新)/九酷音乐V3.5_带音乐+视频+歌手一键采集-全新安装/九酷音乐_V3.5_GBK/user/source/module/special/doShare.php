<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$CD_Name = unescape(SafeRequest("SpecialName","post"));
	$CD_SingerID = unescape(SafeRequest("SingerID","post"));
	$CD_GongSi = unescape(SafeRequest("GongSi","post"));
	$CD_ClassID = SafeRequest("classId","post");
	$CD_YuYan = unescape(SafeRequest("YuYan","post"));
	$CD_Pic = unescape(SafeRequest("Pic","post"));
	$CD_Intro = unescape(SafeRequest("Intro","post"));
	$setarr = array(
		'CD_ClassID' => $CD_ClassID,
		'CD_Name' => $CD_Name,
		'CD_User' => $qianwei_in_username,
		'CD_Pic' => $CD_Pic,
		'CD_SingerID' => $CD_SingerID,
		'CD_GongSi' => $CD_GongSi,
		'CD_YuYan' => $CD_YuYan,
		'CD_Intro' => $CD_Intro,
		'CD_Hits' => 0,
		'CD_IsBest' => 0,
		'CD_Passed' => 1,
		'CD_AddTime' => date('Y-m-d H:i:s')
	);
	inserttable('special', $setarr, 1);
	$row = $db->getrow("select * from ".tname('special')." where CD_User='$qianwei_in_username' and CD_Name='".$CD_Name."' and CD_Pic='".$CD_Pic."' order by CD_ID desc");
	$setarrs = array(
		'cd_uid' => $qianwei_in_userid,
		'cd_uname' => $qianwei_in_username,
		'cd_icon' => 'special',
		'cd_title' => '制作了专辑',
		'cd_data' => '制作了《'.$CD_Name.'》<a href="'.LinkUrl("special",$row['CD_ClassID'],1,$row['CD_ID']).'" target="_blank">试听</a>',
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