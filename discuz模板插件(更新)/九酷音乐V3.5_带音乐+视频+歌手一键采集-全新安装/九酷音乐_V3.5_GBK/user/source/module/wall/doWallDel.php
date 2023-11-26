<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_uid = unescape(SafeRequest("uid","post"));
		$cd_cid = unescape(SafeRequest("cid","post"));
		if($cd_cid == 0){
			$cd_id = unescape(SafeRequest("wid","post"));
		}else{
			$cd_id = unescape(SafeRequest("cid","post"));
		}

		$sql = "select * from ".tname('wall')." where cd_id='".$cd_id."'";
		if($row = $db->getrow($sql)){
			if($cd_uid == $qianwei_in_userid){
				if($row['cd_wallid'] == 0){
					$db->query("delete from ".tname('wall')." where cd_wallid=0 and cd_id='$cd_id'");
					$db->query("delete from ".tname('wall')." where cd_wallid='$cd_id'");
				}else{
					$db->query("delete from ".tname('wall')." where cd_wallid<>0 and cd_id='$cd_id'");
					$showstr='';
        				$query = $db->query("select * from ".tname('wall')." where cd_wallid='".$row['cd_wallid']."' order by cd_addtime desc LIMIT 0,100");
        				while ($rows = $db->fetch_array($query)) {
						$showstr=$showstr.'<div class="wallComment">';
						$showstr=$showstr.'<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
						$showstr=$showstr.'<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
						$showstr=$showstr.'<div class="wC_top">';
						$showstr=$showstr.'<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'</a></span>';
						if($cd_uid == $qianwei_in_userid){
							$showstr=$showstr.'<span id="del-c'.$rows['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$row['cd_uid'].', '.$rows['cd_id'].', '.$row['cd_id'].', 0)});"></span>';
						}
						$showstr=$showstr.'<span class="others">';
						$showstr=$showstr.'<span class="createTime">'.datetime($rows['cd_addtime']).'</span>';
						if($cd_uid != $qianwei_in_userid){
							$showstr=$showstr.'<span><a href="javascript:;" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', '.$rows['cd_id'].', '.$rows['cd_uid'].', \''.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'\', 0)});">回复</a></span>';
						}
						$showstr=$showstr.'</span>';
						$showstr=$showstr.'</div>';
						$showstr=$showstr.'<div class="wC_text">'.$rows['cd_content'].'</div>';
						$showstr=$showstr.'</div>';
						$showstr=$showstr.'</div>';
						$showstr=$showstr.'<div id="exp"></div>';
					}
					echo $showstr;
				}
				if($row['cd_uid'] != $qianwei_in_userid){
					if(cd_pointsdea >= 1){ //大于1才记录
						//记录账单
						$setarr = array(
							'cd_type' => 0, //1为加,0为减
							'cd_uid' => $row['cd_uid'],
							'cd_uname' => $row['cd_uname'],
							'cd_icon' => 'wall',
							'cd_title' => '留言被删除',
							'cd_points' => cd_pointsdea,
							'cd_addtime' => date('Y-m-d H:i:s')
						);
						inserttable('bill', $setarr, 1);
					}
					$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdea." where cd_points>=1 and cd_id='".$row['cd_uid']."'");
					$db->query("update ".tname('user')." set cd_rank=cd_rank-".cd_pointsdeb." where cd_rank>=1 and cd_id='".$row['cd_uid']."'");
				}
			}else{
				die('20002');
			}
		}else{
			die('10004');
		}
	}else{
		die('20001');
	}
?>