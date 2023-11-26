<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=utf-8");
include "../../../source/global/global_conn.php";
close_browse();
$CD_ID=SafeRequest("id","get");
global $db;
$sql="select * from ".tname('video')." where CD_ID=".$CD_ID;
if($row=$db->getrow($sql)){
	echo "<list><m type=\"video\" src=\"".LinkVideoUrl($row['CD_Play'],0)."\" /></list>";
}
?>