<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_wallId = SafeRequest("wid","post");
	$cd_uid = SafeRequest("uid","post");
	$cd_note = unescape(SafeRequest("content","post"));
	$cd_replayUser = unescape(SafeRequest("replayUser","post"));

	$sql = "Select * from ".tname('wall')." where cd_id='".$cd_wallId."'";
	if($row = $db->getrow($sql)){
		$qianwei_in_a = explode("[",$cd_replayUser);
		$qianwei_in_b = str_replace("回复@","",$qianwei_in_a[0]);
		$qianwei_in_c = str_replace("]","",isset($qianwei_in_a[1])?$qianwei_in_a[1]:NULL);
		$cd_unames = $qianwei_in_b;
		$cd_uids = $qianwei_in_c;
		$cd_replayUsers = '';
		if($cd_replayUser){
			$cd_replayUsers = '回复<a href="'.cd_upath.rewrite_url('index.php?p=space&uid='.$cd_uids).'" target="_blank">@'.$cd_unames.'</a>:';
		}

		if($cd_note == ""){
			die('10007');
		}else{
        		$cookies="comment_add_".$qianwei_in_userid;
			if(!empty($_COOKIE[$cookies])){
				die('10012');
			}else{
				setcookie($cookies,"have",time()+1);
				//入库
				$setarr = array(
					'cd_wallid' => $cd_wallId,
					'cd_dataid' => $cd_uid,
					'cd_content' => $cd_replayUsers.$cd_note,
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uip' => getonlineip(),
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('wall', $setarr, 1);

				if($cd_uid  != $qianwei_in_userid){
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $row['cd_uid'],
						'cd_unames' => $row['cd_uname'],
						'cd_icon' => 'wall',
						'cd_data' => '评论了&nbsp;<strong>您</strong>&nbsp;留言板上的回复&nbsp;<a href="'.cd_upath.'index.php?p=space&a=wall&uid='.$row['cd_uid'].'&id='.$cd_wallId.'" target="_blank">查看详情</a>',
						'cd_dataid' => $cd_wallId,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}else{
					if($row['cd_uid']  != $qianwei_in_userid){
						//入库
						$setarr = array(
							'cd_uid' => $qianwei_in_userid,
							'cd_uname' => $qianwei_in_username,
							'cd_uids' => $row['cd_uid'],
							'cd_unames' => $row['cd_uname'],
							'cd_icon' => 'wall',
							'cd_data' => '评论了您给&nbsp;<strong>TA</strong>&nbsp;的留言&nbsp;<a href="'.cd_upath.'index.php?p=space&a=wall&uid='.$qianwei_in_userid.'&id='.$cd_wallId.'" target="_blank">查看详情</a>',
							'cd_dataid' => $cd_wallId,
							'cd_state' => 1,
							'cd_addtime' => date('Y-m-d H:i:s')
						);
						inserttable('notice', $setarr, 1);
					}
				}
				$showstr='';
        			$query = $db->query("select * from ".tname('wall')." where cd_wallid='".$cd_wallId."' order by cd_addtime desc LIMIT 0,100");
        			while ($rows = $db->fetch_array($query)) {
					$users = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
					$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);

					$showstr=$showstr.'<div class="wallComment">';
					$showstr=$showstr.'<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
					$showstr=$showstr.'<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
					$showstr=$showstr.'<div class="wC_top">';
					$showstr=$showstr.'<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$users['cd_nicheng'].'</a>';
					$showstr=$showstr.CheckCertify($users['cd_checkmusic'],$users['cd_checkmm'],$users['cd_grade'],$users['cd_viprank']);
					$showstr=$showstr.'</span>';
					if($cd_uid == $qianwei_in_userid){
						$showstr=$showstr.'<span id="del-c'.$rows['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$cd_uid.', '.$row['cd_id'].', '.$rows['cd_id'].', 0)});"></span>';
					}
					$showstr=$showstr.'<span class="others">';
					$showstr=$showstr.'<span class="createTime">'.datetime($rows['cd_addtime']).'</span>';
					if($rows['cd_uid'] != $qianwei_in_userid){
						$showstr=$showstr.'<span><a href="javascript:;" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', '.$rows['cd_id'].', '.$rows['cd_uid'].', \''.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'\', 0)});">回复</a></span>';
					}
					$showstr=$showstr.'</span>';
					$showstr=$showstr.'</div>';
					$showstr=$showstr.'<div class="wC_text">'.$cd_contents.'</div>';
					$showstr=$showstr.'</div>';
					$showstr=$showstr.'</div>';
					$showstr=$showstr.'<div id="exp"></div>';
				}
				echo $showstr;
			}
		}
	}else{
		die('10004');
	}
}else{
	die('20001');
}
?>