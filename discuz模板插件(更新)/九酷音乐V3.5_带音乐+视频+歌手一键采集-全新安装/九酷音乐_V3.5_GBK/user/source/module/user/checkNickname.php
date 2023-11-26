<?php
	include "../source/global/global_inc.php";
	close_browse();
        global $db;
	$cd_nickname = unescape(SafeRequest("nickname","post"));
	if(mb_strlen($cd_nickname,'UTF8') > 12){
		exit('2');
	}
	$nicheng = $db->getone("select cd_id from ".tname('user')." where cd_id<>'$qianwei_in_userid' and cd_nicheng='".$cd_nickname."'");
	if($nicheng){
		exit('1');
	}else{
		exit('10000');
	}
?>