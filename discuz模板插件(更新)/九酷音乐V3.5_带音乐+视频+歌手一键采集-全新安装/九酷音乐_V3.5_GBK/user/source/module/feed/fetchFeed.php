<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_type = SafeRequest("type","post");
	$cd_cid = SafeRequest("cid","post");
	if($cd_cid){
		$cd_cid = $cd_cid;
	}else{
		$cd_cid = 0;
	}
	if($cd_cid == 3){
        	$query = $db->query("select * from ".tname('feed')." where cd_uid='$qianwei_in_userid' order by cd_addtime desc LIMIT 0,100");
		$num = $db->num_rows($query);
		if($num == 0){
			echo '<div class="feed_item">您还没有最新动态！</div>';
		}else{
			echo '<ul class="me">';
        		while ($row = $db->fetch_array($query)) {
				$user = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$row['cd_uid']."'");
				$cd_data = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $row['cd_data']);
				echo '<li>';
				echo '<div class="time"><em>'.date('Y',strtotime($row['cd_addtime'])).'</em>'.date('m',strtotime($row['cd_addtime'])).'/'.date('d',strtotime($row['cd_addtime'])).'</div>';
				echo '<i class="square"></i>';
				echo '<div class="feedContent">';
				echo '<div class="feedName"><a href="javascript:;" style="float:left;"><img width="16" height="16" class="feedIcon" src="'.cd_upath.'static/space/images/icon/icon_mini_'.$row['cd_icon'].'.gif" /></a><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$user['cd_nicheng'].'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'&nbsp;'.$row['cd_title'].'&nbsp;<span class="createTime">('.datetime($row['cd_addtime']).')</span></div>';
				if($row['cd_icon'] == 'album'){
        				$query = $db->query("select cd_id,cd_url from ".tname('pic')." where cd_uid='".$row['cd_uid']."' order by cd_addtime desc LIMIT 0,4");
        				while ($rows = $db->fetch_array($query)) {
						echo '<a class="img" href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$rows['cd_id']).'" target="_blank"><img onerror="$call(function(){libs.imageError(this);}, this)" src="'.getalbumthumb($rows['cd_url'],1).'" class="summaryimg" /></a>';
					}
				}else{
					echo '<div class="detail">'.$cd_data.'</div>';
				}
				echo '</div>';
				echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}else{
		switch ($cd_type){
			case '1':
				$typename = "发布音乐";
				$typesql = "cd_icon='dance'";
				break;
			case '2':
				$typename = "收藏音乐";
				$typesql = "cd_icon='favorites'";
				break;
			case '3':
				$typename = "发表说说";
				$typesql = "cd_icon='miniblog'";
				break;
			case '4':
				$typename = "上传照片";
				$typesql = "cd_icon='album'";
				break;
			default:
				$typename = "任何";
				$typesql = "cd_icon!=''";
				break;
		}

		global $db;
		if($cd_cid == 2){
        		$query = $db->query("select * from ".tname('feed')." where $typesql order by cd_addtime desc LIMIT 0,100");
		}else{
        		$query = $db->query("select * from ".tname('feed')." where cd_uid in(".GetFolloWing($qianwei_in_userid,0).") and $typesql order by cd_addtime desc LIMIT 0,100");
		}
		$num = $db->num_rows($query);
		if($num == 0){
			echo '<div class="feed_item">还没有'.$typename.'动态！</div>';
		}else{
        		while ($row = $db->fetch_array($query)) {
				$user = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$row['cd_uid']."'");
				$cd_data = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $row['cd_data']);
				echo '<ul class="all">';
				echo '<li>';
				echo '<div class="avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank"><img src="'.getavatar($row['cd_uid'],48).'"/></a></div>';
				echo '<div class="feedContent">';
				echo '<div class="feedName"><a href="#" style="float:left;"><img class="feedIcon" src="'.cd_upath.'static/space/images/icon/icon_mini_'.$row['cd_icon'].'.gif" /></a> <a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$user['cd_nicheng'].'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'&nbsp;'.$row['cd_title'].' <span class="createTime" title="'.$row['cd_addtime'].'">'.datetime($row['cd_addtime']).'</span></div>';
				if($row['cd_icon'] == 'album'){
        				$query = $db->query("select cd_id,cd_url from ".tname('pic')." where cd_uid='".$row['cd_uid']."' order by cd_addtime desc LIMIT 0,4");
        				while ($rows = $db->fetch_array($query)) {
						echo '<a class="img" href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$rows['cd_id']).'" target="_blank"><img onerror="$call(function(){libs.imageError(this);}, this)" src="'.getalbumthumb($rows['cd_url'],1).'" class="summaryimg" /></a>';
					}
				}else{
					echo '<div class="line" iCount="1">';
					echo '<div class="detail">'.$cd_data.'</div>';
					echo '</div>';
				}
				echo '<div class="more"><a href="'.cd_upath.rewrite_url('index.php?p=space&a=feed&uid='.$row['cd_uid']).'" target="_blank">查看'.GetAlias("qianwei_user","cd_nicheng","cd_id",$row['cd_uid']).'更多动态&raquo;</a></div>';
				echo '</li>';
				echo '</ul>';
			}
		}
		echo '<input type="hidden" name="feedItem" id="feedItem" cid="'.$cd_cid.'"/>';
	}
}else{
	exit('20001');
}
?>