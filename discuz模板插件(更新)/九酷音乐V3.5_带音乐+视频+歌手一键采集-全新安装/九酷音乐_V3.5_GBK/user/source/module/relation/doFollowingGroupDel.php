<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_fgid = SafeRequest("fgid","get");

	$db->query("delete from ".tname('friendgroup')." where cd_uid='".$qianwei_in_userid."' and cd_id='".$cd_fgid."'");
	$db->query("update ".tname('friend')." set cd_group='0' where cd_group='".$cd_fgid."'");
	$db->query("update ".tname('user')." set cd_groupnum=cd_groupnum-1 where cd_groupnum>=1 and cd_id='$qianwei_in_userid'");

	exit($_GET['callback'].'({"error":20000})');
}else{
	exit($_GET['callback'].'({"error":20001})');

}
?>