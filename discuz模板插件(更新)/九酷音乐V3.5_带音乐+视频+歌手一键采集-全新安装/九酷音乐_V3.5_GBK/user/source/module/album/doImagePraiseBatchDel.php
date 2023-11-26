<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_lid = unescape(SafeRequest("lidArr","post"));
		$cd_pid = unescape(SafeRequest("pidArr","post"));

		$query = $db->query("select cd_id,cd_dataid from ".tname('pic_like')." where cd_id in($cd_lid)");
		while ($row = $db->fetch_array($query)) {
			//É¾³ýÏ²»¶
			$db->query("delete from ".tname('pic_like')." where cd_id='".$row['cd_id']."'");
			//É¾³ýÆÀÂÛ
			$db->query("delete from ".tname('comment')." where cd_channel=1 and cd_dataid='".$row['cd_dataid']."'");
			$db->query("update ".tname('pic')." set cd_praisenum=cd_praisenum-1 where cd_id='".$row['cd_dataid']."'");
			$db->query("update ".tname('pic')." set cd_replynum=cd_replynum-1 where cd_id='".$row['cd_dataid']."'");
		}
		die('10000');
	}else{
		die('20001');
	}
?>