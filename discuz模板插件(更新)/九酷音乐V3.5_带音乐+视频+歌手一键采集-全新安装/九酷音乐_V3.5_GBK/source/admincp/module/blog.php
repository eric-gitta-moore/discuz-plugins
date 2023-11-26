<?php
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>说说管理</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.name != 'chkall')
			e.checked = form.chkall.checked;
	}
}
function s(){
        var k=document.getElementById("search").value;
        if(k==""){
                asyncbox.tips("请输入要查询的关键词！", "wait", 1000);
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
	case 'del':
		del();
		break;
	case 'alldel':
		alldel();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('blog')." where cd_content like '%".$key."%' or cd_uname like '%".$key."%' order by cd_addtime desc",20);
		break;
	default:
		main("select * from ".tname('blog')." order by cd_addtime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 所有说说';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;所有说说&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=所有说说&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>所有说说</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>所有说说内容中的表情被过滤，用“*”符号来标记。可以输入说说内容、所属会员等关键词进行搜索</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="blog">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=blog&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>说说内容</th>
<th>所属会员</th>
<th>更新时间</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有说说</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
$cd_content = preg_replace('/\[em:(\d+)]/is', '*', $row['cd_content']);
$cd_content = getlen("len","25",$cd_content);
$cd_url = cd_upath."index.php?p=space&a=miniblog&uid=".$row['cd_uid']."&id=".$row['cd_id'];
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td><a href="<?php echo $cd_url; ?>" target="_blank" class="act"><?php echo ReplaceStr($cd_content,SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=blog&action=keyword&key=<?php echo $row['cd_uname']; ?>" class="act"><?php echo ReplaceStr($row['cd_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if(date("Y-m-d",$row['cd_addtime'])==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",$row['cd_addtime'])."</em>"; }else{ echo date("Y-m-d",$row['cd_addtime']); } ?></td>
<td><a href="?iframe=blog&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="alldel" class="btn" value="批量删除" onclick="{if(confirm('确定要删除所选定的说说吗？')){this.document.form.submit();return true;}return false;}" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//批量删除
	function alldel(){
		global $db;
		if(!submitcheck('alldel')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		if($cd_id==0){
			ShowMessage("批量删除失败，请先勾选要删除的说说！","?iframe=blog","infotitle3",3000,1);
		}else{
			$query = $db->query("select cd_id,cd_uid,cd_uname from ".tname('blog')." where cd_id in($cd_id)");
			while ($row = $db->fetch_array($query)) {
				$db->query("delete from ".tname('blog')." where cd_id=".$row['cd_id']);
				$db->query("delete from ".tname('comment')." where cd_channel=0 and cd_dataid=".$row['cd_id']);
				$db->query("delete from ".tname('feed')." where cd_icon='miniblog' and cd_dataid=".$row['cd_id']);
				if(cd_pointsdaa >= 1){
					$setarr = array(
						'cd_type' => 0,
						'cd_uid' => $row['cd_uid'],
						'cd_uname' => $row['cd_uname'],
						'cd_icon' => 'miniblog',
						'cd_title' => '说说被删除',
						'cd_points' => cd_pointsdaa,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdaa.",cd_rank=cd_rank-".cd_pointsdab." where cd_id=".$row['cd_uid']);
			}
			ShowMessage("恭喜您，说说批量删除成功！","?iframe=blog","infotitle2",3000,1);
		}
	}

	//删除
	function del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select cd_id,cd_uid,cd_uname from ".tname('blog')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$db->query("delete from ".tname('blog')." where cd_id=".$row['cd_id']);
			$db->query("delete from ".tname('comment')." where cd_channel=0 and cd_dataid=".$row['cd_id']);
			$db->query("delete from ".tname('feed')." where cd_icon='miniblog' and cd_dataid=".$row['cd_id']);
			if(cd_pointsdaa >= 1){
				$setarr = array(
					'cd_type' => 0,
					'cd_uid' => $row['cd_uid'],
					'cd_uname' => $row['cd_uname'],
					'cd_icon' => 'miniblog',
					'cd_title' => '说说被删除',
					'cd_points' => cd_pointsdaa,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdaa.",cd_rank=cd_rank-".cd_pointsdab." where cd_id=".$row['cd_uid']);
			ShowMessage("恭喜您，说说删除成功！","?iframe=blog","infotitle2",1000,1);
		}
	}
?>