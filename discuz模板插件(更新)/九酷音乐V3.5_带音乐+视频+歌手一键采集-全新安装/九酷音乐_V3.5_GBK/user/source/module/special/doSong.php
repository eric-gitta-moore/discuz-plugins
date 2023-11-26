<?php
include "../source/global/global_inc.php";
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
		$specialid=SafeRequest("specialid","post");
		$joinlist=RequestBox("joinlist");
		$dellist=RequestBox("dellist");
		if(submitcheck('join')){
			$db->query("update ".tname('music')." set CD_SpecialID=".$specialid." where CD_ID in ($joinlist)");
			header("Location:".$_SERVER['HTTP_REFERER']);
		}elseif(submitcheck('del')){
			$db->query("update ".tname('music')." set CD_SpecialID=0 where CD_ID in ($dellist)");
			header("Location:".$_SERVER['HTTP_REFERER']);
		}else{
			echo "<script type=\"text/javascript\">window.location='".$_SERVER['HTTP_REFERER']."'</script>";
		}
}else{
	echo "<script type=\"text/javascript\">window.location='".$_SERVER['HTTP_REFERER']."'</script>";
}
?>