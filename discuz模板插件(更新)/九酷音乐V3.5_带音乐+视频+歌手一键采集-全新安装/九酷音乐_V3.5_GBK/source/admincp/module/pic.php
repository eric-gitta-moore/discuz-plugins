<?php
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>照片管理</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="source/plugin/fancybox/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="source/plugin/fancybox/jquery.fancybox.pack.js"></script>
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
		main("select * from ".tname('pic')." where cd_title like '%".$key."%' or cd_uname like '%".$key."%' order by cd_addtime desc",20);
		break;
	default:
		main("select * from ".tname('pic')." order by cd_addtime desc",20);
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 所有照片';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;所有照片&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=所有照片&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>所有照片</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>点击小图可以查看大图，可以输入照片标题、所属会员等关键词进行搜索</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="pic">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=pic&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>小图</th>
<th>照片标题</th>
<th>所属会员</th>
<th>更新时间</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有照片</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<script type="text/javascript">
$(document).ready(function() {
$("#thumb<?php echo $row['cd_id']; ?>").fancybox({
'overlayColor' : '#000',
'overlayOpacity' : 0.1,
'overlayShow' : true,
'transitionIn' : 'elastic',
'transitionOut'	: 'elastic'
});
});
</script>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td><a href="<?php echo getalbumthumb($row["cd_url"],2); ?>" id="thumb<?php echo $row['cd_id']; ?>"><img src="<?php echo getalbumthumb($row["cd_url"],1); ?>" width="25" height="25" /></a></td>
<td><a href="<?php echo cd_upath; ?>index.php?p=space&a=album&uid=<?php echo $row['cd_uid']; ?>&id=<?php echo $row['cd_id']; ?>" target="_blank" class="act"><?php echo ReplaceStr($row['cd_title'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=pic&action=keyword&key=<?php echo $row['cd_uname']; ?>" class="act"><?php echo ReplaceStr($row['cd_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if(date("Y-m-d",$row['cd_addtime'])==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",$row['cd_addtime'])."</em>"; }else{ echo date("Y-m-d",$row['cd_addtime']); } ?></td>
<td><a href="<?php echo getalbumthumb($row["cd_url"],0); ?>" target="_blank" class="act">原图</a><a href="?iframe=pic&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="alldel" class="btn" value="批量删除" onclick="{if(confirm('确定要删除所选定的照片吗？')){this.document.form.submit();return true;}return false;}" /></td></tr>
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
			ShowMessage("批量删除失败，请先勾选要删除的照片！","?iframe=pic","infotitle3",3000,1);
		}else{
			$query = $db->query("select cd_id,cd_uid,cd_uname,cd_url from ".tname('pic')." where cd_id in($cd_id)");
			while ($row = $db->fetch_array($query)) {
				$db->query("delete from ".tname('pic')." where cd_id=".$row['cd_id']);
				$db->query("delete from ".tname('pic_like')." where cd_dataid=".$row['cd_id']);
				$db->query("delete from ".tname('comment')." where cd_channel=1 and cd_dataid=".$row['cd_id']);
				if(cd_pointsdba >= 1){
					$setarr = array(
						'cd_type' => 0,
						'cd_uid' => $row['cd_uid'],
						'cd_uname' => $row['cd_uname'],
						'cd_icon' => 'album',
						'cd_title' => '照片被删除',
						'cd_points' => cd_pointsdba,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdba.",cd_rank=cd_rank-".cd_pointsdbb." where cd_id=".$row['cd_uid']);
				@unlink("data/attachment/album/".$row['cd_url'].".thumb.".fileext($row['cd_url']));
				@unlink("data/attachment/album/".$row['cd_url'].".thumb_180x180.".fileext($row['cd_url']));
				@unlink("data/attachment/album/".$row['cd_url']);
			}
			ShowMessage("恭喜您，照片批量删除成功！","?iframe=pic","infotitle2",3000,1);
		}
	}

	//删除
	function del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select cd_id,cd_uid,cd_uname,cd_url from ".tname('pic')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$db->query("delete from ".tname('pic')." where cd_id=".$row['cd_id']);
			$db->query("delete from ".tname('pic_like')." where cd_dataid=".$row['cd_id']);
			$db->query("delete from ".tname('comment')." where cd_channel=1 and cd_dataid=".$row['cd_id']);
			if(cd_pointsdba >= 1){
				$setarr = array(
					'cd_type' => 0,
					'cd_uid' => $row['cd_uid'],
					'cd_uname' => $row['cd_uname'],
					'cd_icon' => 'album',
					'cd_title' => '照片被删除',
					'cd_points' => cd_pointsdba,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdba.",cd_rank=cd_rank-".cd_pointsdbb." where cd_id=".$row['cd_uid']);
			@unlink("data/attachment/album/".$row['cd_url'].".thumb.".fileext($row['cd_url']));
			@unlink("data/attachment/album/".$row['cd_url'].".thumb_180x180.".fileext($row['cd_url']));
			@unlink("data/attachment/album/".$row['cd_url']);
			ShowMessage("恭喜您，照片删除成功！","?iframe=pic","infotitle2",1000,1);
		}
	}
?>