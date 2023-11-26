<?php
Administrator(7);
$action=SafeRequest("action","get");
switch($action){
	case 'createsql':
		mainjump();
		create_sql();
		break;
	case 'mainjump':
		mainjump();
		break;
	default:
		main();
		break;
} function main(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>执行语句</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function is_create_sql(text){
	if(text.match(/\<?php echo cd_tablename; ?>/g)){
	        return true;
	}
	return false;
}
function CheckForm(){
        if(document.form.CD_Pass.value==""){
            asyncbox.tips("密码不能为空，请输入！", "wait", 1000);
            document.form.CD_Pass.focus();
            return false;
        }
        else if(document.form.CD_Sql.value==""){
            asyncbox.tips("语句不能为空，请填写！", "wait", 1000);
            document.form.CD_Sql.focus();
            return false;
        }
        else if(document.form.CD_Sql.value!=="" && is_create_sql(document.form.CD_Sql.value)==false){
            asyncbox.tips("语句不规范，请重新填写！", "error", 1000);
            document.form.CD_Sql.focus();
            return false;
        }
        else {
            return true;
        }
}
</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 工具 - 执行语句';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='工具&nbsp;&raquo;&nbsp;执行语句&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=执行语句&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>执行语句</h3></div></div><div class="floattopempty"></div>
<form method="post" name="form" action="?iframe=sql&action=createsql" target="iframe">
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li class="lightnum">提醒：SQL语句后面必须加“;”，且每次只允许执行一条</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<tr><td>密码：<input type="password" class="txt" name="CD_Pass" id="CD_Pass">&nbsp;&nbsp;为避免恶意提交，需验证当前系统用户的登录密码</td></tr>
</table>
<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">语句：</div><textarea rows="6" cols="50" id="CD_Sql" name="CD_Sql" style="width:400px;height:100px;"></textarea></td></tr>
<tr><td><input type="submit" class="btn" value="提交" onclick="return CheckForm();" /></td></tr>
</table>
</form>
<h3>QianWei Music 提示</h3>
<div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=sql&action=mainjump"></iframe></div>
</div>
</body>
</html>
<?php
} function create_sql(){
        if(cd_weboffa==0){die("<font color=\"red\">执行前请先关闭站点！</font>");}
        if(md5(md5($_POST['CD_Pass']))!==$_COOKIE['CD_AdminPassWord']){exit("<font color=\"#C00\">密码错误！</font>");}
	mysql_query("SET NAMES gb2312",mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd));
	if(mysql_query($_POST['CD_Sql'])){
		echo "<font color=\"green\">恭喜，语句执行完成！</font>";
	}else{
		echo "<font color=\"red\">".mysql_error()."</font>";
	}
}
?>