<?php
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>ģ���ǩ</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
function setcopy(text, alertmsg){
	if(is_ie) {
		clipboardData.setData('Text', text);
		asyncbox.tips(alertmsg, "success", 1000);
	} else if(prompt('Press Ctrl+C Copy to Clipboard', text)) {
		asyncbox.tips(alertmsg, "success", 1000);
	}
}
function CheckForm(){
        if(document.form.cd_name.value==""){
            asyncbox.tips("��ǩ���Ʋ���Ϊ�գ�����д��", "wait", 1000);
            document.form.cd_name.focus();
            return false;
        }
        else if(document.form.cd_type.value==""){
            asyncbox.tips("��ǩ���಻��Ϊ�գ�����д��", "wait", 1000);
            document.form.cd_type.focus();
            return false;
        }
        else if(document.form.cd_priority.value==""){
            asyncbox.tips("���ȵȼ�����Ϊ�գ�����д��", "wait", 1000);
            document.form.cd_priority.focus();
            return false;
        }
        else if(document.form.cd_selflable.value==""){
            asyncbox.tips("��ǩ���ݲ���Ϊ�գ�����д��", "wait", 1000);
            document.form.cd_selflable.focus();
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
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('label')." where cd_type like '%".$key."%' order by cd_id desc",20);
		break;
	default:
		main("select * from ".tname('label')." order by cd_id desc",30);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
		$cd_name = $Arr[0];
		$cd_type = $Arr[1];
		$cd_remark = $Arr[2];
		$cd_priority = $Arr[3];
		$cd_selflable = $Arr[4];
		if(!IsNum($cd_priority)){$cd_priority=10;}
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - ������ǩ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;������ǩ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������ǩ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - �༭��ǩ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;�༭��ǩ';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>��ǩ</h3><ul class="tab1">
<li><a href="?iframe=tag"><span>ģ���ǩ</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag&action=add"><span>������ǩ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>��ǩ</th></tr>
<tr><td colspan="2" class="td27">��ǩ����:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_name; ?>" name="cd_name" id="cd_name"></td><td class="vtop tips2">Ӣ�����ִ�Сд���������붨����Ҳ����ظ�</td></tr>
<tr><td colspan="2" class="td27">��ǩ����:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo $cd_type; ?>" id="cd_type" name="cd_type"></li>
<li><select onchange="cd_type.value=this.value;">
<option value=""><?php echo $arrname; ?>����</option>
<?php
global $db;
$sqlclass="select distinct (cd_type) from ".tname('label');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['cd_type']."\">".$row3['cd_type']."</option>";
}
}
?>
</select></li>
</ul>
</td><td class="vtop tips2">��û�з��࣬������һ��</td></tr>
<tr><td colspan="2" class="td27">��ǩ����:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_remark; ?>" name="cd_remark" id="cd_remark"></td><td class="vtop tips2">�Ա�ǩ�ļ���������������������õ�</td></tr>
<tr><td colspan="2" class="td27">���ȵȼ�:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_priority; ?>" name="cd_priority" id="cd_priority" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����ԽС�����ȼ�Խ��</td></tr>
<tr><td colspan="2" class="td27">��ǩ����:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="cd_selflable" id="cd_selflable" cols="50" class="tarea"><?php echo $cd_selflable; ?></textarea></td><td class="vtop tips2">֧�����б�ǩ</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="cd_httpurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" /><input type="submit" name="form" onclick="return CheckForm();" class="btn" value="�ύ" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db,$action;
        $key=SafeRequest("key","get");
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - ģ���ǩ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;ģ���ǩ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=ģ���ǩ&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - ��ǩ����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;��ǩ����';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>ģ���ǩ</h3><ul class="tab1">
<li class="current"><a href="?iframe=tag"><span>ģ���ǩ</span></a></li>
<li><a href="?iframe=tag&action=add"><span>������ǩ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<div style="height:45px;line-height:45px;">
<a href="?iframe=tag"><?php if($key==""){echo "<b>ȫ������</b>";}else{echo "ȫ������";} ?></a> | 
<?php
$sqlclass="select distinct (cd_type) from ".tname('label');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<a href=\"?iframe=tag&action=keyword&key=".$row3['cd_type']."\">";
if($key==$row3['cd_type']){
echo "<b>".$row3['cd_type']."</b>";
} else {
echo $row3['cd_type'];
}
echo "</a> | ";
}
}
?>
</div>
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>��ǩ����</th>
<th>���ȵȼ�</th>
<th>��ǩ����</th>
<th>����ʱ��</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û��ģ���ǩ</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td><?php echo $row['cd_id']; ?></td>
<td><a href="javascript:void(0)" onclick="setcopy('{tag:<?php echo $row['cd_name']; ?>}', '��ǩ{tag:<?php echo $row['cd_name']; ?>}���Ƴɹ���')" class="act">{tag:<?php echo $row['cd_name']; ?>}</a></td>
<td><?php echo $row['cd_priority']; ?></td>
<td><?php echo $row['cd_remark']; ?></td>
<td><?php if(date("Y-m-d",strtotime($row['cd_addtime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d H:i:s",strtotime($row['cd_addtime']))."</em>"; }else{ echo date("Y-m-d H:i:s",strtotime($row['cd_addtime'])); } ?></td>
<td><a href="?iframe=tag&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">�༭</a><a href="?iframe=tag&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
<?php echo $Arr[0]; ?>
</table>
</div>



<?php
}
	//ɾ��
	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('label')." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("��ϲ����ģ���ǩɾ���ɹ���",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//�༭
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('label')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_type'],$row['cd_remark'],$row['cd_priority'],$row['cd_selflable']);
		}
		EditBoard($Arr,"?iframe=tag&action=saveedit&cd_id=".$cd_id,"�༭");
	}

	//�������
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=tag&action=saveadd","����");
	}

	//ִ�б���
	function SaveAdd(){
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_name = SafeRequest("cd_name","post");
		$cd_type = SafeRequest("cd_type","post");
		$cd_selflable = htmlspecialchars_decode(SafeRequest("cd_selflable","post"),ENT_QUOTES);
		$cd_remark = SafeRequest("cd_remark","post");
		$cd_priority = SafeRequest("cd_priority","post");
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_type' => $cd_type,
			'cd_selflable' => $cd_selflable,
			'cd_remark' => $cd_remark,
			'cd_priority' => $cd_priority,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('label', $setarr, 1);
		ShowMessage("��ϲ����ģ���ǩ�����ɹ���","?iframe=tag","infotitle2",1000,1);
	}

	//����༭
	function SaveEdit(){
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = SafeRequest("cd_id","get");
		$cd_name = SafeRequest("cd_name","post");
		$cd_type = SafeRequest("cd_type","post");
		$cd_selflable = htmlspecialchars_decode(SafeRequest("cd_selflable","post"),ENT_QUOTES);
		$cd_remark = SafeRequest("cd_remark","post");
		$cd_priority = SafeRequest("cd_priority","post");
		$cd_httpurl = SafeRequest("cd_httpurl","post");
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_type' => $cd_type,
			'cd_selflable' => $cd_selflable,
			'cd_remark' => $cd_remark,
			'cd_priority' => $cd_priority,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		updatetable('label', $setarr, array('cd_id'=>$cd_id));
		ShowMessage("��ϲ����ģ���ǩ�༭�ɹ���",$cd_httpurl,"infotitle2",1000,1);
	}
?>