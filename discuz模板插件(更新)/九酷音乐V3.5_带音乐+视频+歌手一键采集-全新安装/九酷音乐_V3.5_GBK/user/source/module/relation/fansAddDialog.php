<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","get");
	$cd_fgName = unescape(SafeRequest("fg_name","get"));
		$showstr = '[';
        	$query = $db->query("select * from ".tname('friendgroup')." where cd_uid='$qianwei_in_userid' order by cd_id asc LIMIT 0,10");
        	while ($row = $db->fetch_array($query)) {
			$showstr=$showstr.'{"fgid":"'.$row['cd_id'].'","uid":"'.$qianwei_in_userid.'","fg_name":"'.$row['cd_name'].'","num":"'.$row['cd_count'].'"},';
		}
		$showstr = $showstr.']';
		$showstr = ReplaceStr($showstr,",]","]");
		exit($_GET['callback'].'({"error":'.$showstr.',"data":{"uid":'.$cd_uid.',"fgid":0,"is_quietly":0}})');
}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>