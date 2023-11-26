<?php
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>���ֹ���</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/admincp/jquery/ajax.js"></script>
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
	case 'editpassed':
		EditPassed();
		break;
	case 'saveeditpassed':
		SaveEditPassed();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('music')." where CD_Deleted=0 and CD_Name like '%".$key."%' or CD_Deleted=0 and CD_User like '%".$key."%' order by CD_AddTime desc",20);
		break;
	case 'class':
		$CD_ClassID=SafeRequest("CD_ClassID","get");
		main("select * from ".tname('music')." where CD_ClassID=".$CD_ClassID." and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'server':
		$CD_Server=SafeRequest("CD_Server","get");
		main("select * from ".tname('music')." where CD_Server=".$CD_Server." and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'pass':
		main("select * from ".tname('music')." where CD_Passed=1 and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'error':
		main("select * from ".tname('music')." where CD_Error<>0 and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'isbest':
		main("select * from ".tname('music')." where CD_IsBest<>0 and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'deleted':
		main("select * from ".tname('music')." where CD_Deleted=1 order by CD_AddTime desc",20);
		break;
	case 'special':
		$CD_SpecialID=SafeRequest("CD_SpecialID","get");
		main("select * from ".tname('music')." where CD_SpecialID=".$CD_SpecialID." and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'singer':
		$CD_SingerID=SafeRequest("CD_SingerID","get");
		main("select * from ".tname('music')." where CD_SingerID=".$CD_SingerID." and CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	case 'dela':
		DelA();
		break;
	case 'delb':
		DelB();
		break;
	case 'delc':
		DelC();
		break;
	case 'allhtml':
		AllHtml();
		break;
	default:
		main("select * from ".tname('music')." where CD_Deleted=0 order by CD_AddTime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditPassedBoard($Arr,$url){
$CD_ID = $Arr[0];
$CD_Name = $Arr[1];
$CD_ClassID = $Arr[2];
$CD_SingerID = $Arr[3];
$CD_UserID = $Arr[4];
$CD_User = $Arr[5];
$CD_AddTime = $Arr[6];
$CD_Passed = $Arr[7];
?>
<script type="text/javascript">
function change(type){
        if(type==0){
                document.editpassed.CD_Notice.value = "��ϲ�����ϴ������֡�<?php echo $CD_Name; ?>���Ѿ�ͨ����ˣ�";
        }else{
                document.editpassed.CD_Notice.value = "��Ǹ�����ϴ������֡�<?php echo $CD_Name; ?>���򲻷��ϱ�վ��¼������δͨ����ˣ�";
        }
}
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ������� - �������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�������';</script>
<div class="floattop"><div class="itemtitle"><h3>�������</h3><ul class="tab1">
<li><a href="?iframe=song"><span>��������</span></a></li>
<li><a href="?iframe=song&action=add"><span>��������</span></a></li>
<li><a href="?iframe=song&action=pass"><span>��������</span></a></li>
<li><a href="?iframe=song&action=error"><span>��������</span></a></li>
<li><a href="?iframe=song&action=isbest"><span>�Ƽ�����</span></a></li>
<li><a href="?iframe=song&action=deleted"><span>����վ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="editpassed">
<tr><td align="right">�������ƣ�</td><td>
<a href="index.php/song/<?php echo $CD_ID; ?>/" class="act" target="_blank"><?php echo $CD_Name; ?></a>
</td></tr>
<tr><td align="right">������Ŀ��</td><td>
<?php
global $db;
$res=$db->getrow("select CD_ID,CD_Name from ".tname('class')." where CD_ID=".$CD_ClassID);
if($res){
echo "<a href=\"index.php/list/".$res['CD_ID']."/1/\" class=\"act\" target=\"_blank\">".$res['CD_Name']."</a>";
}else{
echo "������Ŀ";
}
?>
</td></tr>
<tr><td align="right">�������֣�</td><td>
<a href="<?php echo LinkSingerUrl('singer',$CD_ClassID,1,$CD_SingerID); ?>" class="act" target="_blank"><?php echo GetSingerAlias('qianwei_singer','CD_Name','CD_ID',$CD_SingerID); ?></a>
</td></tr>
<tr><td align="right">������Ա��</td><td>
<a href="<?php echo cd_upath; ?>index.php?p=space&uid=<?php echo $CD_UserID; ?>" class="act" target="_blank"><?php echo $CD_User; ?></a>
</td></tr>
<tr><td align="right">�ϴ�ʱ�䣺</td><td>
<?php echo $CD_AddTime; ?>
</td></tr>
<tr><td align="right">��˽����</td><td>
<input class="radio" type="radio" name="CD_Passed" id="CD_Passed0" value="0" onclick="change(0);"<?php if($CD_Passed=="0"){echo " checked";} ?>>&nbsp;<label for="CD_Passed0">ͨ��</label>
<input class="radio" type="radio" name="CD_Passed" id="CD_Passed1" value="1" onclick="change(1);"<?php if($CD_Passed=="1"){echo " checked";} ?>>&nbsp;<label for="CD_Passed1">�ܾ�</label>
</td></tr>
<tr><td align="right">����֪ͨ��</td><td>
<textarea rows="6" cols="50" name="CD_Notice" id="CD_Notice" class="tarea">��Ǹ�����ϴ������֡�<?php echo $CD_Name; ?>���򲻷��ϱ�վ��¼������δͨ����ˣ�</textarea>
</td></tr>
<tr><td align="right"><input type="submit" class="btn" name="editpassed" value="�ύ���" /></td></tr>
</form>
</table>
</div>


<?php
}
function EditBoard($Arr,$url,$arrname){
		global $db,$action;
		if(cd_remoteup==1){
		        $cd_remotepath="plugin.php?open=ftp&opens=index&to=admin&ac=song";
		        $cd_remotewidth="688px";
		        $cd_remoteheight="132px";
		        $cd_remotetop="120px";
		}elseif(cd_remoteup==2){
		        $cd_remotepath="plugin.php?open=qiniu&opens=index&to=admin&ac=song";
		        $cd_remotewidth="688px";
		        $cd_remoteheight="132px";
		        $cd_remotetop="120px";
		}elseif(cd_remoteup==3){
		        $cd_remotepath="plugin.php?open=baidu&opens=index&to=admin&ac=song";
		        $cd_remotewidth="688px";
		        $cd_remoteheight="132px";
		        $cd_remotetop="120px";
		}elseif(cd_remoteup==4){
		        $cd_remotepath="plugin.php?open=oss&opens=index&to=admin&ac=song";
		        $cd_remotewidth="580px";
		        $cd_remoteheight="200px";
		        $cd_remotetop="90px";
		}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Name = $Arr[0];
		$CD_ClassID = $Arr[1];
		$CD_SpecialID = $Arr[2];
		$CD_SingerID = $Arr[3];
		$CD_User = $Arr[4];
		$CD_Pic = $Arr[5];
		$CD_Url = $Arr[6];
		$CD_DownUrl = $Arr[7];
		$CD_Word = $Arr[8];
		$CD_Lrc = $Arr[9];
		$CD_Hits = $Arr[10];
		$CD_DownHits = $Arr[11];
		$CD_FavHits = $Arr[12];
		$CD_DianGeHits = $Arr[13];
		$CD_GoodHits = $Arr[14];
		$CD_BadHits = $Arr[15];
		$CD_Server = $Arr[16];
		$CD_IsBest = $Arr[17];
		$CD_Points = $Arr[18];
		$CD_Grade = $Arr[19];
		$CD_Color = $Arr[20];
		$CD_Skin = $Arr[21];
		$CD_Time = $Arr[22];
		if(!IsNul($CD_User)){$CD_User=$_COOKIE['CD_AdminUserName'];}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		if(!IsNum($CD_DownHits)){$CD_DownHits=0;}
		if(!IsNum($CD_FavHits)){$CD_FavHits=0;}
		if(!IsNum($CD_DianGeHits)){$CD_DianGeHits=0;}
		if(!IsNum($CD_GoodHits)){$CD_GoodHits=0;}
		if(!IsNum($CD_BadHits)){$CD_BadHits=0;}
		if(!IsNum($CD_Server)){$CD_Server=1;}
		if(!IsNum($CD_Points)){$CD_Points=0;}
		if(!IsNum($CD_Grade)){$CD_Grade=3;}
		if(!IsNul($CD_Skin)){$CD_Skin="play.html";}
		if(SafeRequest("ClassID","get")<>""){
		        $qianwei_CD_ClassID=SafeRequest("ClassID","get");
		}else{
		        $qianwei_CD_ClassID=$CD_ClassID;
		}
?>
<script type="text/javascript">
function CheckForm(){
	if(document.form.CD_Hits.value==""){
		asyncbox.tips("������������Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_Hits.focus();
		return false;
	}
	else if(document.form.CD_GoodHits.value==""){
		asyncbox.tips("������������Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_GoodHits.focus();
		return false;
	}
	else if(document.form.CD_BadHits.value==""){
		asyncbox.tips("������������Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_BadHits.focus();
		return false;
	}
	else if(document.form.CD_DianGeHits.value==""){
		asyncbox.tips("�����������Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_DianGeHits.focus();
		return false;
	}
	else if(document.form.CD_DownHits.value==""){
		asyncbox.tips("������������Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_DownHits.focus();
		return false;
	}
	else if(document.form.CD_FavHits.value==""){
		asyncbox.tips("�ղ���������Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_FavHits.focus();
		return false;
	}
	else if(document.form.CD_Name.value==""){
		asyncbox.tips("�������Ʋ���Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_Name.focus();
		return false;
	}
	else if(document.form.CD_ClassID.value=="0"){
		asyncbox.tips("������Ŀ����Ϊ�գ���ѡ��", "wait", 1000);
		document.form.CD_ClassID.focus();
		return false;
	}
	else if(document.form.CD_User.value==""){
		asyncbox.tips("������Ա����Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_User.focus();
		return false;
	}
	else if(document.form.CD_Points.value==""){
		asyncbox.tips("���ؿ۵㲻��Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_Points.focus();
		return false;
	}
	else if(document.form.CD_Skin.value==""){
		asyncbox.tips("����ģ�岻��Ϊ�գ���ѡ��", "wait", 1000);
		document.form.CD_Skin.focus();
		return false;
	}
	else if(document.form.CD_Url.value==""){
		asyncbox.tips("������ַ����Ϊ�գ�����д��", "wait", 1000);
		document.form.CD_Url.focus();
		return false;
	}
	else {
		return true;
	}
}
</script>
<div class="container">
<?php if($action=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - �༭����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�༭����';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>����</h3><ul class="tab1">
<li><a href="?iframe=song"><span>��������</span></a></li>
<?php if($action=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=song&action=add"><span>��������</span></a></li>
<li><a href="?iframe=song&action=pass"><span>��������</span></a></li>
<li><a href="?iframe=song&action=error"><span>��������</span></a></li>
<li><a href="?iframe=song&action=isbest"><span>�Ƽ�����</span></a></li>
<li><a href="?iframe=song&action=deleted"><span>����վ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $url; ?>" method="post" name="form">
<table class="tb tb2">
<tr style="width:600px">
<td class="td25" style="width:100px">������<input type="text" class="txt" value="<?php echo $CD_Hits; ?>" name="CD_Hits" id="CD_Hits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td25" style="width:100px">������<input type="text" class="txt" value="<?php echo $CD_GoodHits; ?>" name="CD_GoodHits" id="CD_GoodHits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td25" style="width:100px">������<input type="text" class="txt" value="<?php echo $CD_BadHits; ?>" name="CD_BadHits" id="CD_BadHits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td25" style="width:100px">��裺<input type="text" class="txt" value="<?php echo $CD_DianGeHits; ?>" name="CD_DianGeHits" id="CD_DianGeHits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td25" style="width:100px">���أ�<input type="text" class="txt" value="<?php echo $CD_DownHits; ?>" name="CD_DownHits" id="CD_DownHits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td class="td25" style="width:100px">�ղأ�<input type="text" class="txt" value="<?php echo $CD_FavHits; ?>" name="CD_FavHits" id="CD_FavHits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>
</table>

<table class="tb tb2">
<tr>
<td class="td29 lightnum">�������ƣ�<input type="text" class="txt" value="<?php echo $CD_Name; ?>" name="CD_Name" id="CD_Name">
<select name="CD_Color">
<option value="">��ɫ</option>
<option style="background-color:#88b3e6;color:#88b3e6" value="#88b3e6"<?php if($CD_Color=="#88b3e6"){echo " selected";} ?>>����</option>
<option style="background-color:#0C87CD;color:#0C87CD" value="#0C87CD"<?php if($CD_Color=="#0C87CD"){echo " selected";} ?>>����</option>
<option style="background-color:#FF6969;color:#FF6969" value="#FF6969"<?php if($CD_Color=="#FF6969"){echo " selected";} ?>>�ۺ�</option>
<option style="background-color:#F34F34;color:#F34F34" value="#F34F34"<?php if($CD_Color=="#F34F34"){echo " selected";} ?>>���</option>
<option style="background-color:#93C366;color:#93C366" value="#93C366"<?php if($CD_Color=="#93C366"){echo " selected";} ?>>����</option>
<option style="background-color:#FA7A19;color:#FA7A19" value="#FA7A19"<?php if($CD_Color=="#FA7A19"){echo " selected";} ?>>��ɫ</option>
</select></td>
<td class="lightnum">������Ŀ��<select name="CD_ClassID" id="CD_ClassID">
<option value="0">ѡ����Ŀ</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if($qianwei_CD_ClassID==$row3['CD_ID']){
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
<td>�������֣�<select name="CD_SingerID" id="CD_SingerID">
<option value="0">��ѡ��</option>
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
</select>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('ѡ�����', '?iframe=star&to=a&so=form.CD_SingerID', '500px', '400px', '40px');" class="addtr">ѡ��</a></td>
<td>������Ա��<input type="text" class="txt" value="<?php echo $CD_User; ?>" name="CD_User" id="CD_User"></td>
</tr>

<tr>
<td>����Ȩ�ޣ�<select name="CD_Grade" id="CD_Grade">
<option value="3"<?php if($CD_Grade==3){echo " selected";} ?>>�ο�����</option>
<option value="2"<?php if($CD_Grade==2){echo " selected";} ?>>��ͨ�û�</option>
<option value="1"<?php if($CD_Grade==1){echo " selected";} ?>>VIP ��Ա</option>
</select></td>
<td>���ؿ۵㣺<input type="text" class="txt" value="<?php echo $CD_Points; ?>" name="CD_Points" id="CD_Points" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>

<tr>
<td>����ר����<select name="CD_SpecialID" id="CD_SpecialID">
<option value="0">��ѡ��</option>
<?php
$sqlclass="select CD_ID,CD_Name from ".tname('special');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if($CD_SpecialID==$row3['CD_ID']){
echo "<option value=\"".$row3['CD_ID']."\" selected=\"selected\">".getlen("len","10",$row3['CD_Name'])."</option>";
}else{
echo "<option value=\"".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
}
?>
</select>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('ѡ��ר��', '?iframe=special&so=form.CD_SpecialID', '500px', '400px', '40px');" class="addtr">ѡ��</a></td>
<td>�Ƽ��Ǽ���<select name="CD_IsBest" id="CD_IsBest">
<option value="0"<?php if($CD_IsBest==0){echo " selected";} ?>>���Ƽ�</option>
<option value="1"<?php if($CD_IsBest==1){echo " selected";} ?>>һ��</option>
<option value="2"<?php if($CD_IsBest==2){echo " selected";} ?>>����</option>
<option value="3"<?php if($CD_IsBest==3){echo " selected";} ?>>����</option>
<option value="4"<?php if($CD_IsBest==4){echo " selected";} ?>>����</option>
<option value="5"<?php if($CD_IsBest==5){echo " selected";} ?>>����</option>
</select></td>
</tr>

<tr>
<td>����ģ�壺<input type="text" class="txt" value="<?php echo $CD_Skin; ?>" name="CD_Skin" id="CD_Skin"><a href="javascript:void(0)" onclick="pop.up('ѡ��ģ��', '?iframe=template&f=form.CD_Skin', '500px', '400px', '40px');" class="addtr">ѡ��</a></td>
<td>�� �� ����<select name="CD_Server" id="CD_Server">
<option value="0">������</option>
<?php
$sqlclass="select * from ".tname('server');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if($CD_Server==$row3['CD_ID']){
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
<td class="longtxt lightnum">������ַ��<input type="text" class="txt" value="<?php echo $CD_Url; ?>" name="CD_Url" id="CD_Url"></td><td><div class="rssbutton"><input type="button" value="�����ϴ�" onclick="pop.up('�ϴ�����', 'plugin.php?open=upload&opens=index&to=admin&ac=song&f=form.CD_Url&d=form.CD_DownUrl', '406px', '180px', '100px');" /></div>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('�ϴ�����', '<?php echo $cd_remotepath; ?>', '<?php echo $cd_remotewidth; ?>', '<?php echo $cd_remoteheight; ?>', '<?php echo $cd_remotetop; ?>');" class="addtr">Զ���ϴ�</a></td>
</tr>

<tr>
<td class="longtxt">���ص�ַ��<input type="text" class="txt" value="<?php echo $CD_DownUrl; ?>" name="CD_DownUrl" id="CD_DownUrl"></td>
</tr>

<tr>
<td class="longtxt">���ַ��棺<input type="text" class="txt" value="<?php echo $CD_Pic; ?>" name="CD_Pic" id="CD_Pic"></td><td><div class="rssbutton"><input type="button" value="�����ϴ�" onclick="pop.up('�ϴ�����', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form.CD_Pic', '406px', '180px', '100px');" /></div></td>
</tr>

<tr>
<td class="longtxt">��̬��ʣ�<input type="text" class="txt" value="<?php echo $CD_Lrc; ?>" name="CD_Lrc" id="CD_Lrc"></td><td><div class="rssbutton"><input type="button" value="�����ϴ�" onclick="pop.up('�ϴ����', 'plugin.php?open=upload&opens=index&to=admin&ac=lrc&f=form.CD_Lrc', '406px', '180px', '100px');" /></div></td>
</tr>
</table>

<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">�ı���ʣ�</div><textarea rows="6" cols="50" id="CD_Word" name="CD_Word" style="width:400px;height:100px;"><?php echo $CD_Word; ?></textarea></td></tr>
<tr><td><input type="hidden" name="CD_HttpUrl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="hidden" name="CD_Time" value="<?php echo $CD_Time; ?>"><input type="submit" class="btn" name="form" value="�ύ" onclick="return CheckForm();" /><input class="checkbox" type="checkbox" name="edittime" id="edittime" value="1" checked /><label for="edittime">����ʱ��</label></td></tr>
</table>
</form>
</div>


<?php
}
function main($sql,$size){
	global $db,$action;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$mnum=$db->num_rows($result);
?>
<script type="text/javascript">
function batch_setup(){
        var Nums = document.getElementsByName("CD_ID[]");
        var mIdSrt = '';
	for (var i=0;i<Nums.length;i++){
		if(Nums[i].checked){
			mIdSrt += Nums[i].value + ',';
		}
	}
	if(mIdSrt){
		location.href = '?iframe=music&id=' + mIdSrt.substr(0, mIdSrt.length-1);
	}
	else{
		location.href = '?iframe=music';
	}
}
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
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="pass"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="error"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - �Ƽ�����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�Ƽ�����&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�Ƽ�����&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="deleted"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����վ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����վ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=����վ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������';</script>";} ?>
<?php if($action=="class"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��Ŀ����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��Ŀ����';</script>";} ?>
<?php if($action=="server"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����������';</script>";} ?>
<?php if($action=="special"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ר������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;ר������';</script>";} ?>
<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action==""){echo "��������";}else if($action=="pass"){echo "��������";}else if($action=="error"){echo "��������";}else if($action=="isbest"){echo "�Ƽ�����";}else if($action=="deleted"){echo "����վ";}else if($action=="keyword"){echo "��������";}else if($action=="class"){echo "��Ŀ����";}else if($action=="server"){echo "����������";}else if($action=="special"){echo "ר������";}else if($action=="singer"){echo "��������";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=song"><span>��������</span></a></li>
<li><a href="?iframe=song&action=add"><span>��������</span></a></li>
<?php if($action=="pass"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=song&action=pass"><span>��������</span></a></li>
<?php if($action=="error"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=song&action=error"><span>��������</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=song&action=isbest"><span>�Ƽ�����</span></a></li>
<?php if($action=="deleted"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=song&action=deleted"><span>����վ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<?php
$key=SafeRequest("key","get");
if($action==""){
echo "<li>������������δ�������վ�е������б�</li>";
}elseif($action=="pass"){
echo "<li>�������������δ�������վ�е������б�������ǰ̨��ʾ</li>";
}elseif($action=="error"){
echo "<li>�����Ǳ�������δ�������վ�е������б����±༭����������״̬</li>";
}elseif($action=="isbest"){
echo "<li>�����Ǳ��Ƽ���δ�������վ�е������б�</li>";
}elseif($action=="deleted"){
echo "<li>�������������վ����δ�����ݿ���ɾ���������б�������ǰ̨��ʾ��������ʱѡ��ָ�</li>";
}elseif($key<>""){
echo "<li>������������".$key."����δ�������վ�е������б����������������ơ�������Ա�ȹؼ��ʽ�������</li>";
}elseif($action=="class"){
echo "<li>�����ǰ���Ŀ�鿴��δ�������վ�е������б�</li>";
}elseif($action=="server"){
echo "<li>�����ǰ��������鿴��δ�������վ�е������б�</li>";
}elseif($action=="special"){
echo "<li>�����ǰ�ר���鿴��δ�������վ�е������б�</li>";
}elseif($action=="singer"){
echo "<li>�����ǰ����ֲ鿴��δ�������վ�е������б�</li>";
}
?>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="song">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=song">������Ŀ</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_ClassID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=song&action=class&CD_ClassID=".$row3['CD_ID']."\" selected=\"selected\">".$row3['CD_Name']."</option>";
}else{
echo "<option value=\"?iframe=song&action=class&CD_ClassID=".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
}
?>
</select>
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=song">���޷�����</option>
<?php
$sqlclass="select * from ".tname('server');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_Server","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=song&action=server&CD_Server=".$row3['CD_ID']."\" selected=\"selected\">".$row3['CD_Name']."</option>";
}else{
echo "<option value=\"?iframe=song&action=server&CD_Server=".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
}
?>
</select>
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=song">����ר��</option>
<?php
$sqlclass="select * from ".tname('special');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_SpecialID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=song&action=special&CD_SpecialID=".$row3['CD_ID']."\" selected=\"selected\">".getlen("len","10",$row3['CD_Name'])."</option>";
}else{
echo "<option value=\"?iframe=song&action=special&CD_SpecialID=".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
}
?>
</select>
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=song">���޸���</option>
<?php
$sqlclass="select * from ".tname('singer');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
if(SafeRequest("CD_SingerID","get")==$row3['CD_ID']){
echo "<option value=\"?iframe=song&action=singer&CD_SingerID=".$row3['CD_ID']."\" selected=\"selected\">".getlen("len","10",$row3['CD_Name'])."</option>";
}else{
echo "<option value=\"?iframe=song&action=singer&CD_SingerID=".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
}
?>
</select>
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=song&action=allhtml">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>��������</th>
<th>������Ŀ</th>
<th>������Ա</th>
<th>�Ƽ��Ǽ�</th>
<th>����</th>
<th>���</th>
<th>����ʱ��</th>
<th>�༭����</th>
</tr>
<?php
if($mnum==0){
?>
<tr><td colspan="2" class="td27">û������</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?></td>
<td><a href="index.php/song/<?php echo $row['CD_ID']; ?>/" target="_blank" class="act"><font color="<?php echo $row['CD_Color']; ?>"><?php echo ReplaceStr($row['CD_Name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></font></a></td>
<td>
<?php
$res=$db->getrow("select CD_ID,CD_Name from ".tname('class')." where CD_ID=".$row['CD_ClassID']);
if($res){
echo "<a href=\"?iframe=song&action=class&CD_ClassID=".$res['CD_ID']."\" class=\"act\">".$res['CD_Name']."</a>";
}else{
echo "������Ŀ";
}
?>
</td>
<td><?php echo $row['CD_User']; ?></td>
<td id="CD_IsBest<?php echo $row['CD_ID']; ?>"><script type="text/javascript">ShowStar(<?php echo $row['CD_IsBest']; ?>, <?php echo $row['CD_ID']; ?>);</script></td>
<td><?php echo CheckHtml("music",LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']),$row['CD_ID'],$row['CD_ClassID']); ?></td>
<td><?php if($row['CD_Passed']==1){ ?><img src="static/admincp/images/ishide_no.gif" /><?php }else{ ?><img src="static/admincp/images/ishide_yes.gif" /><?php } ?></td>
<td><?php if(date("Y-m-d",strtotime($row['CD_AddTime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['CD_AddTime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['CD_AddTime'])); } ?></td>
<td><?php if($row['CD_Passed']==1){ ?><a href="?iframe=song&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">���</a><?php } ?><a href="?iframe=song&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">�༭</a><?php if($action=="deleted"){ ?><a href="?iframe=song&action=delc&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">�ָ�</a><a href="?iframe=song&action=delb&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">ɾ��</a><?php }else{ ?><a href="?iframe=song&action=dela&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">ɾ��</a><?php } ?></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td class="td25"><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label></td><td colspan="15"><div class="fixsel"><input type="button" class="btn" value="��������" onclick="batch_setup();" /> &nbsp; <input type="submit" name="allhtml" class="btn" value="��������" /></div></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//������������
	function AllHtml(){
		global $db;
		if(!submitcheck('allhtml')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID=RequestBox("CD_ID");
		if($CD_ID==0){
			ShowMessage("��������ʧ�ܣ����ȹ�ѡҪ���ɵ����֣�","?iframe=song","infotitle3",3000,1);
		}elseif(cd_webhtml==2){
		        $Arr=explode(",",$CD_ID);
		        for($i=0;$i<count($Arr);$i++){
			        $sql="select CD_ClassID from ".tname('music')." where CD_ID=".$Arr[$i];
			        $row=$db->getrow($sql);
			        $spanpath="http://".$_SERVER['HTTP_HOST'].cd_webpath."index.php/song/".$Arr[$i]."/";
			        $spanurl=substr(LinkUrl("music",$row['CD_ClassID'],1,$Arr[$i]),strlen(cd_webpath));
			        spandir($spanurl);
			        fwrite(fopen($spanurl,"wb"),@file_get_contents($spanpath));
		        }
		        ShowMessage("��ϲ���������������ɳɹ���",$_SERVER['HTTP_REFERER'],"infotitle2",3000,1);
		}else{
		        ShowMessage("������ ȫ��->������Ϣ->����ģʽ ������̬��","?iframe=config&action=html","infotitle1",3000,1);
		}
	}

	//�ƽ�����վ
	function DelA(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="update ".tname('music')." set CD_Deleted=1 where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ���������������վ�гɹ���",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//ɾ��
	function DelB(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sqls="Select CD_ID,CD_Url,CD_Pic,CD_Lrc,CD_UserID,CD_User,CD_Passed from ".tname('music')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sqls)){
			if($row["CD_Passed"]==0){
				if(cd_pointsdca >= 1){
					$setarr = array(
						'cd_type' => 0,
						'cd_uid' => $row['CD_UserID'],
						'cd_uname' => $row['CD_User'],
						'cd_icon' => 'dance',
						'cd_title' => '���ֱ�ɾ��',
						'cd_points' => cd_pointsdca,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdca.",cd_rank=cd_rank-".cd_pointsdcb.",cd_musicnum=cd_musicnum-1 where cd_id=".$row['CD_UserID']);
			}
			$db->query("delete from ".tname('comment')." where cd_channel=4 and cd_dataid=".$row['CD_ID']);
			$Url=$row['CD_Url'];
			$Pic=$row['CD_Pic'];
			$Lrc=$row['CD_Lrc'];
			if(file_exists($Url)){unlink($Url);}
			if(file_exists($Pic)){unlink($Pic);}
			if(file_exists($Lrc)){unlink($Lrc);}
		}
		$sql="delete from ".tname('music')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ�������ִ����ݿ���ɾ���ɹ���",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//�ӻ���վ�ָ�
	function DelC(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="update ".tname('music')." set CD_Deleted=0 where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ�������ִӻ���վ�лָ��ɹ���",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//���
	function SaveEditPassed(){
		global $db;
		if(!submitcheck('editpassed')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Passed = SafeRequest("CD_Passed","post");
		$CD_Notice = SafeRequest("CD_Notice","post");
		$sql="Select CD_ID,CD_Name,CD_UserID,CD_User from ".tname('music')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			if($CD_Notice){
				$setarr = array(
					'cd_uid' => 0,
					'cd_uname' => 'ϵͳ��ʾ',
					'cd_uids' => $row['CD_UserID'],
					'cd_unames' => $row['CD_User'],
					'cd_icon' => 'dance',
					'cd_data' => $CD_Notice,
					'cd_dataid' => $row['CD_ID'],
					'cd_state' => 1,
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('notice', $setarr, 1);
			}
			if($CD_Passed==0){
				$db->query("update ".tname('music')." set CD_Passed=0 where CD_ID=".$row['CD_ID']);
				$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuea.",cd_rank=cd_rank+".cd_pointsueb.",cd_musicnum=cd_musicnum+1 where cd_id=".$row['CD_UserID']);
				if(cd_pointsuea >= 1){
					$setarr = array(
						'cd_type' => 1,
						'cd_uid' => $row['CD_UserID'],
						'cd_uname' => $row['CD_User'],
						'cd_icon' => 'dance',
						'cd_title' => '��������',
						'cd_points' => cd_pointsuea,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
				ShowMessage("������˱�ͨ������Ӧ�������ͳ���","?iframe=song","infotitle2",1000,1);
			}else{
				$db->query("update ".tname('music')." set CD_Deleted=1,CD_Passed=1 where CD_ID=".$row['CD_ID']);
				ShowMessage("������˱��ܾ������������վ�У�","?iframe=song&action=deleted","infotitle1",1000,1);
			}
		}
	}

	//�������
	function EditPassed(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="Select * from ".tname('music')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_ID'],$row['CD_Name'],$row['CD_ClassID'],$row['CD_SingerID'],$row['CD_UserID'],$row['CD_User'],$row['CD_AddTime'],$row['CD_Passed']);
		}
		EditPassedBoard($Arr,"?iframe=song&action=saveeditpassed&CD_ID=".$CD_ID);
	}

	//�༭
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="Select * from ".tname('music')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_Name'],$row['CD_ClassID'],$row['CD_SpecialID'],$row['CD_SingerID'],$row['CD_User'],$row['CD_Pic'],$row['CD_Url'],$row['CD_DownUrl'],$row['CD_Word'],$row['CD_Lrc'],$row['CD_Hits'],$row['CD_DownHits'],$row['CD_FavHits'],$row['CD_DianGeHits'],$row['CD_GoodHits'],$row['CD_BadHits'],$row['CD_Server'],$row['CD_IsBest'],$row['CD_Points'],$row['CD_Grade'],$row['CD_Color'],$row['CD_Skin'],$row['CD_AddTime']);
		}
		EditBoard($Arr,"?iframe=song&action=saveedit&CD_ID=".$CD_ID,"�༭");
	}

	//�������
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=song&action=saveadd","����");
	}

	//ִ�б���
	function SaveAdd(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_ClassID = SafeRequest("CD_ClassID","post");
		$CD_SpecialID = SafeRequest("CD_SpecialID","post");
		$CD_SingerID = SafeRequest("CD_SingerID","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_Url = SafeRequest("CD_Url","post");
		$CD_DownUrl = SafeRequest("CD_DownUrl","post");
		$CD_Word = SafeRequest("CD_Word","post");
		$CD_Lrc = SafeRequest("CD_Lrc","post");
		$CD_Hits = SafeRequest("CD_Hits","post");
		$CD_DownHits = SafeRequest("CD_DownHits","post");
		$CD_FavHits = SafeRequest("CD_FavHits","post");
		$CD_DianGeHits = SafeRequest("CD_DianGeHits","post");
		$CD_GoodHits = SafeRequest("CD_GoodHits","post");
		$CD_BadHits = SafeRequest("CD_BadHits","post");
		$CD_Server = SafeRequest("CD_Server","post");
		$CD_IsBest = SafeRequest("CD_IsBest","post");
		$CD_Points = SafeRequest("CD_Points","post");
		$CD_Grade = SafeRequest("CD_Grade","post");
		$CD_Color = SafeRequest("CD_Color","post");
		$CD_Skin = SafeRequest("CD_Skin","post");
		$CD_AddTime = date('Y-m-d H:i:s');
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		if(!IsNum($CD_DownHits)){$CD_DownHits=0;}
		if(!IsNum($CD_FavHits)){$CD_FavHits=0;}
		if(!IsNum($CD_DianGeHits)){$CD_DianGeHits=0;}
		if(!IsNum($CD_GoodHits)){$CD_GoodHits=0;}
		if(!IsNum($CD_BadHits)){$CD_BadHits=0;}
		$sql="select cd_id,cd_nicheng from ".tname('user')." where cd_name='".$CD_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			$db->query("Insert ".tname('music')." (CD_Name,CD_ClassID,CD_SpecialID,CD_SingerID,CD_User,CD_UserID,CD_UserNicheng,CD_Pic,CD_Url,CD_DownUrl,CD_Word,CD_Lrc,CD_Hits,CD_DownHits,CD_FavHits,CD_DianGeHits,CD_GoodHits,CD_BadHits,CD_Server,CD_IsBest,CD_Points,CD_Grade,CD_Color,CD_Skin,CD_AddTime,CD_Deleted,CD_Error,CD_Passed) values ('".$CD_Name."',".$CD_ClassID.",".$CD_SpecialID.",".$CD_SingerID.",'".$CD_User."',".$row['cd_id'].",'".$row['cd_nicheng']."','".$CD_Pic."','".$CD_Url."','".$CD_DownUrl."','".$CD_Word."','".$CD_Lrc."',".$CD_Hits.",".$CD_DownHits.",".$CD_FavHits.",".$CD_DianGeHits.",".$CD_GoodHits.",".$CD_BadHits.",".$CD_Server.",".$CD_IsBest.",".$CD_Points.",".$CD_Grade.",'".$CD_Color."','".$CD_Skin."','".$CD_AddTime."',0,0,0)");
			if(cd_pointsuea >= 1){
				$setarr = array(
					'cd_type' => 1,
					'cd_uid' => $row['cd_id'],
					'cd_uname' => $CD_User,
					'cd_icon' => 'dance',
					'cd_title' => '��������',
					'cd_points' => cd_pointsuea,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuea.",cd_rank=cd_rank+".cd_pointsueb.",cd_musicnum=cd_musicnum+1 where cd_id=".$row['cd_id']);
			ShowMessage("��ϲ�������������ɹ���","?iframe=song","infotitle2",1000,1);
		}else{
			ShowMessage("����ʧ�ܣ�������Ա�����ڣ�","history.back(1);","infotitle3",3000,2);
		}
	}

	//����༭
	function SaveEdit(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_ClassID = SafeRequest("CD_ClassID","post");
		$CD_SpecialID = SafeRequest("CD_SpecialID","post");
		$CD_SingerID = SafeRequest("CD_SingerID","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_Url = SafeRequest("CD_Url","post");
		$CD_DownUrl = SafeRequest("CD_DownUrl","post");
		$CD_Word = SafeRequest("CD_Word","post");
		$CD_Lrc = SafeRequest("CD_Lrc","post");
		$CD_Hits = SafeRequest("CD_Hits","post");
		$CD_DownHits = SafeRequest("CD_DownHits","post");
		$CD_FavHits = SafeRequest("CD_FavHits","post");
		$CD_DianGeHits = SafeRequest("CD_DianGeHits","post");
		$CD_GoodHits = SafeRequest("CD_GoodHits","post");
		$CD_BadHits = SafeRequest("CD_BadHits","post");
		$CD_Server = SafeRequest("CD_Server","post");
		$CD_IsBest = SafeRequest("CD_IsBest","post");
		$CD_Points = SafeRequest("CD_Points","post");
		$CD_Grade = SafeRequest("CD_Grade","post");
		$CD_Color = SafeRequest("CD_Color","post");
		$CD_Skin = SafeRequest("CD_Skin","post");
		$edittime = SafeRequest("edittime","post");
		$CD_Time = SafeRequest("CD_Time","post");
		$CD_HttpUrl = SafeRequest("CD_HttpUrl","post");
		if($edittime==1){
			$CD_AddTime = date('Y-m-d H:i:s');
		}else{
			$CD_AddTime = $CD_Time;
		}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
		if(!IsNum($CD_DownHits)){$CD_DownHits=0;}
		if(!IsNum($CD_FavHits)){$CD_FavHits=0;}
		if(!IsNum($CD_DianGeHits)){$CD_DianGeHits=0;}
		if(!IsNum($CD_GoodHits)){$CD_GoodHits=0;}
		if(!IsNum($CD_BadHits)){$CD_BadHits=0;}
		$sql="select cd_id,cd_nicheng from ".tname('user')." where cd_name='".$CD_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			if(!$db->getone("select CD_ID from ".tname('music')." where CD_User='".$CD_User."' and CD_ID=".$CD_ID)) {
				if(cd_pointsuea >= 1){
					$setarr = array(
						'cd_type' => 1,
						'cd_uid' => $row['cd_id'],
						'cd_uname' => $CD_User,
						'cd_icon' => 'dance',
						'cd_title' => '��������',
						'cd_points' => cd_pointsuea,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
                                $db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuea.",cd_rank=cd_rank+".cd_pointsueb.",cd_musicnum=cd_musicnum+1 where cd_id=".$row['cd_id']);
			}
			$db->query("update ".tname('music')." set CD_Name='".$CD_Name."',CD_ClassID=".$CD_ClassID.",CD_SpecialID=".$CD_SpecialID.",CD_SingerID=".$CD_SingerID.",CD_User='".$CD_User."',CD_UserID=".$row['cd_id'].",CD_UserNicheng='".$row['cd_nicheng']."',CD_Pic='".$CD_Pic."',CD_Url='".$CD_Url."',CD_DownUrl='".$CD_DownUrl."',CD_Word='".$CD_Word."',CD_Lrc='".$CD_Lrc."',CD_Hits=".$CD_Hits.",CD_DownHits=".$CD_DownHits.",CD_FavHits=".$CD_FavHits.",CD_DianGeHits=".$CD_DianGeHits.",CD_GoodHits=".$CD_GoodHits.",CD_BadHits=".$CD_BadHits.",CD_Server=".$CD_Server.",CD_IsBest=".$CD_IsBest.",CD_Points=".$CD_Points.",CD_Grade=".$CD_Grade.",CD_Color='".$CD_Color."',CD_Skin='".$CD_Skin."',CD_AddTime='".$CD_AddTime."',CD_Error=0 where CD_ID=".$CD_ID);
			$db->query("update ".tname('fav')." set cd_musicname='".$CD_Name."' where cd_musicid=".$CD_ID);
			$db->query("update ".tname('dislike')." set cd_musicname='".$CD_Name."' where cd_musicid=".$CD_ID);
			$db->query("update ".tname('like')." set cd_musicname='".$CD_Name."' where cd_musicid=".$CD_ID);
			$db->query("update ".tname('listen')." set cd_musicname='".$CD_Name."' where cd_musicid=".$CD_ID);
			$db->query("update ".tname('down')." set cd_musicname='".$CD_Name."' where cd_musicid=".$CD_ID);
			ShowMessage("��ϲ�������ֱ༭�ɹ���",$CD_HttpUrl,"infotitle2",1000,1);
		}else{
			ShowMessage("�༭ʧ�ܣ�������Ա�����ڣ�","history.back(1);","infotitle3",3000,2);
		}
	}
?>