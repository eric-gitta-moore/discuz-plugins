<?php
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>视频管理</title>
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
</script>
</head>
<body>
<?php
switch($action){
	case 'editsave':
		EditSave();
		break;
	case 'class':
		ClassMain();
		break;
	case 'editisindex':
		EditIsIndex();
		break;
	case 'del':
		Del();
		break;
	case 'classadd':
		ClassAdd();
		break;
	case 'videoadd':
		videoAdd();
		break;
	case 'saveadd':
		SaveAdd();
		break;
	case 'videoisbest':
		videoIsBest();
		break;
	case 'videoisindex':
		videoIsIndex();
		break;
	case 'videodel':
		videoDel();
		break;
	case 'videoalldel':
		videoAllDel();
		break;
	case 'edit':
		Edit();
		break;
	case 'saveedit':
		SaveEdit();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		$sql="select * from ".tname('video')." where CD_Name like '%".$key."%' or CD_User like '%".$key."%' order by CD_AddTime desc";
		main($sql,20);
		break;
	case 'classvideo':
		$CD_ClassID=SafeRequest("CD_ClassID","get");
		$sql="select * from ".tname('video')." where CD_ClassID=".$CD_ClassID." order by CD_AddTime desc";
		main($sql,20);
		break;
	case 'isbest':
		main("select * from ".tname('video')." where CD_IsBest=1 order by CD_AddTime desc",20);
		break;
	case 'isindex':
		main("select * from ".tname('video')." where CD_IsIndex=1 order by CD_AddTime desc",20);
		break;
	case 'singer':
		$CD_SingerID=SafeRequest("CD_SingerID","get");
		main("select * from ".tname('video')." where CD_SingerID=".$CD_SingerID." order by CD_AddTime desc",20);
		break;
	default:
		main("select * from ".tname('video')." order by CD_AddTime desc",20);
		break;
	}
