<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../source/global/global_conn.php";
include "../../source/global/global_inc.php";
close_browse();
global $db,$userlogined;
$usernum=$db->num_rows($db->query("select * from ".tname('user')." where cd_musicnum>0"));
$pluginstr="<select onchange=\"window.open(''+this.options[this.selectedIndex].value+'');\"><option value=\"".cd_webpath."\">应用列表</option>";
$query = $db->query("select * from ".tname('plugin')." where CD_IsIndex=1");
while ($row = $db->fetch_array($query)) {
        $pluginstr.="<option value=\"".cd_webpath.rewrite_url('plugin.php?open='.$row['CD_Dir'].'&opens='.$row['CD_File'])."\">".$row['CD_Name']."</option>";
}
$pluginstr=$pluginstr."</select>";
if($userlogined){
   	$showstr="<div class=\"mdBox bgWrite\">";
   	$showstr=$showstr."<div class=\"mdBoxHd\"><a class=\"fr\" style=\"margin-top:10px\">".$pluginstr."</a><h2 class=\"mdBoxHdTit\"><span><strong><i><font color=\"#398DFF\">".$usernum."</font></i></strong> <small>位乐迷分享了好听的音乐</small></span></h2></div>";
   	$showstr=$showstr."<div style=\"width:100%; overflow:hidden; background:#FFF;\">";
   	$showstr=$showstr.escape("<div class=\"mdBoxBd\" style=\"float:left;\"><embed src=\"".cd_webpath."source/plugin/avatar/avatar-wall.swf\" menu=\"false\" wmode=\"opaque\" quality=\"high\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"725\" height=\"164\" flashVars=\"dataUrl=".cd_webpath."source/plugin/avatar/avatar-wall.php&youLink=".ReplaceStr(linkweburl($qianwei_in_userid,$qianwei_in_username),"&","%26")."\"></embed></div>");
   	$showstr=$showstr."<div style=\"float:left; margin-top:6px; margin-left:-4px;\"><a href=\"".cd_upath.rewrite_url('index.php?p=system&a=home')."\"><img src=\"".cd_webpath."source/plugin/avatar/logined.png\" width=\"232\" height=\"152\"></a></div>";
   	$showstr=$showstr."</div></div>";
}else{
   	$showstr="<div class=\"mdBox bgWrite\">";
   	$showstr=$showstr."<div class=\"mdBoxHd\"><a class=\"fr\" style=\"margin-top:10px\">".$pluginstr."</a><h2 class=\"mdBoxHdTit\"><span><strong><i><font color=\"#398DFF\">".$usernum."</font></i></strong> <small>位乐迷分享了好听的音乐</small></span></h2></div>";
   	$showstr=$showstr."<div style=\"width:100%; overflow:hidden; background:#FFF;\">";
   	$showstr=$showstr."<div class=\"mdBoxBd\" style=\"float:left;\"><embed src=\"".cd_webpath."source/plugin/avatar/avatar-wall.swf\" menu=\"false\" wmode=\"opaque\" quality=\"high\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"725\" height=\"164\" flashVars=\"dataUrl=".cd_webpath."source/plugin/avatar/avatar-wall.php&youLink=".cd_webpath.rewrite_url('user.php?do=login')."\"></embed></div>";
   	$showstr=$showstr."<div style=\"float:left; margin-top:6px; margin-left:-4px;\"><a href=\"".cd_webpath.rewrite_url('user.php?do=register')."\"><img src=\"".cd_webpath."source/plugin/avatar/reg.png\" width=\"232\" height=\"152\"></a></div>";
   	$showstr=$showstr."</div></div>";
}
   	echo $showstr;
?>