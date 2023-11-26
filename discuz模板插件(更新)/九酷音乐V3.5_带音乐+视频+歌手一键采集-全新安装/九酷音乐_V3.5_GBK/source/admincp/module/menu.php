<?php
Administrator(1);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>常用操作管理</title>
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
        if(document.form1.cd_order.value==""){
            asyncbox.tips("排序不能为空，请填写！", "wait", 1000);
            document.form1.cd_order.focus();
            return false;
        }
        else if(document.form1.cd_name.value==""){
            asyncbox.tips("名称不能为空，请填写！", "wait", 1000);
            document.form1.cd_name.focus();
            return false;
        }
        else if(document.form1.cd_url.value==""){
            asyncbox.tips("URL不能为空，请填写！", "wait", 1000);
            document.form1.cd_url.focus();
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
	case 'del':
		Del();
		break;
	case 'editsave':
		EditSave();
		break;
	case 'saveadd':
		SaveAdd();
		break;
	case 'getadd':
		GETAdd();
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php
function main(){
	global $db;
	$sql="select * from ".tname('menu')." order by cd_id desc";
	$result=$db->query($sql);
	$menunum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 编辑常用操作';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='编辑常用操作';</script>
<div class="floattop"><div class="itemtitle"><h3>常用操作管理</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">编辑常用操作</th></tr>
</table>
<form name="form" method="post" action="?iframe=menu&action=editsave">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>排序</th>
<th>名称</th>
<th>URL</th>
<th>编辑操作</th>
</tr>
<?php
if($menunum==0){
?>
<tr><td colspan="2" class="td27">没有常用操作</td></tr>
<?php
}
if($result){
while($row=$db->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input type="checkbox" class="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td class="td28"><input type="text" class="txt" name="cd_order<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_order']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td><input type="text" class="txt" name="cd_name<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_name']; ?>"></td>
<td class="td26"><input type="text" class="txt" name="cd_url<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_url']; ?>"></td>
<td><input type="button" class="btn" value="删除" onclick="location.href='?iframe=menu&action=del&cd_id=<?php echo $row['cd_id']; ?>';" /></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td class="td25"><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label></td><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="form" value="提交修改" /></div></td></tr>
</table>
</form>
<table class="tb tb2">
<tr><th class="partition">新增常用操作</th></tr>
</table>
<form name="form1" method="post" action="?iframe=menu&action=saveadd">
<table class="tb tb2">
<tr class="header">
<th>排序</th>
<th>名称</th>
<th>URL</th>
</tr>
<tr class="hover">
<td class="td28"><input type="text" class="txt" size="3" name="cd_order" id="cd_order" value="0" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td><input type="text" class="txt" size="25" name="cd_name" id="cd_name"></td>
<td class="td26"><input type="text" class="txt" size="40" name="cd_url" id="cd_url"></td>
</tr>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form1" class="btn" value="新增" onclick="return CheckForm();" /></div></td></tr>
</table>
</form>
</div>



<?php
}
	function GETAdd(){
		global $db;
		$cd_name=SafeRequest("name","get");
		$cd_url="?".SafeRequest("url","get");
		$sql="Insert ".tname('menu')." (cd_order,cd_name,cd_url) values (0,'".$cd_name."','".$cd_url."')";
		$db->query($sql);
		echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
		ShowMessage("菜单 ".$cd_name." 已成功添加到常用操作，即将返回上一页，您可以<a href=\"?iframe=menu\">点这里编辑常用操作</a>","history.back(1);","infotitle2",3000,2);
	}

	function SaveAdd(){
		global $db;
		if(!submitcheck('form1')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_order=SafeRequest("cd_order","post");
		$cd_name=SafeRequest("cd_name","post");
		$cd_url=SafeRequest("cd_url","post");
		$sql="Insert ".tname('menu')." (cd_order,cd_name,cd_url) values (".$cd_order.",'".$cd_name."','".$cd_url."')";
		$db->query($sql);
		echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
		ShowMessage("恭喜您，常用操作新增成功！","?iframe=menu","infotitle2",1000,1);
	}

	function EditSave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		if($cd_id==0){
			ShowMessage("修改失败，请先勾选要编辑的常用操作！","?iframe=menu","infotitle3",1000,1);
		}else{
			$ID=explode(",",$cd_id);
			for($i=0;$i<count($ID);$i++){
				$cd_order=SafeRequest("cd_order".$ID[$i],"post");
				$cd_name=SafeRequest("cd_name".$ID[$i],"post");
				$cd_url=SafeRequest("cd_url".$ID[$i],"post");
				if(!IsNum($cd_order)){ShowMessage("修改出错，排序不能为空！","?iframe=menu","infotitle3",1000,1);}
				if(!IsNul($cd_name)){ShowMessage("修改出错，名称不能为空！","?iframe=menu","infotitle3",1000,1);}
				if(!IsNul($cd_url)){ShowMessage("修改出错，URL不能为空！","?iframe=menu","infotitle3",1000,1);}
				$sql="update ".tname('menu')." set cd_order=".$cd_order.",cd_name='".$cd_name."',cd_url='".$cd_url."' where cd_id=".$ID[$i];
				$db->query($sql);
			}
			echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
			ShowMessage("恭喜您，常用操作修改成功！","?iframe=menu","infotitle2",1000,1);
		}
	}

	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('menu')." where cd_id=".$cd_id;
		if($db->query($sql)){
			echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
			ShowMessage("恭喜您，常用操作删除成功！","?iframe=menu","infotitle2",1000,1);
		}
	}
?>