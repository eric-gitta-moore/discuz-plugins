<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("bid","post");
		$cd_uid = SafeRequest("uid","post");
		$sql="select cd_id,cd_uid from ".tname('blog')." where cd_id='$cd_id'";
		if($row=$db->getrow($sql)){
			if($row['cd_uid'] == $qianwei_in_userid){
				$db->query("delete from ".tname('blog')." where cd_uid='".$cd_uid."' and cd_id='".$row['cd_id']."'");
				$db->query("delete from ".tname('comment')." where cd_channel=0 and cd_dataid='".$row['cd_id']."'");
				$db->query("delete from ".tname('feed')." where cd_icon='miniblog' and cd_dataid='".$row['cd_id']."'");

				if(cd_pointsdaa >= 1){ //大于1才记录
					//记录账单
					$setarr = array(
						'cd_type' => 0, //1为加,0为减
						'cd_uid' => $row['cd_uid'],
						'cd_uname' => $row['cd_uname'],
						'cd_icon' => 'miniblog',
						'cd_title' => '说说被删除',
						'cd_points' => cd_pointsdaa,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('bill', $setarr, 1);
				}

				//惩罚经验
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdaa." where cd_points>=1 and cd_id='".$row['cd_uid']."'");
				$db->query("update ".tname('user')." set cd_rank=cd_rank-".cd_pointsdab." where cd_rank>=1 and cd_id='".$row['cd_uid']."'");
			}else{
				exit('20002');
			}
		}else{
			die('10004');
		}
	}else{
		exit('20001');
	}
?>