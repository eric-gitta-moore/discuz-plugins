<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("cid","post");
		$cd_uid = SafeRequest("uid","post");
		$cd_pid = SafeRequest("pid","post");

		$sql="select cd_id,cd_uid,cd_dataid,cd_uname from ".tname('comment')." where cd_channel=1 and cd_id='$cd_id'";
		if($row=$db->getrow($sql)){
			$pic=$db->getrow("select cd_uid from ".tname('pic')." where cd_id='$cd_pid'");
			if($pic['cd_uid'] == $qianwei_in_userid){
				$db->query("delete from ".tname('comment')." where cd_channel=1 and cd_dataid='$cd_pid' and cd_id='$cd_id'");
				$db->query("update ".tname('pic')." set cd_replynum=cd_replynum-1 where cd_replynum>=1 and cd_id='$cd_pid'");

				if(cd_pointsdda >= 1){ //大于1才记录
					//记录账单
					$setarr = array(
						'cd_type' => 0, //1为加,0为减
						'cd_uid' => $row['cd_uid'],
						'cd_uname' => $row['cd_uname'],
						'cd_icon' => 'album',
						'cd_title' => '照片的评论被删除',
						'cd_points' => cd_pointsdda,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('bill', $setarr, 1);
				}

				//惩罚经验
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdda." where cd_points>=1 and cd_id='".$row['cd_uid']."'");
				$db->query("update ".tname('user')." set cd_rank=cd_rank-".cd_pointsddb." where cd_rank>=1 and cd_id='".$row['cd_uid']."'");

			}else{
				die('20002');
			}
		}else{
			die('10005');
		}
	}else{
		die('20001');
	}

	echo '<ul id="commentList" style="overflow: hidden;">';
        $query = $db->query("select * from ".tname('comment')." where cd_channel=1 and cd_dataid='$cd_pid' order by cd_addtime desc LIMIT 0,100");
	$num = $db->num_rows($query);
        while ($rows = $db->fetch_array($query)) {
		$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
		echo '<li id="comment" class="hover" style="_zoom:1;">';
		echo '<div class="pic"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-20" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
		echo '<div class="txt">';
		echo '<p>';
		echo '<span class="name"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'：</a></span>';
		echo '<span class="content_id">'.$cd_contents.'</span>';
		echo '<span class="time">'.datetime($rows['cd_addtime']).'</span>';
		if($rows['cd_uid'] != $qianwei_in_userid){
			echo '<a id="comment" class="reply" authorId="'.$rows['cd_uid'].'" nickname="'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'">回复</a>';
		}
		echo '</p>';
		echo '</div>';
		if($cd_uid == $qianwei_in_userid){
			echo '<span cid="'.$rows['cd_id'].'" uid="'.$cd_uid.'" class="del" title="删除"></span>';
		}
		echo '</li>';
	}
	echo '</ul>';
	echo '<div id="nums" type="hidden" num="'.$num.'"></div>';
?>
	<script type="text/javascript">
	$(document).ready(function(){
		albumLib.imageNameModifyInit(); 
		albumLib.replayUserInit();
		albumLib.replayUserCancelInit();
		albumLib.imageCommentDelInit();
	});
	</script>