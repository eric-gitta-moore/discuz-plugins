<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../../source/global/global_conn.php";
close_browse();
global $db;
$CD_ID=SafeRequest("id","get");
$sql="select * from ".tname('music')." where CD_ID=".$CD_ID;
if($row=$db->getrow($sql)){
        if($row['CD_Server']<>0){
                $server=$db->getrow("select * from ".tname('server')." where CD_ID=".$row['CD_Server']);
                $download=$server['CD_DownUrl'].$row['CD_DownUrl'];
        }else{
                $download=$row['CD_DownUrl'];
        }
        echo $download;
}
?>