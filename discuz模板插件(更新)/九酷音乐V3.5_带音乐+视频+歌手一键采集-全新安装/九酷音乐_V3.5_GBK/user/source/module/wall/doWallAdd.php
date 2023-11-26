<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_wallContent = unescape(SafeRequest("wallContent","post"));

	if($cd_wallContent == ""){
		exit('10007');
	}else{
        	$cookies="wall_add_$cd_uid";
		if($_COOKIE[$cookies]=="yes"){
			exit('10002');
		}else{
			setcookie($cookies,"yes",time()+30);
			//入库
			$setarr = array(
				'cd_wallid' => 0,
				'cd_dataid' => $cd_uid,
				'cd_content' => $cd_wallContent,
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uip' => getonlineip(),
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('wall', $setarr, 1);

			if($cd_uid  != $qianwei_in_userid){
				//检测是否已提交通知
				$query = "select cd_id from ".tname('notice')." where cd_icon='wall' and cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid'";
				if($rows = $db->getrow($query)){
					$db->query("update ".tname('notice')." set cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$rows['cd_id']."'");
				}else{
					$user = $db->getrow("select cd_name from ".tname('user')." where cd_id='".$cd_uid."'");
					$rsc = $db->getrow("select cd_id from ".tname('wall')." where cd_uid='$qianwei_in_userid' and cd_dataid='$cd_uid' order by cd_id desc");
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $cd_uid,
						'cd_unames' => $user['cd_name'],
						'cd_icon' => 'wall',
						'cd_data' => '给你留言了&nbsp;<a href="'.cd_upath.'index.php?p=space&a=wall&uid='.$cd_uid.'&id='.$rsc['cd_id'].'" target="_blank">查看详情</a>',
						'cd_dataid' => 0,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}
			}
		}

	}
}else{
	exit('20001');
}
?>