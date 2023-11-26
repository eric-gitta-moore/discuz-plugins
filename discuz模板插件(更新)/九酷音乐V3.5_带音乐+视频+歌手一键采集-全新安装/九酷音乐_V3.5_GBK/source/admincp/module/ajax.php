<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
close_browse();
$action=SafeRequest("action","get");
switch($action){
	case 'editisbest':
		EditIsbest();
		break;
	}
function EditIsbest(){
	global $db;
	$CD_ID=SafeRequest("id","get");
	$Level=SafeRequest("l","get");
	$sql="update ".tname('music')." set CD_IsBest=".$Level." where CD_ID=".$CD_ID;
	if($db->query($sql)){
		echo "1";
	}
}
?>