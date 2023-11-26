<?php
Administrator(7);
$action=SafeRequest("action","get");
switch($action){
	case 'replacement':
		mainjump();
		replacement();
		break;
	case 'hitrand':
		mainjump();
		hitrand();
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
<title>数据替换</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function exchange_type(theForm){
	var stra='<select name="CD_Rescord"><option value="CD_Name">音乐名称</option><option value="CD_Singer">所属歌手</option><option value="CD_User">所属会员</option><option value="CD_Url">试听地址</option><option value="CD_DownUrl">下载地址</option><option value="CD_Pic">音乐封面</option><option value="CD_Lrc">动态歌词</option><option value="CD_Word">文本歌词</option></select>';
	var strb='<select name="CD_Rescord"><option value="CD_Name">专辑名称</option><option value="CD_User">所属会员</option><option value="CD_YuYan">所属语言</option><option value="CD_Singer">所属歌手</option><option value="CD_GongSi">发行公司</option><option value="CD_Pic">专辑封面</option><option value="CD_Intro">专辑介绍</option></select>';
	var strc='<select name="CD_Rescord"><option value="CD_Name">歌手名称</option><option value="CD_User">所属会员</option><option value="CD_Area">所属分类</option><option value="CD_Pic">歌手封面</option><option value="CD_Intro">歌手介绍</option></select>';
	var strd='<select name="CD_Rescord"><option value="CD_Singer">所属歌手</option><option value="CD_User">所属会员</option><option value="CD_Name">视频名称</option><option value="CD_Play">视频地址</option><option value="CD_Pic">视频封面</option></select>';
	if (theForm.CD_Table.value =='music'){
	        document.getElementById("CD_Select").innerHTML = stra;
	}
	if (theForm.CD_Table.value =='special'){
	        document.getElementById("CD_Select").innerHTML = strb;
	}
	if (theForm.CD_Table.value =='singer'){
	        document.getElementById("CD_Select").innerHTML = strc;
	}
	if (theForm.CD_Table.value =='video'){
	        document.getElementById("CD_Select").innerHTML = strd;
	}
}
function CheckForm(){
        if(document.form.CD_Table.value==""){
            asyncbox.tips("数据表不能为空，请选择！", "wait", 1000);
            document.form.CD_Table.focus();
            return false;
        }
        else if(document.form.CD_Old.value==""){
            asyncbox.tips("字段不能为空，请填写！", "wait", 1000);
            document.form.CD_Old.focus();
            return false;
        }
        else {
            return true;
        }
}
function exchange_type1(theForm){
	var stra='<select name="CD_Rescord1"><option value="CD_Hits">音乐人气</option></select>';
	var strb='<select name="CD_Rescord1"><option value="CD_Hits">专辑人气</option></select>';
	var strc='<select name="CD_Rescord1"><option value="CD_Hits">歌手人气</option></select>';
	var strd='<select name="CD_Rescord1"><option value="CD_Hits">视频人气</option></select>';
	if (theForm.CD_Table1.value =='music'){
	        document.getElementById("CD_Select1").innerHTML = stra;
	}
	if (theForm.CD_Table1.value =='special'){
	        document.getElementById("CD_Select1").innerHTML = strb;
	}
	if (theForm.CD_Table1.value =='singer'){
	        document.getElementById("CD_Select1").innerHTML = strc;
	}
	if (theForm.CD_Table1.value =='video'){
	        document.getElementById("CD_Select1").innerHTML = strd;
	}
}
function CheckForm1(){
        if(document.form1.CD_Table1.value==""){
            asyncbox.tips("数据表不能为空，请选择！", "wait", 1000);
            document.form1.CD_Table1.focus();
            return false;
        }
        else if(document.form1.CD_Start.value==""){
            asyncbox.tips("下限数字不能为空，请填写！", "wait", 1000);
            document.form1.CD_Start.focus();
            return false;
        }
        else if(document.form1.CD_End.value==""){
            asyncbox.tips("上限数字不能为空，请填写！", "wait", 1000);
            document.form1.CD_End.focus();
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 工具 - 数据替换';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='工具&nbsp;&raquo;&nbsp;数据替换&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=数据替换&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>数据替换</h3></div></div><div class="floattopempty"></div>
<form method="post" name="form" action="?iframe=bulk&action=replacement" target="iframe">
<table class="tb tb2">
<tr><th class="partition">替换字段</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="CD_Table" id="CD_Table" onchange="exchange_type(form)">
<option value="">选择数据表</option>
<option value="music">音乐</option>
<option value="special">专辑</option>
<option value="singer">歌手</option>
<option value="video">视频</option>
</select></td>
<td id="CD_Select"></td>
<td>中的字段：<input type="text" class="txt" name="CD_Old" id="CD_Old">替换成：<input type="text" class="txt" name="CD_New" id="CD_New"></td><td><input type="submit" class="btn" value="确认替换" onclick="return CheckForm();" /></td>
</tr>
</table>
</form>
<form method="post" name="form1" action="?iframe=bulk&action=hitrand" target="iframe">
<table class="tb tb2">
<tr><th class="partition">设置人气</th></tr>
</table>
<table class="tb tb2">
<tr>
<td><select name="CD_Table1" id="CD_Table1" onchange="exchange_type1(form1)">
<option value="">选择数据表</option>
<option value="music">音乐</option>
<option value="special">专辑</option>
<option value="singer">歌手</option>
<option value="video">视频</option>
</select></td>
<td id="CD_Select1"></td>
<td>下限数值：<input type="text" class="txt" name="CD_Start" id="CD_Start" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">上限至：<input type="text" class="txt" name="CD_End" id="CD_End" value="999" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td><input type="submit" class="btn" value="随机设置" onclick="return CheckForm1();" /></td>
</tr>
</table>
</form>
<h3>QianWei Music 提示</h3>
<div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=bulk&action=mainjump"></iframe></div>
</div>
</body>
</html>
<?php
} function replacement(){
	global $db;
	$CD_Table=SafeRequest("CD_Table","post");
	$CD_Rescord=SafeRequest("CD_Rescord","post");
	$CD_Old=SafeRequest("CD_Old","post");
	$CD_New=SafeRequest("CD_New","post");
	if($CD_Table=="music"){
		$table=tname('music');
		$sql="select ".$CD_Rescord.",CD_ID from ".tname('music')."  where ".$CD_Rescord." like '%".$CD_Old."%'";
	}elseif($CD_Table=="special"){
		$table=tname('special');
		$sql="select ".$CD_Rescord.",CD_ID from ".tname('special')." where ".$CD_Rescord." like '%".$CD_Old."%'";
	}elseif($CD_Table=="singer"){
		$table=tname('singer');
		$sql="select ".$CD_Rescord.",CD_ID from ".tname('singer')." where ".$CD_Rescord." like '%".$CD_Old."%'";
	}else{
		$table=tname('video');
		$sql="select ".$CD_Rescord.",CD_ID from ".tname('video')." where ".$CD_Rescord." like '%".$CD_Old."%'";
	}
	$result=$db->query($sql);
	if($result){
		while ($row = $db->fetch_array($result)) {
			$replace=ReplaceStr($row[$CD_Rescord],$CD_Old,$CD_New);
			$sqls="update ".$table." set ".$CD_Rescord."='".$replace."' where CD_ID=".$row['CD_ID'];
			$db->query($sqls);
			echo "替换字段 <font color=\"green\">".ReplaceStr($replace,$CD_New,"<font color=\"red\">".$CD_New."</font>")."</font> ... 成功<br />";
		}
		echo "<br /><font color=\"green\">恭喜，字段已经全部替换完成！</font>";
	}
} function hitrand(){
	global $db;
	$CD_Table=SafeRequest("CD_Table1","post");
	$CD_Rescord=SafeRequest("CD_Rescord1","post");
	$CD_Start=SafeRequest("CD_Start","post");
	$CD_End=SafeRequest("CD_End","post");
	if($CD_Table=="music"){
		$table=tname('music');
		$sql="select CD_Name,CD_ID from ".tname('music');
	}elseif($CD_Table=="special"){
		$table=tname('special');
		$sql="select CD_Name,CD_ID from ".tname('special');
	}elseif($CD_Table=="singer"){
		$table=tname('singer');
		$sql="select CD_Name,CD_ID from ".tname('singer');
	}else{
		$table=tname('video');
		$sql="select CD_Name,CD_ID from ".tname('video');
	}
	$result=$db->query($sql);
	if($result){
		while ($row = $db->fetch_array($result)) {
			$hit=mt_rand($CD_Start,$CD_End);
			$sqls="update ".$table." set ".$CD_Rescord."=".$hit." where CD_ID=".$row['CD_ID'];
			$db->query($sqls);
			echo "<font color=\"green\">".$row['CD_Name']."</font> 人气设置为 <font color=\"blue\">".$hit."</font> ... 成功<br />";
		}
		echo "<br /><font color=\"green\">恭喜，人气已经全部设置完成！</font>";
	}
}
?>