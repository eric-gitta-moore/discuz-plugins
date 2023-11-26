<?php
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>ר������</title>
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
            asyncbox.tips("ר����������Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_Hits.focus();
            return false;
        }
        else if(document.form2.CD_Name.value==""){
            asyncbox.tips("ר�����Ʋ���Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_Name.focus();
            return false;
        }
        else if(document.form2.CD_User.value==""){
            asyncbox.tips("������Ա����Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_User.focus();
            return false;
        }
        else if(document.form2.CD_ClassID.value=="0"){
            asyncbox.tips("������Ŀ����Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_ClassID.focus();
            return false;
        }
        else if(document.form2.CD_GongSi.value==""){
            asyncbox.tips("���й�˾����Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_GongSi.focus();
            return false;
        }
        else if(document.form2.CD_Pic.value==""){
            asyncbox.tips("ר�����治��Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_Pic.focus();
            return false;
        }
        else {
            return true;
        }
}
</script>
<div class="container">
<?php if($action=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����ר��&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=����ר��&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - �༭ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�༭ר��';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $ActionName; ?>ר��</h3><ul class="tab1">
<li><a href="?iframe=album"><span>����ר��</span></a></li>
<?php if($action=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album&action=add"><span>����ר��</span></a></li>
<li><a href="?iframe=album&action=pass"><span>����ר��</span></a></li>
<li><a href="?iframe=album&action=isbest"><span>�Ƽ�ר��</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $ActionUrl; ?>" method="post" name="form2">
<table class="tb tb2">
<tr>
<td>ר��������<input type="text" class="txt" value="<?php echo $CD_Hits; ?>" name="CD_Hits" id="CD_Hits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>

<tr>
<td class="td29">ר�����ƣ�<input type="text" class="txt" value="<?php echo $CD_Name; ?>" name="CD_Name" id="CD_Name"></td>
<td>������Ա��<input type="text" class="txt" value="<?php echo $CD_User; ?>" name="CD_User" id="CD_User"></td>
</tr>

<tr>
<td>������Ŀ��<select name="CD_ClassID" id="CD_ClassID">
<option value="0">ѡ����Ŀ</option>
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
<td>�������ԣ�<select name="CD_YuYan" id="CD_YuYan">
<option value="����"<?php if($CD_YuYan=="����"){echo " selected";} ?>>����</option>
<option value="����"<?php if($CD_YuYan=="����"){echo " selected";} ?>>����</option>
<option value="����"<?php if($CD_YuYan=="����"){echo " selected";} ?>>����</option>
<option value="Ӣ��"<?php if($CD_YuYan=="Ӣ��"){echo " selected";} ?>>Ӣ��</option>
<option value="����"<?php if($CD_YuYan=="����"){echo " selected";} ?>>����</option>
<option value="����"<?php if($CD_YuYan=="����"){echo " selected";} ?>>����</option>
<option value="����"<?php if($CD_YuYan=="����"){echo " selected";} ?>>����</option>
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
</select>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('ѡ�����', '?iframe=star&to=a&so=form2.CD_SingerID', '500px', '400px', '40px');" class="addtr">ѡ��</a></td>
<td>���й�˾��<input type="text" class="txt" value="<?php echo $CD_GongSi; ?>" name="CD_GongSi" id="CD_GongSi"></td>
</tr>

<tr>
<td class="longtxt">ר�����棺<input type="text" class="txt" value="<?php echo $CD_Pic; ?>" name="CD_Pic" id="CD_Pic"></td><td><div class="rssbutton"><input type="button" value="�����ϴ�" onclick="pop.up('�ϴ�����', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form2.CD_Pic', '406px', '180px', '100px');" /></div></td>
</tr>
</table>

<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">ר�����ܣ�</div><textarea rows="6" cols="50" id="CD_Intro" name="CD_Intro" style="width:400px;height:100px;"><?php echo $CD_Intro; ?></textarea></td></tr>
<tr><td><input type="hidden" name="CD_HttpUrl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="hidden" name="CD_Time" value="<?php echo $CD_Time; ?>"><input type="submit" class="btn" name="form2" value="�ύ" onclick="return CheckForm();" /><input class="checkbox" type="checkbox" name="CD_EditTime" id="CD_EditTime" value="1" checked /><label for="CD_EditTime">����ʱ��</label><input class="checkbox" type="checkbox" name="CD_IsBest" id="CD_IsBest" value="1"<?php if($CD_IsBest==1){echo " checked";} ?> /><label for="CD_IsBest">�Ƽ�</label><input class="checkbox" type="checkbox" name="CD_Passed" id="CD_Passed" value="1"<?php if($CD_Passed==0){echo " checked";} ?> /><label for="CD_Passed">���</label></td></tr>
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
                asyncbox.tips("������Ҫ��ѯ�Ĺؼ��ʣ�", "wait", 1000);
                document.getElementById("search").focus();
                return false;
        }else{
                document.btnsearch.submit();
        }
}
</script>
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����ר��&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=����ר��&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="pass"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����ר��&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=����ר��&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - �Ƽ�ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�Ƽ�ר��&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�Ƽ�ר��&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����ר��';</script>";} ?>
<?php if($action=="class"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��Ŀר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��Ŀר��';</script>";} ?>
<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ����ר��';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;����ר��';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action==""){echo "����ר��";}else if($action=="pass"){echo "����ר��";}else if($action=="isbest"){echo "�Ƽ�ר��";}else if($action=="keyword"){echo "����ר��";}else if($action=="class"){echo "��Ŀר��";}else if($action=="singer"){echo "����ר��";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album"><span>����ר��</span></a></li>
<li><a href="?iframe=album&action=add"><span>����ר��</span></a></li>
<?php if($action=="pass"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album&action=pass"><span>����ר��</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=album&action=isbest"><span>�Ƽ�ר��</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<?php
$key=SafeRequest("key","get");
if($action==""){
echo "<li>���������е�ר���б�</li>";
}elseif($action=="pass"){
echo "<li>����������˵�ר���б�������ǰ̨��ʾ</li>";
}elseif($action=="isbest"){
echo "<li>�����Ǳ��Ƽ���ר���б�</li>";
}elseif($key<>""){
echo "<li>������������".$key."����ר���б���������ר�����ơ�������Ա�ȹؼ��ʽ�������</li>";
}elseif($action=="class"){
echo "<li>�����ǰ���Ŀ�鿴��ר���б�</li>";
}elseif($action=="singer"){
echo "<li>�����ǰ����ֲ鿴��ר���б�</li>";
}
?>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="album">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=album">������Ŀ</option>
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
<option value="?iframe=album">���޸���</option>
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
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=album&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>ר������</th>
<th>����ͳ��</th>
<th>������Ŀ</th>
<th>������Ա</th>
<th>�Ƽ�</th>
<th>����</th>
<th>���</th>
<th>����ʱ��</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û��ר��</td></tr>
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
echo "������Ŀ";
}
?>
</td>
<td><?php echo ReplaceStr($row['CD_User'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php if($row['CD_IsBest']==0){ ?><a href="?iframe=album&action=editisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=1"><img src="static/admincp/images/isbest_no.gif" /></a><?php }else{ ?><a href="?iframe=album&action=editisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=0"><img src="static/admincp/images/isbest_yes.gif" /></a><?php } ?></td>
<td><?php echo CheckHtml("special",LinkUrl("special",$row['CD_ClassID'],1,$row['CD_ID']),$row['CD_ID'],$row['CD_ClassID']); ?></td>
<td><?php if($row['CD_Passed']==1){ ?><a href="?iframe=album&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>&CD_Passed=0"><img src="static/admincp/images/ishide_no.gif" /></a><?php }else{ ?><a href="?iframe=album&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>&CD_Passed=1"><img src="static/admincp/images/ishide_yes.gif" /></a><?php } ?></td>
<td><?php if(date("Y-m-d",strtotime($row['CD_AddTime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['CD_AddTime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['CD_AddTime'])); } ?></td>
<td><a href="?iframe=album&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">�༭</a><a href="?iframe=album&action=del&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="����ɾ��" onclick="{if(confirm('ȷ��Ҫɾ����ѡ����ר����')){this.document.form.submit();return true;}return false;}" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//�Ƽ�
	function EditIsBest(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_IsBest = SafeRequest("CD_IsBest","get");
		$sql="update ".tname('special')." set CD_IsBest=".$CD_IsBest." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ�����Ƽ�״̬�л��ɹ���","?iframe=album","infotitle2",1000,1);
		}
	}

	//���
	function EditPassed(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Passed = SafeRequest("CD_Passed","get");
		$sql="update ".tname('special')." set CD_Passed=".$CD_Passed." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ�������״̬�л��ɹ���","?iframe=album","infotitle2",1000,1);
		}
	}

	//����ɾ��
	function AllDel(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID=RequestBox("CD_ID");
		$query = $db->query("select CD_Pic from ".tname('special')." where CD_ID in ($CD_ID)");
		while ($row = $db->fetch_array($query)) {
			$Pic=$row['CD_Pic'];
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('special')." where CD_ID in ($CD_ID)";
		if($CD_ID==0){
			ShowMessage("����ɾ��ʧ�ܣ����ȹ�ѡҪɾ����ר����","?iframe=album","infotitle3",3000,1);
		}else{
			if($db->query($sql)){
				ShowMessage("��ϲ����ר������ɾ���ɹ���","?iframe=album","infotitle2",3000,1);
			}
		}
	}

	//ɾ��
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
			ShowMessage("��ϲ����ר��ɾ���ɹ���","?iframe=album","infotitle2",1000,1);
		}
	}

	//�༭
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="select * from ".tname('special')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_ClassID'],$row['CD_Name'],$row['CD_User'],$row['CD_Pic'],$row['CD_SingerID'],$row['CD_GongSi'],$row['CD_YuYan'],$row['CD_Intro'],$row['CD_Hits'],$row['CD_IsBest'],$row['CD_Passed'],$row['CD_AddTime']);
		}
		EditBoard($Arr,"?iframe=album&action=saveedit&CD_ID=".$CD_ID,"�༭");
	}

	//�������
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=album&action=saveadd","����");
	}

	//�����������
	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
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
			ShowMessage("��ϲ����ר�������ɹ���","?iframe=album","infotitle2",1000,1);
		}else{
			ShowMessage("����ʧ�ܣ�������Ա�����ڣ�","history.back(1);","infotitle3",3000,2);
		}
	}

	//����༭����
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
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
			ShowMessage("��ϲ����ר���༭�ɹ���",$CD_HttpUrl,"infotitle2",1000,1);
		}else{
			ShowMessage("�༭ʧ�ܣ�������Ա�����ڣ�","history.back(1);","infotitle3",3000,2);
		}
	}
?>