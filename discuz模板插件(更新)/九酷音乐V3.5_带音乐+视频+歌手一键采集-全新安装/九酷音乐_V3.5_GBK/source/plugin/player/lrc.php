<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../global/global_conn.php";
close_browse();
$CD_ID=SafeRequest("id","get");
global $db;
$sql="select * from ".tname('music')." where CD_ID=".$CD_ID;
if($row=$db->getrow($sql)){
        if($row['CD_Server']<>0){
                $server=$db->getrow("select * from ".tname('server')." where CD_ID=".$row['CD_Server']);
                $player=$server['CD_Url'].$row['CD_Url'];
        }else{
                $player=$row['CD_Url'];
        }
        if(substr($player,-4)==".jpg"){
                $type=substr($player,-7,3);
        }else{
                $type=substr($player,-3);
        }
	echo "<list><m type=\"".$type."\" src=\"".$player."\" lrc=\"".cd_upath."static/swf/lyrics.php?id=".$row['CD_ID']."\" /></list>";
}
?>