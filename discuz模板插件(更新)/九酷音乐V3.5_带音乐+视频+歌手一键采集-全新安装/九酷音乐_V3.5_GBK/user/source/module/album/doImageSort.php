<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = unescape(SafeRequest("idArr","post"));
		$cd_uid = SafeRequest("uid","post");

		if($cd_id){
			if($cd_uid != $qianwei_in_userid){
				die('20002');
			}

			$count = explode(",",$cd_id);
			$icount = count($count);

			for($i=0;$i<count($count);$i++) {
				$db->query("update ".tname('pic')." set cd_theorder=$icount-$i where cd_id='".$count[$i]."'");
			}
		}else{
			die('10005');
		}
	}else{
		die('20001');
	}
?>