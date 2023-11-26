<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$sql="select cd_id,cd_name,cd_sign,cd_signtime from ".tname('user')." where cd_id='$qianwei_in_userid'";
		if($row=$db->getrow($sql)){
			if(DateDiff(date("Y-m-d",strtotime($row['cd_signtime'])),date("Y-m-d")) == 0){
				echo $_GET['callback'].'({"error":10002})';
			}else{
				if(DateDiff(date("Y-m-d",strtotime($row['cd_signtime'])),date('Y-m-d' , strtotime('-1 day'))) == 0){
					$db->query("update ".tname('user')." set cd_sign=cd_sign+1,cd_signcumu=cd_signcumu+1,cd_signtime='".date('Y-m-d H:i:s')."' where cd_id='$qianwei_in_userid'");
					$cd_sign = ($row['cd_sign']+1);
				}else{
					$db->query("update ".tname('user')." set cd_sign=1,cd_signcumu=cd_signcumu+1,cd_signtime='".date('Y-m-d H:i:s')."' where cd_id='$qianwei_in_userid'");
					$cd_sign = 1;
				}
				if($cd_sign > 10){
					$cd_points = 100;
				}elseif($cd_sign >= 4 && $cd_sign <= 10){
					$cd_points = 50;
				}else{
					$cd_points = 30;
				}
				$db->query("update ".tname('user')." set cd_points=cd_points+".$cd_points." where cd_id='$qianwei_in_userid'");

				//记录账单
				$setarr = array(
					'cd_type' => 1, //1为加,0为减
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_icon' => 'sign',
					'cd_title' => '每日签到',
					'cd_points' => $cd_points,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);

				echo $_GET['callback'].'({"sign_num":'.$cd_sign.',"score":'.$cd_points.'})';
			}
		}
	}else{
		echo $_GET['callback'].'({"error":20001})';

	}
?>