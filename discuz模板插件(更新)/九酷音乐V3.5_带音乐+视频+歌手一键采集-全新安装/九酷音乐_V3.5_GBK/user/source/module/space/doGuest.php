<?php
include "../source/global/global_inc.php";
close_browse();

	$cd_uid = SafeRequest("uid","post");
	global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$sql="select cd_id,cd_name from ".tname('user')." where cd_id='$cd_uid'";
		if($row=$db->getrow($sql)){
			$cd_uids = $row['cd_id'];
			$cd_unames = $row['cd_name'];
			if($cd_uid != $qianwei_in_userid){

				//奖励
				$cookies="web_user_".$cd_uid;
				if(empty($_COOKIE[$cookies])){
					setcookie($cookies,"have",time()+86400);
					$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuba.",cd_rank=cd_rank+".cd_pointsubb." where cd_id='$qianwei_in_userid'");
				}

				//检测是否已存在
        			$cd_id= $db->getone("select cd_id from ".tname('footprints')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uids'");
				if($cd_id){
					//更新
					$db->query("update ".tname('footprints')." set cd_addtime='".date('Y-m-d H:i:s')."' where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uids'");
				}else{
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $cd_uids,
						'cd_unames' => $cd_unames,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('footprints', $setarr, 1);
				}


			}
		}
	}
	$showstr='';
	$query = $db->query("select cd_uid,cd_uname,cd_addtime from ".tname('footprints')." where cd_uids='$cd_uid' order by cd_addtime desc LIMIT 0,16");
	while ($rows = $db->fetch_array($query)) {
		$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
		$showstr=$showstr.'<li>';
		$showstr=$showstr.'<div class="friendAvatar">';
		$showstr=$showstr.'<a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img width="48" height="48" src="'.getavatar($rows['cd_uid'],48).'"/></a>';
		$showstr=$showstr.'</div>';
		$showstr=$showstr.'<div class="friendInfo">';
		$showstr=$showstr.'<span><a title="'.$user['cd_nicheng'].'" href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"';
		if(CheckLogin($rows['cd_uid'])){
			$showstr=$showstr.' class="online_icon"';
		}
		$showstr=$showstr.'>'.$user['cd_nicheng'].'</a></span>';
		$showstr=$showstr.'<p>'.date('m',strtotime($rows['cd_addtime'])).'月'.date('d',strtotime($rows['cd_addtime'])).'日</p>';
		$showstr=$showstr.'</div>';
		$showstr=$showstr.'</li>';
	}
	echo $showstr;
?>