<?php
include "source/global/global_conn.php";
$lpid=SafeRequest("id","get");
if(IsNul($lpid)){
	$lpids=$lpid;
}else{
	global $db;
	$lpids="";
	$sql="select * from ".tname('music')." where DateDiff(DATE(CD_AddTime),'".date('Y-m-d')."')=0 order by rand() desc";
	$rs=$db->query($sql);
	$num=$db->num_rows($rs);
	if($num==0){
		$lpids="";
	}else{
		$nums=30;
		if($num<$nums){
			$j=$num;
		}else{
			$j=$nums;
		}
		for($i=0;$i<$j;$i++){
			$row=$db->fetch_array($rs);
			$lpids=$lpids."{song}".$row['CD_ID'].",";
		}
		$lpids=$lpids."]";
		$lpids=ReplaceStr($lpids,",]","");
	}
}
$tplpath=_qianwei_root_.cd_templatedir."lplayer.html";
if(file_exists($tplpath)){
	$Mark_Text=@file_get_contents($tplpath);
	$Mark_Text=ReplaceStr($Mark_Text,"[qianwei:lpid]",$lpids);
	$Mark_Text=Common_Mark($Mark_Text,0);
	echo $Mark_Text;
}else{
	die(html_message("错误信息","lplayer.html模板文件不存在！"));
}
?>