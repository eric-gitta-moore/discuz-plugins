<?php
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>վ����Ŀ</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="source/plugin/layer/jquery.js"></script>
<script type="text/javascript" src="source/plugin/layer/lib.js"></script>
<script type="text/javascript">
layer.ready(function() {
        pop = {
                up : function(text, url, width, height, top) {
                        $.layer({
                                type : 2,
                                title : text,
                                iframe : {src : url},
                                area : [width, height],
                                offset : [top, '50%'],
                                shade : [0.1, '#000', true]
                        });
                }
        }
});
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.name != 'chkall')
			e.checked = form.chkall.checked;
	}
}
function exchange_type(theForm){
	if (theForm.CD_SystemID.value =='2'){
		document.form1.CD_AliasName.focus();
		return false;
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
	case 'editishide':
		EditIsHide();
		break;
	case 'editsave':
		EditSave();
		break;
	case 'saveadd':
		SaveAdd();
		break;
	case 'unite':
		Unite();
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
	$sql="select * from ".tname('class')." order by CD_ID asc";
	$result=$db->query($sql);
	$classnum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ������� - վ����Ŀ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;վ����Ŀ&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=վ����Ŀ&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>վ����Ŀ</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">��Ŀ����</th></tr>
</table>
<form name="form" method="post" action="?iframe=class&action=editsave">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>��������</th>
<th>��Ŀ����</th>
<th>Ӣ�ı���</th>
<th>��Ŀģ��</th>
<th>����</th>
<th>״̬</th>
<th>�༭����</th>
</tr>
<?php
if($classnum==0){
?>
<tr><td colspan="2" class="td27">û��վ����Ŀ</td></tr>
<?php
}
if($result){
while($row=$db->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?></td>
<td><div class="parentboard"><input type="text" name="CD_Name<?php echo $row['CD_ID']; ?>" value="<?php echo $row['CD_Name']; ?>" class="txt" /></div></td>
<?php if($row['CD_FatherID']==0){ ?>
<td class="td23 lightfont">��Ŀ��չ</td>
<?php }else if($row['CD_SystemID']==1 && $row['CD_FatherID']==1){ ?>
<td>������Ŀ
<a href="?iframe=song&action=class&CD_ClassID=<?php echo $row['CD_ID']; ?>">
<?php
$sqlstr="select * from ".tname('music')." where CD_ClassID=".$row['CD_ID'];
$res=$db -> query($sqlstr);
$nums= $db -> num_rows($res);
echo $nums;
?>
</a>
</td>
<?php }else{ ?>
<td>�ⲿ����</td>
<?php } ?>
<td><input type="text" name="CD_AliasName<?php echo $row['CD_ID']; ?>" value="<?php echo $row['CD_AliasName']; ?>" class="txt" /></td>
<td><input type="text" name="CD_Template<?php echo $row['CD_ID']; ?>" value="<?php echo $row['CD_Template']; ?>" class="txt" /><a href="javascript:void(0)" onclick="pop.up('ѡ��ģ��', '?iframe=template&f=form.CD_Template<?php echo $row['CD_ID']; ?>', '500px', '400px', '40px');" class="addtr">��ѡ</a></td>
<td class="td25"><input type="text" name="CD_TheOrder<?php echo $row['CD_ID']; ?>" value="<?php echo $row['CD_TheOrder']; ?>" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
<td>
<?php if($row['CD_IsHide']==1){ ?>
<a href="?iframe=class&action=editishide&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsHide=0"><img src="static/admincp/images/ishide_no.gif" /></a>
<?php }else{ ?>
<a href="?iframe=class&action=editishide&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsHide=1"><img src="static/admincp/images/ishide_yes.gif" /></a>
<?php } ?>
</td>
<td><input type="button" class="btn" value="Ԥ��" onclick="window.open('<?php if($row['CD_SystemID']==2){ echo $row['CD_AliasName']; }else{ ?>index.php/list/<?php echo $row['CD_ID']; ?>/1/<?php } ?>')" />&nbsp;<input type="button" class="btn" <?php if($row['CD_FatherID']==1){ ?>value="ɾ��" onclick="location.href='?iframe=class&action=del&CD_ID=<?php echo $row['CD_ID']; ?>';"<?php }else{ ?>value="����" disabled="disabled"<?php } ?> /></td>
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
<tr><th class="partition">������Ŀ</th></tr>
</table>
<form id="form1" name="form1" method="post" action="?iframe=class&action=saveadd">
<table class="tb tb2">
<tr class="header">
<th>��������</th>
<th>Ӣ�ı���</th>
<th>��Ŀ����</th>
<th>��Ŀģ��</th>
<th>����</th>
<th>״̬</th>
</tr>
<tr class="hover">
<td><div class="parentboard"><input type="text" name="CD_Name" id="CD_Name" value="" class="txt" /></div></td>
<td><input type="text" name="CD_AliasName" id="CD_AliasName" value="" class="txt" /></td>
<td><select name="CD_SystemID" id="CD_SystemID" onchange="exchange_type(form1)">
<option value="1">������Ŀ</option>
<option value="2">�ⲿ����</option>
</select></td>
<td><input type="text" name="CD_Template" id="CD_Template" value="list.html" class="txt" /><a href="javascript:void(0)" onclick="pop.up('ѡ��ģ��', '?iframe=template&f=form1.CD_Template', '500px', '400px', '40px');" class="addtr">ѡ��</a></td>
<td class="td25"><input type="text" name="CD_TheOrder" id="CD_TheOrder" value="0" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
<td><select name="CD_IsHide">
<option value="0">��ʾ</option>
<option value="1">����</option>
</select></td>
</tr>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="button" class="btn" value="����" /> &nbsp;ע��: ������Ŀ������ѡ���ⲿ���ӡ����뽫������д����Ӣ�ı�������</div></td></tr>
</table>
</form>

<form action="?iframe=class&action=unite" name="unite" id="unite" method="post">
<table class="tb tb2">
<tr><th class="partition">����ת��</th></tr>
</table>
<table class="tb tb2">
<tr><td colspan="2" class="td27">ԭʼ��Ŀ:</td></tr>
<tr><td class="vtop rowform">
<select name="Type_1">
<option value="">ѡ����Ŀ</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
?>
<option value="<?php echo $row3['CD_ID']; ?>"><?php echo $row3['CD_Name']; ?></option>
<?php
}
}
?>
</select>
</td><td class="vtop tips2">�ȴ�ת�����ݵ���Ŀ</td></tr>
<tr><td colspan="2" class="td27">Ŀ����Ŀ:</td></tr>
<tr><td class="vtop rowform">
<select name="Type_2">
<option value="">ѡ����Ŀ</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
?>
<option value="<?php echo $row3['CD_ID']; ?>"><?php echo $row3['CD_Name']; ?></option>
<?php
}
}
?>
</select>
</td><td class="vtop tips2">�ȴ�ת�����ݵ���Ŀ</td></tr>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="unite" class="btn" value="ת��" /> &nbsp;ע��: ת��ǰ���ȱ������ݿ⣬ת�ƺ�����ݽ������ٵ����ָ�����ԭʼ��Ŀ����������</div></td></tr>
</table>
</form>
</div>


