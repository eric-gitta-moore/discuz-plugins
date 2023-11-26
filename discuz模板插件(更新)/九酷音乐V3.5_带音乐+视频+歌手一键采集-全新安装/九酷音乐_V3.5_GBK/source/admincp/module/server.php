<?php
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>服务器设置</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.name != 'chkall')
			e.checked = form.chkall.checked;
	}
}
function CheckForm(){
        if(document.form2.CD_Name.value==""){
            asyncbox.tips("服务器名称不能为空，请填写！", "wait", 1000);
            document.form2.CD_Name.focus();
            return false;
        }
        else if(document.form2.CD_Url.value==""){
            asyncbox.tips("试听服务器不能为空，请填写！", "wait", 1000);
            document.form2.CD_Url.focus();
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
	case 'saveadd':
		SaveAdd();
		break;
	case 'edit':
		Edit();
		break;
	case 'saveedit':
		SaveEdit();
		break;
	case 'del':
		Del();
		break;
	case 'alldel':
		AllDel();
		break;
	default:
		main("select * from ".tname('server')." order by CD_ID desc",30);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
$CD_Name = $Arr[0];
$CD_Url = $Arr[1];
$CD_DownUrl = $Arr[2];
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 新增服务器';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;新增服务器&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=新增服务器&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 编辑服务器';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;编辑服务器';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>服务器</h3><ul class="tab1">
<li><a href="?iframe=server"><span>服务器设置</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=server&action=add"><span>新增服务器</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form2">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>服务器</th></tr>
<tr><td colspan="2" class="td27">服务器名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $CD_Name; ?>" name="CD_Name" id="CD_Name"></td><td class="vtop tips2">自定义一个名称</td></tr>
<tr><td colspan="2" class="td27">试听服务器:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $CD_Url; ?>" name="CD_Url" id="CD_Url"></td><td class="vtop tips2">必须以“http://”开头</td></tr>
<tr><td colspan="2" class="td27">下载服务器:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $CD_DownUrl; ?>" name="CD_DownUrl" id="CD_DownUrl"></td><td class="vtop tips2">必须以“http://”开头</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form2" class="btn" value="提交" onclick="return CheckForm();" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 服务器设置';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;服务器设置&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=服务器设置&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>服务器设置</h3><ul class="tab1">
<li class="current"><a href="?iframe=server"><span>服务器设置</span></a></li>
<li><a href="?iframe=server&action=add"><span>新增服务器</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form name="form" method="post" action="?iframe=server&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>服务器名称</th>
<th>试听服务器</th>
<th>下载服务器</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有服务器</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25">
<?php if($row['CD_ID']==1){ ?>
<input class="checkbox" type="checkbox" name="CD_ID" id="CD_ID" value="<?php echo $row['CD_ID']; ?>" disabled><?php echo $row['CD_ID']; ?>
<?php }else{ ?>
<input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?>
<?php } ?>
</td>
<td><a href="?iframe=server&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act"><?php echo $row['CD_Name']; ?></a></td>
<td><?php echo $row['CD_Url']; ?></td>
<td><?php echo $row['CD_DownUrl']; ?></td>
<td><?php if($row['CD_Yes']==0){ ?><a href="?iframe=server&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">编辑</a><?php }else{ ?><a href="?iframe=server&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">编辑</a><a href="?iframe=server&action=del&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">删除</a><?php } ?></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="alldel" class="btn" value="批量删除" onclick="{if(confirm('确定要删除所选定的服务器吗？')){this.document.form.submit();return true;}return false;}" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//批量删除
	function AllDel(){
		global $db;
		if(!submitcheck('alldel')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID=RequestBox("CD_ID");
		$sql="delete from ".tname('server')." where CD_ID in ($CD_ID)";
		if($CD_ID==0){
			ShowMessage("批量删除失败，请先勾选要删除的服务器！","?iframe=server","infotitle3",3000,1);
		}else{
			if($db->query($sql)){
				ShowMessage("恭喜您，服务器批量删除成功！","?iframe=server","infotitle2",3000,1);
			}
		}
	}

	//删除
	function Del(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="delete from ".tname('server')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，服务器删除成功！","?iframe=server","infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="select * from ".tname('server')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_Name'],$row['CD_Url'],$row['CD_DownUrl']);
		}
		EditBoard($Arr,"?iframe=server&action=saveedit&CD_ID=".$CD_ID,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=server&action=saveadd","新增");
	}

	//执行保存
	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_Url = SafeRequest("CD_Url","post");
		$CD_DownUrl = SafeRequest("CD_DownUrl","post");
		$sql="Insert ".tname('server')." (CD_Name,CD_Url,CD_DownUrl,CD_Yes) values ('".$CD_Name."','".$CD_Url."','".$CD_DownUrl."',1)";
		if($db->query($sql)){
			ShowMessage("恭喜您，服务器新增成功！","?iframe=server","infotitle2",1000,1);
		}else{
			ShowMessage("新增出错，服务器新增失败！","?iframe=server","infotitle3",3000,1);
		}
	}

	//保存编辑
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_Url = SafeRequest("CD_Url","post");
		$CD_DownUrl = SafeRequest("CD_DownUrl","post");
		$sql="update ".tname('server')." set CD_Name='".$CD_Name."',CD_Url='".$CD_Url."',CD_DownUrl='".$CD_DownUrl."' where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，服务器编辑成功！","?iframe=server","infotitle2",1000,1);
		}else{
			ShowMessage("编辑出错，服务器编辑失败！","?iframe=server","infotitle3",3000,1);
		}
	}
?>