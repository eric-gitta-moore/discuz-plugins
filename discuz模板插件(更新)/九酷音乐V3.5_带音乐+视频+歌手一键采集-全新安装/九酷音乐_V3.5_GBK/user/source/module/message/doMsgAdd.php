<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_uid = SafeRequest("uid","post");
	$cd_note = unescape(SafeRequest("note","post"));

	if($cd_uid == $qianwei_in_userid){
		exit('10013');
	}

	if($cd_note == ""){
		exit('10007');
	}

	$user = $db->getrow("select cd_id,cd_name from ".tname('user')." where cd_id='$cd_uid'");
	if($user){

		$cd_uids = $user['cd_id'];
		$cd_unames = $user['cd_name'];
		$query = "select cd_id from ".tname('message')." where cd_uids='$qianwei_in_userid' and cd_uid='$cd_uid' and cd_dataid=0";
		if($rows = $db->getrow($query)){
			$rsa = $db->getrow("select cd_id from ".tname('message')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid' and cd_dataid=0 order by cd_id desc");
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $cd_uids,
				'cd_unames' => $cd_unames,
				'cd_dataid' => $rsa['cd_id'],
				'cd_readid' => 1,
				'cd_content' => $cd_note,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('message', $setarr, 1);

			$rsb = $db->getrow("select cd_id from ".tname('message')." where cd_uids='$qianwei_in_userid' and cd_uid='$cd_uid' and cd_dataid=0 order by cd_id desc");
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $cd_uids,
				'cd_unames' => $cd_unames,
				'cd_dataid' => $rsb['cd_id'],
				'cd_readid' => 1,
				'cd_content' => $cd_note,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('message', $setarr, 1);
		}else{
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $cd_uids,
				'cd_unames' => $cd_unames,
				'cd_dataid' => 0,
				'cd_readid' => 1,
				'cd_content' => $cd_note,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('message', $setarr, 1);

			$setarr = array(
				'cd_uid' => $cd_uids,
				'cd_uname' => $cd_unames,
				'cd_uids' => $qianwei_in_userid,
				'cd_unames' => $qianwei_in_username,
				'cd_dataid' => 0,
				'cd_readid' => 1,
				'cd_content' => $cd_note,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('message', $setarr, 1);

			$rsa = $db->getrow("select cd_id from ".tname('message')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid' and cd_dataid=0 order by cd_id desc");
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $cd_uids,
				'cd_unames' => $cd_unames,
				'cd_dataid' => $rsa['cd_id'],
				'cd_readid' => 1,
				'cd_content' => $cd_note,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('message', $setarr, 1);

			$rsb = $db->getrow("select cd_id from ".tname('message')." where cd_uids='$qianwei_in_userid' and cd_uid='$cd_uid' and cd_dataid=0 order by cd_id desc");
			$setarr = array(
				'cd_uid' => $qianwei_in_userid,
				'cd_uname' => $qianwei_in_username,
				'cd_uids' => $cd_uids,
				'cd_unames' => $cd_unames,
				'cd_dataid' => $rsb['cd_id'],
				'cd_readid' => 1,
				'cd_content' => $cd_note,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('message', $setarr, 1);
		}

		$rsc = $db->getrow("select cd_id from ".tname('message')." where cd_uid='$qianwei_in_userid' and cd_uids='$cd_uid' and cd_dataid=0 order by cd_id desc");
		//更新通知
		$setarr = array(
			'cd_uid' => $qianwei_in_userid,
			'cd_uname' => $qianwei_in_username,
			'cd_uids' => $cd_uids,
			'cd_unames' => $cd_unames,
			'cd_icon' => 'message',
			'cd_data' => '给您发了一个私信&nbsp;<a href="'.cd_upath.'index.php?p=message&a=msgDetail&toUid='.$rsc['cd_id'].'" target="_blank">查看</a>',
			'cd_dataid' => 0,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('notice', $setarr, 1);


		$result = $db->query("select * from ".tname('message')." where cd_dataid='".$rsb['cd_id']."' order by cd_id asc");
		$num=$db->num_rows($result);
		if($num){
			echo '<ul>';
			while ($rows = $db ->fetch_array($result)){
				$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $rows['cd_content']);

				$users = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
				echo '<li id="msg-'.$rows['cd_id'].'">';
				echo '<div class="icon"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-58" src="'.getavatar($rows['cd_uid'],48).'" title="'.$users['cd_nicheng'].'"/></a></div>';
				echo '<div class="pm">';
				echo '<div class="h">';
				echo '<div class="f">';
				echo '<p><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.$users['cd_nicheng'].'</a> <span class="mtime">'.datetime($rows['cd_addtime']).'</span> <span class="del" mcid="'.$rows['cd_id'].'" toUid="'.$qianwei_in_userid.'">删除</span></p>';
				echo '<div class="c">'.$cd_content.'</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</li>';
			}
			echo '<li>';
			echo '<div class="icon"><a href="'.linkweburl($qianwei_in_userid,$qianwei_in_username).'" target="_blank"><img class="avatar-58" src="'.getavatar($qianwei_in_userid,48).'" title="'.$qianwei_in_nicheng.'"/></a></div>';
			echo '<div class="pm">';
			echo '<div class="h">';
			echo '<div class="f">';
			echo '<div class="c">';
			echo '<div id="fnote" contenteditable="true" class="messageSend" name="fnote"></div>';
			echo '<div id="emot_fnote" class="emot" to="fnote"></div>';
			echo '<span class="button-main"><span><button class="reMsg" type="button" toUid="'.$rows['cd_uid'].'">回复</button></span></span>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</li>';
			echo '</ul>';
		}
	}else{
		exit('10004');
	}
}else{
	exit('20001');
}
?>
<script type="text/javascript">
	messageLib.reMsgDelInit(); 
	messageLib.msgAddInit();
	messageLib.reMsgOneDelInit();
</script>