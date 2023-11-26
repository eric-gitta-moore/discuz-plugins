<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../source/global/global_conn.php";
close_browse();
global $db;
$CD_ID=SafeRequest("id","get");
$query = $db->query("select * from ".tname('music')." where CD_ID in ($CD_ID)");
while ($row = $db->fetch_array($query)) {
        echo "<li onclick=\"songplayer('{song}".$row['CD_ID']."');\"><strong class=\"music_name\">".getlen("len","10",$row['CD_Name'])."</strong><strong class=\"singer_name\">".GetSingerAlias("qianwei_singer","CD_Name","CD_ID",$row['CD_SingerID'])."</strong></li>";
}
?>