<?php
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>模板标签</title>
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
            asyncbox.tips("标签名称不能为空，请填写！", "wait", 1000);
            document.form.cd_name.focus();
            return false;
        }
        else if(document.form.cd_type.value==""){
            asyncbox.tips("标签分类不能为空，请填写！", "wait", 1000);
            document.form.cd_type.focus();
            return false;
        }
        else if(document.form.cd_priority.value==""){
            asyncbox.tips("优先等级不能为空，请填写！", "wait", 1000);
            document.form.cd_priority.focus();
            return false;
        }
        else if(document.form.cd_selflable.value==""){
            asyncbox.tips("标签内容不能为空，请填写！", "wait", 1000);
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
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 新增标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;新增标签&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=新增标签&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 编辑标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;编辑标签';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>标签</h3><ul class="tab1">
<li><a href="?iframe=tag"><span>模板标签</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag&action=add"><span>新增标签</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>标签</th></tr>
<tr><td colspan="2" class="td27">标签名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_name; ?>" name="cd_name" id="cd_name"></td><td class="vtop tips2">英文区分大小写，不用输入定界符且不可重复</td></tr>
<tr><td colspan="2" class="td27">标签分类:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo $cd_type; ?>" id="cd_type" name="cd_type"></li>
<li><select onchange="cd_type.value=this.value;">
<option value=""><?php echo $arrname; ?>分类</option>
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
</td><td class="vtop tips2">如没有分类，请新增一个</td></tr>
<tr><td colspan="2" class="td27">标签描述:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_remark; ?>" name="cd_remark" id="cd_remark"></td><td class="vtop tips2">对标签的简短描述，比如填它的作用等</td></tr>
<tr><td colspan="2" class="td27">优先等级:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_priority; ?>" name="cd_priority" id="cd_priority" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">数字越小，优先级越高</td></tr>
<tr><td colspan="2" class="td27">标签内容:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="cd_selflable" id="cd_selflable" cols="50" class="tarea"><?php echo $cd_selflable; ?></textarea></td><td class="vtop tips2">支持所有标签</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="cd_httpurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" /><input type="submit" name="form" onclick="return CheckForm();" class="btn" value="提交" /></div></td></tr>
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
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 模板标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;模板标签&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=模板标签&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 界面风格 - 标签分类';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='界面风格&nbsp;&raquo;&nbsp;标签分类';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>模板标签</h3><ul class="tab1">
<li class="current"><a href="?iframe=tag"><span>模板标签</span></a></li>
<li><a href="?iframe=tag&action=add"><span>新增标签</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<div style="height:45px;line-height:45px;">
<a href="?iframe=tag"><?php if($key==""){echo "<b>全部分类</b>";}else{echo "全部分类";} ?></a> | 
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
<th>编号</th>
<th>标签代码</th>
<th>优先等级</th>
<th>标签描述</th>
<th>更新时间</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有模板标签</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td><?php echo $row['cd_id']; ?></td>
<td><a href="javascript:void(0)" onclick="setcopy('{tag:<?php echo $row['cd_name']; ?>}', '标签{tag:<?php echo $row['cd_name']; ?>}复制成功！')" class="act">{tag:<?php echo $row['cd_name']; ?>}</a></td>
<td><?php echo $row['cd_priority']; ?></td>
<td><?php echo $row['cd_remark']; ?></td>
<td><?php if(date("Y-m-d",strtotime($row['cd_addtime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d H:i:s",strtotime($row['cd_addtime']))."</em>"; }else{ echo date("Y-m-d H:i:s",strtotime($row['cd_addtime'])); } ?></td>
<td><a href="?iframe=tag&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">编辑</a><a href="?iframe=tag&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">删除</a></td>
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
	//删除
	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('label')." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，模板标签删除成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('label')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_type'],$row['cd_remark'],$row['cd_priority'],$row['cd_selflable']);
		}
		EditBoard($Arr,"?iframe=tag&action=saveedit&cd_id=".$cd_id,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=tag&action=saveadd","新增");
	}

	//执行保存
	function SaveAdd(){
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
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
		ShowMessage("恭喜您，模板标签新增成功！","?iframe=tag","infotitle2",1000,1);
	}

	//保存编辑
	function SaveEdit(){
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
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
		ShowMessage("恭喜您，模板标签编辑成功！",$cd_httpurl,"infotitle2",1000,1);
	}
?>