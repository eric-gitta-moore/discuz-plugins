<?php
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>模板方案</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckAdd(){
	if(document.form.CD_Name.value==""){
	    asyncbox.tips("新增方案名称不能为空，请填写！", "wait", 1000);
	    document.form.CD_Name.focus();
	    return false;
	}
	else if(document.form.CD_TempPath.value==""){
	    asyncbox.tips("新增模板路径不能为空，请填写！", "wait", 1000);
	    document.form.CD_TempPath.focus();
	    return false;
	}
	else {
	    return true;
	}
}
</script>
</head>
<body>
<?php
switch($action){
	case 'add':
		Add();
		break;
	case 'temp':
		Temp();
		break;
	case 'edit':
		Edit();
		break;
	case 'del':
		Del();
		break;
	case 'templist':
		TempList();
		break;
	case 'save':
		Save();
		break;
	case 'delfile':
		DelFile();
		break;
	case 'copyfile':
		CopyFile();
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php
function TempList(){
if(trim(SafeRequest("file","get"))<>"") {
$path = SafeRequest("path","get");
if(file_exists($path.trim(SafeRequest("file","get"))) && is_file($path.trim(SafeRequest("file","get")))) {
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 编辑模板';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;编辑模板';</script>
<div class="floattop"><div class="itemtitle"><h3>编辑模板</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition"><?php echo SafeRequest("tempname","get"); ?></th></tr>
</table>
<table class="tb tb2">
<form action="?iframe=skin&action=save" method="post">
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo SafeRequest("file","get"); ?>" name="FileName"></td></tr>
<tr class="noborder"><td class="vtop rowform">
<textarea rows="30" name="content" style="width:700px;"><?php echo file_get_contents($path.trim(SafeRequest("file","get"))); ?></textarea>
</td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="folder" value="<?php echo $path; ?>"><input name="tempname" type="hidden" value="<?php echo SafeRequest("tempname","get"); ?>"><input name="save" type="submit" class="btn" value="提交修改" /> &nbsp; <input type="button" class="btn" value="返回" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo SafeRequest("tempname","get"); ?>&dir=<?php echo $path; ?>';"></div></td></tr>
</form>
</table>
</div>


<?php			
}
} else {
if(trim($_GET['dir'])<>"") {
$path = trim($_GET['dir']);
} else {
$path = getcwd();
}
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 浏览模板';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;浏览模板';</script>
<div class="floattop"><div class="itemtitle"><h3>浏览模板</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition"><?php echo SafeRequest("tempname","get"); ?></th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>模板名称</th>
<th>模板类型</th>
<th>文件大小</th>
<th>修改时间</th>
<th>编辑操作</th>
</tr>
<?php
if(file_exists($path) && is_dir($path)) {
$d = dir($path);
$d->rewind();
while(false !== ($v = $d->read())) {
if($v == "." || $v == "..") {
continue;
}
$file = $d->path.$v;
if(is_dir($file)) {
?>
<tr class="hover">
<td><a href="?iframe=skin&action=templist&tempname=<?php echo SafeRequest("tempname","get"); ?>&dir=<?php echo $path; ?><?php echo $v; ?>/" class="act"><?php echo $v; ?></a></td>
<td>文件夹</td>
<td><?php echo round(filesize($file)/1204,2)."Kb"; ?></td>
<td><?php echo date('Y-m-d H:i:s',filemtime($file)); ?></td>
<td><a href="?iframe=skin&action=templist&path=<?php echo $path; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>&file=<?php echo $v; ?>" class="act">编辑</a><a href="?iframe=skin&action=copyfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">复制</a><a href="?iframe=skin&action=delfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">删除</a></td>
</tr>
<?php
}
if(is_file($file)) {
?>
<tr class="hover">
<td><a href="?iframe=skin&action=templist&path=<?php echo $path; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>&file=<?php echo $v; ?>" class="act"><?php echo $v; ?></a></td>
<td><?php echo getTemplateType($v); ?></td>
<td><?php echo round(filesize($file)/1204,2)."Kb"; ?></td>
<td><?php echo date('Y-m-d H:i:s',filemtime($file)); ?></td>
<td><a href="?iframe=skin&action=templist&path=<?php echo $path; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>&file=<?php echo $v; ?>" class="act">编辑</a><a href="?iframe=skin&action=copyfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">复制</a><a href="?iframe=skin&action=delfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">删除</a></td>
</tr>
<?php
}
}
$d->close();
}
?>
</table>
</div>


<?php
}
}
function main(){
	global $db;
	$sql="select * from ".tname('mold');
	$result=$db->query($sql);
	$tempcount=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 模板方案';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;模板方案&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=模板方案&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>模板方案</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>把图片命名为“preview.jpg”放置在模板上一级目录下，则可以读取封面</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<?php
if($tempcount==0){
?>
<tr><td colspan="2" class="td27">没有模板方案</td></tr>
<?php
}
else{
if($result){
while($row=$db->fetch_array($result)){
$TempImg=cd_webpath.substr(substr($row['CD_TempPath'],0,strlen($row['CD_TempPath'])-1),0,strrpos(substr($row['CD_TempPath'],0,strlen($row['CD_TempPath'])-1),'/')+1);
?>
<form action="?iframe=skin&action=edit" method="post">
<table cellspacing="0" cellpadding="0" style="margin-left: 10px; width: 250px;height: 200px;" class="left">
<tr><th class="partition" colspan="2"><input type="text" class="txt" name="CD_Name" value="<?php echo $row['CD_Name']; ?>" style="margin: 2px 0; width: 104px;"></th></tr>
<tr>
<td style="width: 130px;height:170px" valign="top">
<p style="margin-bottom: 12px;"><img width="110" height="120" style="cursor:pointer" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo $row['CD_Name']; ?>&dir=<?php echo $row['CD_TempPath']; ?>';" title="<?php echo $row['CD_Name']; ?>" onerror="this.src='static/admincp/images/stylepreview.gif'" src="<?php echo $TempImg; ?>preview.jpg" /></p>
<p style="margin: 2px 0"><input type="hidden" name="CD_ID" value="<?php echo $row['CD_ID']; ?>"><input type="text" class="txt" name="CD_TempPath" value="<?php echo $row['CD_TempPath']; ?>" style="margin:0; width: 140px;"></p>
</td>
<td valign="top">
<p><div class="fixsel"><input type="button" class="btn"<?php if(cd_templatedir==$row['CD_TempPath']){ ?> value="已为默认" disabled="disabled"<?php }else{ ?> value="设为默认" onclick="location.href='?iframe=skin&action=temp&path=<?php echo $row['CD_TempPath']; ?>';"<?php } ?> /></div></p>
<p style="margin: 1px 0"><div class="fixsel"><input name="edit" type="submit" class="btn" value="修改" /></div></p>
<p style="margin: 1px 0"><div class="fixsel"><input type="button" class="btn" value="管理" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo $row['CD_Name']; ?>&dir=<?php echo $row['CD_TempPath']; ?>';" /></div></p>
<p style="margin: 8px 0 0 0"><div class="fixsel"><input type="button" class="btn"<?php if(cd_templatedir==$row['CD_TempPath']){ ?> value="保留" disabled="disabled"<?php }else{ ?> value="删除" onclick="if(confirm('删除模板将同时移除该模板下的所有文件，确定删除？')){location.href='?iframe=skin&action=del&id=<?php echo $row['CD_ID']; ?>';}else{return false;}"<?php } ?> /></div></p>
</td>
</tr>
</table>
</form>
<?php
}
}
}
?>
</table>
<form action="?iframe=skin&action=add" name="form" method="post">
<table class="tb tb2">
<tr>
<td>方案名称</td>
<td><input type="text" class="txt" name="CD_Name" id="CD_Name" size="18" style="margin:0; width: 104px;"></td>
<td>模板路径</td>
<td><input type="text" class="txt" name="CD_TempPath" id="CD_TempPath" size="18" style="margin:0; width: 140px;"></td>
</tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form" onclick="return CheckAdd();" class="btn" value="新增" /></div></td></tr>
</table>
</form>
</div>



<?php
}
//复制模板文件
function CopyFile(){
	$CD_Name=SafeRequest("file","get");
	$CD_Path=SafeRequest("path","get");
	$CD_TempName=SafeRequest("tempname","get");
	if(copy($CD_Path.$CD_Name,$CD_Path."复件 ".$CD_Name)){
		ShowMessage("恭喜您，模板文件{".$CD_Name."}复制成功！","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle2",1000,1);
	}
}

//删除模板文件
function DelFile(){
	$CD_Name=SafeRequest("file","get");
	$CD_Path=SafeRequest("path","get");
	$CD_TempName=SafeRequest("tempname","get");
	if(file_exists($CD_Path.$CD_Name)){
		unlink($CD_Path.$CD_Name);
		ShowMessage("恭喜您，模板文件删除成功！","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle2",1000,1);
	}else{
		ShowMessage("删除失败，模板文件不存在！","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle3",3000,1);
	}
}

//编辑模板文件
function Save(){
	if(!submitcheck('save')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
	$CD_Name=$_POST["FileName"];
	$CD_Path=$_POST["folder"];
	$CD_TempName=$_POST["tempname"];
	$CD_Content=stripslashes($_POST["content"]);
	$F_Ext = substr(strrchr($CD_Name,'.'),1);
	$FileType = strtolower($F_Ext);
	if($FileType=="html"){
		if(!$fp = fopen($CD_Path.$CD_Name, 'w')) {
			ShowMessage("修改失败，模板文件{".$CD_Path.$CD_Name."}没有写入权限！","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle3",3000,1);
		}
		$ifile = new iFile($CD_Path.$CD_Name, 'w');
		$ifile->WriteFile($CD_Content,3);
		ShowMessage("恭喜您，模板文件修改成功！","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle2",1000,1);
	}else{
		ShowMessage("保存出错，模板文件后缀名不规范！","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle3",3000,1);
	}
}

//删除模板方案
function Del(){
	global $db;
	$CD_ID=SafeRequest("id","get");
	$row=$db->getrow("select * from ".tname('mold')." where CD_ID=".$CD_ID);
	$d=substr(substr($row['CD_TempPath'],0,strlen($row['CD_TempPath'])-1),0,strrpos(substr($row['CD_TempPath'],0,strlen($row['CD_TempPath'])-1),'/')+1);
	destroyDir($d);
	$sql="delete from ".tname('mold')." where CD_ID=".$CD_ID;
	if($db->query($sql)){
		ShowMessage("恭喜您，模板方案删除成功！","?iframe=skin","infotitle2",1000,1);
	}
}

//编辑模板方案
function Edit(){
	global $db;
	if(!submitcheck('edit')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
	$CD_ID=SafeRequest("CD_ID","post");
	$CD_Name=SafeRequest("CD_Name","post");
	$CD_TempPath=SafeRequest("CD_TempPath","post");
	$sql="update ".tname('mold')." set CD_Name='".$CD_Name."',CD_TempPath='".$CD_TempPath."' where CD_ID=".$CD_ID;
	if(file_exists($CD_TempPath)){
		if(!Copyright_Style($CD_TempPath)){
			ShowMessage("修改出错，模板方案未授权！","?iframe=skin","infotitle3",3000,1);
		}
	}else{
		ShowMessage("修改失败，模板路径不存在！","?iframe=skin","infotitle3",3000,1);
	}
	$db->query($sql);
	ShowMessage("恭喜您，模板方案修改成功！","?iframe=skin","infotitle2",1000,1);
}

//添加模板方案
function Add(){
	global $db;
	if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
	$CD_Name=SafeRequest("CD_Name","post");
	$CD_TempPath=SafeRequest("CD_TempPath","post");
	$sql="Insert ".tname('mold')." (CD_Name,CD_TempPath,CD_TheOrder) values ('".$CD_Name."','".$CD_TempPath."',0)";
	if(file_exists($CD_TempPath)){
		if(!Copyright_Style($CD_TempPath)){
			ShowMessage("新增出错，模板方案未授权！","?iframe=skin","infotitle3",3000,1);
		}
	}else{
		ShowMessage("新增失败，模板路径不存在！","?iframe=skin","infotitle3",3000,1);
	}
	$db->query($sql);
	ShowMessage("恭喜您，模板方案新增成功！","?iframe=skin","infotitle2",1000,1);
}

//切换模板方案
function Temp(){
	$CD_Path=SafeRequest("path","get");
	$str=file_get_contents("source/global/global_config.php"); 
	$str=preg_replace('/"cd_templatedir","(.*?)"/','"cd_templatedir","'.$CD_Path.'"',$str);
	if(!$fp = fopen('source/global/global_config.php', 'w')) {
		ShowMessage("设为默认失败，文件{source/global/global_config.php}没有写入权限！","?iframe=skin","infotitle3",3000,1);
	}
	$ifile = new iFile('source/global/global_config.php', 'w');
	$ifile->WriteFile($str,3);
	ShowMessage("恭喜您，模板方案设为默认成功！","?iframe=skin","infotitle2",1000,1);
}

function getTemplateType($filename){
	switch(strtolower($filename)){
		case 'index.html':
			$getTemplateType="站点首页";
			break;
		case "head.html":
			$getTemplateType="站点顶部";
			break;
		case "bottom.html":
			$getTemplateType="站点底部";
			break;
		case "search.html":
			$getTemplateType="站点搜索";
			break;
		case "list.html":
			$getTemplateType="站点栏目";
			break;
		case "play.html":
			$getTemplateType="音乐内容";
			break;
		case "lplayer.html":
			$getTemplateType="音乐连播";
			break;
		case "down.html":
			$getTemplateType="音乐下载";
			break;
		case "special.html":
			$getTemplateType="专辑内容";
			break;
		case "singersearch.html":
			$getTemplateType="歌手搜索";
			break;
		case "singer.html":
			$getTemplateType="歌手内容";
			break;
		case "videosearch.html":
			$getTemplateType="视频搜索";
			break;
		case "videolist.html":
			$getTemplateType="视频栏目";
			break;
		case "video.html":
			$getTemplateType="视频内容";
			break;
		default:
			if(stristr($filename,'.jpg')){
				$getTemplateType="JPEG 图像";
			}elseif(stristr($filename,'.gif')){
				$getTemplateType="GIF 图像";
			}elseif(stristr($filename,'.png')){
				$getTemplateType="PNG 图像";
			}elseif(stristr($filename,'.css')){
				 $getTemplateType="层叠样式表文档";
			}elseif(stristr($filename,'.js')){
				$getTemplateType="JScript Script File";
			}elseif(stristr($filename,'.swf')){
				$getTemplateType="Shockwave Flash Object";
			}elseif(stristr($filename,'.xml')){
				$getTemplateType="XML 文档";
			}elseif(stristr($filename,'.php')){
				$getTemplateType="PHP 文件";
			}elseif(stristr($filename,'.html')){
				$getTemplateType="模板扩展";
			}else{
				$getTemplateType="其它文件";
			}
	}
	return $getTemplateType;
}
?>