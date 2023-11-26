<?php
Administrator(6);
$action=SafeRequest("action","get");
switch($action){
	case 'page':
		html_top();
		html_page();
		html_bottom();
		break;
	case 'video':
		html_top();
		html_video();
		html_bottom();
		break;
	case 'music':
		html_top();
		html_music();
		html_bottom();
		break;
	case 'mainjump':
		mainjump();
		break;
	default:
		html_top();
		html_index();
		html_bottom();
		break;
} function html_top(){
        global $action;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>��̬����</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ��̬���� - ������ҳ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='��̬����&nbsp;&raquo;&nbsp;������ҳ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������ҳ&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="music"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ��̬���� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='��̬����&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="video"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ��̬���� - ������Ƶ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='��̬����&nbsp;&raquo;&nbsp;������Ƶ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������Ƶ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="page"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ��̬���� - ���ɵ�ҳ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='��̬����&nbsp;&raquo;&nbsp;���ɵ�ҳ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=���ɵ�ҳ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action=="music"){echo "��������";}else if($action=="video"){echo "������Ƶ";}else if($action=="page"){echo "���ɵ�ҳ";}else{echo "������ҳ";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html"><span>������ҳ</span></a></li>
<?php if($action=="music"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=music"><span>��������</span></a></li>
<?php if($action=="video"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=video"><span>������Ƶ</span></a></li>
<?php if($action=="page"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=page"><span>���ɵ�ҳ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<?php } function html_index(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">������ҳ</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><input type="submit" class="btn" value="������ҳ" onclick="form.action='?iframe=htmlindex'" /></td>
</tr>
</table>
</form>
<?php } function html_page(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">���ɵ�ҳ</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="pageid">
<option value="0">���е�ҳ</option>
<?php
global $db;
$sql="select * from ".tname('page')." where cd_html=0 order by cd_id desc";
$result=$db->query($sql);
if($result){
	while ($row=$db->fetch_array($result)){
		echo "<option value=\"".$row['cd_id']."\">".$row['cd_name']."</option>";
	}
}
?>
</select></td>
<td><input type="submit" class="btn" value="���ɵ�ҳ" onclick="form.action='?iframe=htmlpage'" /></td>
</tr>
</table>
</form>
<?php } function html_video(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">������Ƶ</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="listid">
<option value="0">������Ŀ</option>
<?php
global $db;
$sql="select * from ".tname('videoclass')." where CD_IsIndex=0";
$result=$db->query($sql);
if($result){
	while ($row=$db->fetch_array($result)){
		echo "<option value=\"".$row['CD_ID']."\">".$row['CD_Name']."</option>";
	}
}
?>
</select></td>
<td><input type="submit" class="btn" value="������Ŀ" onclick="form.action='?iframe=htmlvideolist'" /></td>
</tr>
<tr>
<td><select name="classid">
<option value="0">������Ƶ</option>
<?php
$sql="select * from ".tname('videoclass')." where CD_IsIndex=0";
$result=$db->query($sql);
if($result){
	while ($row=$db->fetch_array($result)){
		echo "<option value=\"".$row['CD_ID']."\">".$row['CD_Name']."</option>";
	}
}
?>
</select></td>
<td><input type="submit" class="btn" value="������Ƶ" onclick="form.action='?iframe=htmlvideo&ac=class'" /></td>
</tr>
<tr>
<td><select name="dayid">
<option value="0">�������</option>
<option value="1">�������</option>
<option value="2">ǰ�����</option>
</select></td>
<td><input type="submit" class="btn" value="������Ƶ" onclick="form.action='?iframe=htmlvideo&ac=day'" /></td>
</tr>
</table>
</form>
<?php } function html_music(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">��������</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="class">
<option value="0">������Ŀ</option>
<?php
global $db;
$sql="select * from ".tname('class')." where CD_SystemID=1 and CD_IsHide=0";
$result=$db->query($sql);
if($result){
	while ($row=$db->fetch_array($result)){
		echo "<option value=\"".$row['CD_ID']."\">".$row['CD_Name']."</option>";
	}
}
?>
</select></td>
<td><input type="submit" class="btn" value="������Ŀ" onclick="form.action='?iframe=htmllist'" /></td>
</tr>
<tr>
<td><select name="music">
<option value="0">��������</option>
<?php
$sql="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1 and CD_IsHide=0";
$result=$db->query($sql);
if($result){
	while ($row=$db->fetch_array($result)){
		echo "<option value=\"".$row['CD_ID']."\">".$row['CD_Name']."</option>";
	}
}
?>
</select></td>
<td><input type="submit" class="btn" value="��������" onclick="form.action='?iframe=htmlmusic&ac=class'" /></td>
</tr>
<tr>
<td><select name="musicday">
<option value="0">�������</option>
<option value="1">�������</option>
<option value="2">ǰ�����</option>
</select></td>
<td><input type="submit" class="btn" value="��������" onclick="form.action='?iframe=htmlmusic&ac=day'" /></td>
</tr>
<tr>
<td><select name="special">
<option value="0">����ר��</option>
<?php
$sql="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1 and CD_IsHide=0";
$result=$db->query($sql);
if($result){
	while ($row=$db->fetch_array($result)){
		echo "<option value=\"".$row['CD_ID']."\">".$row['CD_Name']."</option>";
	}
}
?>
</select></td>
<td><input type="submit" class="btn" value="����ר��" onclick="form.action='?iframe=htmlspecial&ac=class'" /></td>
</tr>
<tr>
<td><select name="specialday">
<option value="0">�������</option>
<option value="1">�������</option>
<option value="2">ǰ�����</option>
</select></td>
<td><input type="submit" class="btn" value="����ר��" onclick="form.action='?iframe=htmlspecial&ac=day'" /></td>
</tr>
<tr>
<td><select name="singer">
<option value="0">���и���</option>
<option value="�������">�������</option>
<option value="ŷ������">ŷ������</option>
<option value="�պ�����">�պ�����</option>
</select></td>
<td><input type="submit" class="btn" value="���ɸ���" onclick="form.action='?iframe=htmlsinger&ac=class'" /></td>
</tr>
<tr>
<td><select name="singerday">
<option value="0">�������</option>
<option value="1">�������</option>
<option value="2">ǰ�����</option>
</select></td>
<td><input type="submit" class="btn" value="���ɸ���" onclick="form.action='?iframe=htmlsinger&ac=day'" /></td>
</tr>
</table>
</form>
<?php } function html_bottom(){ ?>
	<h3>QianWei Music ��ʾ</h3>
        <div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=html&action=mainjump"></iframe></div>
        </div>
        </body>
        </html>
<?php } ?>