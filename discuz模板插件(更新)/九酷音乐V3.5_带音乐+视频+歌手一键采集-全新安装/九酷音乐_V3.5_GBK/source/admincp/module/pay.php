<?php
Administrator(8);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>֧������</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function s(){
        var k=document.getElementById("search").value;
        if(k==""){
                asyncbox.tips("������Ҫ��ѯ�Ĺؼ��ʣ�", "wait", 1000);
                document.getElementById("search").focus();
                return false;
        }else{
                document.btnsearch.submit();
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'add':
		adds();
		break;
	case 'edit':
		edits();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		$sql="select * from ".tname('paylog')." where cd_title like '%".$key."%' or cd_uname like '%".$key."%' order by cd_addtime desc";
		logs($sql,20);
		break;
	case 'log':
		$lock=SafeRequest("lock","get");
		if(!IsNum($lock)){
		        $sql="select * from ".tname('paylog')." order by cd_addtime desc";
		}else{
		        $sql="select * from ".tname('paylog')." where cd_lock=".$lock." order by cd_addtime desc";
		}
		logs($sql,20);
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php
function logs($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$paynum=$db->num_rows($result);
?>
<div class="container">
<?php if($_GET['action']=="log"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ϵͳ - ֧����¼';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;֧����¼&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=֧����¼&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ϵͳ - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;��������';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>֧����¼</h3><ul class="tab1">
<li><a href="?iframe=pay"><span>�㿨��Ʒ</span></a></li>
<li class="current"><a href="?iframe=pay&action=log"><span>֧����¼</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>�������붩���š�֧����Ա�ȹؼ��ʽ�������</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="pay">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=pay&action=log">����״̬</option>
<option value="?iframe=pay&action=log&lock=0"<?php if(isset($_GET['lock']) && $_GET['lock']==0){echo " selected";} ?>>֧���ɹ�</option>
<option value="?iframe=pay&action=log&lock=1"<?php if(isset($_GET['lock']) && $_GET['lock']==1){echo " selected";} ?>>֧��ʧ��</option>
</select>
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<table class="tb tb2">
<tr class="header">
<th>��Ʒ����</th>
<th>������</th>
<th>���</th>
<th>״̬</th>
<th>֧����Ա</th>
<th>֧��ʱ��</th>
</tr>
<?php
if($paynum==0){
?>
<tr><td colspan="2" class="td27">û��֧����¼</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td><?php echo GetAlias("qianwei_pay","cd_name","cd_id",$row['cd_dataid']); ?></td>
<td><?php echo ReplaceStr($row['cd_title'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php echo $row['cd_money']; ?></td>
<td><?php if($row['cd_lock']==0){echo "�ɹ�";}else{echo "<em class=\"lightnum\">ʧ��</em>";} ?></td>
<td><a href="?iframe=pay&action=keyword&key=<?php echo $row['cd_uname']; ?>" class="act"><?php echo ReplaceStr($row['cd_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if(date("Y-m-d",$row['cd_addtime'])==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d H:i:s",$row['cd_addtime'])."</em>"; }else{ echo date("Y-m-d H:i:s",$row['cd_addtime']); } ?></td>
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
function main(){
	global $db;
	$sql="select * from ".tname('pay');
	$result=$db->query($sql);
	$classnum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ϵͳ - �㿨��Ʒ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;�㿨��Ʒ&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=�㿨��Ʒ&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>�㿨��Ʒ</h3><ul class="tab1">
<li class="current"><a href="?iframe=pay"><span>�㿨��Ʒ</span></a></li>
<li><a href="?iframe=pay&action=log"><span>֧����¼</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">�༭��Ʒ</th></tr>
</table>
<form name="form" method="post" action="?iframe=pay&action=edit">
<table class="tb tb2">
<tr class="header">
<th>��Ʒ����</th>
<th>��Ʒ����</th>
<th>���</th>
<th>���</th>
<th>״̬</th>
</tr>
<?php
if($classnum==0){
?>
<tr><td colspan="2" class="td27">û�е㿨��Ʒ</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td><select name="cd_type<?php echo $row['cd_id']; ?>">
<option value="0"<?php if($row['cd_type']==0){echo " selected";} ?>>���</option>
<option value="1"<?php if($row['cd_type']==1){echo " selected";} ?>>����</option>
<option value="2"<?php if($row['cd_type']==2){echo " selected";} ?>>����</option>
</select></td>
<td><input type="text" name="cd_name<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_name']; ?>" class="txt" /></td>
<td class="td25"><input type="text" name="cd_points<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_points']; ?>" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
<td class="td25"><input type="text" name="cd_money<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_money']; ?>" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
<td class="td25"><input type="hidden" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><input type="checkbox" class="checkbox" name="cd_checks<?php echo $row['cd_id']; ?>" value="1" checked />����</td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="edit" value="�ύ�޸�" /></div></td></tr>
</table>
</form>

<table class="tb tb2">
<tr><th class="partition">������Ʒ</th></tr>
</table>
<form method="post" action="?iframe=pay&action=add">
<table class="tb tb2">
<tr class="header">
<th>��Ʒ����</th>
<th>��Ʒ����</th>
<th>���</th>
<th>���</th>
</tr>
<tr class="hover">
<td><select name="cd_type">
<option value="0">���</option>
<option value="1">����</option>
<option value="2">����</option>
</select></td>
<td><input type="text" class="txt" size="25" name="cd_name"></td>
<td class="td28"><input type="text" class="txt" size="3" name="cd_points" value="10" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td28"><input type="text" class="txt" size="3" name="cd_money" value="10" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="add" class="btn" value="����" /></div></td></tr>
</table>
</form>
</div>



<?php
}
	function adds(){
		global $db;
		if(!submitcheck('add')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_type = SafeRequest("cd_type","post");
		$cd_name = SafeRequest("cd_name","post");
		$cd_points = SafeRequest("cd_points","post");
		$cd_money = SafeRequest("cd_money","post");
		if(!IsNul($cd_name)){ShowMessage("����������Ʒ���Ʋ���Ϊ�գ�","?iframe=pay","infotitle3",1000,1);}
		if(!IsNum($cd_points)){ShowMessage("����������Ҳ���Ϊ�գ�","?iframe=pay","infotitle3",1000,1);}
		if(!IsNum($cd_money)){ShowMessage("������������Ϊ�գ�","?iframe=pay","infotitle3",1000,1);}
		$sql="Insert ".tname('pay')." (cd_type,cd_name,cd_points,cd_money) values (".$cd_type.",'".$cd_name."',".$cd_points.",".$cd_money.")";
		if($db->query($sql)){
			ShowMessage("��ϲ�����㿨��Ʒ�����ɹ���","?iframe=pay","infotitle2",1000,1);
		}else{
			ShowMessage("���������㿨��Ʒ����ʧ�ܣ�","?iframe=pay","infotitle3",3000,1);
		}
	}

	function edits(){
		global $db;
		if(!submitcheck('edit')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		$ID=explode(",",$cd_id);
		for($i=0;$i<count($ID);$i++){
			$cd_type=SafeRequest("cd_type".$ID[$i],"post");
			$cd_name=SafeRequest("cd_name".$ID[$i],"post");
			$cd_points=SafeRequest("cd_points".$ID[$i],"post");
			$cd_money=SafeRequest("cd_money".$ID[$i],"post");
			$cd_checks=SafeRequest("cd_checks".$ID[$i],"post");
			if(!IsNul($cd_name)){ShowMessage("�޸ĳ�����Ʒ���Ʋ���Ϊ�գ�","?iframe=pay","infotitle3",1000,1);}
			if(!IsNum($cd_points)){ShowMessage("�޸ĳ�����Ҳ���Ϊ�գ�","?iframe=pay","infotitle3",1000,1);}
			if(!IsNum($cd_money)){ShowMessage("�޸ĳ�������Ϊ�գ�","?iframe=pay","infotitle3",1000,1);}
			if($cd_checks==1){
				$sql="update ".tname('pay')." set cd_type=".$cd_type.",cd_name='".$cd_name."',cd_points=".$cd_points.",cd_money=".$cd_money." where cd_id=".$ID[$i];
			}else{
				$sql="delete from ".tname('pay')." where cd_id=".$ID[$i];
			}
			$db->query($sql);
		}
		ShowMessage("��ϲ�����㿨��Ʒ�޸ĳɹ���","?iframe=pay","infotitle2",1000,1);
	}
?>