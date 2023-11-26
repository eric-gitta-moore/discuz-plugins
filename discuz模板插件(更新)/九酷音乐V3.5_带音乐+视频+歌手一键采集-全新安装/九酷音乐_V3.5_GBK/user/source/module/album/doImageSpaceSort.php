<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db,$qianwei_in_userid;
	if($qianwei_in_userid){
		$cd_id = unescape(SafeRequest("idArr","post"));

		if($cd_id){

			$count = explode(",",$cd_id);
			$icount = count($count);

			for($i=0;$i<count($count);$i++) {
				$db->query("update ".tname('pic')." set cd_weborder=$icount-$i where cd_id='".$count[$i]."'");
			}
		}else{
			die('10005');
		}
	}else{
		die('20001');
	}
?>