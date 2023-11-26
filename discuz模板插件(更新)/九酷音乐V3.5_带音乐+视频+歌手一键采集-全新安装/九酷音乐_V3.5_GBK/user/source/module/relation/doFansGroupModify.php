<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_fgid = SafeRequest("fgid","get");
	$cd_uid = SafeRequest("uid","get");
	$cd_fgName = unescape(SafeRequest("fg_name","get"));

	$querys = "select cd_id from ".tname('friendgroup')." where cd_id='$cd_fgid'";
	if($rows = $db->getrow($querys)){
		if($cd_fgName == ''){
			exit($_GET['callback'].'({"error":10007})');
		}

		if(mb_strlen($cd_fgName,'UTF8') > 7){
			exit($_GET['callback'].'({"error":10006})');
		}

		$showstr = '[';
		$db->query("update ".tname('friendgroup')." set cd_name='".$cd_fgName."' where cd_uid='".$qianwei_in_userid."' and cd_id='".$cd_fgid."'");
        	$query = $db->query("select * from ".tname('friendgroup')." where cd_uid='$qianwei_in_userid' order by cd_id asc LIMIT 0,10");
        	while ($row = $db->fetch_array($query)) {
			$showstr=$showstr.'{"fgid":"'.$row['cd_id'].'","uid":"'.$row['cd_uid'].'","fg_name":"'.$row['cd_name'].'","num":"'.$row['cd_count'].'"},';
		}
		$showstr = $showstr.']';
		$showstr = ReplaceStr($showstr,",]","]");
		exit($_GET['callback'].'({"error":'.$showstr.',"data":{"uid":'.$cd_uid.',"fgid":'.$cd_fgid.',"is_quietly":0}})');
	}else{
		exit($_GET['callback'].'({"error":20002})');
	}
}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>