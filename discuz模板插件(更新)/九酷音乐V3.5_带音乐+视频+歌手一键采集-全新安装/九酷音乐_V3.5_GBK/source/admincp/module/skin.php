<?php
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>ģ�巽��</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckAdd(){
	if(document.form.CD_Name.value==""){
	    asyncbox.tips("�����������Ʋ���Ϊ�գ�����д��", "wait", 1000);
	    document.form.CD_Name.focus();
	    return false;
	}
	else if(document.form.CD_TempPath.value==""){
	    asyncbox.tips("����ģ��·������Ϊ�գ�����д��", "wait", 1000);
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ������ - �༭ģ��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;�༭ģ��';</script>
<div class="floattop"><div class="itemtitle"><h3>�༭ģ��</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition"><?php echo SafeRequest("tempname","get"); ?></th></tr>
</table>
<table class="tb tb2">
<form action="?iframe=skin&action=save" method="post">
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo SafeRequest("file","get"); ?>" name="FileName"></td></tr>
<tr class="noborder"><td class="vtop rowform">
<textarea rows="30" name="content" style="width:700px;"><?php echo file_get_contents($path.trim(SafeRequest("file","get"))); ?></textarea>
</td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="folder" value="<?php echo $path; ?>"><input name="tempname" type="hidden" value="<?php echo SafeRequest("tempname","get"); ?>"><input name="save" type="submit" class="btn" value="�ύ�޸�" /> &nbsp; <input type="button" class="btn" value="����" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo SafeRequest("tempname","get"); ?>&dir=<?php echo $path; ?>';"></div></td></tr>
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ������ - ���ģ��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;���ģ��';</script>
<div class="floattop"><div class="itemtitle"><h3>���ģ��</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition"><?php echo SafeRequest("tempname","get"); ?></th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>ģ������</th>
<th>ģ������</th>
<th>�ļ���С</th>
<th>�޸�ʱ��</th>
<th>�༭����</th>
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
<td>�ļ���</td>
<td><?php echo round(filesize($file)/1204,2)."Kb"; ?></td>
<td><?php echo date('Y-m-d H:i:s',filemtime($file)); ?></td>
<td><a href="?iframe=skin&action=templist&path=<?php echo $path; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>&file=<?php echo $v; ?>" class="act">�༭</a><a href="?iframe=skin&action=copyfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">����</a><a href="?iframe=skin&action=delfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">ɾ��</a></td>
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
<td><a href="?iframe=skin&action=templist&path=<?php echo $path; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>&file=<?php echo $v; ?>" class="act">�༭</a><a href="?iframe=skin&action=copyfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">����</a><a href="?iframe=skin&action=delfile&path=<?php echo $path; ?>&file=<?php echo $v; ?>&tempname=<?php echo SafeRequest("tempname","get"); ?>" class="act">ɾ��</a></td>
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ������ - ģ�巽��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;ģ�巽��&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=ģ�巽��&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>ģ�巽��</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>��ͼƬ����Ϊ��preview.jpg��������ģ����һ��Ŀ¼�£�����Զ�ȡ����</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<?php
if($tempcount==0){
?>
<tr><td colspan="2" class="td27">û��ģ�巽��</td></tr>
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
<p><div class="fixsel"><input type="button" class="btn"<?php if(cd_templatedir==$row['CD_TempPath']){ ?> value="��ΪĬ��" disabled="disabled"<?php }else{ ?> value="��ΪĬ��" onclick="location.href='?iframe=skin&action=temp&path=<?php echo $row['CD_TempPath']; ?>';"<?php } ?> /></div></p>
<p style="margin: 1px 0"><div class="fixsel"><input name="edit" type="submit" class="btn" value="�޸�" /></div></p>
<p style="margin: 1px 0"><div class="fixsel"><input type="button" class="btn" value="����" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo $row['CD_Name']; ?>&dir=<?php echo $row['CD_TempPath']; ?>';" /></div></p>
<p style="margin: 8px 0 0 0"><div class="fixsel"><input type="button" class="btn"<?php if(cd_templatedir==$row['CD_TempPath']){ ?> value="����" disabled="disabled"<?php }else{ ?> value="ɾ��" onclick="if(confirm('ɾ��ģ�彫ͬʱ�Ƴ���ģ���µ������ļ���ȷ��ɾ����')){location.href='?iframe=skin&action=del&id=<?php echo $row['CD_ID']; ?>';}else{return false;}"<?php } ?> /></div></p>
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
<td>��������</td>
<td><input type="text" class="txt" name="CD_Name" id="CD_Name" size="18" style="margin:0; width: 104px;"></td>
<td>ģ��·��</td>
<td><input type="text" class="txt" name="CD_TempPath" id="CD_TempPath" size="18" style="margin:0; width: 140px;"></td>
</tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form" onclick="return CheckAdd();" class="btn" value="����" /></div></td></tr>
</table>
</form>
</div>



<?php
}
//����ģ���ļ�
function CopyFile(){
	$CD_Name=SafeRequest("file","get");
	$CD_Path=SafeRequest("path","get");
	$CD_TempName=SafeRequest("tempname","get");
	if(copy($CD_Path.$CD_Name,$CD_Path."���� ".$CD_Name)){
		ShowMessage("��ϲ����ģ���ļ�{".$CD_Name."}���Ƴɹ���","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle2",1000,1);
	}
}

//ɾ��ģ���ļ�
function DelFile(){
	$CD_Name=SafeRequest("file","get");
	$CD_Path=SafeRequest("path","get");
	$CD_TempName=SafeRequest("tempname","get");
	if(file_exists($CD_Path.$CD_Name)){
		unlink($CD_Path.$CD_Name);
		ShowMessage("��ϲ����ģ���ļ�ɾ���ɹ���","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle2",1000,1);
	}else{
		ShowMessage("ɾ��ʧ�ܣ�ģ���ļ������ڣ�","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle3",3000,1);
	}
}

//�༭ģ���ļ�
function Save(){
	if(!submitcheck('save')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
	$CD_Name=$_POST["FileName"];
	$CD_Path=$_POST["folder"];
	$CD_TempName=$_POST["tempname"];
	$CD_Content=stripslashes($_POST["content"]);
	$F_Ext = substr(strrchr($CD_Name,'.'),1);
	$FileType = strtolower($F_Ext);
	if($FileType=="html"){
		if(!$fp = fopen($CD_Path.$CD_Name, 'w')) {
			ShowMessage("�޸�ʧ�ܣ�ģ���ļ�{".$CD_Path.$CD_Name."}û��д��Ȩ�ޣ�","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle3",3000,1);
		}
		$ifile = new iFile($CD_Path.$CD_Name, 'w');
		$ifile->WriteFile($CD_Content,3);
		ShowMessage("��ϲ����ģ���ļ��޸ĳɹ���","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle2",1000,1);
	}else{
		ShowMessage("�������ģ���ļ���׺�����淶��","?iframe=skin&action=templist&tempname=".$CD_TempName."&dir=".$CD_Path,"infotitle3",3000,1);
	}
}

//ɾ��ģ�巽��
function Del(){
	global $db;
	$CD_ID=SafeRequest("id","get");
	$row=$db->getrow("select * from ".tname('mold')." where CD_ID=".$CD_ID);
	$d=substr(substr($row['CD_TempPath'],0,strlen($row['CD_TempPath'])-1),0,strrpos(substr($row['CD_TempPath'],0,strlen($row['CD_TempPath'])-1),'/')+1);
	destroyDir($d);
	$sql="delete from ".tname('mold')." where CD_ID=".$CD_ID;
	if($db->query($sql)){
		ShowMessage("��ϲ����ģ�巽��ɾ���ɹ���","?iframe=skin","infotitle2",1000,1);
	}
}

//�༭ģ�巽��
function Edit(){
	global $db;
	if(!submitcheck('edit')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
	$CD_ID=SafeRequest("CD_ID","post");
	$CD_Name=SafeRequest("CD_Name","post");
	$CD_TempPath=SafeRequest("CD_TempPath","post");
	$sql="update ".tname('mold')." set CD_Name='".$CD_Name."',CD_TempPath='".$CD_TempPath."' where CD_ID=".$CD_ID;
	if(file_exists($CD_TempPath)){
		if(!Copyright_Style($CD_TempPath)){
			ShowMessage("�޸ĳ���ģ�巽��δ��Ȩ��","?iframe=skin","infotitle3",3000,1);
		}
	}else{
		ShowMessage("�޸�ʧ�ܣ�ģ��·�������ڣ�","?iframe=skin","infotitle3",3000,1);
	}
	$db->query($sql);
	ShowMessage("��ϲ����ģ�巽���޸ĳɹ���","?iframe=skin","infotitle2",1000,1);
}

//���ģ�巽��
function Add(){
	global $db;
	if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
	$CD_Name=SafeRequest("CD_Name","post");
	$CD_TempPath=SafeRequest("CD_TempPath","post");
	$sql="Insert ".tname('mold')." (CD_Name,CD_TempPath,CD_TheOrder) values ('".$CD_Name."','".$CD_TempPath."',0)";
	if(file_exists($CD_TempPath)){
		if(!Copyright_Style($CD_TempPath)){
			ShowMessage("��������ģ�巽��δ��Ȩ��","?iframe=skin","infotitle3",3000,1);
		}
	}else{
		ShowMessage("����ʧ�ܣ�ģ��·�������ڣ�","?iframe=skin","infotitle3",3000,1);
	}
	$db->query($sql);
	ShowMessage("��ϲ����ģ�巽�������ɹ���","?iframe=skin","infotitle2",1000,1);
}

//�л�ģ�巽��
function Temp(){
	$CD_Path=SafeRequest("path","get");
	$str=file_get_contents("source/global/global_config.php"); 
	$str=preg_replace('/"cd_templatedir","(.*?)"/','"cd_templatedir","'.$CD_Path.'"',$str);
	if(!$fp = fopen('source/global/global_config.php', 'w')) {
		ShowMessage("��ΪĬ��ʧ�ܣ��ļ�{source/global/global_config.php}û��д��Ȩ�ޣ�","?iframe=skin","infotitle3",3000,1);
	}
	$ifile = new iFile('source/global/global_config.php', 'w');
	$ifile->WriteFile($str,3);
	ShowMessage("��ϲ����ģ�巽����ΪĬ�ϳɹ���","?iframe=skin","infotitle2",1000,1);
}

function getTemplateType($filename){
	switch(strtolower($filename)){
		case 'index.html':
			$getTemplateType="վ����ҳ";
			break;
		case "head.html":
			$getTemplateType="վ�㶥��";
			break;
		case "bottom.html":
			$getTemplateType="վ��ײ�";
			break;
		case "search.html":
			$getTemplateType="վ������";
			break;
		case "list.html":
			$getTemplateType="վ����Ŀ";
			break;
		case "play.html":
			$getTemplateType="��������";
			break;
		case "lplayer.html":
			$getTemplateType="��������";
			break;
		case "down.html":
			$getTemplateType="��������";
			break;
		case "special.html":
			$getTemplateType="ר������";
			break;
		case "singersearch.html":
			$getTemplateType="��������";
			break;
		case "singer.html":
			$getTemplateType="��������";
			break;
		case "videosearch.html":
			$getTemplateType="��Ƶ����";
			break;
		case "videolist.html":
			$getTemplateType="��Ƶ��Ŀ";
			break;
		case "video.html":
			$getTemplateType="��Ƶ����";
			break;
		default:
			if(stristr($filename,'.jpg')){
				$getTemplateType="JPEG ͼ��";
			}elseif(stristr($filename,'.gif')){
				$getTemplateType="GIF ͼ��";
			}elseif(stristr($filename,'.png')){
				$getTemplateType="PNG ͼ��";
			}elseif(stristr($filename,'.css')){
				 $getTemplateType="�����ʽ���ĵ�";
			}elseif(stristr($filename,'.js')){
				$getTemplateType="JScript Script File";
			}elseif(stristr($filename,'.swf')){
				$getTemplateType="Shockwave Flash Object";
			}elseif(stristr($filename,'.xml')){
				$getTemplateType="XML �ĵ�";
			}elseif(stristr($filename,'.php')){
				$getTemplateType="PHP �ļ�";
			}elseif(stristr($filename,'.html')){
				$getTemplateType="ģ����չ";
			}else{
				$getTemplateType="�����ļ�";
			}
	}
	return $getTemplateType;
}
?>