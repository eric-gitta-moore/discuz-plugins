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
<title>ִ�����</title>
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
            asyncbox.tips("���벻��Ϊ�գ������룡", "wait", 1000);
            document.form.CD_Pass.focus();
            return false;
        }
        else if(document.form.CD_Sql.value==""){
            asyncbox.tips("��䲻��Ϊ�գ�����д��", "wait", 1000);
            document.form.CD_Sql.focus();
            return false;
        }
        else if(document.form.CD_Sql.value!=="" && is_create_sql(document.form.CD_Sql.value)==false){
            asyncbox.tips("��䲻�淶����������д��", "error", 1000);
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ���� - ִ�����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='����&nbsp;&raquo;&nbsp;ִ�����&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=ִ�����&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>ִ�����</h3></div></div><div class="floattopempty"></div>
<form method="post" name="form" action="?iframe=sql&action=createsql" target="iframe">
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li class="lightnum">���ѣ�SQL���������ӡ�;������ÿ��ֻ����ִ��һ��</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<tr><td>���룺<input type="password" class="txt" name="CD_Pass" id="CD_Pass">&nbsp;&nbsp;Ϊ��������ύ������֤��ǰϵͳ�û��ĵ�¼����</td></tr>
</table>
<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">��䣺</div><textarea rows="6" cols="50" id="CD_Sql" name="CD_Sql" style="width:400px;height:100px;"></textarea></td></tr>
<tr><td><input type="submit" class="btn" value="�ύ" onclick="return CheckForm();" /></td></tr>
</table>
</form>
<h3>QianWei Music ��ʾ</h3>
<div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=sql&action=mainjump"></iframe></div>
</div>
</body>
</html>
<?php
} function create_sql(){
        if(cd_weboffa==0){die("<font color=\"red\">ִ��ǰ���ȹر�վ�㣡</font>");}
        if(md5(md5($_POST['CD_Pass']))!==$_COOKIE['CD_AdminPassWord']){exit("<font color=\"#C00\">�������</font>");}
	mysql_query("SET NAMES gb2312",mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd));
	if(mysql_query($_POST['CD_Sql'])){
		echo "<font color=\"green\">��ϲ�����ִ����ɣ�</font>";
	}else{
		echo "<font color=\"red\">".mysql_error()."</font>";
	}
}
?>