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
$action=SafeRequest("ac","get");
if($action=="class"){
        $special=SafeRequest("special","post");
        if($special==0){
                $album = $db->query("select * from ".tname('special')." where CD_Passed=0 and CD_ClassID<>0");
        }else{
                $album = $db->query("select * from ".tname('special')." where CD_Passed=0 and CD_ClassID=".$special);
        }
        $num=0;
        while ($row = $db->fetch_array($album)) {
		$num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/album/".$row['CD_ID']."/";
		$spanurl=substr(LinkUrl("special",$row['CD_ClassID'],1,$row['CD_ID']),strlen(cd_webpath));
		spandir($spanurl);
		fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	 	echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
		ob_flush();
		flush();
        }
        echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
}elseif($action=="day"){
        $specialday=SafeRequest("specialday","post");
        if($specialday==0){
                $album = $db->query("select * from ".tname('special')." where CD_Passed=0 and CD_ClassID<>0 and DateDiff(DATE(CD_AddTime),'".date('Y-m-d')."')=0 order by CD_ID desc");
        }else{
                $album = $db->query("select * from ".tname('special')." where CD_Passed=0 and CD_ClassID<>0 and DateDiff(DATE(CD_AddTime),'".date('Y-m-d')."')=-".$specialday." order by CD_ID desc");
        }
        $num=0;
        while ($row = $db->fetch_array($album)) {
		$num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/album/".$row['CD_ID']."/";
		$spanurl=substr(LinkUrl("special",$row['CD_ClassID'],1,$row['CD_ID']),strlen(cd_webpath));
		spandir($spanurl);
		fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	 	echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
		ob_flush();
		flush();
        }
        echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
}elseif($action=="one"){
        $cid=SafeRequest("cid","get");
        $sid=SafeRequest("sid","get");
	$spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/album/".$sid."/";
	$spanurl=substr(LinkUrl("special",$cid,1,$sid),strlen(cd_webpath));
	spandir($spanurl);
	fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}
?>