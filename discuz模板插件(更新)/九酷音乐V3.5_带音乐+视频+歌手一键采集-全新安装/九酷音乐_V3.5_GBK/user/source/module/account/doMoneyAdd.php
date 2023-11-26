<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$my_array=array('1','0','2','1','0','4','1','0','2','1','0','3','8','1','2','0','5','1','0','2','6','0','1','2','0','9','1','0','7','1','0');
		$integral_a = $my_array[rand(0,30)];
		$integral_b = rand(1,9);
		$integral_c = rand(1,9);
		$sql="select cd_id,cd_uid,cd_uname,cd_addtime from ".tname('slot')." where cd_uid='$qianwei_in_userid'";
		if($row=$db->getrow($sql)){
			if(DateDiff(date("Y-m-d",strtotime($row['cd_addtime'])),date("Y-m-d")) == 0){
				exit($_GET['callback'].'({"error":10003})');
			}else{
				echo $_GET['callback'].'({"right":["'.$integral_a.'","'.$integral_b.'","'.$integral_c.'"]})';
				$db->query("update ".tname('slot')." set cd_number=cd_number+1,cd_points='".$integral_a.$integral_b.$integral_c."',cd_addtime='".date('Y-m-d H:i:s')."' where cd_uid='$qianwei_in_userid'");
			}
		}else{
			echo $_GET['callback'].'({"right":["'.$integral_a.'","'.$integral_b.'","'.$integral_c.'"]})';
			//入库
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_points' => $integral_a.$integral_b.$integral_c,
				'cd_number' => 1,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('slot', $setarr, 1);
		}

		$tomorrow = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+7, date("Y"));
		$cd_enddate = date("Y-m-d H:i:s",$tomorrow);
		//记录账单
		$setarr = array(
			'cd_type' => 1, //1为加,0为减
			'cd_uid' => $qianwei_in_userid,
			'cd_uname' => $qianwei_in_username,
			'cd_icon' => 'app',
			'cd_title' => '幸运摇一摇奖励',
			'cd_points' => $integral_a.$integral_b.$integral_c,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s'),
			'cd_endtime' => $cd_enddate
		);
		inserttable('bill', $setarr, 1);
	}else{
		exit($_GET['callback'].'({"error":20001})');
	}
?>