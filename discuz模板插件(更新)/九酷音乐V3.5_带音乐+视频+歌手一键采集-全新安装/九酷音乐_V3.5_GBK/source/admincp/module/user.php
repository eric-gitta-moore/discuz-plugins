<?php
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>�û�����</title>
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
                document.form2.cd_notice.value = "��ϲ�����Ѿ��ɹ�ͨ����Ů��֤��";
        }else{
                document.form2.cd_notice.value = "��Ǹ�����������Ƶ����Ч�����δ��ͨ����Ů��֤��";
        }
}
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - �û����� - �����Ů';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;�����Ů';</script>
<div class="floattop"><div class="itemtitle"><h3>�����Ů</h3><ul class="tab1">
<li><a href="?iframe=user"><span>�����û�</span></a></li>
<li><a href="?iframe=user&action=users"><span>��ͨ�û�</span></a></li>
<li><a href="?iframe=user&action=vips"><span>VIP�û�</span></a></li>
<li><a href="?iframe=user&action=ulock"><span>�����û�</span></a></li>
<li><a href="?iframe=user&action=vlock"><span>�����û�</span></a></li>
<li><a href="?iframe=user&action=isbest"><span>�Ƽ��û�</span></a></li>
<li><a href="?iframe=user&action=checkmusic"><span>������֤</span></a></li>
<li><a href="?iframe=user&action=checkmm"><span>��Ů��֤</span></a></li>
<li><a href="?iframe=user&action=verifiedmm"><span>������Ů</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form2">
<tr><td colspan="2" class="td27">�û���:</td></tr>
<tr><td class="vtop rowform"><?php echo $cd_name; ?></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">��Ƶ��:</td></tr>
<tr class="noborder"><td class="vtop rowform"><img width="120" height="120" src="<?php echo $cd_verified; ?>" onerror="this.src='<?php echo cd_upath; ?>static/images/noface_120x120.gif'" /><br /><br /><input name="cd_avatar" class="checkbox" type="checkbox" value="1" /> ɾ����Ƭ</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">��˽��:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($cd_checkmm==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_checkmm" value="1" onclick="change(1);"<?php if($cd_checkmm==1){echo " checked";} ?>>&nbsp;ͨ��</li><?php if($cd_checkmm==0 || $cd_checkmm==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_checkmm" value="0" onclick="change(0);"<?php if($cd_checkmm==0 || $cd_checkmm==2){echo " checked";} ?>>&nbsp;�ܾ�</li></ul></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">����֪ͨ:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea rows="6" name="cd_notice" id="cd_notice" cols="50" class="tarea">��Ǹ�����������Ƶ����Ч�����δ��ͨ����Ů��֤��</textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="cd_name" value="<?php echo $cd_name; ?>"><input type="hidden" name="cd_verified" value="<?php echo $cd_verified; ?>"><input type="submit" class="btn" name="checkmm" value="�ύ" /></div></td></tr>
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
		        asyncbox.tips("��ѡ��VIP��Ա�ȼ���", "wait", 1000);
		        return false;
	        }
	        if(document.form2.cd_viprank.value==""){
		        asyncbox.tips("����дVIP�ɳ����飡", "wait", 1000);
		        document.form2.cd_viprank.focus();
		        return false;
	        }
	        if(document.form2.cd_vipindate.value=="" || document.form2.cd_vipindate.value=="0000-00-00 00:00:00"){
		        asyncbox.tips("����дVIP��ͨ���ڣ�", "wait", 1000);
		        document.form2.cd_vipindate.focus();
		        return false;
	        }
	        if(document.form2.cd_vipenddate.value=="" || document.form2.cd_vipenddate.value=="0000-00-00 00:00:00"){
		        asyncbox.tips("����дVIP�������ڣ�", "wait", 1000);
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
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - �û����� - �༭�û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;�༭�û�';</script>
<div class="floattop"><div class="itemtitle"><h3>�༭�û�</h3><ul class="tab1">
<li><a href="?iframe=user"><span>�����û�</span></a></li>
<li><a href="?iframe=user&action=users"><span>��ͨ�û�</span></a></li>
<li><a href="?iframe=user&action=vips"><span>VIP�û�</span></a></li>
<li><a href="?iframe=user&action=ulock"><span>�����û�</span></a></li>
<li><a href="?iframe=user&action=vlock"><span>�����û�</span></a></li>
<li><a href="?iframe=user&action=isbest"><span>�Ƽ��û�</span></a></li>
<li><a href="?iframe=user&action=checkmusic"><span>������֤</span></a></li>
<li><a href="?iframe=user&action=checkmm"><span>��Ů��֤</span></a></li>
<li><a href="?iframe=user&action=verifiedmm"><span>������Ů</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $url; ?>" method="post" name="form2">
<table class="tb tb2">
<tr><td colspan="2" class="td27">�û���:</td></tr>
<tr><td class="vtop rowform"><?php echo $cd_name; ?></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">ͷ��:</td></tr>
<tr class="noborder"><td class="vtop rowform"><img width="120" height="120" src="<?php echo getavatars($cd_id,1); ?>" /><br /><br /><input name="cd_avatar" class="checkbox" type="checkbox" value="1" /> ɾ��ͷ��</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">ͳ����Ϣ:</td></tr>
<tr class="noborder"><td class="vtop rowform">
<a href="?iframe=song&action=keyword&key=<?php echo $cd_name; ?>" class="act">������(<?php echo $music; ?>)</a>
<a href="?iframe=album&action=keyword&key=<?php echo $cd_name; ?>" class="act">ר����(<?php echo $special; ?>)</a>
<a href="?iframe=singer&action=keyword&key=<?php echo $cd_name; ?>" class="act">������(<?php echo $singer; ?>)</a>
<a href="?iframe=video&action=keyword&key=<?php echo $cd_name; ?>" class="act">��Ƶ��(<?php echo $video; ?>)</a>
</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">������:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_password" name="cd_password" value="" type="text" class="txt" /></td><td class="vtop tips2">�������������˴�������</td></tr>
<tr><td colspan="2" class="td27">�س�:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_nicheng" name="cd_nicheng" value="<?php echo $cd_nicheng; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">Email:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_email" name="cd_email" value="<?php echo $cd_email; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">�Ա�:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_sex" class="ps">
<option value="1"<?php if($cd_sex==1){echo " selected";} ?>>��</option>
<option value="0"<?php if($cd_sex==0){echo " selected";} ?>>Ů</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">QQ:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_qq" name="cd_qq" value="<?php echo $cd_qq; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_birthday" name="cd_birthday" value="<?php echo $cd_birthday; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_address" name="cd_address" value="<?php echo $cd_address; ?>" type="text" class="txt" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_hits" id="cd_hits" class="px" value="<?php echo $cd_hits; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">���:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_points" id="cd_points" class="px" value="<?php echo $cd_points; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_rank" id="cd_rank" class="px" value="<?php echo $cd_rank; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">VIP�û�:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($cd_grade==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_grade" value="1" onclick="change(1);"<?php if($cd_grade==1){echo " checked";} ?>>&nbsp;��</li><?php if($cd_grade==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_grade" value="0" onclick="change(0);"<?php if($cd_grade==0){echo " checked";} ?>>&nbsp;��</li></ul></td><td class="vtop tips2"></td></tr>
<tbody class="sub" id="pathdiv"<?php if($cd_grade==0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">VIP��Ա�ȼ�:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($cd_vipgrade==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_vipgrade" value="1" onclick="getvipdate(0);"<?php if($cd_vipgrade==1){echo " checked";} ?>>&nbsp;�¸���Ա</li><?php if($cd_vipgrade==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_vipgrade" value="2" onclick="getvipdate(1);"<?php if($cd_vipgrade==2){echo " checked";} ?>>&nbsp;�긶��Ա</li></ul></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">VIP�ɳ�����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" name="cd_viprank" id="cd_viprank" class="px" value="<?php echo $cd_viprank; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2">32400����</td></tr>
<tr><td colspan="2" class="td27">VIP��ͨ����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_vipindate" name="cd_vipindate" value="<?php echo $cd_vipindate; ?>" onclick="laydate();" type="text" class="txt" /></td><td class="vtop tips2">���ڸ�ʽ��YYYY-MM-DD hh:mm:ss</td></tr>
<tr><td colspan="2" class="td27">VIP��������:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="cd_vipenddate" name="cd_vipenddate" value="<?php echo $cd_vipenddate; ?>" onclick="laydate();" type="text" class="txt" /></td><td class="vtop tips2">���ڸ�ʽ��YYYY-MM-DD hh:mm:ss</td></tr>
</tbody>
<tr><td colspan="2" class="td27">������֤:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_checkmusic" class="ps">
<option value="1"<?php if($cd_checkmusic==1){echo " selected";} ?>>��</option>
<option value="0"<?php if($cd_checkmusic==0){echo " selected";} ?>>��</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">�Ƽ��û�:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_isbest" class="ps">
<option value="1"<?php if($cd_isbest==1){echo " selected";} ?>>��</option>
<option value="0"<?php if($cd_isbest==0){echo " selected";} ?>>��</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">�����û�:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_lock" class="ps">
<option value="1"<?php if($cd_lock==1){echo " selected";} ?>>��</option>
<option value="0"<?php if($cd_lock==0){echo " selected";} ?>>��</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">���˽���:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea name="cd_introduce" id="cd_introduce" class="pt" rows="3" cols="40"><?php echo $cd_introduce; ?></textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="edit" onclick="return CheckForm();" value="�ύ" /></div></td></tr>
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
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �����û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;�����û�&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�����û�&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="users"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - ��ͨ�û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;��ͨ�û�&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��ͨ�û�&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="vips"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - VIP�û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;VIP�û�&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=VIP�û�&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="ulock"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �����û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;�����û�&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�����û�&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="vlock"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �����û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;�����û�&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�����û�&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �Ƽ��û�';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;�Ƽ��û�&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�Ƽ��û�&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="checkmusic"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - ������֤';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;������֤&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������֤&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="checkmm"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - ��Ů��֤';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;��Ů��֤&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��Ů��֤&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="verifiedmm"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - ������Ů';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;������Ů&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������Ů&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action=="users"){echo "��ͨ�û�";}else if($action=="vips"){echo "VIP�û�";}else if($action=="ulock"){echo "�����û�";}else if($action=="vlock"){echo "�����û�";}else if($action=="isbest"){echo "�Ƽ��û�";}else if($action=="checkmusic"){echo "������֤";}else if($action=="checkmm"){echo "��Ů��֤";}else if($action=="verifiedmm"){echo "������Ů";}else{echo "�����û�";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user"><span>�����û�</span></a></li>
<?php if($action=="users"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=users"><span>��ͨ�û�</span></a></li>
<?php if($action=="vips"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=vips"><span>VIP�û�</span></a></li>
<?php if($action=="ulock"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=ulock"><span>�����û�</span></a></li>
<?php if($action=="vlock"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=vlock"><span>�����û�</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=isbest"><span>�Ƽ��û�</span></a></li>
<?php if($action=="checkmusic"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=checkmusic"><span>������֤</span></a></li>
<?php if($action=="checkmm"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=checkmm"><span>��Ů��֤</span></a></li>
<?php if($action=="verifiedmm"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=verifiedmm"><span>������Ů</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>���ͷ����ԷŴ󣬿��������û������ǳƵȹؼ��ʽ�������</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="user">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=user&action=save">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>ͷ��</th>
<th>�û���</th>
<th>������֤</th>
<th>�ȼ�</th>
<th>״̬</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û���û�</td></tr>
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
<td><?php if($row['cd_checkmusic']==1){echo "<em class=\"lightnum\">����֤</em>";}else{echo "δ��֤";} ?></td>
<td><?php if($row['cd_grade']==1 && $row['cd_vipgrade']==1){echo "<em class=\"lightnum\">��VIP</em>";}elseif($row['cd_grade']==1 && $row['cd_vipgrade']==2){echo "<em class=\"lightnum\">��VIP</em>";}else{echo "��ͨ";} ?></td>
<td><?php if($row['cd_lock']==1){echo "<em class=\"lightnum\">����</em>";}else{echo "����";} ?></td>
<td><?php if($action=="verifiedmm" || $action=="checkmm"){ ?><a href="?iframe=user&action=mmedit&cd_id=<?php echo $row['cd_id']; ?>" class="act">���</a><?php } ?><a href="?iframe=user&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">�༭</a><a href="?iframe=user&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act" onclick="return confirm('ɾ���û���ͬʱ��ո��ʺ��µ��������ݣ�ȷ��ɾ����');">ɾ��</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label> &nbsp;&nbsp; <select name="cd_eid">
<option value="0">����ɾ��</option>
<option value="1">���������û�</option>
<option value="2">��Ϊ�����û�</option>
<option value="3">����������֤</option>
<option value="4">���������֤</option>
<option value="5">��ͨ�¸�VIP</option>
<option value="6">��ͨ�긶VIP</option>
<option value="7">���VIP��Ա</option>
</select> &nbsp;&nbsp; <input type="submit" name="save" class="btn" value="��������" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//����ɾ��
	function save(){
		global $db;
		if(!submitcheck('save')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		$cd_eid = SafeRequest("cd_eid","post");
		if($cd_id==0){
			ShowMessage("��������ʧ�ܣ����ȹ�ѡҪ�������û���","?iframe=user","infotitle3",3000,1);
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
					ShowMessage("��ϲ�����û�����ɾ���ɹ���","?iframe=user","infotitle2",3000,1);
				}
			}elseif($cd_eid==1){
				$db->query("update ".tname('user')." set cd_lock=0 where cd_id in ($cd_id)");
				ShowMessage("��ϲ�����û����������ɹ���","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==2){
				$db->query("update ".tname('user')." set cd_lock=1 where cd_id in ($cd_id)");
				ShowMessage("��ϲ�����û���Ϊ�����ɹ���","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==3){
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => 'ϵͳ��ʾ',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '��ϲ�����Ѿ�������Ա����������֤��',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_checkmusic=1 where cd_id=".$row['cd_id']);
				}
				ShowMessage("��ϲ�����û�����������֤�ɹ���","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==4){
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => 'ϵͳ��ʾ',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '���ź������Ѿ�������Ա���������֤��',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_checkmusic=0 where cd_id=".$row['cd_id']);
				}
				ShowMessage("��ϲ�����û����������֤�ɹ���","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==5){
				$cd_viptime = 30;
				$cd_vipindate = date('Y-m-d H:i:s');
				$tomorrow=mktime(date("H"), date("i"), date("s"), date("m"), date("d")+$cd_viptime, date("Y"));
				$cd_vipenddate=date("Y-m-d H:i:s",$tomorrow);
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => 'ϵͳ��ʾ',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '��ϲ�����Ѿ�������Ա��ͨ�¸�VIP��',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_grade=1,cd_vipgrade=1,cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."' where cd_id=".$row['cd_id']);
				}
				ShowMessage("��ϲ�����û���ͨ�¸�VIP�ɹ���","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==6){
				$cd_viptime = 360;
				$cd_vipindate = date('Y-m-d H:i:s');
				$tomorrow=mktime(date("H"), date("i"), date("s"), date("m"), date("d")+$cd_viptime, date("Y"));
				$cd_vipenddate=date("Y-m-d H:i:s",$tomorrow);
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => 'ϵͳ��ʾ',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '��ϲ�����Ѿ�������Ա��ͨ�긶VIP��',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_grade=1,cd_vipgrade=2,cd_vipindate='".$cd_vipindate."',cd_vipenddate='".$cd_vipenddate."' where cd_id=".$row['cd_id']);
				}
				ShowMessage("��ϲ�����û���ͨ�긶VIP�ɹ���","?iframe=user","infotitle2",1000,1);
			}elseif($cd_eid==7){
				$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_id in($cd_id)");
				while ($row = $db->fetch_array($query)) {
		                        $setarr = array(
			                        'cd_uid' => 0,
			                        'cd_uname' => 'ϵͳ��ʾ',
			                        'cd_uids' => $row['cd_id'],
			                        'cd_unames' => $row['cd_name'],
			                        'cd_icon' => 'account',
			                        'cd_data' => '���ź������Ѿ�������Ա���VIP��Ա��',
			                        'cd_dataid' => 0,
			                        'cd_state' => 1,
			                        'cd_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('notice', $setarr, 1);
		                        $db->query("update ".tname('user')." set cd_grade=0,cd_vipgrade=0,cd_vipindate='0000-00-00 00:00:00',cd_vipenddate='0000-00-00 00:00:00' where cd_id=".$row['cd_id']);
				}
				ShowMessage("��ϲ�����û����VIP��Ա�ɹ���","?iframe=user","infotitle2",1000,1);
			}
		}
	}

	//ɾ��
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
			ShowMessage("��ϲ�����û�ɾ���ɹ���","?iframe=user","infotitle2",3000,1);
		}
	}

	//�����֤MM
	function MMEdit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('user')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_checkmm'],$row['cd_verified']);
		}
		EditBoardMM($Arr,"?iframe=user&action=savemmedit&cd_id=".$cd_id);
	}


	//�����֤MM-����༭
	function SaveMMEdit(){
		global $db;
		if(!submitcheck('checkmm')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id=SafeRequest("cd_id","get");
		$cd_checkmm=SafeRequest("cd_checkmm","post");
		$cd_notice=SafeRequest("cd_notice","post");
		$cd_name=SafeRequest("cd_name","post");
		$cd_avatar=SafeRequest("cd_avatar","post");
		$cd_verified=SafeRequest("cd_verified","post");
		if($cd_notice){
			$setarr = array(
				'cd_uid' => 0,
				'cd_uname' => 'ϵͳ��ʾ',
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
					'cd_title' => 'ͨ����Ů��֤',
					'cd_points' => cd_mmpoints,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			ShowMessage("��Ů�����ͨ����","?iframe=user&action=checkmm","infotitle2",1000,1);
		}else{
			$db->query("update ".tname('user')." set cd_checkmm=0 where cd_id=".$cd_id);
			ShowMessage("��Ů����Ѿܾ���","?iframe=user","infotitle2",1000,1);
		}
	}

	//�༭
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="Select * from ".tname('user')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_nicheng'],$row['cd_email'],$row['cd_sex'] ,$row['cd_qq'],$row['cd_points'],$row['cd_vipindate'],$row['cd_vipenddate'],$row['cd_rank'],$row['cd_introduce'],$row['cd_birthday'],$row['cd_address'],$row['cd_hits'],$row['cd_checkmusic'],$row['cd_isbest'],$row['cd_grade'],$row['cd_vipgrade'],$row['cd_viprank'],$row['cd_lock']);
		}
		EditBoard($Arr,"?iframe=user&action=saveedit&cd_id=".$cd_id);
	}

	//����༭
	function SaveEdit(){
		global $db;
		if(!submitcheck('edit')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
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
			ShowMessage("��ϲ�����û��༭�ɹ���","?iframe=user","infotitle2",1000,1);
		}else{
			ShowMessage("�༭�����û��༭ʧ�ܣ�","?iframe=user","infotitle3",3000,1);
		}
	}
?>