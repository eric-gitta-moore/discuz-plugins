<?php
Administrator(6);
mainjump();
if(cd_webhtml==1 || cd_webhtml==3){die("<font color=\"red\">当前站点运行模式为动态，请先开启静态！</font>");}
echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
echo "<table style=\"border:1px solid #09C;width:300px\">";
echo "<tr><td>累计生成</td><td><div id=\"num\" style=\"color:blue\">0</div></td></tr>";
echo "<tr><td>生成总计</td><td><div id=\"nums\" style=\"color:green\"><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
echo "</table>";
global $db;
$pageid=SafeRequest("pageid","post");
if($pageid==0){
        ob_start();
        $num=0;
        $page = $db->query("select * from ".tname('page')." where cd_html=0");
        while ($row = $db->fetch_array($page)) {
		$num=$num+1;
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/page/".$row['cd_id']."/";
		spandir($row['cd_url']);
		fwrite(fopen($row['cd_url'],"wb"),@file_get_contents($spanpath));
	 	echo "<script type=\"text/javascript\">$('num').innerHTML=".$num.";</script>";
		ob_flush();
		flush();
	}
        echo "<script type=\"text/javascript\">$('nums').innerHTML=".$num.";</script>";
}else{
	$sql="select * from ".tname('page')." where cd_html=0 and cd_id=".$pageid;
	if($row=$db->getrow($sql)){
	        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/page/".$row['cd_id']."/";
		spandir($row['cd_url']);
		fwrite(fopen($row['cd_url'],"wb"),@file_get_contents($spanpath));
		echo "<script type=\"text/javascript\">$('num').innerHTML=1;</script>";
		echo "<script type=\"text/javascript\">$('nums').innerHTML=1;</script>";
	}
}
?>