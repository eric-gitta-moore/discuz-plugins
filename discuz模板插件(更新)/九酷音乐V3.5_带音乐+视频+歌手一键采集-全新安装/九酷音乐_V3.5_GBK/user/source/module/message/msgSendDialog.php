<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$uidKey = SafeRequest("uidKey","post");
	$cd_uidKey = ZxingCrypt($uidKey,"decode");
	$sql="Select cd_id,cd_nicheng from ".tname('user')." where cd_id='$cd_uidKey'";
	$row=$db->getrow($sql);
	if($row){
		echo '<div class="msg_dialog_send">';
		echo '<div class="title"><span>·¢ËÍ¸ø£º<span class="nickname" style="color:#CC3300; font-size:12px; margin-left:2px; margin-right:2px;">'.$row['cd_nicheng'].'</span></span></div>';
		echo '<div class="main">';
		echo '<div class="face"><img class="avatar" width="48" height="48" src="'.getavatar($row['cd_id'],48).'"/></div>';
		echo '<div class="message"><div id="fnote" contenteditable="true" class="send" name="fnote"></div></div>';
		echo '<div id="emot_fnote" class="emot" to="fnote"></div>';
		echo '</div>';
		echo '<div id="uid" style="display:none" uid = "'.$row['cd_id'].'"></div>';
		echo '</div>';

	}else{
		exit('10004');
	}
}else{
	exit('20001');
}
?>
<script type="text/javascript">$("#fnote").emotEditor({emot:true, newLine:true});</script>