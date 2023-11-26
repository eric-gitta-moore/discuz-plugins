<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_pid = SafeRequest("pid","post");
	$sql="select cd_id,cd_uid,cd_uname,cd_praisenum from ".tname('pic')." where cd_id='$cd_pid'";
	$result=$db->query($sql);
	if($row=$db->fetch_array($result)){
		if($row['cd_uid'] == $qianwei_in_userid){
			exit('10013');
		}else{

			//检测是否已喜欢
        		$cd_id = $db->getone("select cd_id from ".tname('pic_like')." where cd_uid='$qianwei_in_userid' and cd_dataid='".$row['cd_id']."'");
			if($cd_id){
				exit('10003');
			}else{
				//入库
				$setarr = array(
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_dataid' => $row['cd_id'],
					'cd_addtime' => time()
				);
				inserttable('pic_like', $setarr, 1);
				$db->query("update ".tname('pic')." set cd_praisenum=cd_praisenum+1 where cd_id='$cd_pid'");

				$my_array = array(
					'图片真不错，怎么就照的这么好看呢！',
					'不错不错，很吸引眼球的照片，收了！',
					'好看啊，很喜欢，是我喜欢的风格！',
					'这照片太显眼了，一下就看见了，照片太给力了！',
					'不错哦~赞！',
					'我喜欢这张照片！',
					'妖孽级别的啊！谁能告诉我这是怎么弄的？',
					'照片很好看啊！',
					'顶起！',
					'很好看啊~顶一个！',
					'这张照片照的很棒啊，有专业的水平！',
					'太赞了~~喜欢！',
					'赞一个！',
					'照片不错嘛！',
					'听歌交友看照片，看到这张好照片，点个喜欢收起来，等你更多好照片！',
					'( ^_^ )不错嘛！',
					'很棒的图片，快点再多上传一些！',
					'难得看见这么好看的照片，再来几个人把照片顶起来！',
					'照片不错嘛！'
				);  

				$setarr = array(
					'cd_channel' => 1,
					'cd_dataid' => $cd_pid,
					'cd_content' => $my_array[rand(0,6)],
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uip' => getonlineip(),
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('comment', $setarr, 1);
				$db->query("update ".tname('pic')." set cd_replynum=cd_replynum+1 where cd_id='$cd_pid'");


				//检测是否已提交通知
				$query = "select cd_id from ".tname('notice')." where cd_icon='album' and cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_uid']."' and cd_dataid='$cd_pid'";
				if($rows = $db->getrow($query)){
					$db->query("update ".tname('notice')." set cd_state=1,cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$rows['cd_id']."'");
				}else{
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $row['cd_uid'],
						'cd_unames' => $row['cd_uname'],
						'cd_icon' => 'album',
						'cd_data' => '评论了你的照片&nbsp;<a href="'.cd_upath.'index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$cd_pid.'" target="_blank">查看详情</a>',
						'cd_dataid' => $cd_pid,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}
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
			echo '</div>';

        		$query = $db->query("select * from ".tname('pic_like')." where cd_dataid='$cd_pid' order by cd_addtime desc LIMIT 0,16");
			$num = $db->num_rows($query);
			if($num){
				echo '<div class="Q_whoLiked">';
				echo '<div class="hd">';
				echo '<h2>这些人喜欢过</h2>';
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
				echo '<div id="praiseNum" type="hidden" num="'.($row['cd_praisenum']+1).'"></div>';
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