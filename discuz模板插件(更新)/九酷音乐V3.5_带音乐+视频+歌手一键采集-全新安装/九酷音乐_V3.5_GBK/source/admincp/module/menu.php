<?php
Administrator(1);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>���ò�������</title>
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
            asyncbox.tips("������Ϊ�գ�����д��", "wait", 1000);
            document.form1.cd_order.focus();
            return false;
        }
        else if(document.form1.cd_name.value==""){
            asyncbox.tips("���Ʋ���Ϊ�գ�����д��", "wait", 1000);
            document.form1.cd_name.focus();
            return false;
        }
        else if(document.form1.cd_url.value==""){
            asyncbox.tips("URL����Ϊ�գ�����д��", "wait", 1000);
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - �༭���ò���';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�༭���ò���';</script>
<div class="floattop"><div class="itemtitle"><h3>���ò�������</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">�༭���ò���</th></tr>
</table>
<form name="form" method="post" action="?iframe=menu&action=editsave">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>����</th>
<th>����</th>
<th>URL</th>
<th>�༭����</th>
</tr>
<?php
if($menunum==0){
?>
<tr><td colspan="2" class="td27">û�г��ò���</td></tr>
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
<td><input type="button" class="btn" value="ɾ��" onclick="location.href='?iframe=menu&action=del&cd_id=<?php echo $row['cd_id']; ?>';" /></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td class="td25"><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label></td><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="form" value="�ύ�޸�" /></div></td></tr>
</table>
</form>
<table class="tb tb2">
<tr><th class="partition">�������ò���</th></tr>
</table>
<form name="form1" method="post" action="?iframe=menu&action=saveadd">
<table class="tb tb2">
<tr class="header">
<th>����</th>
<th>����</th>
<th>URL</th>
</tr>
<tr class="hover">
<td class="td28"><input type="text" class="txt" size="3" name="cd_order" id="cd_order" value="0" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td><input type="text" class="txt" size="25" name="cd_name" id="cd_name"></td>
<td class="td26"><input type="text" class="txt" size="40" name="cd_url" id="cd_url"></td>
</tr>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form1" class="btn" value="����" onclick="return CheckForm();" /></div></td></tr>
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
		ShowMessage("�˵� ".$cd_name." �ѳɹ���ӵ����ò���������������һҳ��������<a href=\"?iframe=menu\">������༭���ò���</a>","history.back(1);","infotitle2",3000,2);
	}

	function SaveAdd(){
		global $db;
		if(!submitcheck('form1')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_order=SafeRequest("cd_order","post");
		$cd_name=SafeRequest("cd_name","post");
		$cd_url=SafeRequest("cd_url","post");
		$sql="Insert ".tname('menu')." (cd_order,cd_name,cd_url) values (".$cd_order.",'".$cd_name."','".$cd_url."')";
		$db->query($sql);
		echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
		ShowMessage("��ϲ�������ò��������ɹ���","?iframe=menu","infotitle2",1000,1);
	}

	function EditSave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		if($cd_id==0){
			ShowMessage("�޸�ʧ�ܣ����ȹ�ѡҪ�༭�ĳ��ò�����","?iframe=menu","infotitle3",1000,1);
		}else{
			$ID=explode(",",$cd_id);
			for($i=0;$i<count($ID);$i++){
				$cd_order=SafeRequest("cd_order".$ID[$i],"post");
				$cd_name=SafeRequest("cd_name".$ID[$i],"post");
				$cd_url=SafeRequest("cd_url".$ID[$i],"post");
				if(!IsNum($cd_order)){ShowMessage("�޸ĳ���������Ϊ�գ�","?iframe=menu","infotitle3",1000,1);}
				if(!IsNul($cd_name)){ShowMessage("�޸ĳ������Ʋ���Ϊ�գ�","?iframe=menu","infotitle3",1000,1);}
				if(!IsNul($cd_url)){ShowMessage("�޸ĳ���URL����Ϊ�գ�","?iframe=menu","infotitle3",1000,1);}
				$sql="update ".tname('menu')." set cd_order=".$cd_order.",cd_name='".$cd_name."',cd_url='".$cd_url."' where cd_id=".$ID[$i];
				$db->query($sql);
			}
			echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
			ShowMessage("��ϲ�������ò����޸ĳɹ���","?iframe=menu","infotitle2",1000,1);
		}
	}

	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('menu')." where cd_id=".$cd_id;
		if($db->query($sql)){
			echo "<script type=\"text/javascript\">parent.$('menu_index').innerHTML='".Menu_Index()."';</script>";
			ShowMessage("��ϲ�������ò���ɾ���ɹ���","?iframe=menu","infotitle2",1000,1);
		}
	}
?>