?>
</body>
</html>
<?php					
function main($sql,$size){
	global $db,$action;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<script type="text/javascript">
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
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 所有视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;所有视频&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=所有视频&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="isindex"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 待审视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;待审视频&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=待审视频&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 推荐视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;推荐视频&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=推荐视频&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 搜索视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;搜索视频';</script>";} ?>
<?php if($action=="classvideo"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 栏目视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;栏目视频';</script>";} ?>
<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 歌手视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;歌手视频';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action==""){echo "所有视频";}else if($action=="isindex"){echo "待审视频";}else if($action=="isbest"){echo "推荐视频";}else if($action=="singer"){echo "歌手视频";}else if($action=="classvideo"){echo "栏目视频";}else if($action=="keyword"){echo "搜索视频";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=video"><span>所有视频</span></a></li>
<li><a href="?iframe=video&action=videoadd"><span>新增视频</span></a></li>
<?php if($action=="isindex"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=video&action=isindex"><span>待审视频</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=video&action=isbest"><span>推荐视频</span></a></li>
<li><a href="?iframe=video&action=class"><span>视频栏目</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<?php
$key=SafeRequest("key","get");
if($action==""){
echo "<li>以下是所有的视频列表</li>";
}elseif($action=="isindex"){
echo "<li>以下是需审核的视频列表，不会在前台显示</li>";
}elseif($action=="isbest"){
echo "<li>以下是被推荐的视频列表</li>";
}elseif($key<>""){
echo "<li>以下是搜索“".$key."”的视频列表，可以输入视频名称、所属会员等关键词进行搜索</li>";
}elseif($action=="classvideo"){
echo "<li>以下是按栏目查看的视频列表</li>";
}elseif($action=="singer"){
echo "<li>以下是按歌手查看的视频列表</li>";
}
?>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="video">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=video">不限栏目</option>
<?php
$sqlclass="select * from ".tname('videoclass');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_ClassID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=video&action=classvideo&CD_ClassID=".$row3['CD_ID']."\" selected=\"selected\">".$row3['CD_Name']."</option>";
}else{
echo "<option value=\"?iframe=video&action=classvideo&CD_ClassID=".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}	
}
}
?>
</select>
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=video">不限歌手</option>
<?php
$sqlclass="select * from ".tname('singer');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_SingerID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=video&action=singer&CD_SingerID=".$row3['CD_ID']."\" selected=\"selected\">".getlen("len","10",$row3['CD_Name'])."</option>";
}else{
echo "<option value=\"?iframe=video&action=singer&CD_SingerID=".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
}
?>
</select>
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=video&action=videoalldel">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>视频名称</th>
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
<tr><td colspan="2" class="td27">没有视频</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?></td>
<td><a href="index.php/video/<?php echo $row['CD_ID']; ?>/" target="_blank" class="act"><font color="<?php echo $row['CD_Color']; ?>"><?php echo ReplaceStr($row['CD_Name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></font></a></td>
<td>
<?php
$res=$db->getrow("select CD_ID,CD_Name from ".tname('videoclass')." where CD_ID=".$row['CD_ClassID']);
if($res){
echo "<a href=\"?iframe=video&action=classvideo&CD_ClassID=".$res['CD_ID']."\" class=\"act\">".$res['CD_Name']."</a>";
}else{
echo "暂无栏目";
}
?>
</td>
<td><?php echo ReplaceStr($row['CD_User'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php if($row['CD_IsBest']==0){ ?><a href="?iframe=video&action=videoisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=1"><img src="static/admincp/images/isbest_no.gif" /></a><?php }else{ ?><a href="?iframe=video&action=videoisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=0"><img src="static/admincp/images/isbest_yes.gif" /></a><?php } ?></td>
<td><?php echo CheckHtml("video",LinkUrl("video",$row['CD_ClassID'],1,$row['CD_ID']),$row['CD_ID'],$row['CD_ClassID']); ?></td>
<td>
<?php if($row['CD_IsIndex']==1){ ?>
<a href="?iframe=video&action=videoisindex&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsIndex=0"><img src="static/admincp/images/ishide_no.gif" /></a>
<?php }else{ ?>
<a href="?iframe=video&action=videoisindex&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsIndex=1"><img src="static/admincp/images/ishide_yes.gif" /></a>
<?php } ?>
</td>
<td><?php if(date("Y-m-d",strtotime($row['CD_AddTime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['CD_AddTime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['CD_AddTime'])); } ?></td>
<td><a href="?iframe=video&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">编辑</a><a href="?iframe=video&action=videodel&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="批量删除" onclick="{if(confirm('确定要删除所选定的视频吗？')){this.document.form.submit();return true;}return false;}" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>


<?php
}
function EditBoard($Arr,$ActionUrl,$ActionName){
		global $db,$action;
		if(cd_remoteup==1){
		        $cd_remotepath="plugin.php?open=ftp&opens=index&to=admin&ac=video";
		        $cd_remotewidth="688px";
		        $cd_remoteheight="132px";
		        $cd_remotetop="120px";
		}elseif(cd_remoteup==2){
		        $cd_remotepath="plugin.php?open=qiniu&opens=index&to=admin&ac=video";
		        $cd_remotewidth="688px";
		        $cd_remoteheight="132px";
		        $cd_remotetop="120px";
		}elseif(cd_remoteup==3){
		        $cd_remotepath="plugin.php?open=baidu&opens=index&to=admin&ac=video";
		        $cd_remotewidth="688px";
		        $cd_remoteheight="132px";
		        $cd_remotetop="120px";
		}elseif(cd_remoteup==4){
		        $cd_remotepath="plugin.php?open=oss&opens=index&to=admin&ac=video";
		        $cd_remotewidth="580px";
		        $cd_remoteheight="200px";
		        $cd_remotetop="90px";
		}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_ClassID = $Arr[0];
		$CD_Name = $Arr[1];
		$CD_User = $Arr[2];
		$CD_Pic = $Arr[3];
		$CD_SingerID = $Arr[4];
		$CD_Play = $Arr[5];
		$CD_Hits = $Arr[6];
		$CD_IsIndex = $Arr[7];
		$CD_IsBest = $Arr[8];
		$CD_Color = $Arr[9];
		$CD_Time = $Arr[10];
		if(!IsNul($CD_User)){$CD_User=$_COOKIE['CD_AdminUserName'];}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
?>
<script type="text/javascript">
function CheckForm(){
        if(document.form2.CD_Hits.value==""){
            asyncbox.tips("视频人气不能为空，请填写！", "wait", 1000);
            document.form2.CD_Hits.focus();
            return false;
        }
        else if(document.form2.CD_User.value==""){
            asyncbox.tips("所属会员不能为空，请填写！", "wait", 1000);
            document.form2.CD_User.focus();
            return false;
        }
        else if(document.form2.CD_Name.value==""){
            asyncbox.tips("视频名称不能为空，请填写！", "wait", 1000);
            document.form2.CD_Name.focus();
            return false;
        }
        else if(document.form2.CD_ClassID.value=="0"){
            asyncbox.tips("所属栏目不能为空，请填写！", "wait", 1000);
            document.form2.CD_ClassID.focus();
            return false;
        }
        else if(document.form2.CD_Play.value==""){
            asyncbox.tips("视频地址不能为空，请填写！", "wait", 1000);
            document.form2.CD_Play.focus();
            return false;
        }
        else if(document.form2.CD_Pic.value==""){
            asyncbox.tips("视频封面不能为空，请填写！", "wait", 1000);
            document.form2.CD_Pic.focus();
            return false;
        }
        else {
            return true;
        }
}
</script>
<div class="container">
<?php if($action=="videoadd"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 新增视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;新增视频&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=新增视频&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 编辑视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;编辑视频';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $ActionName; ?>视频</h3><ul class="tab1">
<li><a href="?iframe=video"><span>所有视频</span></a></li>
<?php if($action=="videoadd"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=video&action=videoadd"><span>新增视频</span></a></li>
<li><a href="?iframe=video&action=isindex"><span>待审视频</span></a></li>
<li><a href="?iframe=video&action=isbest"><span>推荐视频</span></a></li>
<li><a href="?iframe=video&action=class"><span>视频栏目</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $ActionUrl; ?>" method="post" name="form2">
<table class="tb tb2">
<tr>
<td>视频人气：<input type="text" class="txt" value="<?php echo $CD_Hits; ?>" name="CD_Hits" id="CD_Hits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
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
<td>所属会员：<input type="text" class="txt" value="<?php echo $CD_User; ?>" name="CD_User" id="CD_User"></td>
</tr>

<tr>
<td class="td29">视频名称：<input type="text" class="txt" value="<?php echo $CD_Name; ?>" name="CD_Name" id="CD_Name">
<select name="CD_Color">
<option value="">颜色</option>
<option style="background-color:#88b3e6;color:#88b3e6" value="#88b3e6"<?php if($CD_Color=="#88b3e6"){echo " selected";} ?>>淡蓝</option>
<option style="background-color:#0C87CD;color:#0C87CD" value="#0C87CD"<?php if($CD_Color=="#0C87CD"){echo " selected";} ?>>天蓝</option>
<option style="background-color:#FF6969;color:#FF6969" value="#FF6969"<?php if($CD_Color=="#FF6969"){echo " selected";} ?>>粉红</option>
<option style="background-color:#F34F34;color:#F34F34" value="#F34F34"<?php if($CD_Color=="#F34F34"){echo " selected";} ?>>深红</option>
<option style="background-color:#93C366;color:#93C366" value="#93C366"<?php if($CD_Color=="#93C366"){echo " selected";} ?>>淡绿</option>
<option style="background-color:#FA7A19;color:#FA7A19" value="#FA7A19"<?php if($CD_Color=="#FA7A19"){echo " selected";} ?>>黄色</option>
</select></td>
<td>所属栏目：<select name="CD_ClassID" id="CD_ClassID">
<option value="0">选择栏目</option>
<?php
$sqlclass="select * from ".tname('videoclass')." order by CD_ID asc";
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
</tr>

<tr>
<td class="longtxt">视频地址：<input type="text" class="txt" value="<?php echo $CD_Play; ?>" name="CD_Play" id="CD_Play"></td><td><div class="rssbutton"><input type="button" value="本地上传" onclick="pop.up('上传视频', 'plugin.php?open=upload&opens=index&to=admin&ac=video&f=form2.CD_Play', '406px', '180px', '100px');" /></div>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('上传视频', '<?php echo $cd_remotepath; ?>', '<?php echo $cd_remotewidth; ?>', '<?php echo $cd_remoteheight; ?>', '<?php echo $cd_remotetop; ?>');" class="addtr">远程上传</a></td>
</tr>

<tr>
<td class="longtxt">视频封面：<input type="text" class="txt" value="<?php echo $CD_Pic; ?>" name="CD_Pic" id="CD_Pic"></td><td><div class="rssbutton"><input type="button" value="本地上传" onclick="pop.up('上传封面', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form2.CD_Pic', '406px', '180px', '100px');" /></div></td>
</tr>
</table>

<table class="tb tb2">
<tr><td><input type="hidden" name="CD_HttpUrl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="hidden" name="CD_Time" value="<?php echo $CD_Time; ?>"><input type="submit" class="btn" name="form2" value="提交" onclick="return CheckForm();" /><input class="checkbox" type="checkbox" name="edittime" id="edittime" value="1" checked /><label for="edittime">更新时间</label><input class="checkbox" type="checkbox" name="CD_IsBest" id="CD_IsBest" value="1"<?php if($CD_IsBest==1){echo " checked";} ?> /><label for="CD_IsBest">推荐</label><input class="checkbox" type="checkbox" name="CD_IsIndex" id="CD_IsIndex" value="1"<?php if($CD_IsIndex==0){echo " checked";} ?> /><label for="CD_IsIndex">审核</label></td></tr>
</table>
</form>
</div>


<?php
}
function ClassMain(){
		global $db;
		$sql="select * from ".tname('videoclass')." order by CD_ID asc";
		$result=$db->query($sql);
		$classnum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 内容审核 - 视频栏目';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容审核&nbsp;&raquo;&nbsp;视频栏目&nbsp;&nbsp;<a target="main" title="添加到常用操作" href="?iframe=menu&action=getadd&name=视频栏目&url=<?php echo ReplaceStr($_SERVER['QUERY_STRING'],"&","%26"); ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>视频栏目</h3><ul class="tab1">
<li><a href="?iframe=video"><span>所有视频</span></a></li>
<li><a href="?iframe=video&action=videoadd"><span>新增视频</span></a></li>
<li><a href="?iframe=video&action=isindex"><span>待审视频</span></a></li>
<li><a href="?iframe=video&action=isbest"><span>推荐视频</span></a></li>
<li class="current"><a href="?iframe=video&action=class"><span>视频栏目</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">栏目管理</th></tr>
</table>
<form name="form" method="post" action="?iframe=video&action=editsave">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>栏目名称</th>
<th>视频统计</th>
<th>排序</th>
<th>状态</th>
<th>编辑操作</th>
</tr>
<?php
if($classnum==0){
?>
<tr><td colspan="2" class="td27">没有视频栏目</td></tr>
<?php
}
if($result){
while($row=$db->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?></td>
<td><div class="parentboard"><input type="text" name="CD_Name<?php echo $row['CD_ID']; ?>" value="<?php echo $row['CD_Name']; ?>" class="txt" /></div></td>
<td><a href="?iframe=video&action=classvideo&CD_ClassID=<?php echo $row['CD_ID']; ?>" class="act">
<?php
$sqlstr="select * from ".tname('video')." where CD_ClassID=".$row['CD_ID'];
$res=$db -> query($sqlstr);
$nums= $db -> num_rows($res);
echo $nums;
?>
</a></td>
<td class="td25"><input type="text" name="CD_TheOrder<?php echo $row['CD_ID']; ?>" value="<?php echo $row['CD_TheOrder']; ?>" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
<td>
<?php if($row['CD_IsIndex']==1){ ?>
<a href="?iframe=video&action=editisindex&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsIndex=0"><img src="static/admincp/images/ishide_no.gif" /></a>
<?php }else{ ?>
<a href="?iframe=video&action=editisindex&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsIndex=1"><img src="static/admincp/images/ishide_yes.gif" /></a>
<?php } ?>
</td>
<td><input type="button" class="btn" value="删除" onclick="location.href='?iframe=video&action=del&CD_ID=<?php echo $row['CD_ID']; ?>';" /></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td class="td25"><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label></td><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="form" value="提交修改" /></div></td></tr>
</table>
</form>
<table class="tb tb2">
<tr><th class="partition">新增栏目</th></tr>
</table>
<form method="post" action="?iframe=video&action=classadd">
<table class="tb tb2">
<tr>
<td>栏目名称</td>
<td><input type="text" class="txt" name="CD_Name" id="CD_Name" size="18" style="margin:0; width: 140px;"></td>
<td>排序</td>
<td><input type="text" class="txt" name="CD_TheOrder" id="CD_TheOrder" style="margin:0; width: 104px;" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="button" class="btn" value="新增" /></div></td></tr>
</table>
</form>
</div>



<?php
}
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="Select * from ".tname('video')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_ClassID'],$row['CD_Name'],$row['CD_User'],$row['CD_Pic'],$row['CD_SingerID'],$row['CD_Play'],$row['CD_Hits'],$row['CD_IsIndex'],$row['CD_IsBest'],$row['CD_Color'],$row['CD_AddTime']);
		}
		EditBoard($Arr,"?iframe=video&action=saveedit&CD_ID=".$CD_ID,"编辑");
	}

	function videoAllDel(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID = RequestBox("CD_ID");
		$query = $db->query("select CD_Play,CD_Pic from ".tname('video')." where CD_ID in ($CD_ID)");
		while ($row = $db->fetch_array($query)) {
			$Play=$row['CD_Play'];
			$Pic=$row['CD_Pic'];
			if(file_exists($Play)){unlink($Play);}
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('video')." where CD_ID in ($CD_ID)";
		if($CD_ID==0){
			ShowMessage("批量删除失败，请先勾选要删除的视频！","?iframe=video","infotitle3",3000,1);
		}else{
			if($db->query($sql)){
				ShowMessage("恭喜您，视频批量删除成功！","?iframe=video","infotitle2",3000,1);
			}
		}
	}

	function videoDel(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sqls="select CD_Play,CD_Pic from ".tname('video')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sqls)){
			$Play=$row['CD_Play'];
			$Pic=$row['CD_Pic'];
			if(file_exists($Play)){unlink($Play);}
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('video')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，视频删除成功！","?iframe=video","infotitle2",1000,1);
		}
	}

	//保存编辑
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_ClassID = SafeRequest("CD_ClassID","post");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_SingerID = SafeRequest("CD_SingerID","post");
		$CD_Play = SafeRequest("CD_Play","post");
		$CD_Hits = SafeRequest("CD_Hits","post");
		$CD_IsIndex = SafeRequest("CD_IsIndex","post");
		$CD_IsBest = SafeRequest("CD_IsBest","post");
		$CD_Color = SafeRequest("CD_Color","post");
		$edittime = SafeRequest("edittime","post");
		$CD_Time = SafeRequest("CD_Time","post");
		$CD_HttpUrl = SafeRequest("CD_HttpUrl","post");
		if($edittime==1){
			$CD_AddTime = date('Y-m-d H:i:s');
		}else{
			$CD_AddTime = $CD_Time;
		}
		if($CD_IsBest==1){
			$CD_IsBest = 1;
		}else{
			$CD_IsBest = 0;
		}
		if($CD_IsIndex==1){
			$CD_IsIndex = 0;
		}else{
			$CD_IsIndex = 1;
		}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		$sql="select * from ".tname('user')." where cd_name='".$CD_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			$db->query("update ".tname('video')." set CD_ClassID=".$CD_ClassID.",CD_Name='".$CD_Name."',CD_User='".$CD_User."',CD_Pic='".$CD_Pic."',CD_SingerID=".$CD_SingerID.",CD_Play='".$CD_Play."',CD_Hits=".$CD_Hits.",CD_IsIndex=".$CD_IsIndex.",CD_IsBest=".$CD_IsBest.",CD_Color='".$CD_Color."',CD_AddTime='".$CD_AddTime."' where CD_ID=".$CD_ID);
			ShowMessage("恭喜您，视频编辑成功！",$CD_HttpUrl,"infotitle2",1000,1);
		}else{
			ShowMessage("编辑失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}

	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ClassID = SafeRequest("CD_ClassID","post");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_SingerID = SafeRequest("CD_SingerID","post");
		$CD_Play = SafeRequest("CD_Play","post");
		$CD_Hits = SafeRequest("CD_Hits","post");
		$CD_IsIndex = SafeRequest("CD_IsIndex","post");
		$CD_IsBest = SafeRequest("CD_IsBest","post");
		$CD_Color = SafeRequest("CD_Color","post");
		$CD_AddTime = date('Y-m-d H:i:s');
		if($CD_IsBest==1){
			$CD_IsBest = 1;
		}else{
			$CD_IsBest = 0;
		}
		if($CD_IsIndex==1){
			$CD_IsIndex = 0;
		}else{
			$CD_IsIndex = 1;
		}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		$sql="select * from ".tname('user')." where cd_name='".$CD_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			$db->query("Insert ".tname('video')." (CD_ClassID,CD_Name,CD_User,CD_Pic,CD_SingerID,CD_Play,CD_Hits,CD_IsIndex,CD_IsBest,CD_Color,CD_AddTime) values (".$CD_ClassID.",'".$CD_Name."','".$CD_User."','".$CD_Pic."',".$CD_SingerID.",'".$CD_Play."',".$CD_Hits.",".$CD_IsIndex.",".$CD_IsBest.",'".$CD_Color."','".$CD_AddTime."')");
			ShowMessage("恭喜您，视频新增成功！","?iframe=video","infotitle2",1000,1);
		}else{
			ShowMessage("新增失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}

	function videoAdd(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=video&action=saveadd","新增");
	}

	function ClassAdd(){
		global $db;
		if(!submitcheck('button')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_Name=SafeRequest("CD_Name","post");
		$CD_TheOrder=SafeRequest("CD_TheOrder","post");
		if(!IsNul($CD_Name)){ShowMessage("新增出错，栏目名称不能为空！","?iframe=video&action=class","infotitle3",2000,1);}
		if(!IsNum($CD_TheOrder)){ShowMessage("新增出错，排序不能为空！","?iframe=video&action=class","infotitle3",2000,1);}
		$sql="Insert ".tname('videoclass')." (CD_Name,CD_TheOrder,CD_IsIndex) values ('".$CD_Name."',".$CD_TheOrder.",0)";
		$db->query($sql);
		ShowMessage("恭喜您，视频栏目新增成功！","?iframe=video&action=class","infotitle2",2000,1);
	}

	function EditSave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$CD_ID = RequestBox("CD_ID");
		if($CD_ID==0){
			ShowMessage("修改失败，请先勾选要编辑的栏目！","?iframe=video&action=class","infotitle3",3000,1);
		}else{
			$ID=explode(",",$CD_ID);
			for($i=0;$i<count($ID);$i++){
				$CD_Name=SafeRequest("CD_Name".$ID[$i],"post");
				$CD_TheOrder=SafeRequest("CD_TheOrder".$ID[$i],"post");
				if(!IsNul($CD_Name)){ShowMessage("修改出错，栏目名称不能为空！","?iframe=video&action=class","infotitle3",2000,1);}
				if(!IsNum($CD_TheOrder)){ShowMessage("修改出错，排序不能为空！","?iframe=video&action=class","infotitle3",2000,1);}
				$sql="update ".tname('videoclass')." set CD_Name='".$CD_Name."',CD_TheOrder=".$CD_TheOrder." where CD_ID=".$ID[$i];
				$db->query($sql);
			}
			ShowMessage("恭喜您，视频栏目修改成功！","?iframe=video&action=class","infotitle2",2000,1);
		}
	}

	function videoIsBest(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsBest = SafeRequest("CD_IsBest","get");
		$sql="update ".tname('video')." set CD_IsBest=".$CD_IsBest." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，推荐状态切换成功！","?iframe=video","infotitle2",1000,1);
		}
	}

	function videoIsIndex(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsIndex = SafeRequest("CD_IsIndex","get");
		$sql="update ".tname('video')." set CD_IsIndex=".$CD_IsIndex." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，审核状态切换成功！","?iframe=video","infotitle2",1000,1);
		}
	}

	function EditIsIndex(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsIndex = SafeRequest("CD_IsIndex","get");
		$sql="update ".tname('videoclass')." set CD_IsIndex=".$CD_IsIndex." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，状态切换成功！","?iframe=video&action=class","infotitle2",1000,1);
		}
	}

	function del(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="delete from ".tname('videoclass')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("恭喜您，视频栏目删除成功！","?iframe=video&action=class","infotitle2",2000,1);
		}
	}
?>