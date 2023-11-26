<?php
$action=SafeRequest("action","get");
if($action=="login"){
	if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,0);}
	$CD_Name=SafeRequest("CD_AdminUserName","post");
	$CD_Pass=md5(SafeRequest("CD_AdminPassWord","post"));
	$CD_Code=SafeRequest("CD_CheckCode","post");
	$logtime=date('Y-m-d H:i:s');
	$UIP=getonlineip();
	global $db;
	if(cd_webcodea==0){
		if($CD_Code!==cd_webcodeb){ShowMessage("认证码有误，请检查！","admin.php","infotitle3",2000,0);}
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
		ShowMessage("登录成功，正在转向管理中心！","?iframe=index","infotitle2",1000,0);
	}else{
		ShowMessage("登录信息有误或帐号未开启，请检查！","admin.php","infotitle3",3000,0);
	}
}elseif($action=="logout"){
	setcookie("CD_AdminID","",time()-1);
	setcookie("CD_AdminUserName","",time()-1);
	setcookie("CD_AdminPassWord","",time()-1);
	setcookie("CD_Permission","",time()-1);
	setcookie("CD_Login","",time()-1);
	ShowMessage("您已经安全退出管理中心！","admin.php","infotitle1",1000,0);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>登录管理中心</title>
<link rel="stylesheet" href="static/admincp/images/main.css" type="text/css" media="all" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckLogin(){
	if(document.form.CD_AdminUserName.value==""){
	        asyncbox.tips("用户名不能为空，请填写！", "wait", 1000);
	        document.form.CD_AdminUserName.focus();
	        return false;
	}
	else if(document.form.CD_AdminPassWord.value==""){
	        asyncbox.tips("密码不能为空，请填写！", "wait", 1000);
	        document.form.CD_AdminPassWord.focus();
	        return false;
	}
	<?php if(cd_webcodea==0){ ?>
	else if(document.form.CD_CheckCode.value==""){
	        asyncbox.tips("认证码不能为空，请填写！", "wait", 1000);
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
		<p><?php echo cd_version; ?> 是 <a href="http://www.qianwe.com" target="_blank">前卫音乐</a> 旗下 <a href="http://www.qianwei.in" target="_blank">QianWei Music</a> 推出的以音乐为基础的专业建站平台，帮助网站实现一站式服务。</p>
	</td>
	<td>	<form method="post" name="form" action="?action=login" target="_top">
		<p class="logintitle">用户名: </p>
		<p class="loginform"><input name="CD_AdminUserName" id="CD_AdminUserName" type="text" class="txt" /></p>
		<p class="logintitle">密　码:</p>
		<p class="loginform"><input name="CD_AdminPassWord" id="CD_AdminPassWord" type="password" class="txt" /></p>
		<?php if(cd_webcodea==0){ ?>
		<p class="logintitle">提　问:</p>
		<p class="loginform"><select><option value="认证码">认证码</option></select></p>
		<p class="logintitle">回　答:</p>
		<p class="loginform"><input name="CD_CheckCode" id="CD_CheckCode" type="password" class="txt" /></p>
		<?php }else{ ?>
		<p class="logintitle">提　问:</p>
		<p class="loginform"><select><option value="无安全提问">无安全提问</option></select></p>
		<p class="logintitle">免　答:</p>
		<p class="loginform"><input class="txt" readonly="readonly" /></p>
		<?php } ?>
		<p class="loginnofloat"><input name="form" value="提交" type="submit" class="btn" onclick="return CheckLogin();" /></p>
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