<?php
Administrator(6);
mainjump();
if(cd_webhtml==1 || cd_webhtml==3){die("<font color=\"red\">��ǰվ������ģʽΪ��̬�����ȿ�����̬��</font>");}
echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
echo "<table style=\"border:1px solid #09C;width:300px\">";
echo "<tr><td>�ۼ�����</td><td><div id=\"num\" style=\"color:blue\">0</div></td></tr>";
echo "<tr><td>�����ܼ�</td><td><div id=\"nums\" style=\"color:green\"><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
echo "</table>";
ob_start();
global $db;
$action=SafeRequest("ac","get");
if($action=="class"){
        $classid=SafeRequest("classid","post");
        if($classid==0){
                $video = $db->query("select * from ".tname('video')." where CD_IsIndex=0 and CD_ClassID<>0");
        }else{
                $video = $db->query("select * from ".tname('video')." where CD_IsIndex=0 and CD_ClassID=".$classid);
        }
        $num=0;
        while ($row = $db->fetch_array($video)) {
		$num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/video/".$row['CD_ID']."/";
		$spanurl=substr(LinkUrl("video",$row['CD_ClassID'],1,$row['CD_ID']),strlen(cd_webpath));
		spandir($spanurl);
		fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	 	echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
		ob_flush();
		flush();
        }
        echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
}elseif($action=="day"){
        $dayid=SafeRequest("dayid","post");
        if($dayid==0){
                $video = $db->query("select * from ".tname('video')." where CD_IsIndex=0 and CD_ClassID<>0 and DateDiff(DATE(CD_AddTime),'".date('Y-m-d')."')=0 order by CD_ID desc");
        }else{
                $video = $db->query("select * from ".tname('video')." where CD_IsIndex=0 and CD_ClassID<>0 and DateDiff(DATE(CD_AddTime),'".date('Y-m-d')."')=-".$dayid." order by CD_ID desc");
        }
        $num=0;
        while ($row = $db->fetch_array($video)) {
		$num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/video/".$row['CD_ID']."/";
		$spanurl=substr(LinkUrl("video",$row['CD_ClassID'],1,$row['CD_ID']),strlen(cd_webpath));
		spandir($spanurl);
		fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	 	echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
		ob_flush();
		flush();
        }
        echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
}elseif($action=="one"){
        $cid=SafeRequest("cid","get");
        $vid=SafeRequest("vid","get");
	$spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/video/".$vid."/";
	$spanurl=substr(LinkUrl("video",$cid,1,$vid),strlen(cd_webpath));
	spandir($spanurl);
	fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	echo "<script type=\"text/javascript\">location.href='".$_SERVER['HTTP_REFERER']."';</script>";
}
?>