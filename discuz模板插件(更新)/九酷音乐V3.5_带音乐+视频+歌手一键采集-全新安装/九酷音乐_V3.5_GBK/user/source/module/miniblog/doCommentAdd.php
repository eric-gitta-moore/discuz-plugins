<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_bid = SafeRequest("bid","post");
	$cd_note = unescape(SafeRequest("note","post"));
	$cd_replayUser = unescape(SafeRequest("replayUser","post"));
	$qianwei_in_a = explode("[",$cd_replayUser);
	$qianwei_in_b = str_replace("回复@","",$qianwei_in_a[0]);
	$qianwei_in_c = str_replace("]","",isset($qianwei_in_a[1])?$qianwei_in_a[1]:NULL);
	$cd_unames = $qianwei_in_b;
	$cd_uids = $qianwei_in_c;
	$cd_replayUsers = '';
	if($cd_replayUser){
		$cd_replayUsers = '<a href="'.cd_upath.rewrite_url('index.php?p=space&uid='.$cd_uids).'" target="_blank" style="float:none;">@'.$cd_unames.'</a> ';
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

			$sql="select cd_id,cd_uid,cd_uname from ".tname('blog')." where cd_id='$cd_bid'";
			if($row=$db->getrow($sql)){
				setcookie($cookies,"have",time()+30);
				//入库
				$setarr = array(
					'cd_channel' => 0,
					'cd_dataid' => $cd_bid,
					'cd_content' => $cd_replayUsers.$cd_note,
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uip' => getonlineip(),
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('comment', $setarr, 1);
				$db->query("update ".tname('blog')." set cd_commentnum=cd_commentnum+1 where cd_id='$cd_bid'");

				if($row['cd_uid']  != $qianwei_in_userid){
					if($cd_replayUser){
						$cd_data = '回复了您在&nbsp;<strong>您</strong>&nbsp;说说中的评论&nbsp;<a href="'.cd_upath.'index.php?p=space&a=miniblog&uid='.$row['cd_uid'].'&id='.$cd_bid.'" target="_blank">查看详情</a>';
					}else{
						$cd_data = '评论了你的说说&nbsp;<a href="'.cd_upath.'index.php?p=space&a=miniblog&uid='.$row['cd_uid'].'&id='.$cd_bid.'" target="_blank">查看详情</a>';
					}
					//入库
					$setarr = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_uids' => $row['cd_uid'],
						'cd_unames' => $row['cd_uname'],
						'cd_icon' => 'miniblog',
						'cd_data' => $cd_data,
						'cd_dataid' => $cd_bid,
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
						'cd_icon' => 'miniblog',
						'cd_data' => '回复了您在&nbsp;<strong>TA</strong>&nbsp;说说中的评论&nbsp;<a href="'.cd_upath.'index.php?p=space&a=miniblog&uid='.$row['cd_uid'].'&id='.$cd_bid.'" target="_blank">查看详情</a>',
						'cd_dataid' => $cd_bid,
						'cd_state' => 1,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('notice', $setarr, 1);
				}
			}else{
				exit('10004');
			}
		}
	}

	echo '<ul>';
        $query = $db->query("select * from ".tname('comment')." where cd_channel=0 and cd_dataid='$cd_bid' order by cd_addtime desc LIMIT 0,100");
	$num = $db->num_rows($query);
        while ($rows = $db->fetch_array($query)) {
		echo '<li>';
		echo '<div class="avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-34" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
		echo '<div class="content">';
		echo '<div class="note"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.GetAlias("qianwei_user","cd_name","cd_id",$rows['cd_uid']).'</a>&nbsp;'.$rows['cd_content'].'</div>';
		echo '<div class="time">发表于:'.datetime($rows['cd_addtime']).'</div>';
		echo '<div class="replay">';
		if($rows['cd_uid'] == $qianwei_in_userid){
			echo '<span></span>';
		}else{
			echo '<a id="comment" class="comment" authorId="'.$rows['cd_uid'].'" nickname="'.GetAlias("qianwei_user","cd_name","cd_id",$rows['cd_uid']).'" cid="'.$rows['cd_id'].'">回复</a>';
		}
		if($cd_uid == $qianwei_in_userid){
			echo '<span cid="'.$rows['cd_id'].'" class="dell" title="删除"></span>';
		}else{
			echo '<span></span>';
		}
		echo '</div>';
		echo '</div>';
		echo '</li>';
	}
	echo '</ul>';
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
<?php
}else{
	exit('20001');
}
?>