<?php
Administrator(8);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>�ϴ���¼</title>
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
	case 'keyword':
		$key=SafeRequest("key","get");
		$sql="select * from ".tname('upload')." where cd_username like '%".$key."%' or cd_filetype like '%".$key."%' order by cd_filetime desc";
		logs($sql,20);
		break;
	default:
		$sql="select * from ".tname('upload')." order by cd_filetime desc";
		logs($sql,20);
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
	$upnum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ϵͳ - �ϴ���¼';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;�ϴ���¼&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=�ϴ���¼&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>�ϴ���¼</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>Ϊ�����Ƹ�����أ��ϴ���¼�ݲ�����ɾ�������������ϴ��û����ļ����͵ȹؼ��ʽ�������</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="uplog">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<table class="tb tb2">
<tr class="header">
<th>�ļ�����</th>
<th>�ļ���С</th>
<th>�ļ�����</th>
<th>�ϴ��û�</th>
<th>�ϴ�ʱ��</th>
</tr>
<?php
if($upnum==0){
?>
<tr><td colspan="2" class="td27">û���ϴ���¼</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td><a href="<?php echo $row['cd_fileurl']; ?>" target="_blank" class="act"><?php echo $row['cd_filename']; ?></a></td>
<td><?php echo formatsize($row['cd_filesize']); ?></td>
<td><a href="?iframe=uplog&action=keyword&key=<?php echo $row['cd_filetype']; ?>" class="act"><?php echo ReplaceStr($row['cd_filetype'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=uplog&action=keyword&key=<?php echo $row['cd_username']; ?>" class="act"><?php echo ReplaceStr($row['cd_username'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if(date("Y-m-d",$row['cd_filetime'])==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d H:i:s",$row['cd_filetime'])."</em>"; }else{ echo date("Y-m-d H:i:s",$row['cd_filetime']); } ?></td>
</tr>
<?php
}
}
?>
<?php echo $Arr[0]; ?>
</table>
</div>
<?php } ?>