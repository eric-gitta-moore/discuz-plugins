<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_mcId = SafeRequest("mcId","post");
	$cd_toUid = SafeRequest("toUid","post");
	$sql="select * from ".tname('message')." where cd_id='$cd_mcId'";
	if($row=$db->getrow($sql)){
		if($cd_toUid==$qianwei_in_userid){
			$db->query("delete from ".tname('message')." where cd_id='".$row['cd_id']."'");

			$result = $db->query("select * from ".tname('message')." where cd_dataid='".$row['cd_dataid']."' order by cd_id asc");
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
					echo '<p><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.$users['cd_nicheng'].'</a> <span class="mtime">'.datetime($rows['cd_addtime']).'</span> <span class="del" mcid="'.$rows['cd_id'].'" toUid="'.$qianwei_in_userid.'">É¾³ý</span></p>';
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
				echo '<span class="button-main"><span><button class="reMsg" type="button" toUid="'.$row['cd_uid'].'">»Ø¸´</button></span></span>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</li>';
				echo '</ul>';
			}else{
				$db->query("delete from ".tname('message')." where cd_id='".$row['cd_dataid']."'");
				exit('10000');
			}



		}else{
			exit('20002');
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