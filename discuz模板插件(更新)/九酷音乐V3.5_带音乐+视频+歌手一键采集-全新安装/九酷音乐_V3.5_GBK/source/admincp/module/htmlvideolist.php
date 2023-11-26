<?php
Administrator(6);
mainjump();
if(cd_webhtml==1 || cd_webhtml==3){die("<font color=\"red\">当前站点运行模式为动态，请先开启静态！</font>");}
echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
echo "<table style=\"border:1px solid #09C;width:300px\">";
echo "<tr><td>累计生成</td><td><div id=\"num\" style=\"color:blue\">0</div></td></tr>";
echo "<tr><td>生成总计</td><td><div id=\"nums\" style=\"color:green\"><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
echo "</table>";
ob_start();
global $db;
$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."videolist.html");
$Mark_Text=explode("pagesize=",$Mark_Text);
$Mark_Text=substr($Mark_Text[1],0,2);
$listid=SafeRequest("listid","post");
if($listid==0){
        $video = $db->query("select * from ".tname('videoclass')." where CD_IsIndex=0");
}else{
        $video = $db->query("select * from ".tname('videoclass')." where CD_ID in ($listid)");
}
$num=0;
while ($row = $db->fetch_array($video)) {
	$videonum=$db->num_rows($db->query("select * from ".tname('video')." where CD_IsIndex=0 and CD_ClassID=".$row['CD_ID']));
	$pagenum=ceil($videonum/$Mark_Text);
	if($videonum==0){$pagenum=1;}
        for($i=1;$i<=$pagenum;$i++){
	        $num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/class/".$row['CD_ID']."/".$i."/";
	        $spanurl=substr(LinkClassUrl("video",$row['CD_ID'],"",$i),strlen(cd_webpath));
	        spandir($spanurl);
	        if($i==$pagenum){
	                fwrite(fopen($spanurl,"wb"),ReplaceStr(@file_get_contents($spanpath),LinkClassUrl("video",$row['CD_ID'],"",$i+1),LinkClassUrl("video",$row['CD_ID'],"",$i)));
	        }else{
	                fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	        }
	        echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
	        ob_flush();
	        flush();
        }
}
echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
?>