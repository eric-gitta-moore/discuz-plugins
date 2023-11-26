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
$class=SafeRequest("class","post");
if($class==0){
        $list = $db->query("select * from ".tname('class')." where CD_SystemID=1 and CD_IsHide=0");
}else{
        $list = $db->query("select * from ".tname('class')." where CD_ID in ($class)");
}
$num=0;
while ($row = $db->fetch_array($list)) {
        if($row['CD_ID']==1){
                $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."singer_all.html");
                $Mark_Text=explode("pagesize=",$Mark_Text);
                $Mark_Text=substr($Mark_Text[1],0,2);
	        $singernum=$db->num_rows($db->query("select * from ".tname('singer')." where CD_Passed=0"));
	        $pagenum=ceil($singernum/$Mark_Text);
	        if($singernum==0){$pagenum=1;}
                for($i=1;$i<=$pagenum;$i++){
	                $num=$num+1;
	                $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/list/".$row['CD_ID']."/".$i."/";
	                $spanurl=substr(LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i),strlen(cd_webpath));
	                spandir($spanurl);
	                if($i==$pagenum){
	                        fwrite(fopen($spanurl,"wb"),ReplaceStr(@file_get_contents($spanpath),LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i+1),LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i)));
	                }else{
	                        fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	                }
	                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
	                ob_flush();
	                flush();
                }
        }elseif($row['CD_ID']==2 || $row['CD_ID']==3 || $row['CD_ID']==4){
                if($row['CD_ID']==2){
                        $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."album_time.html");
                }elseif($row['CD_ID']==3){
                        $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."album_hits.html");
                }elseif($row['CD_ID']==4){
                        $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."album_stars.html");
                }
                $Mark_Text=explode("pagesize=",$Mark_Text);
                $Mark_Text=substr($Mark_Text[1],0,2);
                if($row['CD_ID']==2 || $row['CD_ID']==3){
	                $specialnum=$db->num_rows($db->query("select * from ".tname('special')." where CD_Passed=0 and CD_ClassID<>0"));
                }elseif($row['CD_ID']==4){
	                $specialnum=$db->num_rows($db->query("select * from ".tname('special')." where CD_IsBest>0 and CD_Passed=0 and CD_ClassID<>0"));
                }
	        $pagenum=ceil($specialnum/$Mark_Text);
	        if($specialnum==0){$pagenum=1;}
                for($i=1;$i<=$pagenum;$i++){
	                $num=$num+1;
	                $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/list/".$row['CD_ID']."/".$i."/";
	                $spanurl=substr(LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i),strlen(cd_webpath));
	                spandir($spanurl);
	                if($i==$pagenum){
	                        fwrite(fopen($spanurl,"wb"),ReplaceStr(@file_get_contents($spanpath),LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i+1),LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i)));
	                }else{
	                        fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	                }
	                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
	                ob_flush();
	                flush();
                }
        }elseif($row['CD_ID']>4 && $row['CD_ID']<13){
	        $num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/list/".$row['CD_ID']."/1/";
	        $spanurl=substr(LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1),strlen(cd_webpath));
	        spandir($spanurl);
	        fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	        echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
        }else{
                $Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."list.html");
                $Mark_Text=explode("pagesize=",$Mark_Text);
                $Mark_Text=substr($Mark_Text[1],0,2);
	        $musicnum=$db->num_rows($db->query("select * from ".tname('music')." where CD_Passed=0 and CD_Deleted=0 and CD_ClassID=".$row['CD_ID']));
	        $pagenum=ceil($musicnum/$Mark_Text);
	        if($musicnum==0){$pagenum=1;}
                for($i=1;$i<=$pagenum;$i++){
	                $num=$num+1;
	                $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/list/".$row['CD_ID']."/".$i."/";
	                $spanurl=substr(LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i),strlen(cd_webpath));
	                spandir($spanurl);
	                if($i==$pagenum){
	                        fwrite(fopen($spanurl,"wb"),ReplaceStr(@file_get_contents($spanpath),LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i+1),LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],$i)));
	                }else{
	                        fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
	                }
	                echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
	                ob_flush();
	                flush();
                }
        }
}
echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
?>