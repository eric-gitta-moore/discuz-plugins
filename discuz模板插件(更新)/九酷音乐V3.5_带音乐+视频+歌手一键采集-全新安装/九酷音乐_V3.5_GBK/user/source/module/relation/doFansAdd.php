<?php
include "../source/global/global_inc.php";
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","get","true");
	$cd_fgid = SafeRequest("fgid","get","true");
	$cd_isquietly = SafeRequest("is_quietly","get","true");

	if($qianwei_in_userid == $cd_uid){
		exit($_GET['callback'].'({"error":10013})');
	}else{
		$sql="select cd_id,cd_name from ".tname('user')." where cd_lock=0 and cd_id='$cd_uid'";
		if($row=$db->getrow($sql)){
			$cd_uids=$row['cd_id'];
			$cd_unames=$row['cd_name'];

			//检测分组是否存在
			if($cd_fgid){
        			$cd_groupid = $db->getone("select cd_id from ".tname('friendgroup')." where cd_uid='$qianwei_in_userid' and cd_id='$cd_fgid'");
				if(!$cd_groupid){exit($_GET['callback'].'({"error":10007})');}
			}

			//检测是否已关注
        		$cd_ida = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uids'");
			if($cd_ida){exit($_GET['callback'].'({"error":10003})');}

        		$cd_idb = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$cd_uids' and cd_uids='$qianwei_in_userid'");
			if($cd_idb){
				$db->query("update ".tname('friend')." set cd_lock=1 where cd_uid='$cd_uids' and cd_uids='$qianwei_in_userid'");
       				$cd_lock = 1;
			}else{
        			$cd_lock = 0;
			}


			//检测是否悄悄关注
			if($cd_isquietly == 1){
        			$cd_hidden = 1;
			}else{
        			$cd_hidden = 0;
			}

			//$cd_friendid = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$cd_uid' and cd_uids='$qianwei_in_userid'");
			//if($cd_friendid){
			//	exit($_GET['callback'].'({"error":10007})');
			//}


			//检测关注数量
			//if(!$cd_groupid){exit($_GET['callback'].'({"error":10006})');}

			//入库
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $cd_uids,
				'cd_unames' => $cd_unames,
				'cd_lock' => $cd_lock,
				'cd_note' => '',
				'cd_group' => $cd_fgid,
				'cd_hidden' => $cd_hidden,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('friend', $setarr, 1);
			$db->query("update ".tname('user')." set cd_fansnum=cd_fansnum+1 where cd_id='$cd_uid'");
			$db->query("update ".tname('user')." set cd_idolnum=cd_idolnum+1 where cd_id='$qianwei_in_userid'");

			//检测是否已提交通知
			$query = "select cd_id from ".tname('notice')." where cd_icon='fans' and cd_uid='$qianwei_in_userid' and cd_uids='$cd_uids'";
			if($rows = $db->getrow($query)){
				$db->query("update ".tname('notice')." set cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$rows['cd_id']."'");
			}else{
				//入库
				$setarr = array(
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uids' => $cd_uids,
					'cd_unames' => $cd_unames,
					'cd_icon' => 'fans',
					'cd_data' => '关注了您&nbsp;<a href="'.linkweburl($qianwei_in_userid,$qianwei_in_username).'" target="_blank">立即查看</a>',
					'cd_dataid' => 0,
					'cd_state' => 1,
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('notice', $setarr, 1);
			}
			exit($_GET['callback'].'({"error":1})');
		}else{
			exit($_GET['callback'].'({"error":10004})');
		}
	}
}else{
	exit($_GET['callback'].'({"error":20001})');
}
?>