<?php
Administrator(8);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>系统用户</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckForm(){
	if(document.form.CD_AdminUserName.value==""){
		asyncbox.tips("登录帐号不能为空，请填写！", "wait", 1000);
		document.form.CD_AdminUserName.focus();
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
	case 'islock':
		IsLock();
		break;
	case 'del':
		Del();
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
	$sql="select * from ".tname('admin');
	$result=$db->query($sql);
	$nums=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 系统 - 系统用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;系统用户&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=系统用户&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>系统用户</h3><ul class="tab1">
<li class="current"><a href="?iframe=admin"><span>系统用户</span></a></li>
<li><a href="?iframe=admin&action=add"><span>新增用户</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">用户列表</th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>帐号</th>
<th>最后登录时间</th>
<th>登录次数</th>
<th>状态</th>
<th>操作</th>
</tr>
<?php
if($nums==0){
?>
<tr><td colspan="2" class="td27">没有系统用户</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><?php echo $row['CD_ID']; ?></td>
<td><a href="?iframe=admin&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act"><?php echo $row['CD_AdminUserName']; ?></a></td>
<td class="lightnum"><?php echo $row['CD_LastLogin']; ?></td>
<td><?php echo $row['CD_LoginNum']; ?></td>
<td><?php if($row['CD_IsLock']==1){ ?><a href="?iframe=admin&action=islock&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsLock=0"><img src="static/admincp/images/ishide_no.gif" /></a><?php }else{ ?><a href="?iframe=admin&action=islock&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsLock=1"><img src="static/admincp/images/ishide_yes.gif" /></a><?php } ?></td>
<td><a href="?iframe=admin&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">编辑</a><a href="?iframe=admin&action=del&CD_ID=<?php echo $row['CD_ID']; ?>" class="act" onclick="return confirm('删除系统用户将导致该帐号无法登录后台，确定吗？');">删除</a></td>
</tr>
<?php
}
}
?>
</table>
</div>


<?php
}
function EditBoard($Arr,$url,$arrname){
	global $db;
	$CD_ID = SafeRequest("CD_ID","get");
	$CD_AdminUserName = $Arr[0];
	$CD_AdminPassWord = $Arr[1];
	$CD_IsLock = $Arr[2];
	$CD_Permission = $Arr[3];
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 系统 - 新增用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;新增用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=新增用户&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 系统 - 编辑用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;编辑用户';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>用户</h3><ul class="tab1">
<li><a href="?iframe=admin"><span>系统用户</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=admin&action=add"><span>新增用户</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>用户</th></tr>
<tr><td colspan="2" class="td27">登录帐号:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $CD_AdminUserName; ?>" name="CD_AdminUserName" id="CD_AdminUserName" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">仅限字母与数字</td></tr>
<tr><td colspan="2" class="td27">登录密码:</td></tr>
<tr><td class="vtop rowform"><input type="password" class="txt" value="" name="CD_AdminPassWord" id="CD_AdminPassWord"></td><td class="vtop tips2">不修改请留空</td></tr>
<tr><td colspan="2" class="td27">确认密码:</td></tr>
<tr><td class="vtop rowform"><input type="password" class="txt" value="" name="CD_AdminPassWord1" id="CD_AdminPassWord1"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">权限设置:</td></tr>
<tr>
<td class="vtop"><ul>
<?php if(checkpermission($CD_Permission,1)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value1" value="1"<?php if(checkpermission($CD_Permission,1)){echo " checked";} ?>><label for="value1">首页</label></li>
<?php if(checkpermission($CD_Permission,2)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value2" value="2"<?php if(checkpermission($CD_Permission,2)){echo " checked";} ?>><label for="value2">全局</label></li>
<?php if(checkpermission($CD_Permission,3)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value3" value="3"<?php if(checkpermission($CD_Permission,3)){echo " checked";} ?>><label for="value3">界面风格</label></li>
<?php if(checkpermission($CD_Permission,4)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value4" value="4"<?php if(checkpermission($CD_Permission,4)){echo " checked";} ?>><label for="value4">内容审核</label></li>
<?php if(checkpermission($CD_Permission,5)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value5" value="5"<?php if(checkpermission($CD_Permission,5)){echo " checked";} ?>><label for="value5">用户管理</label></li>
<?php if(checkpermission($CD_Permission,6)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value6" value="6"<?php if(checkpermission($CD_Permission,6)){echo " checked";} ?>><label for="value6">静态生成</label></li>
<?php if(checkpermission($CD_Permission,7)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value7" value="7"<?php if(checkpermission($CD_Permission,7)){echo " checked";} ?>><label for="value7">工具</label></li>
<?php if(checkpermission($CD_Permission,8)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value8" value="8"<?php if(checkpermission($CD_Permission,8)){echo " checked";} ?>><label for="value8">系统</label></li>
<?php if(checkpermission($CD_Permission,9)){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="CD_Permission[]" id="value9" value="9"<?php if(checkpermission($CD_Permission,9)){echo " checked";} ?>><label for="value9">UCenter</label></li>
</ul></td>
<td class="vtop"><select name="CD_IsLock" class="ps">
<option value="0"<?php if($CD_IsLock==0){echo " selected";} ?>>激活状态</option>
<option value="1"<?php if($CD_IsLock==1){echo " selected";} ?>>锁定状态</option>
</select></td>
</tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="admin" onclick="return CheckForm();" value="提交" /></div></td></tr>
</form>
</table>
</div>



<?php
}
	function checkpermission($permission,$value){
		if(!empty($permission)){
		        $array=explode(",",$permission);
		        $checkpermission=false;
		        for($i=0;$i<count($array);$i++){
			        if($array[$i]==$value){$checkpermission=true;}
		        }
		}else{
		        $checkpermission=false;
		}
		return $checkpermission;
	}

	//保存编辑数据
	function SaveEdit(){
		global $db;
		if(!submitcheck('admin')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID=SafeRequest("CD_ID","get");
		$CD_AdminUserName=SafeRequest("CD_AdminUserName","post");
		$CD_AdminPassWord=SafeRequest("CD_AdminPassWord","post");
		$CD_AdminPassWord1=SafeRequest("CD_AdminPassWord1","post");
		$CD_IsLock=SafeRequest("CD_IsLock","post");
		$CD_Permission=RequestBox("CD_Permission");
		if($CD_AdminPassWord!==$CD_AdminPassWord1){ShowMessage("编辑失败，两次密码填写不一致！","history.back(1);","infotitle3",3000,2);}
		if($db->getone("select CD_ID from ".tname('admin')." where CD_ID<>".$CD_ID." and CD_AdminUserName='".$CD_AdminUserName."'")){ShowMessage("编辑出错，该帐号已经存在！","history.back(1);","infotitle3",3000,2);}
		if(!IsNul($CD_AdminPassWord1)){
			$sql="update ".tname('admin')." set CD_AdminUserName='".$CD_AdminUserName."',CD_Permission='".$CD_Permission."',CD_IsLock=".$CD_IsLock." where CD_ID=".$CD_ID;
		}else{
			$sql="update ".tname('admin')." set CD_AdminPassWord='".md5($CD_AdminPassWord)."',CD_AdminUserName='".$CD_AdminUserName."',CD_Permission='".$CD_Permission."',CD_IsLock=".$CD_IsLock." where CD_ID=".$CD_ID;
		}
		if($db->query($sql)){
			ShowMessage("恭喜您，系统用户编辑成功！重新登录后生效！","?iframe=admin","infotitle2",1000,1);
		}else{
			ShowMessage("编辑出错，系统用户编辑失败！","?iframe=admin","infotitle3",3000,1);
		}
	}

	//编辑数据
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="Select * from ".tname('admin')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_AdminUserName'],$row['CD_AdminPassWord'],$row['CD_IsLock'],$row['CD_Permission']);
		}
		EditBoard($Arr,"?iframe=admin&action=saveedit&CD_ID=".$CD_ID,"编辑");
	}

	//删除数据
	function Del(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		if($CD_ID==1){ShowMessage("抱歉，默认帐号不允许删除！","?iframe=admin","infotitle3",3000,1);}
		$sql="delete from ".tname('admin')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，系统用户删除成功！","?iframe=admin","infotitle2",3000,1);
		}
	}

	//保存添加数据
	function SaveAdd(){
		global $db;
		if(!submitcheck('admin')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_AdminUserName=SafeRequest("CD_AdminUserName","post");
		$CD_AdminPassWord=SafeRequest("CD_AdminPassWord","post");
		$CD_AdminPassWord1=SafeRequest("CD_AdminPassWord1","post");
		$CD_IsLock=SafeRequest("CD_IsLock","post");
		$CD_Permission=RequestBox("CD_Permission");
		if(empty($CD_AdminPassWord) || $CD_AdminPassWord!==$CD_AdminPassWord1){ShowMessage("新增失败，密码不能为空或两次密码填写不一致！","history.back(1);","infotitle3",3000,2);}
		if($db->getone("select CD_ID from ".tname('admin')." where CD_AdminUserName='".$CD_AdminUserName."'")){
			ShowMessage("新增出错，该帐号已经存在！","history.back(1);","infotitle3",3000,2);
		}else{
			$sql="Insert ".tname('admin')." (CD_AdminUserName,CD_AdminPassWord,CD_LoginNum,CD_IsLock,CD_Permission) values ('".$CD_AdminUserName."','".md5($CD_AdminPassWord1)."',0,".$CD_IsLock.",'".$CD_Permission."')";
			if($db->query($sql)){
				ShowMessage("恭喜您，系统用户新增成功！","?iframe=admin","infotitle2",1000,1);
			}else{
				ShowMessage("新增出错，系统用户新增失败！","?iframe=admin","infotitle3",3000,1);
			}
		}
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=admin&action=saveadd","新增");
	}

	//更新状态
	function IsLock(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsLock = SafeRequest("CD_IsLock","get");
		$sql="update ".tname('admin')." set CD_IsLock=".$CD_IsLock." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，状态切换成功！","?iframe=admin","infotitle2",1000,1);
		}
	}
?>