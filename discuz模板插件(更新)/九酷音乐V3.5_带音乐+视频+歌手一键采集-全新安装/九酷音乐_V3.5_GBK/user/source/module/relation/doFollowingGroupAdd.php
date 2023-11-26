<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_fgid = SafeRequest("fgid","post");
	$cd_fgName = unescape(SafeRequest("fgName","post"));

	if($qianwei_in_userid != $cd_uid){
		exit('20002');
	}else{
		if($cd_fgName == ''){
			exit('10007');
		}

		if($qianwei_in_groupnum >= 8){
			exit('100061');
		}

		if(mb_strlen($cd_fgName,'UTF8') > 7){
			exit('10006');
		}

		//入库
		$setarr = array(
			'cd_uid' => $qianwei_in_userid,
			'cd_name' => $cd_fgName,
			'cd_count' => 0
		);
		inserttable('friendgroup', $setarr, 1);
		$db->query("update ".tname('user')." set cd_groupnum=cd_groupnum+1 where cd_id='$qianwei_in_userid'");
        	$showstr='';
        	$query = $db->query("select * from ".tname('friendgroup')." where cd_uid='$cd_uid' order by cd_id asc LIMIT 0,10");
        	while ($row = $db->fetch_array($query)) {

			$showstr=$showstr.'<div class="list"><a class="list_clo" href="'.cd_upath.'index.php?p=relation&a=following&cid=4&fgid='.$row['cd_id'].'">'.$row['cd_name'].'</a></div>';

			//$showstr=$showstr.'<li id="friendGroupLine_'.$row['cd_id'].'"><a id="group_'.$row['cd_id'].'" class="fgName" href="'.cd_upath.'index.php?p=friend&a=friendList&fgid='.$row['cd_id'].'">'.$row['cd_name'].'<span class="fgCount" id="fgCount_'.$row['cd_id'].'">['.$row['cd_count'].']</span></a></li>';
		}
		$showstr=$showstr.'<div class="add"><a onclick="$(\'#friendGroupAdd\').show();$(\'#addGroup1\').hide();" href="javascript:;" id="addGroup1">添加分组</a></div>';
		echo $showstr;
	}
}else{
	exit('20001');
}
?>