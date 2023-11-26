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
<title>静态生成</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 静态生成 - 生成首页';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成首页&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=生成首页&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="music"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 静态生成 - 生成音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成音乐&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=生成音乐&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="video"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 静态生成 - 生成视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成视频&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=生成视频&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="page"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 静态生成 - 生成单页';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成单页&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=生成单页&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action=="music"){echo "生成音乐";}else if($action=="video"){echo "生成视频";}else if($action=="page"){echo "生成单页";}else{echo "生成首页";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html"><span>生成首页</span></a></li>
<?php if($action=="music"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=music"><span>生成音乐</span></a></li>
<?php if($action=="video"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=video"><span>生成视频</span></a></li>
<?php if($action=="page"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=page"><span>生成单页</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<?php } function html_index(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">生成首页</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><input type="submit" class="btn" value="生成首页" onclick="form.action='?iframe=htmlindex'" /></td>
</tr>
</table>
</form>
<?php } function html_page(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">生成单页</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="pageid">
<option value="0">所有单页</option>
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
<td><input type="submit" class="btn" value="生成单页" onclick="form.action='?iframe=htmlpage'" /></td>
</tr>
</table>
</form>
<?php } function html_video(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">生成视频</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="listid">
<option value="0">所有栏目</option>
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
<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=htmlvideolist'" /></td>
</tr>
<tr>
<td><select name="classid">
<option value="0">所有视频</option>
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
<td><input type="submit" class="btn" value="生成视频" onclick="form.action='?iframe=htmlvideo&ac=class'" /></td>
</tr>
<tr>
<td><select name="dayid">
<option value="0">今天更新</option>
<option value="1">昨天更新</option>
<option value="2">前天更新</option>
</select></td>
<td><input type="submit" class="btn" value="生成视频" onclick="form.action='?iframe=htmlvideo&ac=day'" /></td>
</tr>
</table>
</form>
<?php } function html_music(){ ?>
<form method="post" name="form" target="iframe">
<table class="tb tb2">
<tr><th class="partition">生成音乐</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="class">
<option value="0">所有栏目</option>
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
<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=htmllist'" /></td>
</tr>
<tr>
<td><select name="music">
<option value="0">所有音乐</option>
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
<td><input type="submit" class="btn" value="生成音乐" onclick="form.action='?iframe=htmlmusic&ac=class'" /></td>
</tr>
<tr>
<td><select name="musicday">
<option value="0">今天更新</option>
<option value="1">昨天更新</option>
<option value="2">前天更新</option>
</select></td>
<td><input type="submit" class="btn" value="生成音乐" onclick="form.action='?iframe=htmlmusic&ac=day'" /></td>
</tr>
<tr>
<td><select name="special">
<option value="0">所有专辑</option>
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
<td><input type="submit" class="btn" value="生成专辑" onclick="form.action='?iframe=htmlspecial&ac=class'" /></td>
</tr>
<tr>
<td><select name="specialday">
<option value="0">今天更新</option>
<option value="1">昨天更新</option>
<option value="2">前天更新</option>
</select></td>
<td><input type="submit" class="btn" value="生成专辑" onclick="form.action='?iframe=htmlspecial&ac=day'" /></td>
</tr>
<tr>
<td><select name="singer">
<option value="0">所有歌手</option>
<option value="华语歌手">华语歌手</option>
<option value="欧美歌手">欧美歌手</option>
<option value="日韩歌手">日韩歌手</option>
</select></td>
<td><input type="submit" class="btn" value="生成歌手" onclick="form.action='?iframe=htmlsinger&ac=class'" /></td>
</tr>
<tr>
<td><select name="singerday">
<option value="0">今天更新</option>
<option value="1">昨天更新</option>
<option value="2">前天更新</option>
</select></td>
<td><input type="submit" class="btn" value="生成歌手" onclick="form.action='?iframe=htmlsinger&ac=day'" /></td>
</tr>
</table>
</form>
<?php } function html_bottom(){ ?>
	<h3>QianWei Music 提示</h3>
        <div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=html&action=mainjump"></iframe></div>
        </div>
        </body>
        </html>
<?php } ?>