<?php
}
	function Unite(){
		global $db;
		if(!submitcheck('unite')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$classa=SafeRequest("Type_1","post");
		$classb=SafeRequest("Type_2","post");
		if(!IsNum($classa) || !IsNum($classb)){
			ShowMessage("ת��ʧ�ܣ���Ŀδѡ���δѡȫ��","?iframe=class","infotitle3",3000,1);
		}
		$sql="select * from ".tname('music')." where CD_ClassID=".$classa;
		$result=$db->query($sql);
		if($result){
			while($row=$db->fetch_array($result)){
				$sqlstr="update ".tname('music')." set CD_ClassID=".$classb." where CD_ID=".$row['CD_ID'];
				$db->query($sqlstr);
			}
			ShowMessage("��ϲ��������ת�Ƴɹ���","?iframe=class","infotitle2",3000,1);
		}
	}

	function SaveAdd(){
		global $db;
		if(!submitcheck('button')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_Name=SafeRequest("CD_Name","post");
		$CD_AliasName=SafeRequest("CD_AliasName","post");
		$CD_TheOrder=SafeRequest("CD_TheOrder","post");
		$CD_Template=SafeRequest("CD_Template","post");
		$CD_IsHide = SafeRequest("CD_IsHide","post");
		$CD_SystemID = SafeRequest("CD_SystemID","post");
		if(!IsNul($CD_Name)){ShowMessage("���������������Ʋ���Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
		if(!IsNul($CD_AliasName)){ShowMessage("��������Ӣ�ı�������Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
		if(!IsNul($CD_Template)){ShowMessage("����������Ŀģ�岻��Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
		if(!IsNum($CD_TheOrder)){ShowMessage("��������������Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
		$sql="Insert ".tname('class')." (CD_Name,CD_AliasName,CD_FatherID,CD_TheOrder,CD_Template,CD_IsHide,CD_SystemID) values ('".$CD_Name."','".$CD_AliasName."',1,".$CD_TheOrder.",'".$CD_Template."',".$CD_IsHide.",".$CD_SystemID.")";
		$db->query($sql);
		ShowMessage("��ϲ����վ����Ŀ�����ɹ���","?iframe=class","infotitle2",2000,1);
	}

	function EditSave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID = RequestBox("CD_ID");
		if($CD_ID==0){
			ShowMessage("�޸�ʧ�ܣ����ȹ�ѡҪ�༭����Ŀ��","?iframe=class","infotitle3",3000,1);
		}else{
			$ID=explode(",",$CD_ID);
			for($i=0;$i<count($ID);$i++){
				$CD_Name=SafeRequest("CD_Name".$ID[$i],"post");
				$CD_AliasName=SafeRequest("CD_AliasName".$ID[$i],"post");
				$CD_Template=SafeRequest("CD_Template".$ID[$i],"post");
				$CD_TheOrder=SafeRequest("CD_TheOrder".$ID[$i],"post");
				if(!IsNul($CD_Name)){ShowMessage("�޸ĳ����������Ʋ���Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
				if(!IsNul($CD_AliasName)){ShowMessage("�޸ĳ���Ӣ�ı�������Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
				if(!IsNul($CD_Template)){ShowMessage("�޸ĳ�����Ŀģ�岻��Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
				if(!IsNum($CD_TheOrder)){ShowMessage("�޸ĳ���������Ϊ�գ�","?iframe=class","infotitle3",2000,1);}
				$sql="update ".tname('class')." set CD_Name='".$CD_Name."',CD_AliasName='".$CD_AliasName."',CD_Template='".$CD_Template."',CD_TheOrder=".$CD_TheOrder." where CD_ID=".$ID[$i];
				$db->query($sql);
			}
			ShowMessage("��ϲ����վ����Ŀ�޸ĳɹ���","?iframe=class","infotitle2",2000,1);
		}
	}

	function EditIsHide(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsHide = SafeRequest("CD_IsHide","get");
		$sql="update ".tname('class')." set CD_IsHide=".$CD_IsHide." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ����״̬�л��ɹ���","?iframe=class","infotitle2",1000,1);
		}
	}

	function Del(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="delete from ".tname('class')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ����վ����Ŀɾ���ɹ���","?iframe=class","infotitle2",2000,1);
		}
	}
?>