<?php
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>用户管理</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="source/plugin/fancybox/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="source/plugin/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="source/plugin/layer/laydate/laydate.js"></script>
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
	case 'mmedit':
		MMEdit();
		break;
	case 'savemmedit':
		SaveMMEdit();
		break;
	case 'edit':
		Edit();
		break;
	case 'saveedit':
		SaveEdit();
		break;
	case 'del':
		del();
		break;
	case 'save':
		save();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('user')." where cd_name like '%".$key."%' or cd_nicheng like '%".$key."%' order by cd_id desc",20);
		break;
	case 'users':
		main("select * from ".tname('user')." where cd_grade=0 order by cd_id desc",20);
		break;
	case 'vips':
		main("select * from ".tname('user')." where cd_grade=1 order by cd_id desc",20);
		break;
	case 'ulock':
		main("select * from ".tname('user')." where cd_lock=0 order by cd_id desc",20);
		break;
	case 'vlock':
		main("select * from ".tname('user')." where cd_lock=1 order by cd_id desc",20);
		break;
	case 'isbest':
		main("select * from ".tname('user')." where cd_isbest=1 order by cd_id desc",20);
		break;
	case 'checkmusic':
		main("select * from ".tname('user')." where cd_checkmusic=1 order by cd_id desc",20);
		break;
	case 'checkmm':
		main("select * from ".tname('user')." where cd_checkmm=1 order by cd_id desc",20);
		break;
	case 'verifiedmm':
		main("select * from ".tname('user')." where cd_checkmm=2 order by cd_id desc",20);
		break;
	default:
		main("select * from ".tname('user')." order by cd_id desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoardMM($Arr,$url){
	$cd_name = $Arr[0];
	$cd_checkmm = $Arr[1];
	$cd_verified = $Arr[2];
?>
<script type="text/javascript">
function change(type){
        if(type==1){
                document.form2.cd_notice.value = "恭喜，您已经成功通过美女认证！";
        }else{
                document.form2.cd_notice.value = "抱歉，您拍摄的视频照无效，因此未能通过美女认证！";
        }
}
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 审核美女';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;审核美女';</script>
<div class="floattop"><div class="itemtitle"><h3>审核美女</h3><ul class="tab1">
<li><a href="?iframe=user"><span>所有用户</span></a></li>
<li><a href="?iframe=user&action=users"><span>普通用户</span></a></li>
<li><a href="?iframe=user&action=vips"><span>VIP用户</span></a></li>
<li><a href="?iframe=user&action=ulock"><span>正常用户</span></a></li>
<li><a href="?iframe=user&action=vlock"><span>锁定用户</span></a></li>
<li><a href="?iframe=user&action=isbest"><span>推荐用户</span></a></li>
<li><a href="?iframe=user&action=checkmusic"><span>音乐认证</span></a></li>
<li><a href="?iframe=user&action=checkmm"><span>美女认证</span></a></li>
<li><a href="?iframe=user&action=verifiedmm"><span>待审美女</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form2">
<tr><td colspan="2" class="td27">用户名:</td></tr>
<tr><td class="vtop rowform"><?php echo $cd_name; ?></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">视频照:</td></tr>
<tr class="noborder"><td class="vtop rowform"><img width="120" height="120" src="<?php echo $cd_verified; ?>" onerror="this.src='<?php echo cd_upath; ?>static/images/noface_120x120.gif'" /><br /><br /><input name="cd_avatar" class="checkbox" type="checkbox" value="1" /> 删除照片</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">审核结果:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($cd_checkmm==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_checkmm" value="1" onclick="change(1);"<?php if($cd_checkmm==1){echo " checked";} ?>>&nbsp;通过</li><?php if($cd_checkmm==0 || $cd_checkmm==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_checkmm" value="0" onclick="change(0);"<?php if($cd_checkmm==0 || $cd_checkmm==2){echo " checked";} ?>>&nbsp;拒绝</li></ul></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">发送通知:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea rows="6" name="cd_notice" id="cd_notice" cols="50" class="tarea">抱歉，您拍摄的视频照无效，因此未能通过美女认证！</textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="cd_name" value="<?php echo $cd_name; ?>"><input type="hidden" name="cd_verified" value="<?php echo $cd_verified; ?>"><input type="submit" class="btn" name="checkmm" value="提交" /></div></td></tr>
</form>  
</table>
</div>


<?php
}
function EditBoard($Arr,$url){
	global $db;
	$music=$db->num_rows($db->query("select * from ".tname('music')." where CD_User='".$Arr[0]."'"));
	$special=$db->num_rows($db->query("select * from ".tname('special')." where CD_User='".$Arr[0]."'"));
	$singer=$db->num_rows($db->query("select * from ".tname('singer')." where CD_User='".$Arr[0]."'"));
	$video=$db->num_rows($db->query("select * from ".tname('video')." where CD_User='".$Arr[0]."'"));
	$cd_id = SafeRequest("cd_id","get");
	$cd_name = $Arr[0];
	$cd_nicheng = $Arr[1];
	$cd_email = $Arr[2];
	$cd_sex = $Arr[3];
	$cd_qq = $Arr[4];
	$cd_points = $Arr[5];
	$cd_vipindate = $Arr[6];
	$cd_vipenddate = $Arr[7];
	$cd_rank = $Arr[8];
	$cd_introduce = $Arr[9];
	$cd_birthday = $Arr[10];
	$cd_address = $Arr[11];
	$cd_hits = $Arr[12];
	$cd_checkmusic = $Arr[13];
	$cd_isbest = $Arr[14];
	$cd_grade = $Arr[15];
	$cd_vipgrade = $Arr[16];
	$cd_viprank = $Arr[17];
	$cd_lock = $Arr[18];
	if(!IsNum($cd_hits)){$cd_hits=0;}
	if(!IsNum($cd_points)){$cd_points=0;}
	if(!IsNum($cd_rank)){$cd_rank=0;}
	if(!IsNum($cd_viprank)){$cd_viprank=0;}
	if(!IsNul($cd_vipindate)){$cd_vipindate="0000-00-00 00:00:00";}
	if(!IsNul($cd_vipenddate)){$cd_vipenddate="0000-00-00 00:00:00";}
?>
<script type="text/javascript">
function CheckForm(){
        var New=document.getElementsByName("cd_grade");
        var strNew;
        for(var i=0;i<New.length;i++){
	        if(New.item(i).checked){
		        strNew=New.item(i).getAttribute("value");
		        break;
	        }else{
		        continue;
	        }
        }
        var vipgrade=document.getElementsByName("cd_vipgrade");
        var vipgradeNew;
        for(var i=0;i<vipgrade.length;i++){
	        if(vipgrade.item(i).checked){
		        vipgradeNew=vipgrade.item(i).getAttribute("value");
		        break;
	        }else{
		        continue;
	        }
        }
        if(strNew==1){
                if(!vipgradeNew){
		        asyncbox.tips("请选择VIP会员等级！", "wait", 1000);
		        return false;
	        }
	        if(document.form2.cd_viprank.value==""){
		        asyncbox.tips("请填写VIP成长经验！", "wait", 1000);
		        document.form2.cd_viprank.focus();
		        return false;
	        }
	        if(document.form2.cd_vipindate.value=="" || document.form2.cd_vipindate.value=="0000-00-00 00:00:00"){
		        asyncbox.tips("请填写VIP开通日期！", "wait", 1000);
		        document.form2.cd_vipindate.focus();
		        return false;
	        }
	        if(document.form2.cd_vipenddate.value=="" || document.form2.cd_vipenddate.value=="0000-00-00 00:00:00"){
		        asyncbox.tips("请填写VIP结束日期！", "wait", 1000);
		        document.form2.cd_vipenddate.focus();
		        return false;
	        }
        }
}
function change(type){
	if(type==1){
		pathdiv.style.display='';
        }else{
		pathdiv.style.display='none';
        }
}
function getvipdate(itype){
	if (itype==0){
		document.form2.cd_vipindate.value = "<?php echo date('Y-m-d H:i:s'); ?>";
		document.form2.cd_vipenddate.value = "<?php echo date("Y-m-d H:i:s",mktime(date("H"), date("i"), date("s"), date("m"), date("d")+30, date("Y"))); ?>";
        }else{
		document.form2.cd_vipindate.value = "<?php echo date('Y-m-d H:i:s'); ?>";
		document.form2.cd_vipenddate.value = "<?php echo date("Y-m-d H:i:s",mktime(date("H"), date("i"), date("s"), date("m"), date("d")+360, date("Y"))); ?>";
        }
}
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 编辑用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;编辑用户';</script>
<div class="floattop"><div class="itemtitle"><h3>编辑用户</h3><ul class="tab1">
<li><a href="?iframe=user"><span>所有用户</span></a></li>
<li><a href="?iframe=user&action=users"><span>普通用户</span></a></li>
<li><a href="?iframe=user&action=vips"><span>VIP用户</span></a></li>
<li><a href="?iframe=user&action=ulock"><span>正常用户</span></a></li>
<li><a href="?iframe=user&action=vlock"><span>锁定用户</span></a></li>
<li><a href="?iframe=user&action=isbest"><span>推荐用户</span></a></li>
<li><a href="?iframe=user&action=checkmusic"><span>音乐认证</span></a></li>
<li><a href="?iframe=user&action=checkmm"><span>美女认证</span></a></li>
<li><a href="?iframe=user&action=verifiedmm"><span>待审美女</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $url; ?>" method="post" name="form2">
<table class="tb tb2">
<tr><td colspan="2" class="td27">用户名:</td></tr>
<tr><td class="vtop rowform"><?php echo $cd_name; ?></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">头像:</td></tr>
<tr class="noborder"><td class="vtop rowform"><img width="120" height="120" src="<?php echo getavatars($cd_id,1); ?>" /><br /><br /><input name="cd_avatar" class="checkbox" type="checkbox" value="1" /> 删除头像</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">统计信息:</td></tr>
<tr class="noborder"><td class="vtop rowform">
<a href="?iframe=song&action=keyword&key=<?php echo $cd_name; ?>" class="act">音乐数(<?php echo $music; ?>)</a>
<a href="?iframe=album&action=keyword&key=<?php echo $cd_name; ?>" class="act">专辑数(<?php echo $special; ?>)</a>
<a href="?iframe=singer&action=keyword&key=<?php echo $cd_name; ?>" class="act">歌手数(<?php echo $singer; ?>)</a>
<a href="?iframe=video&action=keyword&key=<?php echo $cd_name; ?>" class="act">视频数(<?php echo $video; ?>)</a>
</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">新密码:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_password" name="cd_password" value="" type="text" class="txt" /></td><td class="vtop tips2">如果不更改密码此处请留空</td></tr>
<tr><td colspan="2" class="td27">呢称:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_nicheng" name="cd_nicheng" value="<?php echo $cd_nicheng; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">Email:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_email" name="cd_email" value="<?php echo $cd_email; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">性别:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_sex" class="ps">
<option value="1"<?php if($cd_sex==1){echo " selected";} ?>>男</option>
<option value="0"<?php if($cd_sex==0){echo " selected";} ?>>女</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">QQ:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_qq" name="cd_qq" value="<?php echo $cd_qq; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">生日:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_birthday" name="cd_birthday" value="<?php echo $cd_birthday; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">地区:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_address" name="cd_address" value="<?php echo $cd_address; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">人气:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_hits" id="cd_hits" class="px" value="<?php echo $cd_hits; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">金币:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_points" id="cd_points" class="px" value="<?php echo $cd_points; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">经验:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_rank" id="cd_rank" class="px" value="<?php echo $cd_rank; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">VIP用户:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($cd_grade==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_grade" value="1" onclick="change(1);"<?php if($cd_grade==1){echo " checked";} ?>>&nbsp;是</li><?php if($cd_grade==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_grade" value="0" onclick="change(0);"<?php if($cd_grade==0){echo " checked";} ?>>&nbsp;否</li></ul></td><td class="vtop tips2"></td></tr>
<tbody class="sub" id="pathdiv"<?php if($cd_grade==0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">VIP会员等级:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($cd_vipgrade==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_vipgrade" value="1" onclick="getvipdate(0);"<?php if($cd_vipgrade==1){echo " checked";} ?>>&nbsp;月付会员</li><?php if($cd_vipgrade==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_vipgrade" value="2" onclick="getvipdate(1);"<?php if($cd_vipgrade==2){echo " checked";} ?>>&nbsp;年付会员</li></ul></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">VIP成长经验:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_viprank" id="cd_viprank" class="px" value="<?php echo $cd_viprank; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2">32400上限</td></tr>
<tr><td colspan="2" class="td27">VIP开通日期:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_vipindate" name="cd_vipindate" value="<?php echo $cd_vipindate; ?>" onclick="laydate();" type="text" class="txt" /></td><td class="vtop tips2">日期格式：YYYY-MM-DD hh:mm:ss</td></tr>
<tr><td colspan="2" class="td27">VIP结束日期:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_vipenddate" name="cd_vipenddate" value="<?php echo $cd_vipenddate; ?>" onclick="laydate();" type="text" class="txt" /></td><td class="vtop tips2">日期格式：YYYY-MM-DD hh:mm:ss</td></tr>
</tbody>
<tr><td colspan="2" class="td27">音乐认证:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_checkmusic" class="ps">
<option value="1"<?php if($cd_checkmusic==1){echo " selected";} ?>>是</option>
<option value="0"<?php if($cd_checkmusic==0){echo " selected";} ?>>否</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">推荐用户:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_isbest" class="ps">
<option value="1"<?php if($cd_isbest==1){echo " selected";} ?>>是</option>
<option value="0"<?php if($cd_isbest==0){echo " selected";} ?>>否</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">锁定用户:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_lock" class="ps">
<option value="1"<?php if($cd_lock==1){echo " selected";} ?>>是</option>
<option value="0"<?php if($cd_lock==0){echo " selected";} ?>>否</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">个人介绍:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea name="cd_introduce" id="cd_introduce" class="pt" rows="3" cols="40"><?php echo $cd_introduce; ?></textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="edit" onclick="return CheckForm();" value="提交" /></div></td></tr>
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
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 所有用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;所有用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=所有用户&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="users"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 普通用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;普通用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=普通用户&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="vips"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - VIP用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;VIP用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=VIP用户&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="ulock"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 正常用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;正常用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=正常用户&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="vlock"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 锁定用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;锁定用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=锁定用户&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 推荐用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;推荐用户&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=推荐用户&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="checkmusic"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 音乐认证';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;音乐认证&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=音乐认证&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="checkmm"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 美女认证';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;美女认证&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=美女认证&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="verifiedmm"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board 管理中心 - 用户管理 - 待审美女';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户管理&nbsp;&raquo;&nbsp;待审美女&nbsp;&nbsp;<a target=\"main\" title=\"添加到常用操作\" href=\"?iframe=menu&action=getadd&name=待审美女&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action=="users"){echo "普通用户";}else if($action=="vips"){echo "VIP用户";}else if($action=="ulock"){echo "正常用户";}else if($action=="vlock"){echo "锁定用户";}else if($action=="isbest"){echo "推荐用户";}else if($action=="checkmusic"){echo "音乐认证";}else if($action=="checkmm"){echo "美女认证";}else if($action=="verifiedmm"){echo "待审美女";}else{echo "所有用户";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user"><span>所有用户</span></a></li>
<?php if($action=="users"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=users"><span>普通用户</span></a></li>
<?php if($action=="vips"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=vips"><span>VIP用户</span></a></li>
<?php if($action=="ulock"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=ulock"><span>正常用户</span></a></li>
<?php if($action=="vlock"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=vlock"><span>锁定用户</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=isbest"><span>推荐用户</span></a></li>
<?php if($action=="checkmusic"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=checkmusic"><span>音乐认证</span></a></li>
<?php if($action=="checkmm"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=checkmm"><span>美女认证</span></a></li>
<?php if($action=="verifiedmm"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=verifiedmm"><span>待审美女</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>点击头像可以放大，可以输入用户名、昵称等关键词进行搜索</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="user">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=user&action=save">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>头像</th>
<th>用户名</th>
<th>音乐认证</th>
<th>等级</th>
<th>状态</th>
<th>编辑操作</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">没有用户</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<script type="text/javascript">
$(document).ready(function() {
$("#avatar<?php echo $row['cd_id']; ?>").fancybox({
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
<td><a href="<?php echo getavatars($row["cd_id"],2); ?>" id="avatar<?php echo $row['cd_id']; ?>"><img src="<?php echo getavatars($row["cd_id"],0); ?>" width="25" height="25" /></a></td>
<td><a href="<?php echo cd_upath; ?>index.php?p=space&uid=<?php echo $row['cd_id']; ?>" target="_blank" class="act"><?php echo ReplaceStr($row['cd_name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if($row['cd_checkmusic']==1){echo "<em class=\"lightnum\">已认证</em>";}else{echo "未认证";} ?></td>
<td><?php if($row['cd_grade']==1 && $row['cd_vipgrade']==1){echo "<em class=\"lightnum\">月VIP</em>";}elseif($row['cd_grade']==1 && $row['cd_vipgrade']==2){echo "<em class=\"lightnum\">年VIP</em>";}else{echo "普通";} ?></td>
<td><?php if($row['cd_lock']==1){echo "<em class=\"lightnum\">锁定</em>";}else{echo "正常";} ?></td>
<td><?php if($action=="verifiedmm" || $action=="checkmm"){ ?><a href="?iframe=user&action=mmedit&cd_id=<?php echo $row['cd_id']; ?>" class="act">审核</a><?php } ?><a href="?iframe=user&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">编辑</a><a href="?iframe=user&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act" onclick="return confirm('删除用户将同时清空该帐号下的所有数据，确定删除？');">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">全选</label> &nbsp;&nbsp; <select name="cd_eid">
<option value="0">批量删除</option>
<option value="1">激活锁定用户</option>
<option value="2">设为锁定用户</option>
<option value="3">授予音乐认证</option>
<option value="4">解除音乐认证</option>
<option value="5">开通月付VIP</option>
<option value="6">开通年付VIP</option>
<option value="7">解除VIP会员</option>
</select> &nbsp;&nbsp; <input type="submit" name="save" class="btn" value="批量操作" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//批量删除
	function save(){
		global $db;
		if(!submitcheck('save')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		$cd_eid = SafeRequest("cd_eid","post");
		if($cd_id==0){
			ShowMessage("批量操作失败，请先勾选要操作的用户！","?iframe=user","infotitle3",3000,1);
		}else{
			if($cd_eid==0){
		                $query = $db->query("select cd_url from ".tname('pic')." where cd_uid in ($cd_id)");
		                while ($row = $db->fetch_array($query)) {
			                @unlink("data/attachment/album/".$row['cd_url'].".thumb.".fileext($row['cd_url']));
			                @unlink("data/attachment/album/".$row['cd_url'].".thumb_180x180.".fileext($row['cd_url']));
			                @unlink("data/attachment/album/".$row['cd_url']);
		                }
		                $query = $db->query("select cd_id,cd_verified from ".tname('user')." where cd_id in ($cd_id)");
		                while ($row = $db->fetch_array($query)) {
			                @unlink($row['cd_verified']);
			                @unlink("data/attachment/avatar/".$row['cd_id'].".jpg");
			                @unlink("data/attachment/avatar/".$row['cd_id']."_48x48.jpg");
			                @unlink("data/attachment/avatar/".$row['cd_id']."_120x120.jpg");
			                @unlink("data/attachment/avatar/".$row['cd_id']."_200x200.jpg");
		                }
				$sql="delete from ".tname('user')." where cd_id in ($cd_id)";
				if($db->query($sql)){
					$db->query("delete from ".tname('comment')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('wall')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('blog')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('pic')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('pic_like')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('bill')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('slot')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('dislike')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('like')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('listen')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('fav')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('down')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('fans')." where cd_uid in ($cd_id) or cd_uids in ($cd_id)");
					$db->query("delete from ".tname('feed')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('footprints')." where cd_uid in ($cd_id) or cd_uids in ($cd_id)");
					$db->query("delete from ".tname('friend')." where cd_uid in ($cd_id) or cd_uids in ($cd_id)");
					$db->query("delete from ".tname('friendgroup')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('message')." where cd_uid in ($cd_id) or cd_uids in ($cd_id)");
					$db->query("delete from ".tname('notice')." where cd_uid in ($cd_id) or cd_uids in ($cd_id)");
					$db->query("delete from ".tname('paylog')." where cd_uid in ($cd_id)");
					$db->query("delete from ".tname('session')." where cd_uid in ($cd_id)");
					ShowMessage("恭喜您，用户批量删除成功！","?iframe=user","infotitle2",3000,1);
				}
			}elseif($cd_eid==1){
				$db->query("update ".tname('user')." set cd_lock=0 where cd_id in ($cd_id)");
				ShowMessage("恭喜您，用户激活锁定成功！","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==2){
				$db->query("update ".tname('user')." set cd_lock=1 where cd_id in ($cd_id)");
				ShowMessage("恭喜您，用户设为锁定成功！","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==3){
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => '系统提示',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '恭喜，您已经被管理员授予音乐认证！',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_checkmusic=1 where cd_id=".$row['cd_id']);
				}
				ShowMessage("恭喜您，用户授予音乐认证成功！","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==4){
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => '系统提示',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '很遗憾，您已经被管理员解除音乐认证！',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_checkmusic=0 where cd_id=".$row['cd_id']);
				}
				ShowMessage("恭喜您，用户解除音乐认证成功！","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==5){
				$cd_viptime = 30;
				$cd_vipindate = date('Y-m-d H:i:s');
				$tomorrow=mktime(date("H"), date("i"), date("s"), date("m"), date("d")+$cd_viptime, date("Y"));
				$cd_vipenddate=date("Y-m-d H:i:s",$tomorrow);
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => '系统提示',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '恭喜，您已经被管理员开通月付VIP！',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_grade=1,cd_vipgrade=1,cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."' where cd_id=".$row['cd_id']);
				}
				ShowMessage("恭喜您，用户开通月付VIP成功！","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==6){
				$cd_viptime = 360;
				$cd_vipindate = date('Y-m-d H:i:s');
				$tomorrow=mktime(date("H"), date("i"), date("s"), date("m"), date("d")+$cd_viptime, date("Y"));
				$cd_vipenddate=date("Y-m-d H:i:s",$tomorrow);
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => '系统提示',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '恭喜，您已经被管理员开通年付VIP！',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_grade=1,cd_vipgrade=2,cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."' where cd_id=".$row['cd_id']);
				}
				ShowMessage("恭喜您，用户开通年付VIP成功！","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==7){
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => '系统提示',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '很遗憾，您已经被管理员解除VIP会员！',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_grade=0,cd_vipgrade=0,cd_vipindate='0000-00-00 00:00:00',cd_vipenddate='0000-00-00 00:00:00' where cd_id=".$row['cd_id']);
				}
				ShowMessage("恭喜您，用户解除VIP会员成功！","?iframe=user","infotitle2",1000,1);
			}
		}
	}

	//删除
	function del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$query = $db->query("select cd_url from ".tname('pic')." where cd_uid=".$cd_id);
		while ($row = $db->fetch_array($query)) {
			@unlink("data/attachment/album/".$row['cd_url'].".thumb.".fileext($row['cd_url']));
			@unlink("data/attachment/album/".$row['cd_url'].".thumb_180x180.".fileext($row['cd_url']));
			@unlink("data/attachment/album/".$row['cd_url']);
		}
		$sqls="select cd_id,cd_verified from ".tname('user')." where cd_id=".$cd_id;
		if($row=$db->getrow($sqls)){
			$verified=$row['cd_verified'];
			$avatar="data/attachment/avatar/".$row['cd_id'].".jpg";
			$avatar_48="data/attachment/avatar/".$row['cd_id']."_48x48.jpg";
			$avatar_120="data/attachment/avatar/".$row['cd_id']."_120x120.jpg";
			$avatar_200="data/attachment/avatar/".$row['cd_id']."_200x200.jpg";
			if(file_exists($verified)){unlink($verified);}
			if(file_exists($avatar)){unlink($avatar);}
			if(file_exists($avatar_48)){unlink($avatar_48);}
			if(file_exists($avatar_120)){unlink($avatar_120);}
			if(file_exists($avatar_200)){unlink($avatar_200);}
		}
		$sql="delete from ".tname('user')." where cd_id=".$cd_id;
		if($db->query($sql)){
			$db->query("delete from ".tname('comment')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('wall')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('blog')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('pic')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('pic_like')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('bill')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('slot')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('dislike')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('like')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('listen')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('fav')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('down')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('fans')." where cd_uid=".$cd_id." or cd_uids=".$cd_id);
			$db->query("delete from ".tname('feed')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('footprints')." where cd_uid=".$cd_id." or cd_uids=".$cd_id);
			$db->query("delete from ".tname('friend')." where cd_uid=".$cd_id." or cd_uids=".$cd_id);
			$db->query("delete from ".tname('friendgroup')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('message')." where cd_uid=".$cd_id." or cd_uids=".$cd_id);
			$db->query("delete from ".tname('notice')." where cd_uid=".$cd_id." or cd_uids=".$cd_id);
			$db->query("delete from ".tname('paylog')." where cd_uid=".$cd_id);
			$db->query("delete from ".tname('session')." where cd_uid=".$cd_id);
			ShowMessage("恭喜您，用户删除成功！","?iframe=user","infotitle2",3000,1);
		}
	}

	//审核认证MM
	function MMEdit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('user')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_checkmm'],$row['cd_verified']);
		}
		EditBoardMM($Arr,"?iframe=user&action=savemmedit&cd_id=".$cd_id);
	}


	//审核认证MM-保存编辑
	function SaveMMEdit(){
		global $db;
		if(!submitcheck('checkmm')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id=SafeRequest("cd_id","get");
		$cd_checkmm=SafeRequest("cd_checkmm","post");
		$cd_notice=SafeRequest("cd_notice","post");
		$cd_name=SafeRequest("cd_name","post");
		$cd_avatar=SafeRequest("cd_avatar","post");
		$cd_verified=SafeRequest("cd_verified","post");
		if($cd_notice){
			$setarr = array(
				'cd_uid' => 0,
				'cd_uname' => '系统提示',
				'cd_uids' => $cd_id,
				'cd_unames' => $cd_name,
				'cd_icon' => 'account',
				'cd_data' => $cd_notice,
				'cd_dataid' => $cd_id,
				'cd_state' => 1,
				'cd_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('notice', $setarr, 1);
		}
		if($cd_avatar==1){
			@unlink($cd_verified);
		}
		if($cd_checkmm==1){
			$db->query("update ".tname('user')." set cd_checkmm=1,cd_points=cd_points+".cd_mmpoints." where cd_id=".$cd_id);
			if(cd_mmpoints >= 1){
				$setarr = array(
					'cd_type' => 1,
					'cd_uid' => $cd_id,
					'cd_uname' => $cd_name,
					'cd_icon' => 'account',
					'cd_title' => '通过美女认证',
					'cd_points' => cd_mmpoints,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			ShowMessage("美女审核已通过！","?iframe=user&action=checkmm","infotitle2",1000,1);
		}else{
			$db->query("update ".tname('user')." set cd_checkmm=0 where cd_id=".$cd_id);
			ShowMessage("美女审核已拒绝！","?iframe=user","infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="Select * from ".tname('user')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_nicheng'],$row['cd_email'],$row['cd_sex'] ,$row['cd_qq'],$row['cd_points'],$row['cd_vipindate'],$row['cd_vipenddate'],$row['cd_rank'],$row['cd_introduce'],$row['cd_birthday'],$row['cd_address'],$row['cd_hits'],$row['cd_checkmusic'],$row['cd_isbest'],$row['cd_grade'],$row['cd_vipgrade'],$row['cd_viprank'],$row['cd_lock']);
		}
		EditBoard($Arr,"?iframe=user&action=saveedit&cd_id=".$cd_id);
	}

	//保存编辑
	function SaveEdit(){
		global $db;
		if(!submitcheck('edit')){ShowMessage("表单验证不符，无法提交！","admin.php","infotitle3",3000,1);}
		$cd_id = SafeRequest("cd_id","get");
		$cd_password = SafeRequest("cd_password","post");
		$cd_nicheng = SafeRequest("cd_nicheng","post");
		$cd_email = SafeRequest("cd_email","post");
		$cd_sex = SafeRequest("cd_sex","post");
		$cd_qq = SafeRequest("cd_qq","post");
		$cd_points = SafeRequest("cd_points","post");
		$cd_vipindate = SafeRequest("cd_vipindate","post");
		$cd_vipenddate = SafeRequest("cd_vipenddate","post");
		$cd_rank = SafeRequest("cd_rank","post");
		$cd_introduce = SafeRequest("cd_introduce","post");
		$cd_birthday = SafeRequest("cd_birthday","post");
		$cd_address = SafeRequest("cd_address","post");
		$cd_hits = SafeRequest("cd_hits","post");
		$cd_lock = SafeRequest("cd_lock","post");
		$cd_checkmusic = SafeRequest("cd_checkmusic","post");
		$cd_isbest = SafeRequest("cd_isbest","post");
		$cd_grade = SafeRequest("cd_grade","post");
		$cd_vipgrade = SafeRequest("cd_vipgrade","post");
		$cd_viprank = SafeRequest("cd_viprank","post");
		$cd_avatar = SafeRequest("cd_avatar","post");
		if($cd_avatar==1){
			@unlink("data/attachment/avatar/".$cd_id.".jpg");
			@unlink("data/attachment/avatar/".$cd_id."_48x48.jpg");
			@unlink("data/attachment/avatar/".$cd_id."_120x120.jpg");
			@unlink("data/attachment/avatar/".$cd_id."_200x200.jpg");
		}
		if($cd_grade==0){
			$cd_vipindate="0000-00-00 00:00:00";
			$cd_vipenddate="0000-00-00 00:00:00";
			$cd_vipgrade=0;
		}
		if(!IsNul($cd_password)){
			$sql="update ".tname('user')." set cd_nicheng='".$cd_nicheng."',cd_email='".$cd_email."',cd_sex=".$cd_sex.",cd_qq='".$cd_qq."',cd_points=".$cd_points.",cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."',cd_rank=".$cd_rank.",cd_introduce='".$cd_introduce."',cd_birthday='".$cd_birthday."',cd_address='".$cd_address."',cd_hits=".$cd_hits.",cd_lock=".$cd_lock.",cd_checkmusic=".$cd_checkmusic.",cd_isbest=".$cd_isbest.",cd_grade=".$cd_grade.",cd_vipgrade=".$cd_vipgrade.",cd_viprank=".$cd_viprank." where cd_id=".$cd_id;
		}else{
			$sql="update ".tname('user')." set cd_password='".substr(md5($cd_password),8,16)."',cd_nicheng='".$cd_nicheng."',cd_email='".$cd_email."',cd_sex=".$cd_sex.",cd_qq='".$cd_qq."',cd_points=".$cd_points.",cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."',cd_rank=".$cd_rank.",cd_introduce='".$cd_introduce."',cd_birthday='".$cd_birthday."',cd_address='".$cd_address."',cd_hits=".$cd_hits.",cd_lock=".$cd_lock.",cd_checkmusic=".$cd_checkmusic.",cd_isbest=".$cd_isbest.",cd_grade=".$cd_grade.",cd_vipgrade=".$cd_vipgrade.",cd_viprank=".$cd_viprank." where cd_id=".$cd_id;
		}
		if($db->query($sql)){
			ShowMessage("恭喜您，用户编辑成功！","?iframe=user","infotitle2",1000,1);
		}else{
			ShowMessage("编辑出错，用户编辑失败！","?iframe=user","infotitle3",3000,1);
		}
	}
?>