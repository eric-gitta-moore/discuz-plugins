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
	case 'list':
		$keys=SafeRequest("keys","get");
	        $letter_arr=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	        $letter_arr1=array(-20319,-20283,-19775,-19218,-18710,-18526,-18239,-17922,-1,-17417,-16474,-16212,-15640,-15165,-14922,-14914,-14630,-14149,-14090,-13318,-1,-1,-12838,-12556,-11847,-11055);
	        $letter_arr2=array(-20284,-19776,-19219,-18711,-18527,-18240,-17923,-17418,-1,-16475,-16213,-15641,-15166,-14923,-14915,-14631,-14150,-14091,-13319,-12839,-1,-1,-12557,-11848,-11056,-2050);
	        if(in_array(strtoupper($keys),$letter_arr)){
			$posarr=array_keys($letter_arr,strtoupper($keys));
			$pos=$posarr[0];
			main("select * from ".tname('singer')." where UPPER(substring(CD_Name,1,1))='".$letter_arr[$pos]."' or ord(substring(CD_Name,1,1))-65536>=".$letter_arr1[$pos]." and  ord(substring(CD_Name,1,1))-65536<=".$letter_arr2[$pos],20);
	        }else{
			main("select * from ".tname('singer')." where CD_Area like '%".$keys."%' order by CD_AddTime desc",20);
	        }
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('singer')." where CD_Name like '%".$key."%' or CD_User like '%".$key."%' order by CD_AddTime desc",20);
		break;
	case 'pass':
		main("select * from ".tname('singer')." where CD_Passed=1 order by CD_AddTime desc",20);
		break;
	case 'isbest':
		main("select * from ".tname('singer')." where CD_IsBest=1 order by CD_AddTime desc",20);
		break;
	default:
		main("select * from ".tname('singer')." order by CD_AddTime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$ActionUrl,$ActionName){
		global $db,$action;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Name = $Arr[0];
		$CD_User = $Arr[1];
		$CD_Pic = $Arr[2];
		$CD_Area = $Arr[3];
		$CD_Intro = $Arr[4];
		$CD_Hits = $Arr[5];
		$CD_IsBest = $Arr[6];
		$CD_Passed = $Arr[7];
		$CD_Time = $Arr[8];
		if(!IsNul($CD_User)){$CD_User=$_COOKIE['CD_AdminUserName'];}
		if(!IsNum($CD_Hits)){$CD_Hits=0;}
?>
<script type="text/javascript">
function CheckForm(){
        if(document.form2.CD_Hits.value==""){
            asyncbox.tips("������������Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_Hits.focus();
            return false;
        }
        else if(document.form2.CD_Name.value==""){
            asyncbox.tips("�������Ʋ���Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_Name.focus();
            return false;
        }
        else if(document.form2.CD_User.value==""){
            asyncbox.tips("������Ա����Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_User.focus();
            return false;
        }
        else if(document.form2.CD_Pic.value==""){
            asyncbox.tips("���ַ��治��Ϊ�գ�����д��", "wait", 1000);
            document.form2.CD_Pic.focus();
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
<div class="floattop"><div class="itemtitle"><h3><?php echo $ActionName; ?>����</h3><ul class="tab1">
<li><a href="?iframe=singer"><span>���и���</span></a></li>
<?php if($action=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=singer&action=add"><span>��������</span></a></li>
<li><a href="?iframe=singer&action=pass"><span>�������</span></a></li>
<li><a href="?iframe=singer&action=isbest"><span>�Ƽ�����</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form action="<?php echo $ActionUrl; ?>" method="post" name="form2">
<table class="tb tb2">
<tr>
<td>�������ࣺ<select name="CD_Area" id="CD_Area">
<option value="�������"<?php if($CD_Area=="�������"){echo " selected";} ?>>�������</option>
<option value="ŷ������"<?php if($CD_Area=="ŷ������"){echo " selected";} ?>>ŷ������</option>
<option value="�պ�����"<?php if($CD_Area=="�պ�����"){echo " selected";} ?>>�պ�����</option>
</select></td>
<td>����������<input type="text" class="txt" value="<?php echo $CD_Hits; ?>" name="CD_Hits" id="CD_Hits" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
</tr>

<tr>
<td class="td29">�������ƣ�<input type="text" class="txt" value="<?php echo $CD_Name; ?>" name="CD_Name" id="CD_Name"></td>
<td>������Ա��<input type="text" class="txt" value="<?php echo $CD_User; ?>" name="CD_User" id="CD_User"></td>
</tr>

<tr>
<td class="longtxt">���ַ��棺<input type="text" class="txt" value="<?php echo $CD_Pic; ?>" name="CD_Pic" id="CD_Pic"></td><td><div class="rssbutton"><input type="button" value="�����ϴ�" onclick="pop.up('�ϴ�����', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form2.CD_Pic', '406px', '180px', '100px');" /></div></td>
</tr>
</table>

<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">���ֽ��ܣ�</div><textarea rows="6" cols="50" id="CD_Intro" name="CD_Intro" style="width:400px;height:100px;"><?php echo $CD_Intro; ?></textarea></td></tr>
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
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ���и���';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;���и���&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=���и���&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="pass"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - �������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="isbest"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - �Ƽ�����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;�Ƽ�����&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�Ƽ�����&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������';</script>";} ?>
<?php if($action=="list"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;��������';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action==""){echo "���и���";}else if($action=="pass"){echo "�������";}else if($action=="isbest"){echo "�Ƽ�����";}else if($action=="keyword"){echo "��������";}else if($action=="list"){echo "��������";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=singer"><span>���и���</span></a></li>
<li><a href="?iframe=singer&action=add"><span>��������</span></a></li>
<?php if($action=="pass"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=singer&action=pass"><span>�������</span></a></li>
<?php if($action=="isbest"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=singer&action=isbest"><span>�Ƽ�����</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<?php
$key=SafeRequest("key","get");
if($action==""){
echo "<li>���������еĸ����б�</li>";
}elseif($action=="pass"){
echo "<li>����������˵ĸ����б�������ǰ̨��ʾ</li>";
}elseif($action=="isbest"){
echo "<li>�����Ǳ��Ƽ��ĸ����б�</li>";
}elseif($key<>""){
echo "<li>������������".$key."���ĸ����б���������������ơ�������Ա�ȹؼ��ʽ�������</li>";
}elseif($action=="list"){
echo "<li>�����ǰ������鿴�ĸ����б�</li>";
}
?>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="singer">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=singer">���޷���</option>
<option value="?iframe=singer&action=list&keys=�������"<?php if(SafeRequest("keys","get")=="�������"){echo " selected";} ?>>�������</option>
<option value="?iframe=singer&action=list&keys=ŷ������"<?php if(SafeRequest("keys","get")=="ŷ������"){echo " selected";} ?>>ŷ������</option>
<option value="?iframe=singer&action=list&keys=�պ�����"<?php if(SafeRequest("keys","get")=="�պ�����"){echo " selected";} ?>>�պ�����</option>
</select>
<select onchange="window.location.href=''+this.options[this.selectedIndex].value+'';">
<option value="?iframe=singer">������ĸ</option>
<option value="?iframe=singer&action=list&keys=A"<?php if(SafeRequest("keys","get")=="A"){echo " selected";} ?>>A</option>
<option value="?iframe=singer&action=list&keys=B"<?php if(SafeRequest("keys","get")=="B"){echo " selected";} ?>>B</option>
<option value="?iframe=singer&action=list&keys=C"<?php if(SafeRequest("keys","get")=="C"){echo " selected";} ?>>C</option>
<option value="?iframe=singer&action=list&keys=D"<?php if(SafeRequest("keys","get")=="D"){echo " selected";} ?>>D</option>
<option value="?iframe=singer&action=list&keys=E"<?php if(SafeRequest("keys","get")=="E"){echo " selected";} ?>>E</option>
<option value="?iframe=singer&action=list&keys=F"<?php if(SafeRequest("keys","get")=="F"){echo " selected";} ?>>F</option>
<option value="?iframe=singer&action=list&keys=G"<?php if(SafeRequest("keys","get")=="G"){echo " selected";} ?>>G</option>
<option value="?iframe=singer&action=list&keys=H"<?php if(SafeRequest("keys","get")=="H"){echo " selected";} ?>>H</option>
<option value="?iframe=singer&action=list&keys=I"<?php if(SafeRequest("keys","get")=="I"){echo " selected";} ?>>I</option>
<option value="?iframe=singer&action=list&keys=J"<?php if(SafeRequest("keys","get")=="J"){echo " selected";} ?>>J</option>
<option value="?iframe=singer&action=list&keys=K"<?php if(SafeRequest("keys","get")=="K"){echo " selected";} ?>>K</option>
<option value="?iframe=singer&action=list&keys=L"<?php if(SafeRequest("keys","get")=="L"){echo " selected";} ?>>L</option>
<option value="?iframe=singer&action=list&keys=M"<?php if(SafeRequest("keys","get")=="M"){echo " selected";} ?>>M</option>
<option value="?iframe=singer&action=list&keys=N"<?php if(SafeRequest("keys","get")=="N"){echo " selected";} ?>>N</option>
<option value="?iframe=singer&action=list&keys=O"<?php if(SafeRequest("keys","get")=="O"){echo " selected";} ?>>O</option>
<option value="?iframe=singer&action=list&keys=P"<?php if(SafeRequest("keys","get")=="P"){echo " selected";} ?>>P</option>
<option value="?iframe=singer&action=list&keys=Q"<?php if(SafeRequest("keys","get")=="Q"){echo " selected";} ?>>Q</option>
<option value="?iframe=singer&action=list&keys=R"<?php if(SafeRequest("keys","get")=="R"){echo " selected";} ?>>R</option>
<option value="?iframe=singer&action=list&keys=S"<?php if(SafeRequest("keys","get")=="S"){echo " selected";} ?>>S</option>
<option value="?iframe=singer&action=list&keys=T"<?php if(SafeRequest("keys","get")=="T"){echo " selected";} ?>>T</option>
<option value="?iframe=singer&action=list&keys=U"<?php if(SafeRequest("keys","get")=="U"){echo " selected";} ?>>U</option>
<option value="?iframe=singer&action=list&keys=V"<?php if(SafeRequest("keys","get")=="V"){echo " selected";} ?>>V</option>
<option value="?iframe=singer&action=list&keys=W"<?php if(SafeRequest("keys","get")=="W"){echo " selected";} ?>>W</option>
<option value="?iframe=singer&action=list&keys=X"<?php if(SafeRequest("keys","get")=="X"){echo " selected";} ?>>X</option>
<option value="?iframe=singer&action=list&keys=Y"<?php if(SafeRequest("keys","get")=="Y"){echo " selected";} ?>>Y</option>
<option value="?iframe=singer&action=list&keys=Z"<?php if(SafeRequest("keys","get")=="Z"){echo " selected";} ?>>Z</option>
</select>
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=singer&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>��������</th>
<th>����</th>
<th>ר��</th>
<th>��Ƶ</th>
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
<tr><td colspan="2" class="td27">û�и���</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="CD_ID[]" id="CD_ID" value="<?php echo $row['CD_ID']; ?>"><?php echo $row['CD_ID']; ?></td>
<td><a href="index.php/singer/<?php echo $row['CD_ID']; ?>/" target="_blank" class="act"><?php echo ReplaceStr($row['CD_Name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=song&action=singer&CD_SingerID=<?php echo $row['CD_ID']; ?>" class="act">
<?php
$sqlstr="select CD_ID from ".tname('music')." where CD_SingerID=".$row['CD_ID'];
$res=$db -> query($sqlstr);
$nums= $db -> num_rows($res);
echo $nums;
?>
</a></td>
<td><a href="?iframe=album&action=singer&CD_SingerID=<?php echo $row['CD_ID']; ?>" class="act">
<?php
$sqlstr="select CD_ID from ".tname('special')." where CD_SingerID=".$row['CD_ID'];
$res=$db -> query($sqlstr);
$nums= $db -> num_rows($res);
echo $nums;
?>
</a></td>
<td><a href="?iframe=video&action=singer&CD_SingerID=<?php echo $row['CD_ID']; ?>" class="act">
<?php
$sqlstr="select CD_ID from ".tname('video')." where CD_SingerID=".$row['CD_ID'];
$res=$db -> query($sqlstr);
$nums= $db -> num_rows($res);
echo $nums;
?>
</a></td>
<td><?php echo ReplaceStr($row['CD_User'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php if($row['CD_IsBest']==0){ ?><a href="?iframe=singer&action=editisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=1"><img src="static/admincp/images/isbest_no.gif" /></a><?php }else{ ?><a href="?iframe=singer&action=editisbest&CD_ID=<?php echo $row['CD_ID']; ?>&CD_IsBest=0"><img src="static/admincp/images/isbest_yes.gif" /></a><?php } ?></td>
<td><?php echo CheckHtml("singer",LinkUrl("singer",$row['CD_ID'],1,$row['CD_ID']),$row['CD_ID'],$row['CD_ID']); ?></td>
<td><?php if($row['CD_Passed']==1){ ?><a href="?iframe=singer&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>&CD_Passed=0"><img src="static/admincp/images/ishide_no.gif" /></a><?php }else{ ?><a href="?iframe=singer&action=editpassed&CD_ID=<?php echo $row['CD_ID']; ?>&CD_Passed=1"><img src="static/admincp/images/ishide_yes.gif" /></a><?php } ?></td>
<td><?php if(date("Y-m-d",strtotime($row['CD_AddTime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['CD_AddTime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['CD_AddTime'])); } ?></td>
<td><a href="?iframe=singer&action=edit&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">�༭</a><a href="?iframe=singer&action=del&CD_ID=<?php echo $row['CD_ID']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="����ɾ��" onclick="{if(confirm('ȷ��Ҫɾ����ѡ���ĸ�����')){this.document.form.submit();return true;}return false;}" /></td></tr>
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
		$sql="update ".tname('singer')." set CD_IsBest=".$CD_IsBest." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ�����Ƽ�״̬�л��ɹ���","?iframe=singer","infotitle2",1000,1);
		}
	}

	//���
	function EditPassed(){
		global $db;
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Passed = SafeRequest("CD_Passed","get");
		$sql="update ".tname('singer')." set CD_Passed=".$CD_Passed." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ�������״̬�л��ɹ���","?iframe=singer","infotitle2",1000,1);
		}
	}

	//����ɾ��
	function AllDel(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID=RequestBox("CD_ID");
		$query = $db->query("select CD_Pic from ".tname('singer')." where CD_ID in ($CD_ID)");
		while ($row = $db->fetch_array($query)) {
			$Pic=$row['CD_Pic'];
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('singer')." where CD_ID in ($CD_ID)";
		if($CD_ID==0){
			ShowMessage("����ɾ��ʧ�ܣ����ȹ�ѡҪɾ���ĸ��֣�","?iframe=singer","infotitle3",3000,1);
		}else{
			if($db->query($sql)){
				ShowMessage("��ϲ������������ɾ���ɹ���","?iframe=singer","infotitle2",3000,1);
			}
		}
	}

	//ɾ��
	function Del(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sqls="select CD_Pic from ".tname('singer')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sqls)){
			$Pic=$row['CD_Pic'];
			if(file_exists($Pic)){unlink($Pic);}
		}
		$sql="delete from ".tname('singer')." where CD_ID=".$CD_ID;
		if($db->query($sql)){
			ShowMessage("��ϲ��������ɾ���ɹ���","?iframe=singer","infotitle2",1000,1);
		}
	}

	//�༭
	function Edit(){
		global $db;
		$CD_ID=SafeRequest("CD_ID","get");
		$sql="select * from ".tname('singer')." where CD_ID=".$CD_ID;
		if($row=$db->getrow($sql)){
			$Arr=array($row['CD_Name'],$row['CD_User'],$row['CD_Pic'],$row['CD_Area'],$row['CD_Intro'],$row['CD_Hits'],$row['CD_IsBest'],$row['CD_Passed'],$row['CD_AddTime']);
		}
		EditBoard($Arr,"?iframe=singer&action=saveedit&CD_ID=".$CD_ID,"�༭");
	}

	//�������
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=singer&action=saveadd","����");
	}

	//�����������
	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_Area = SafeRequest("CD_Area","post");
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
			$db->query("Insert ".tname('singer')." (CD_Name,CD_User,CD_Pic,CD_Area,CD_Intro,CD_Hits,CD_IsBest,CD_Passed,CD_AddTime) values ('".$CD_Name."','".$CD_User."','".$CD_Pic."','".$CD_Area."','".$CD_Intro."',".$CD_Hits.",".$CD_IsBest.",".$CD_Passed.",'".$CD_AddTime."')");
			ShowMessage("��ϲ�������������ɹ���","?iframe=singer","infotitle2",1000,1);
		}else{
			ShowMessage("����ʧ�ܣ�������Ա�����ڣ�","history.back(1);","infotitle3",3000,2);
		}
	}

	//����༭����
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$CD_ID = SafeRequest("CD_ID","get");
		$CD_Name = SafeRequest("CD_Name","post");
		$CD_User = SafeRequest("CD_User","post");
		$CD_Pic = SafeRequest("CD_Pic","post");
		$CD_Area = SafeRequest("CD_Area","post");
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
			$db->query("update ".tname('singer')." set CD_Name='".$CD_Name."',CD_User='".$CD_User."',CD_Pic='".$CD_Pic."',CD_Area='".$CD_Area."',CD_Intro='".$CD_Intro."',CD_Hits=".$CD_Hits.",CD_IsBest=".$CD_IsBest.",CD_Passed=".$CD_Passed.",CD_AddTime='".$CD_AddTime."' where CD_ID=".$CD_ID);
			ShowMessage("��ϲ�������ֱ༭�ɹ���",$CD_HttpUrl,"infotitle2",1000,1);
		}else{
			ShowMessage("�༭ʧ�ܣ�������Ա�����ڣ�","history.back(1);","infotitle3",3000,2);
		}
	}
?>