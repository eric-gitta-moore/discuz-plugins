<?php
$action=SafeRequest("action","get");
if($action=="login"){
	if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,0);}
	$CD_Name=SafeRequest("CD_AdminUserName","post");
	$CD_Pass=md5(SafeRequest("CD_AdminPassWord","post"));
	$CD_Code=SafeRequest("CD_CheckCode","post");
	$logtime=date('Y-m-d H:i:s');
	$UIP=getonlineip();
	global $db;
	if(cd_webcodea==0){
		if($CD_Code!==cd_webcodeb){ShowMessage("��֤���������飡","admin.php","infotitle3",2000,0);}
	}
	$sql="select CD_ID from ".tname('admin')." where CD_AdminUserName='".$CD_Name."' and CD_AdminPassWord='".$CD_Pass."' and CD_IsLock=0";
        $CD_ID=$db->getone($sql);
	if($CD_ID){
		$db->query("update ".tname('admin')." set CD_LoginNum=CD_LoginNum+1,CD_LoginIP='".$UIP."',CD_LastLogin ='".$logtime."' where CD_ID=".$CD_ID);
		$row=$db->getrow("select * from ".tname('admin')." where CD_ID=".$CD_ID);
		setcookie("CD_AdminID",$row['CD_ID']);
		setcookie("CD_AdminUserName",$row['CD_AdminUserName']);
		setcookie("CD_AdminPassWord",md5($row['CD_AdminPassWord']));
		setcookie("CD_Permission",$row['CD_Permission']);
		setcookie("CD_Login",md5($row['CD_ID'].$row['CD_AdminUserName'].md5($row['CD_AdminPassWord']).$row['CD_Permission']),time()+1800);
		ShowMessage("��¼�ɹ�������ת��������ģ�","?iframe=index","infotitle2",1000,0);
	}else{
		ShowMessage("��¼��Ϣ������ʺ�δ���������飡","admin.php","infotitle3",3000,0);
	}
}elseif($action=="logout"){
	setcookie("CD_AdminID","",time()-1);
	setcookie("CD_AdminUserName","",time()-1);
	setcookie("CD_AdminPassWord","",time()-1);
	setcookie("CD_Permission","",time()-1);
	setcookie("CD_Login","",time()-1);
	ShowMessage("���Ѿ���ȫ�˳��������ģ�","admin.php","infotitle1",1000,0);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��¼��������</title>
<link rel="stylesheet" href="static/admincp/images/main.css" type="text/css" media="all" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckLogin(){
	if(document.form.CD_AdminUserName.value==""){
	        asyncbox.tips("�û�������Ϊ�գ�����д��", "wait", 1000);
	        document.form.CD_AdminUserName.focus();
	        return false;
	}
	else if(document.form.CD_AdminPassWord.value==""){
	        asyncbox.tips("���벻��Ϊ�գ�����д��", "wait", 1000);
	        document.form.CD_AdminPassWord.focus();
	        return false;
	}
	<?php if(cd_webcodea==0){ ?>
	else if(document.form.CD_CheckCode.value==""){
	        asyncbox.tips("��֤�벻��Ϊ�գ�����д��", "wait", 1000);
	        document.form.CD_CheckCode.focus();
	        return false;
	}
	<?php } ?>
	else {
	        return true;
	}
}
</script>
</head>
<body>
<table class="logintb">
<tr>
	<td class="login">
		<h1>QianWei Music Administrator's Control Panel</h1>
		<p><?php echo cd_version; ?> �� <a href="http://www.qianwe.com" target="_blank">ǰ������</a> ���� <a href="http://www.qianwei.in" target="_blank">QianWei Music</a> �Ƴ���������Ϊ������רҵ��վƽ̨��������վʵ��һվʽ����</p>
	</td>
	<td>	<form method="post" name="form" action="?action=login" target="_top">
		<p class="logintitle">�û���: </p>
		<p class="loginform"><input name="CD_AdminUserName" id="CD_AdminUserName" type="text" class="txt" /></p>
		<p class="logintitle">�ܡ���:</p>
		<p class="loginform"><input name="CD_AdminPassWord" id="CD_AdminPassWord" type="password" class="txt" /></p>
		<?php if(cd_webcodea==0){ ?>
		<p class="logintitle">�ᡡ��:</p>
		<p class="loginform"><select><option value="��֤��">��֤��</option></select></p>
		<p class="logintitle">�ء���:</p>
		<p class="loginform"><input name="CD_CheckCode" id="CD_CheckCode" type="password" class="txt" /></p>
		<?php }else{ ?>
		<p class="logintitle">�ᡡ��:</p>
		<p class="loginform"><select><option value="�ް�ȫ����">�ް�ȫ����</option></select></p>
		<p class="logintitle">�⡡��:</p>
		<p class="loginform"><input class="txt" readonly="readonly" /></p>
		<?php } ?>
		<p class="loginnofloat"><input name="form" value="�ύ" type="submit" class="btn" onclick="return CheckLogin();" /></p>
		</form>
	</td>
</tr>
</table>
<table class="logintb">
<tr>
	<td colspan="2" class="footer">
		<div class="copyright">
			<p>Powered by <a href="http://www.qianwei.in/" target="_blank">QianWei Music</a> <?php echo cd_version; ?> </p>
			<p>&copy; 2008-<?php echo date('Y',time()); ?>, <a href="http://www.qianwe.com/" target="_blank">QianWe</a> Inc.</p>
		</div>
	</td>
</tr>
</table>
</body>
</html>