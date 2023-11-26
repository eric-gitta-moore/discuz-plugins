<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","get");
	$cd_fgName = unescape(SafeRequest("fg_name","get"));

		if($cd_fgName == ''){
			exit($_GET['callback'].'({"error":10007})');
		}

		if($qianwei_in_groupnum >= 8){
			exit($_GET['callback'].'({"error":100061})');
		}

		if(mb_strlen($cd_fgName,'UTF8') > 7){
			exit($_GET['callback'].'({"error":10006})');
		}

		//Илїв
		$setarr = array(
			'cd_uid' => $qianwei_in_userid,
			'cd_name' => $cd_fgName,
			'cd_count' => 0
		);
		inserttable('friendgroup', $setarr, 1);
		$db->query("update ".tname('user')." set cd_groupnum=cd_groupnum+1 where cd_id='$qianwei_in_userid'");

		$showstr = '[';
        	$query = $db->query("select * from ".tname('friendgroup')." where cd_uid='$qianwei_in_userid' order by cd_id asc LIMIT 0,10");
        	while ($row = $db->fetch_array($query)) {
			$showstr=$showstr.'{"fgid":"'.$row['cd_id'].'","uid":"'.$row['cd_uid'].'","fg_name":"'.$row['cd_name'].'","num":"'.$row['cd_count'].'"},';
		}
		$showstr = $showstr.']';
		$showstr = ReplaceStr($showstr,",]","]");
		exit($_GET['callback'].'({"error":'.$showstr.',"data":{"uid":'.$cd_uid.',"fgid":0,"is_quietly":0}})');

}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>