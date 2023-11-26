<?php
Administrator(8);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>友情链接</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="source/plugin/layer/jquery.js"></script>
<script type="text/javascript" src="source/plugin/layer/lib.js"></script>
<script type="text/javascript">
layer.ready(function() {
        pop = {
                up : function(text, url, width, height, top) {
                        $.layer({
                                type : 2,
                                title : text,
                                iframe : {src : url},
                                area : [width, height],
                                offset : [top, '50%'],
                                shade : [0.1, '#000', true]
                        });
                }
        }
});
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.name != 'chkall')
			e.checked = form.chkall.checked;
	}
}
function exchange_type(theForm){
	if (theForm.cd_classid.value =='2'){
		document.form1.cd_pic.focus();
		return false;
	}
}
function CheckForm(){
        if(document.form1.cd_name.value==""){
            asyncbox.tips("站点名称不能为空，请填写！", "wait", 1000);
            document.form1.cd_name.focus();
            return false;
        }
        else if(document.form1.cd_url.value==""){
            asyncbox.tips("链接地址不能为空，请填写！", "wait", 1000);
            document.form1.cd_url.focus();
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
	case 'editisindex':
		editisindex();
		break;
	case 'alleditsave':
		alleditsave();
		break;
	default:
		main("select * from ".tname('link')." order by cd_theorder asc",30);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
	$cd_name = $Arr[0];
	$cd_url = $Arr[1];
	$cd_pic = $Arr[2];
	$cd_classid = $Arr[3];
	$cd_isindex = $Arr[4];
	$cd_input = $Arr[5];
	if(!IsNul($cd_classid)){$cd_classid=1;}
	if(!IsNul($cd_isindex)){$cd_isindex=0;}
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 系统 - 新增链接';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;新增链接&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=新增链接&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 系统 - 编辑链接';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;编辑链接';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>链接</h3><ul class="tab1">
<li><a href="?iframe=link"><span>友情链接</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=link&action=add"><span>新增链接</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form1">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>链接</th></tr>
<tr><td colspan="2" class="td27">站点名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_name; ?>" name="cd_name" id="cd_name"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">链接地址:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_url; ?>" name="cd_url" id="cd_url"></td><td class="vtop tips2">必须以“http://”开头</td></tr>
<tr><td colspan="2" class="td27">链接类型:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_classid" id="cd_classid" onchange="exchange_type(form1)" class="ps">
<option value="1"<?php if($cd_classid==1){echo " selected";} ?>>文字</option>
<option value="2"<?php if($cd_classid==2){echo " selected";} ?>>图片</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">链接图片:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_pic; ?>" name="cd_pic" id="cd_pic"></td><td class="vtop"><a href="javascript:void(0)" onclick="pop.up('上传图片', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form1.cd_pic', '406px', '180px', '100px');" class="addtr">本地上传</a></td></tr>
<tr><td colspan="2" class="td27">链接状态:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_isindex" class="ps">
<option value="0"<?php if($cd_isindex==0){echo " selected";} ?>>显示</option>
<option value="1"<?php if($cd_isindex==1){echo " selected";} ?>>隐藏</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">站点简介:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea name="cd_input" id="cd_input" class="pt" rows="3" cols="40"><?php echo $cd_input; ?></textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="link" onclick="return CheckForm();" value="提交" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 系统 - 友情链接';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;友情链接&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=友情链接&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>友情链接</h3><ul class="tab1">
<li class="current"><a href="?iframe=link"><span>友情链接</span></a></li>
<li><a href="?iframe=link&action=add"><span>新增链接</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form name="form" method="post" action="?iframe=link&action=alleditsave">
<table class="tb tb2">
<tr><th class="partition">链接列表</th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>站点名称</th>
<th>链接地址</th>
<th>排序</th>
<th>类型</th>
<th>状态</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有友情链接</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td><input type="text" class="txt" name="cd_name<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_name']; ?>"></td>
<td class="td26"><input type="text" class="txt" name="cd_url<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_url']; ?>"></td>
<td class="td28"><input type="text" class="txt" name="cd_theorder<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_theorder']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td><?php if($row['cd_classid']==1){echo "文字";}else{echo "<em class=\"lightnum\">图片</em>";} ?></td>
<td><?php if($row['cd_isindex']==1){ ?><a href="?iframe=link&action=editisindex&cd_isindex=0&cd_id=<?php echo $row['cd_id']; ?>"><img src="static/admincp/images/ishide_no.gif" /></a><?php }else{ ?><a href="?iframe=link&action=editisindex&cd_isindex=1&cd_id=<?php echo $row['cd_id']; ?>"><img src="static/admincp/images/ishide_yes.gif" /></a><?php } ?></td>
<td><a href="?iframe=link&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">编辑</a><a href="?iframe=link&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="提交修改" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//删除
	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('link')." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，友情链接删除成功！","?iframe=link","infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('link')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_url'],$row['cd_pic'],$row['cd_classid'],$row['cd_isindex'],$row['cd_input']);
		}
		EditBoard($Arr,"?iframe=link&action=saveedit&cd_id=".$cd_id,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=link&action=saveadd","新增");
	}

	//执行保存
	function SaveAdd(){
		global $db;
		if(!submitcheck('link')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_name = SafeRequest("cd_name","post");
		$cd_url = SafeRequest("cd_url","post");
		$cd_pic = SafeRequest("cd_pic","post");
		$cd_classid = SafeRequest("cd_classid","post");
		$cd_input = SafeRequest("cd_input","post");
		$cd_isindex = SafeRequest("cd_isindex","post");
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_url' => $cd_url,
			'cd_pic' => $cd_pic,
			'cd_classid' => $cd_classid,
			'cd_input' => $cd_input,
			'cd_isverify' => 0,
			'cd_isindex' => $cd_isindex,
			'cd_theorder' => 0
		);
		inserttable('link', $setarr, 1);
		ShowMessage("恭喜您，友情链接新增成功！","?iframe=link","infotitle2",1000,1);
	}

	//保存编辑
	function SaveEdit(){
		global $db;
		if(!submitcheck('link')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id = SafeRequest("cd_id","get");
		$cd_name = SafeRequest("cd_name","post");
		$cd_url = SafeRequest("cd_url","post");
		$cd_pic = SafeRequest("cd_pic","post");
		$cd_classid = SafeRequest("cd_classid","post");
		$cd_input = SafeRequest("cd_input","post");
		$cd_isindex = SafeRequest("cd_isindex","post");
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_url' => $cd_url,
			'cd_pic' => $cd_pic,
			'cd_classid' => $cd_classid,
			'cd_input' => $cd_input,
			'cd_isindex' => $cd_isindex
		);
		updatetable('link', $setarr, array('cd_id'=>$cd_id));
		ShowMessage("恭喜您，友情链接编辑成功！","?iframe=link","infotitle2",1000,1);
	}

	function editisindex(){
		global $db;
		$cd_id = SafeRequest("cd_id","get");
		$cd_isindex = SafeRequest("cd_isindex","get");
		$sql="update ".tname('link')." set cd_isindex=".$cd_isindex." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，状态切换成功！","?iframe=link","infotitle2",1000,1);
		}
	}

	function alleditsave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		if($cd_id==0){
			ShowMessage("修改失败，请先勾选要编辑的友情链接！","?iframe=link","infotitle3",3000,1);
		}else{
			$ID=explode(",",$cd_id);
			for($i=0;$i<count($ID);$i++){
				$cd_name=SafeRequest("cd_name".$ID[$i],"post");
				$cd_url=SafeRequest("cd_url".$ID[$i],"post");
				$cd_theorder=SafeRequest("cd_theorder".$ID[$i],"post");
				if(!IsNul($cd_name)){ShowMessage("修改出错，站点名称不能为空！","?iframe=link","infotitle3",1000,1);}
				if(!IsNul($cd_url)){ShowMessage("修改出错，链接地址不能为空！","?iframe=link","infotitle3",1000,1);}
				if(!IsNum($cd_theorder)){ShowMessage("修改出错，排序不能为空！","?iframe=link","infotitle3",1000,1);}
				$setarr = array(
					'cd_name' => $cd_name,
					'cd_url' => $cd_url,
					'cd_theorder' => $cd_theorder
				);
				updatetable('link', $setarr, array('cd_id'=>$ID[$i]));
			}
			ShowMessage("恭喜您，友情链接修改成功！","?iframe=link","infotitle2",1000,1);
		}
	}
?>