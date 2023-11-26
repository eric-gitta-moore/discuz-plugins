<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","get");

	if($cd_uid == $qianwei_in_userid){
		exit($_GET['callback'].'({"error":10013})');
	}
	$sql="select cd_id,cd_name,cd_uhits from ".tname('user')." where cd_id='$cd_uid'";
	if($row=$db->getrow($sql)){

		//检测是否已赞过
		$query = "select cd_id,cd_addtime from ".tname('fans')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid'";
		if($rowd = $db->getrow($query)){
			if(DateDiff(date("Y-m-d",strtotime($rowd['cd_addtime'])),date("Y-m-d")) == 0){
				exit($_GET['callback'].'({"error":10002})');
			}else{
				$db->query("update ".tname('fans')." set cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$rowd['cd_id']."'");
				$cd_open = 1;
			}
		}else{
			//入库
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $row['cd_id'],
				'cd_unames' => $row['cd_name'],
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('fans', $setarr, 1);
			$cd_open = 1;
		}
		if($cd_open == 1){
			$db->query("update ".tname('user')." set cd_uhits=cd_uhits+1 where cd_id='$cd_uid'");

			//检测是否已提交通知
			$query = "select cd_id from ".tname('notice')." where cd_icon='praise' and cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid'";
			if($rows = $db->getrow($query)){
				$db->query("update ".tname('notice')." set cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$rows['cd_id']."'");
			}else{
				//入库
				$setarr = array(
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uids' => $row['cd_id'],
					'cd_unames' => $row['cd_name'],
					'cd_icon' => 'praise',
					'cd_data' => '赞了你一下&nbsp;<a href="'.cd_upath.'index.php?p=relation&a=userPraiseIn" target="_blank">查看更多</a>',
					'cd_dataid' => 0,
					'cd_state' => 1,
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('notice', $setarr, 1);
			}


			$fansnum = $db -> num_rows($db -> query("select cd_id from ".tname('fans')." where cd_uid='$qianwei_in_userid' and DateDiff(DATE(cd_addtime),'".date('Y-m-d')."')=0"));
			if(($fansnum*cd_pointsufa) < cd_pointsufc){
				//记录账单-自己
				$setarr = array(
					'cd_type' => 1, //1为加,0为减
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_icon' => 'praise',
					'cd_title' => '赞了别人一下',
					'cd_points' => cd_pointsufa,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
				//奖励经验
				$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsufa.",cd_rank=cd_rank+".cd_pointsufb." where cd_id='$qianwei_in_userid'");
			}

			$fansnums = $db -> num_rows($db -> query("select cd_id from ".tname('fans')." where cd_uid='".$row['cd_id']."' and DateDiff(DATE(cd_addtime),'".date('Y-m-d')."')=0"));
			if(($fansnums*cd_pointsuga) < cd_pointsugc){
				$tomorrow = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+7, date("Y"));
				$cd_enddate = date("Y-m-d H:i:s",$tomorrow);
				//记录账单-对方
				$setarr = array(
					'cd_type' => 1, //1为加,0为减
					'cd_uid' => $row['cd_id'],
					'cd_uname' => $row['cd_name'],
					'cd_icon' => 'praise',
					'cd_title' => '被他人赞了一下',
					'cd_points' => cd_pointsuga,
					'cd_state' => 1,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => $cd_enddate
				);
				inserttable('bill', $setarr, 1);
				//奖励经验
				$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuga.",cd_rank=cd_rank+".cd_pointsugb." where cd_id='".$row['cd_id']."'");
			}

			exit($_GET['callback'].'({"right":"'.($row['cd_uhits']+1).'"})');
		}
	}else{
		exit($_GET['callback'].'({"error":10004})');
	}
}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>