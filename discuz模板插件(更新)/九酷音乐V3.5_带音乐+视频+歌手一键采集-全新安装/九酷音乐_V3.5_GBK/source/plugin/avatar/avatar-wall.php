<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../global/global_conn.php";
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo "<avatarList>";
global $db;
$query = $db->query("select * from ".tname('user')." where cd_musicnum>0 order by cd_musicnum desc LIMIT 0,38");
while ($row = $db->fetch_array($query)) {
echo "<avatar>";
echo "<user_name>";
echo iconv('GBK', 'UTF-8', $row['cd_nicheng']);
echo "</user_name>";
echo "<area>";
echo iconv('GBK', 'UTF-8', $row['cd_address']);
echo "</area>";
echo "<sex>";
echo iconv('GBK', 'UTF-8', str_sex($row['cd_sex']));
echo "</sex>";
echo "<avatar_url>";
echo getavatars($row['cd_id'],0);
echo "</avatar_url>";
echo "<link_url>";
echo linkweburl($row['cd_id'],$row['cd_name']);
echo "</link_url>";
echo "</avatar>";
}
echo "</avatarList>";
?>