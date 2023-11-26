<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../../source/global/global_conn.php";
global $db;
$CD_ID=SafeRequest("id","get");
$sql="select * from ".tname('music')." where CD_ID=".$CD_ID;
if($row=$db->getrow($sql)){
        header("Content-Type: application/force-download");
        if(substr(LinkLrcUrl($row['CD_Lrc']),-4)==".jpg"){
                header("Content-Disposition: attachment; filename=".basename(LinkLrcUrl($row['CD_Lrc']),".jpg"));
        }else{
                header("Content-Disposition: attachment; filename=".basename(LinkLrcUrl($row['CD_Lrc'])));
        }
        readfile(LinkLrcUrl($row['CD_Lrc']));
}
?>