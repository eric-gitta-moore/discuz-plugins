<?php
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>专辑管理</title>
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
	case 'alldel':
		AllDel();
		break;
	case 'editisbest':
		EditIsBest();
		break;
	case 'editpassed':
		EditPassed();
		break;
	case 'class':
		$CD_ClassID=SafeRequest("CD_ClassID","get");
		main("select * from ".tname('special')." where CD_ClassID=".$CD_ClassID." order by CD_AddTime desc",20);
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('special')." where CD_Name like '%".$key."%' or CD_User like '%".$key."%' order by CD_AddTime desc",20);
		break;
	case 'pass':
		main("select * from ".tname('special')." where CD_Passed=1 order by CD_AddTime desc",20);
		break;
	case 'isbest':
		main("select * from ".tname('special')." where CD_IsBest=1 order by CD_AddTime desc",20);
		break;
	case 'singer':
		$CD_SingerID=SafeRequest("CD_SingerID","get");
		main("select * from ".tname('special')." where CD_SingerID=".$CD_SingerID." order by CD_AddTime desc",20);
		break;
	default:
		main("select * from ".tname('special')." order by CD_AddTime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$ActionUrl,$ActionName){
		global $db,$action;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_ClassID = $Arr[0];
		$CD_Name = $Arr[1];
		$CD_User = $Arr[2];
		$CD_Pic = $Arr[3];
		$CD_SingerID = $Arr[4];
		$CD_GongSi = $Arr[5];
		$CD_YuYan = $Arr[6];
		$CD_Intro = $Arr[7];
		$CD_Hits = $Arr[8];
		$CD_IsBest = $Arr[9];
		$CD_Passed = $Arr[10];
		$CD_Time = $Arr[11];
		if(!IsNul($CD_User)){$CD_User=$_COOKIE['CD_AdminUserName'];}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
?>
<script type="text/javascript">
function CheckForm(){
        if(document.form2.CD_Hits.value==""){
            asyncbox.tips("专辑人气不能为空，请填写！", "wait", 1000);
            document.form2.CD_Hits.focus();
            return false;
        }
        else if(document.form2.CD_Name.value==""){
            asyncbox.tips("专辑名称不能为空，请填写！", "wait", 1000);
            document.form2.CD_Name.focus();
            return false;
        }
        else if(document.form2.CD_User.value==""){
            asyncbox.tips("所属会员不能为空，请填写！", "wait", 1000);
            document.form2.CD_User.focus();
            return false;
        }
        else if(document.form2.CD_ClassID.value=="0"){
            asyncbox.tips("所属栏目不能为空，请填写！", "wait", 1000);
            document.form2.CD_ClassID.focus();
            return false;
        }
        else if(document.form2.CD_GongSi.value==""){
            asyncbox.tips("发行公司不能为空，请填写！", "wait", 1000);
            document.form2.CD_GongSi.focus();
            return false;
        }
        else if(document.form2.CD_Pic.value==""){
            asyncbox.tips("专辑封面不能为空，请填写！", "wait", 1000);
            document.form2.CD_Pic.focus();
            return false;
        }
        else {
            return true;
        }
}
</script>
<div class="container">
<?php if($action=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 新增专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;新增专辑&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=新增专辑&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 编辑专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;编辑专辑';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $ActionName; ?>专辑</h3><ul class="tab1">
<li><a href="?iframe=album"><span>所有专辑</span></a></li>
<?php if($action=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album&action=add"><span>新增专辑</span></a></li>
<li><a href="?iframe=album&action=pass"><span>待审专辑</span></a></li>
<li><a href="?iframe=album&action=isbest"><span>推荐专辑</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $ActionUrl; ?>" method="post" name="form2">
<table class="tb tb2">
<tr>
<td>专辑人气：<input type="text" class="txt" value="<?php echo $CD_Hits; ?>" name="CD_Hits" id="CD_Hits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>

<tr>
<td class="td29">专辑名称：<input type="text" class="txt" value="<?php echo $CD_Name; ?>" name="CD_Name" id="CD_Name"></td>
<td>所属会员：<input type="text" class="txt" value="<?php echo $CD_User; ?>" name="CD_User" id="CD_User"></td>
</tr>

<tr>
<td>所属栏目：<select name="CD_ClassID" id="CD_ClassID">
<option value="0">选择栏目</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if($CD_ClassID==$row3['CD_ID']){
echo "<option value=\"".$row3['CD_ID']."\" selected=\"selected\">".$row3['CD_Name']."</option>";
}else{
echo "<option value=\"".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}	
}
}
?>
</select></td>
<td>所属语言：<select name="CD_YuYan" id="CD_YuYan">
<option value="国语"<?php if($CD_YuYan=="国语"){echo " selected";} ?>>国语</option>
<option value="粤语"<?php if($CD_YuYan=="粤语"){echo " selected";} ?>>粤语</option>
<option value="闽语"<?php if($CD_YuYan=="闽语"){echo " selected";} ?>>闽语</option>
<option value="英语"<?php if($CD_YuYan=="英语"){echo " selected";} ?>>英语</option>
<option value="日语"<?php if($CD_YuYan=="日语"){echo " selected";} ?>>日语</option>
<option value="韩语"<?php if($CD_YuYan=="韩语"){echo " selected";} ?>>韩语</option>
<option value="其它"<?php if($CD_YuYan=="其它"){echo " selected";} ?>>其它</option>
</select></td>
</tr>

<tr>
<td>所属歌手：<select name="CD_SingerID" id="CD_SingerID">
<option value="0">不选择</option>
<?php
$sqlclass="select CD_ID,CD_Name from ".tname('singer');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if($CD_SingerID==$row3['CD_ID']){
echo "<option value=\"".$row3['CD_ID']."\" selected=\"selected\">".getlen("len","10",$row3['CD_Name'])."</option>";
}else{
echo "<option value=\"".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
}
?>
</select>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('选择歌手', '?iframe=star&to=a&so=form2.CD_SingerID', '500px', '400px', '40px');" class="addtr">选择</a></td>
<td>发行公司：<input type="text" class="txt" value="<?php echo $CD_GongSi; ?>" name="CD_GongSi" id="CD_GongSi"></td>
</tr>

<tr>
<td class="longtxt">专辑封面：<input type="text" class="txt" value="<?php echo $CD_Pic; ?>" name="CD_Pic" id="CD_Pic"></td><td><div class="rssbutton"><input type="button" value="本地上传" onclick="pop.up('上传封面', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form2.CD_Pic', '406px', '180px', '100px');" /></div></td>
</tr>
</table>

<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">专辑介绍：</div><textarea rows="6" cols="50" id="CD_Intro" name="CD_Intro" style="width:400px;height:100px;"><?php echo $CD_Intro; ?></textarea></td></tr>
<tr><td><input type="hidden" name="CD_HttpUrl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="hidden" name="CD_Time" value="<?php echo $CD_Time; ?>"><input type="submit" class="btn" name="form2" value="提交" onclick="return CheckForm();" /><input class="checkbox" type="checkbox" name="CD_EditTime" id="CD_EditTime" value="1" checked /><label for="CD_EditTime">更新时间</label><input class="checkbox" type="checkbox" name="CD_IsBest" id="CD_IsBest" value="1"<?php if($CD_IsBest==1){echo " checked";} ?> /><label for="CD_IsBest">推荐</label><input class="checkbox" type="checkbox" name="CD_Passed" id="CD_Passed" value="1"<?php if($CD_Passed==0){echo " checked";} ?> /><label for="CD_Passed">审核</label></td></tr>
</table>
</form>
</div>



<?php
}
function main($sql,$size){
	global $db,$action;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
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
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 所有专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;所有专辑&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=所有专辑&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="pass"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 待审专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;待审专辑&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=待审专辑&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 推荐专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;推荐专辑&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=推荐专辑&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 搜索专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;搜索专辑';</script>";} ?>
<?php if($action=="class"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 栏目专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;栏目专辑';</script>";} ?>
<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 歌手专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;歌手专辑';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action==""){echo "所有专辑";}else if($action=="pass"){echo "待审专辑";}else if($action=="isbest"){echo "推荐专辑";}else if($action=="keyword"){echo "搜索专辑";}else if($action=="class"){echo "栏目专辑";}else if($action=="singer"){echo "歌手专辑";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album"><span>所有专辑</span></a></li>
<li><a href="?iframe=album&action=add"><span>新增专辑</span></a></li>
<?php if($action=="pass"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album&action=pass"><span>待审专辑</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album&action=isbest"><span>推荐专辑</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<?php
$key=SafeRequest("key","get");
if($action==""){
echo "<li>以下是所有的专辑列表</li>";
}elseif($action=="pass"){
echo "<li>以下是需审核的专辑列表，不会在前台显示</li>";
}elseif($action=="isbest"){
echo "<li>以下是被推荐的专辑列表</li>";
}elseif($key<>""){
echo "<li>以下是搜索“".$key."”的专辑列表，可以输入专辑名称、所属会员等关键词进行搜索</li>";
}elseif($action=="class"){
echo "<li>以下是按栏目查看的专辑列表</li>";
}elseif($action=="singer"){
echo "<li>以下是按歌手查看的专辑列表</li>";
}
?>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="album">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=album">不限栏目</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_ClassID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=album&action=class&CD_ClassID=".$row3['CD_ID']."\" selected=\"selected\">".$row3['CD_Name']."</option>";
}else{
echo "<option value=\"?iframe=album&action=class&CD_ClassID=".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}	
}
}
?>
</select>
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=album">不限歌手</option>
<?php
$sqlclass="select * from ".tname('singer');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_SingerID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=album&action=singer&CD_SingerID=".$row3['CD_ID']."\" selected=\"selected\">".getlen("len","10",$row3['CD_Name'])."</option>";
}else{
echo "<option value=\"?iframe=album&action=singer&CD_SingerID=".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
}
?>
</select>
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=album&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>专辑名称</th>
<th>音乐统计</th>
<th>所属栏目</th>
<th>所属会员</th>
<th>推荐</th>
<th>生成</th>
<th>审核</th>
<th>更新时间</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有专辑</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?></td>
<td><a href="index.php/album/<?php echo $row['CD_ID']; ?>/" target="_blank" class="act"><?php echo ReplaceStr($row['CD_Name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=song&action=special&CD_SpecialID=<?php echo $row['CD_ID']; ?>" class="act">
<?php
$sqlstr="select CD_ID from ".tname('music')." where CD_SpecialID=".$row['CD_ID'];
$res=$db -> query($sqlstr);
$nums= $db -> num_rows($res);
echo $nums;
?>
</a></td>
<td>
<?php
$res=$db->getrow("select CD_ID,CD_Name from ".tname('class')." where CD_ID=".$row['CD_ClassID']);
if($res){
echo "<a href=\"?iframe=album&action=class&CD_ClassID=".$res['CD_ID']."\" class=\"act\">".$res['CD_Name']."</a>";
}else{
echo "暂无栏目";
}
?>
</td>
<td><?php echo ReplaceStr($row['CD_User'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php if($row['CD_IsBest']==0){ ?><a href="?iframe=album&action=editisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=1"><img src="static/admincp/images/isbest_no.gif" /></a><?php }else{ ?><a href="?iframe=album&action=editisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=0"><img src="static/admincp/images/isbest_yes.gif" /></a><?php } ?></td>
<td><?php echo CheckHtml("special",LinkUrl("special",$row['CD_ClassID'],1,$row['CD_ID']),$row['CD_ID'],$row['CD_ClassID']); ?></td>
<td><?php if($row['CD_Passed']==1){ ?><a href="?iframe=album&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>&CD_Passed=0"><img src="static/admincp/images/ishide_no.gif" /></a><?php }else{ ?><a href="?iframe=album&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>&CD_Passed=1"><img src="static/admincp/images/ishide_yes.gif" /></a><?php } ?></td>
<td><?php if(date("Y-m-d",strtotime($row['CD_AddTime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['CD_AddTime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['CD_AddTime'])); } ?></td>
<td><a href="?iframe=album&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">编辑</a><a href="?iframe=album&action=del&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="批量删除" onclick="{if(confirm('确定要删除所选定的专辑吗？')){this.document.form.submit();return true;}return false;}" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//推荐
	function EditIsBest(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsBest = SafeRequest("CD_IsBest","get");
		$sql="update ".tname('special')." set CD_IsBest=".$CD_IsBest." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，推荐状态切换成功！","?iframe=album","infotitle2",1000,1);
		}
	}

	//审核
	function EditPassed(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Passed = SafeRequest("CD_Passed","get");
		$sql="update ".tname('special')." set CD_Passed=".$CD_Passed." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，审核状态切换成功！","?iframe=album","infotitle2",1000,1);
		}
	}

	//批量删除
	function AllDel(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID=RequestBox("CD_ID");
		$query = $db->query("select CD_Pic from ".tname('special')." where CD_ID in ($CD_ID)");
		while ($row = $db->fetch_array($query)) {
			$Pic=$row['CD_Pic'];
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('special')." where CD_ID in ($CD_ID)";
		if($CD_ID==0){
			ShowMessage("批量删除失败，请先勾选要删除的专辑！","?iframe=album","infotitle3",3000,1);
		}else{
			if($db->query($sql)){
				ShowMessage("恭喜您，专辑批量删除成功！","?iframe=album","infotitle2",3000,1);
			}
		}
	}

	//删除
	function Del(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sqls="select CD_Pic from ".tname('special')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sqls)){
			$Pic=$row['CD_Pic'];
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('special')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，专辑删除成功！","?iframe=album","infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="select * from ".tname('special')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_ClassID'],$row['CD_Name'],$row['CD_User'],$row['CD_Pic'],$row['CD_SingerID'],$row['CD_GongSi'],$row['CD_YuYan'],$row['CD_Intro'],$row['CD_Hits'],$row['CD_IsBest'],$row['CD_Passed'],$row['CD_AddTime']);
		}
		EditBoard($Arr,"?iframe=album&action=saveedit&CD_ID=".$CD_ID,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=album&action=saveadd","新增");
	}

	//保存添加数据
	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ClassID = SafeRequest("CD_ClassID","post");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_SingerID = SafeRequest("CD_SingerID","post");
		$CD_GongSi = SafeRequest("CD_GongSi","post");
		$CD_YuYan = SafeRequest("CD_YuYan","post");
		$CD_Intro = SafeRequest("CD_Intro","post");
		$CD_Hits = SafeRequest("CD_Hits","post");
		$CD_IsBest = SafeRequest("CD_IsBest","post");
		$CD_Passed = SafeRequest("CD_Passed","post");
		$CD_AddTime = date('Y-m-d H:i:s');
		if($CD_IsBest==1){
			$CD_IsBest = 1;
		}else{
			$CD_IsBest = 0;
		}
		if($CD_Passed==1){
			$CD_Passed = 0;
		}else{
			$CD_Passed = 1;
		}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		$sql="select * from ".tname('user')." where cd_name='".$CD_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			$db->query("Insert ".tname('special')." (CD_ClassID,CD_Name,CD_User,CD_Pic,CD_SingerID,CD_GongSi,CD_YuYan,CD_Intro,CD_Hits,CD_IsBest,CD_Passed,CD_AddTime) values (".$CD_ClassID.",'".$CD_Name."','".$CD_User."','".$CD_Pic."',".$CD_SingerID.",'".$CD_GongSi."','".$CD_YuYan."','".$CD_Intro."',".$CD_Hits.",".$CD_IsBest.",".$CD_Passed.",'".$CD_AddTime."')");
			ShowMessage("恭喜您，专辑新增成功！","?iframe=album","infotitle2",1000,1);
		}else{
			ShowMessage("新增失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}

	//保存编辑数据
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_ClassID = SafeRequest("CD_ClassID","post");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_SingerID = SafeRequest("CD_SingerID","post");
		$CD_GongSi = SafeRequest("CD_GongSi","post");
		$CD_YuYan = SafeRequest("CD_YuYan","post");
		$CD_Intro = SafeRequest("CD_Intro","post");
		$CD_Hits = SafeRequest("CD_Hits","post");
		$CD_IsBest = SafeRequest("CD_IsBest","post");
		$CD_Passed = SafeRequest("CD_Passed","post");
		$CD_EditTime = SafeRequest("CD_EditTime","post");
		$CD_Time = SafeRequest("CD_Time","post");
		$CD_HttpUrl = SafeRequest("CD_HttpUrl","post");
		if($CD_EditTime==1){
			$CD_AddTime = date('Y-m-d H:i:s');
		}else{
			$CD_AddTime = $CD_Time;
		}
		if($CD_IsBest==1){
			$CD_IsBest = 1;
		}else{
			$CD_IsBest = 0;
		}
		if($CD_Passed==1){
			$CD_Passed = 0;
		}else{
			$CD_Passed = 1;
		}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		$sql="select * from ".tname('user')." where cd_name='".$CD_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			$db->query("update ".tname('special')." set CD_ClassID=".$CD_ClassID.",CD_Name='".$CD_Name."',CD_User='".$CD_User."',CD_Pic='".$CD_Pic."',CD_SingerID=".$CD_SingerID.",CD_GongSi='".$CD_GongSi."',CD_YuYan='".$CD_YuYan."',CD_Intro='".$CD_Intro."',CD_Hits=".$CD_Hits.",CD_IsBest=".$CD_IsBest.",CD_Passed=".$CD_Passed.",CD_AddTime='".$CD_AddTime."' where CD_ID=".$CD_ID);
			ShowMessage("恭喜您，专辑编辑成功！",$CD_HttpUrl,"infotitle2",1000,1);
		}else{
			ShowMessage("编辑失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}
?>