<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_pid = SafeRequest("pid","post");
	$cd_note = unescape(SafeRequest("note","post"));
	$cd_replayUser = unescape(SafeRequest("replayUser","post"));

	$qianwei_in_a = explode("[",$cd_replayUser);
	$qianwei_in_b = str_replace("回复@","",$qianwei_in_a[0]);
	$qianwei_in_c = str_replace("]","",$qianwei_in_a[1]);
	$cd_unames = $qianwei_in_b;
	$cd_uids = $qianwei_in_c;
	$cd_replayUsers = '';
	if($cd_replayUser){
		$cd_replayUsers = '<a href="'.cd_upath.'index.php?p=space&uid='.$cd_uids.'" target="_blank" style="float:none;">@'.$cd_unames.'</a> ';
	}

	if($cd_note == ""){
		exit('10007');
	}else{
		if(mb_strlen($cd_note,'UTF8') > 140){
			exit('10006');
		}
        	$cookies="comment_add_".$qianwei_in_userid;
		if(!empty($_COOKIE[$cookies])){
			exit('10002');
		}else{

			$sql="select cd_id,cd_uid,cd_uname from ".tname('pic')." where cd_id='$cd_pid'";
			if($row=$db->getrow($sql)){
				setcookie($cookies,"have",time()+30);
				//入库
				$setarr = array(
					'cd_channel' => 1,
					'cd_dataid' => $cd_pid,
					'cd_content' => $cd_replayUsers.$cd_note,
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uip' => getonlineip(),
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('comment', $setarr, 1);
				$db->query("update ".tname('pic')." set cd_replynum=cd_replynum+1 where cd_id='$cd_pid'");

				if($row['cd_uid']  != $qianwei_in_userid){
					if($cd_replayUser){
						$cd_data = '回复了您在&nbsp;<strong>您</strong>&nbsp;照片中的评论&nbsp;<a href="'.cd_upath.'index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$cd_pid.'" target="_blank">查看详情</a>';
					}else{
						$cd_data = '评论了你的照片&nbsp;<a href="'.cd_upath.'index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$cd_pid.'" target="_blank">查看详情</a>';
					}
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $row['cd_uid'],
						'cd_unames' => $row['cd_uname'],
						'cd_icon' => 'album',
						'cd_data' => $cd_data,
						'cd_dataid' => $cd_pid,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}else{
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $cd_uids,
						'cd_unames' => GetAlias("qianwei_user","cd_name","cd_id",$cd_uids),
						'cd_icon' => 'album',
						'cd_data' => '回复了您在&nbsp;<strong>TA</strong>&nbsp;照片中的评论&nbsp;<a href="'.cd_upath.'index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$cd_pid.'" target="_blank">查看详情</a>',
						'cd_dataid' => $cd_pid,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}
			}else{
				exit('30000');
			}
		}
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
			echo '<span cid="'.$rows['cd_id'].'" uid="'.$rows['cd_uid'].'" class="del" title="删除"></span>';
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
<?php
}else{
	exit('20001');
}
?>