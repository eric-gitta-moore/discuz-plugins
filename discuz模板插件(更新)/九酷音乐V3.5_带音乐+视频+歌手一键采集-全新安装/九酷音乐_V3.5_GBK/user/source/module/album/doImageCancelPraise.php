<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_pid = SafeRequest("pid","post");
	$sql="select cd_id,cd_uid,cd_praisenum from ".tname('pic')." where cd_id='$cd_pid'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		if($row['cd_uid'] == $qianwei_in_userid){
			exit('10013');
		}else{
			//ºÏ≤‚ «∑Ò“—œ≤ª∂
        		$cd_id = $db->getone("select cd_id from ".tname('pic_like')." where cd_uid='$qianwei_in_userid' and cd_dataid='".$row['cd_id']."'");
			if($cd_id){
				$db->query("update ".tname('pic')." set cd_praisenum=cd_praisenum-1 where cd_id='$cd_pid'");
				//$db->query("update ".tname('pic')." set cd_replynum=cd_replynum-1 where cd_id='$cd_pid'");
				//…æ≥˝œ≤ª∂
				$db->query("delete from ".tname('pic_like')." where cd_dataid='".$row['cd_id']."'");
				//…æ≥˝∆¿¬€
				$db->query("delete from ".tname('comment')." where cd_channel=1 and cd_uid='$qianwei_in_userid' and cd_dataid='".$row['cd_id']."'");
			}else{
				exit('10003');
			}
			echo '<div id="comments_list" class="comments_list">';
			echo '<ul id="commentList" style="overflow: hidden;">';
        		$query = $db->query("select * from ".tname('comment')." where cd_channel=1 and cd_dataid='$cd_pid' order by cd_addtime desc LIMIT 0,100");
			$num = $db->num_rows($query);
        		while ($rows = $db->fetch_array($query)) {
				$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
				echo '<li id="comment" class="hover" style="_zoom:1;">';
				echo '<div class="pic"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-20" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
				echo '<div class="txt">';
				echo '<p>';
				echo '<span class="name"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'£∫</a></span>';
				echo '<span class="content_id">'.$cd_contents.'</span>';
				echo '<span class="time">'.datetime($rows['cd_addtime']).'</span>';
				if($rows['cd_uid'] != $qianwei_in_userid){
					echo '<a id="comment" class="reply" authorId="'.$rows['cd_uid'].'" nickname="'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'">ªÿ∏¥</a>';
				}
				echo '</p>';
				echo '</div>';
				if($cd_uid == $qianwei_in_userid){
					echo '<span cid="'.$rows['cd_id'].'" uid="'.$cd_uid.'" class="del" title="…æ≥˝"></span>';
				}
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';

        		$query = $db->query("select * from ".tname('pic_like')." where cd_dataid='$cd_pid' order by cd_addtime desc LIMIT 0,16");
			$num = $db->num_rows($query);
			if($num){
				echo '<div class="Q_whoLiked">';
				echo '<div class="hd">';
				echo '<h2>’‚–©»Àœ≤ª∂π˝</h2>';
				echo '</div>';
				echo '<div class="bd">';
				echo '<ul class="avatarList clearfix">';
        			while ($rows = $db->fetch_array($query)) {
					echo '<li>';
					echo '<div class="avatar">';
					echo '<a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">';
					echo '<img class="avatar" width="48" height="48" src="'.getavatar($rows['cd_uid'],48).'"/>';
					echo '</a>';
					echo '</div>';
					echo '</li>';
				}
				echo '</ul>';
				echo '</div>';
				echo '<div id="praiseNum" type="hidden" num="'.($row['cd_praisenum']-1).'"></div>';
				echo '</div>';
			}
		}
	}else{
		exit('30000');
	}
}else{
	exit('20001');
}
?>
	<script type="text/javascript">
	$(document).ready(function(){
		albumLib.imageNameModifyInit(); 
		albumLib.replayUserInit();
		albumLib.replayUserCancelInit();
		albumLib.imageCommentDelInit();
	});
	</script>