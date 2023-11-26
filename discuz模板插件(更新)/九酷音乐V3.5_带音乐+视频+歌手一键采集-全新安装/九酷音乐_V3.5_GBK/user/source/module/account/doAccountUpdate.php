<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$sql="select sum(cd_points) from ".tname('bill')." where cd_type=1 and cd_state=1 and cd_uid='$qianwei_in_userid'";
		if($res = $db->query($sql)){
			list($sum_no)=mysql_fetch_row($res);
			mysql_free_result($res);
			if($sum_no){
				$db->query("update ".tname('user')." set cd_points=cd_points+".$sum_no." where cd_id='$qianwei_in_userid'");
				$db->query("update ".tname('bill')." set cd_state=2,cd_endtime='".getendtime()."' where cd_type=1 and cd_state=1 and cd_uid='$qianwei_in_userid'");
			}else{
				exit('10004');
			}
		}
	}else{
		exit('20001');
	}
?>