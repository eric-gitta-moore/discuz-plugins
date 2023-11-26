<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = SafeRequest("cid","post");
		$cd_bid = SafeRequest("bid","post");
		$sql="select cd_id,cd_uid,cd_uname from ".tname('comment')." where cd_channel=0 and cd_dataid='$cd_bid' and cd_id='$cd_id'";
		if($row=$db->getrow($sql)){
			$blog=$db->getrow("select cd_uid from ".tname('blog')." where cd_id='$cd_bid'");
			if($blog['cd_uid'] == $qianwei_in_userid){
				$db->query("delete from ".tname('comment')." where cd_channel=0 and cd_dataid='".$cd_bid."' and cd_id='$cd_id'");
				$db->query("update ".tname('blog')." set cd_commentnum=cd_commentnum-1 where cd_commentnum>=1 and cd_id='$cd_bid'");

				if(cd_pointsdda >= 1){ //大于1才记录
					//记录账单
					$setarr = array(
						'cd_type' => 0, //1为加,0为减
						'cd_uid' => $row['cd_uid'],
						'cd_uname' => $row['cd_uname'],
						'cd_icon' => 'miniblog',
						'cd_title' => '说说的评论被删除',
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

        $query = $db->query("select * from ".tname('comment')." where cd_channel=0 and cd_dataid='$cd_bid' order by cd_addtime desc LIMIT 0,100");
	$num = $db->num_rows($query);
	if($num){
		echo '<ul>';
        	while ($rows = $db->fetch_array($query)) {
			echo '<li>';
			echo '<div class="avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-34" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
			echo '<div class="content">';
			echo '<div class="note"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.GetAlias("qianwei_user","cd_name","cd_id",$rows['cd_uid']).'</a>&nbsp;'.$rows['cd_content'].'</div>';
			echo '<div class="time">发表于:'.datetime($rows['cd_addtime']).'</div>';
			echo '<div class="replay">';
			echo '<span></span>';
			echo '<span cid="'.$rows['cd_id'].'" class="dell" title="删除"></span>';
			echo '</div>';
			echo '</div>';
			echo '</li>';
		}
		echo '</ul>';
	}
	echo '<div id="nums" type="hidden" num="'.$num.'"></div>';
?>
	<script type="text/javascript">
	$(document).ready(function(){
		miniblogLib.miniblogDelInit(".info");
		miniblogLib.commentDelInit();
		miniblogLib.replayUserInit();
		miniblogLib.replayUserDelInit();
	});
	</script>