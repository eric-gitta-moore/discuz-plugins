<?php
$id=SafeRequest("fm","get");
if(IsNum($id)){
	global $db;
	$sql="select * from ".tname('class')." where CD_ID=".$id;
	if($row=$db->getrow($sql)){
		$fmid=$row['CD_ID'];
		$fmname=$row['CD_Name'];
	}else{
		$fmid="none";
		$fmname="����Ƶ��";
	}
	global $db;
	$musicid="";
	$query = $db->query("select * from ".tname('music')." where CD_ClassID=".$id." order by rand() desc LIMIT 0,100");
	while ($row = $db->fetch_array($query)) {
		$musicid=$musicid."{fm}".$row['CD_ID'].",";
	}
		$musicid=$musicid."]";
		$musicid=ReplaceStr($musicid,",]","");
}else{
	$fmid="none";
	$fmname="�������";
	global $db;
	$musicid="";
	$query = $db->query("select * from ".tname('music')." where CD_ClassID<>0 order by rand() desc LIMIT 0,100");
	while ($row = $db->fetch_array($query)) {
		$musicid=$musicid."{fm}".$row['CD_ID'].",";
	}
		$musicid=$musicid."]";
		$musicid=ReplaceStr($musicid,",]","");
}
$tplpath=_qianwei_root_.cd_templatedir."radio.html";
if(file_exists($tplpath)){
	$Mark_Text=@file_get_contents($tplpath);
	$Mark_Text=ReplaceStr($Mark_Text,"[qianwei:fmid]",$fmid);
	$Mark_Text=ReplaceStr($Mark_Text,"[qianwei:fmname]",$fmname);
	$Mark_Text=ReplaceStr($Mark_Text,"[qianwei:musicid]",$musicid);
	$Mark_Text=Common_Mark($Mark_Text,0);
	echo $Mark_Text;
}else{
	die(html_message("������Ϣ","radio.htmlģ���ļ������ڣ�"));
}
?>