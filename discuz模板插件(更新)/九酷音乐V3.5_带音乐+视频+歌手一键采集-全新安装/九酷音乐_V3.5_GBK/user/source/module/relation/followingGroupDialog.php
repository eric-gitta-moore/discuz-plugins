<?php
include "../source/global/global_inc.php";
close_browse();
global $db,$qianwei_in_userid;
if($qianwei_in_userid){
	$cd_fgid = SafeRequest("fgid","get");
	$showstr='<div class="dfriendGroup">';
	$showstr=$showstr.'<ul>';
	$query = $db->query("select * from ".tname('friendgroup')." where cd_uid='$qianwei_in_userid' order by cd_id asc");
	while ($row = $db->fetch_array($query)) {
		if($row['cd_id'] == $cd_fgid){
			$showstr=$showstr.'<li><span class="cbox"><input type="radio" value="'.$row['cd_id'].'" name="fgid" id="fgid_'.$row['cd_id'].'" checked="checked" /></span><label for="fgid_'.$row['cd_id'].'">'.$row['cd_name'].'</label></li>';
		}else{
			$showstr=$showstr.'<li><span class="cbox"><input type="radio" value="'.$row['cd_id'].'" name="fgid" id="fgid_'.$row['cd_id'].'" /></span><label for="fgid_'.$row['cd_id'].'">'.$row['cd_name'].'</label></li>';
		}
	}
	$showstr=$showstr.'<li><span class="cbox"><input type="radio" value="0" name="fgid" id="fgid_0"';
	if($cd_fgid == 0){
		$showstr=$showstr.' checked="checked"';
	}
	$showstr=$showstr.' /></span><label for="fgid_0">Î´·Ö×é</label></li>';
	$showstr=$showstr.'</ul>';
	$showstr=$showstr.'</div>';
	echo $showstr;
}else{
	exit('20001');
}
?>