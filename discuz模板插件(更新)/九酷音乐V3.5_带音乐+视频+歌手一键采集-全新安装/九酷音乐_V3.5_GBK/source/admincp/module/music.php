<?php
Administrator(1);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>������������</title>
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
function switchSupport(vTribe, vFlag){
	vTribes = {'ModifyHits':'0','ModifyUser':'1','ModifySinger':'2','ModifyColor':'3','ModifyGrade':'4','ModifyPoints':'5','ModifyServer':'6','ModifyIsBest':'7','ModifySkin':'8','ModifyPassed':'9','ModifyClass':'10','ModifySpecial':'11','ModifyDeleted':'12'};
	for (var i = 0 ; i < 11 ; i++){
		try{
			document.getElementById("supportTribe" + vTribes[vTribe]).style.color = vFlag ? 'red' : '#000';
		} catch(e) {}
		try{
			document.getElementById("myform").elements['support[' + vTribe + '][soldier][' + i + ']'].disabled = vFlag ? false : true;
			document.getElementById("myform").elements['support[' + vTribe + '][soldier][' + i + ']'].style.borderColor = vFlag ? '#F93' : '#CCC';
		} catch(e) {}
		try{
			document.getElementById("myform").elements['support[' + vTribe + '][level][' + i + ']'].disabled = vFlag ? false : true;
		} catch(e) {}
	}
}
</script>
</head>
<body>
<?php
switch($action){
	case 'edit':
		Edit();
		break;
	default:
		Main();
		break;
	}
?>
</body>
</html>
<?php
function Main(){
	global $db;
	$id=SafeRequest("id","get");
?>
<div class="container"><script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ������� - ���ֹ��� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�������&nbsp;&raquo;&nbsp;���ֹ���&nbsp;&raquo;&nbsp;��������';</script>
<div class="infobox">
<form method="post" id="myform" name="myform" action="?iframe=music&action=edit">
<table class="tb">
<tr><td>
<table class="tb">
<tr><td>
<input class="radio" type="radio" name="BatchType" id="BatchType1" value="1"<?php if($id<>""){echo " checked"; } ?>>
<label for="BatchType1">ָ��ID</label>
</td></tr>
<tr><td><input type="text" class="txt" value="<?php echo $id; ?>" name="CD_ID"></td></tr>
<tr><td>
<input class="radio" type="radio" id="BatchType2" name="BatchType" value="2">
<label for="BatchType2">�޸�ָ��������������</label>
</td></tr>
<tr><td>
<select name="CD_ServerID[]" multiple style="height:80px;width:180px;">
<?php
$sqlclass="select * from ".tname('server');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
?>
</select>
</td></tr>
<tr><td>
<input class="radio" type="radio" id="BatchType3" name="BatchType" value="3"<?php if($id==""){echo " checked"; } ?>>
<label for="BatchType3">�޸�ָ����Ŀ������</label>
</td></tr>
<tr><td>
<select name="CD_ClassID[]" multiple style="height:180px;width:180px;">
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
?>
</select>
</td></tr>
<tr><td><input type="submit" name="music" class="btn" value="�ύ" /></td></tr>
</table>
</td>


<td>
<table class="tb">
<tr><td><input class="checkbox" type="checkbox" name="ModifyHits" value="yes" id="support[ModifyHits][is_able]" onclick="switchSupport('ModifyHits', this.checked)" /></td>
<td id="supportTribe0"><label for="support[ModifyHits][is_able]">����������</label></td>
<td><input name="CD_Hits" id="support[ModifyHits][soldier][0]" type="text" class="txt" value="0" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" disabled /></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyUser" value="yes" id="support[ModifyUser][is_able]" onclick="switchSupport('ModifyUser', this.checked)" /></td>
<td id="supportTribe1"><label for="support[ModifyUser][is_able]">������Ա��</label></td>
<td><input name="CD_User" id="support[ModifyUser][soldier][0]" type="text" class="txt" disabled /></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifySinger" value="yes" id="support[ModifySinger][is_able]" onclick="switchSupport('ModifySinger', this.checked)" /></td>
<td id="supportTribe2"><label for="support[ModifySinger][is_able]">�������֣�</label></td>
<td><select name="CD_Singer" id="support[ModifySinger][soldier][0]" disabled>
<option value="0" selected>��ѡ��</option>
<?php
$sqlclass="select CD_ID,CD_Name from ".tname('singer');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
?>
</select></td><td><a href="javascript:void(0)" onclick="pop.up('ѡ�����', '?iframe=star&to=a&so=myform.CD_Singer', '500px', '400px', '40px');" class="addtr">ѡ��</a></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyColor" value="yes" id="support[ModifyColor][is_able]" onclick="switchSupport('ModifyColor', this.checked)" /></td>
<td id="supportTribe3"><label for="support[ModifyColor][is_able]">������ɫ��</label></td>
<td><select name="CD_Color" id="support[ModifyColor][soldier][0]" disabled>
<option value="" selected>ѡ����ɫ</option>
<option style="background-color:#88b3e6;color:#88b3e6" value="#88b3e6">����</option>
<option style="background-color:#0C87CD;color:#0C87CD" value="#0C87CD">����</option>
<option style="background-color:#FF6969;color:#FF6969" value="#FF6969">�ۺ�</option>
<option style="background-color:#F34F34;color:#F34F34" value="#F34F34">���</option>
<option style="background-color:#93C366;color:#93C366" value="#93C366">����</option>
<option style="background-color:#FA7A19;color:#FA7A19" value="#FA7A19">��ɫ</option>
</select></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyGrade" value="yes" id="support[ModifyGrade][is_able]" onclick="switchSupport('ModifyGrade', this.checked)" /></td>
<td id="supportTribe4"><label for="support[ModifyGrade][is_able]">����Ȩ�ޣ�</label></td>
<td><select name="CD_Grade" id="support[ModifyGrade][soldier][0]" disabled>
<option value="3">�ο�����</option>
<option value="2" selected>��ͨ�û�</option>
<option value="1">VIP ��Ա</option>
</select></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyPoints" value="yes" id="support[ModifyPoints][is_able]" onclick="switchSupport('ModifyPoints', this.checked)" /></td>
<td id="supportTribe5"><label for="support[ModifyPoints][is_able]">���ؿ۵㣺</label></td>
<td><input name="CD_Points" id="support[ModifyPoints][soldier][0]" type="text" class="txt" value="0" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" disabled /></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyServer" value="yes" id="support[ModifyServer][is_able]" onclick="switchSupport('ModifyServer', this.checked)" /></td>
<td id="supportTribe6"><label for="support[ModifyServer][is_able]">�� �� ����</label></td>
<td><select name="CD_Server" id="support[ModifyServer][soldier][0]" disabled>
<option value="0" selected>������</option>
<?php
$sqlclass="select * from ".tname('server');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
?>
</select></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyIsBest" value="yes" id="support[ModifyIsBest][is_able]" onclick="switchSupport('ModifyIsBest', this.checked)" /></td>
<td id="supportTribe7"><label for="support[ModifyIsBest][is_able]">�Ƽ��Ǽ���</label></td>
<td><select name="CD_IsBest" id="support[ModifyIsBest][soldier][0]" disabled>
<option value="0" selected>���Ƽ�</option>
<option value="1">һ��</option>
<option value="2">����</option>
<option value="3">����</option>
<option value="4">����</option>
<option value="5">����</option>
</select></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifySkin" value="yes" id="support[ModifySkin][is_able]" onclick="switchSupport('ModifySkin', this.checked)" /></td>
<td id="supportTribe8"><label for="support[ModifySkin][is_able]">����ģ�壺</label></td>
<td><input name="CD_Skin" id="support[ModifySkin][soldier][0]" type="text" class="txt" value="play.html" disabled /></td><td><a href="javascript:void(0)" onclick="pop.up('ѡ��ģ��', '?iframe=template&f=myform.CD_Skin', '500px', '400px', '40px');" class="addtr">ѡ��</a></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyPassed" value="yes" id="support[ModifyPassed][is_able]" onclick="switchSupport('ModifyPassed', this.checked)" /></td>
<td id="supportTribe9"><label for="support[ModifyPassed][is_able]">������ˣ�</label></td>
<td><input name="CD_Passed" class="radio" type="radio" id="support[ModifyPassed][soldier][0]" value="0" checked disabled>&nbsp;ͨ��&nbsp;&nbsp;<input name="CD_Passed" class="radio" type="radio" id="support[ModifyPassed][level][0]" value="1" disabled>&nbsp;�ܾ�</td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyClass" value="yes" id="support[ModifyClass][is_able]" onclick="switchSupport('ModifyClass', this.checked)" /></td>
<td id="supportTribe10"><label for="support[ModifyClass][is_able]">������Ŀ��</label></td>
<td><select name="CD_Class" id="support[ModifyClass][soldier][0]" disabled>
<option value="0" selected>ѡ����Ŀ</option>
<?php
$sqlclass="select * from ".tname('class')." where CD_FatherID=1 and CD_SystemID=1";
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".$row3['CD_Name']."</option>";
}
}
?>
</select></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifySpecial" value="yes" id="support[ModifySpecial][is_able]" onclick="switchSupport('ModifySpecial', this.checked)" /></td>
<td id="supportTribe11"><label for="support[ModifySpecial][is_able]">����ר����</label></td>
<td><select name="CD_Special" id="support[ModifySpecial][soldier][0]" disabled>
<option value="0" selected>��ѡ��</option>
<?php
$sqlclass="select CD_ID,CD_Name from ".tname('special');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['CD_ID']."\">".getlen("len","10",$row3['CD_Name'])."</option>";
}
}
?>
</select></td><td><a href="javascript:void(0)" onclick="pop.up('ѡ��ר��', '?iframe=special&so=myform.CD_Special', '500px', '400px', '40px');" class="addtr">ѡ��</a></td></tr>

<tr><td><input class="checkbox" type="checkbox" name="ModifyDeleted" value="yes" id="support[ModifyDeleted][is_able]" onclick="switchSupport('ModifyDeleted', this.checked)" /></td>
<td id="supportTribe12"><label for="support[ModifyDeleted][is_able]">ɾ�����֣�</label></td>
<td><select name="CD_Deleted" id="support[ModifyDeleted][soldier][0]" disabled>
<option value="0" selected>�������վ</option>
<option value="1">�ӻ���վ�ָ�</option>
<option value="2">����ɾ��</option>
</select></td></tr>
</table>
</td>
</tr>
</table>
</form>
</div>
</div>

<?php
}
function Edit(){
	global $db;
	if(!submitcheck('music')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
	$qianwei_in_CD_ID = SafeRequest("CD_ID","post");
	$qianwei_in_ClassID = RequestBox("CD_ClassID");
	$qianwei_in_ServerID = RequestBox("CD_ServerID");
	$qianwei_in_BatchType = SafeRequest("BatchType","post");
	$qianwei_in_Hits = SafeRequest("CD_Hits","post");
	$qianwei_in_User = SafeRequest("CD_User","post");
	$qianwei_in_SingerID = SafeRequest("CD_Singer","post");
	$qianwei_in_Color = SafeRequest("CD_Color","post");
	$qianwei_in_Grade = SafeRequest("CD_Grade","post");
	$qianwei_in_Points = SafeRequest("CD_Points","post");
	$qianwei_in_Server = SafeRequest("CD_Server","post");
	$qianwei_in_IsBest = SafeRequest("CD_IsBest","post");
	$qianwei_in_Skin = SafeRequest("CD_Skin","post");
	$qianwei_in_Passed = SafeRequest("CD_Passed","post");
	$qianwei_in_Class = SafeRequest("CD_Class","post");
	$qianwei_in_SpecialID = SafeRequest("CD_Special","post");
	$qianwei_in_Deleted = SafeRequest("CD_Deleted","post");
	$qianwei_in_ModifyHits = SafeRequest("ModifyHits","post");
	$qianwei_in_ModifyUser = SafeRequest("ModifyUser","post");
	$qianwei_in_ModifySinger = SafeRequest("ModifySinger","post");
	$qianwei_in_ModifyColor = SafeRequest("ModifyColor","post");
	$qianwei_in_ModifyGrade = SafeRequest("ModifyGrade","post");
	$qianwei_in_ModifyPoints = SafeRequest("ModifyPoints","post");
	$qianwei_in_ModifyServer = SafeRequest("ModifyServer","post");
	$qianwei_in_ModifyIsBest = SafeRequest("ModifyIsBest","post");
	$qianwei_in_ModifySkin = SafeRequest("ModifySkin","post");
	$qianwei_in_ModifyPassed = SafeRequest("ModifyPassed","post");
	$qianwei_in_ModifyClass = SafeRequest("ModifyClass","post");
	$qianwei_in_ModifySpecial = SafeRequest("ModifySpecial","post");
	$qianwei_in_ModifyDeleted = SafeRequest("ModifyDeleted","post");
        if($qianwei_in_BatchType==1){
                $sqlbox="CD_ID in ($qianwei_in_CD_ID)";
        }elseif($qianwei_in_BatchType==2){
                $sqlbox="CD_Server in ($qianwei_in_ServerID)";
        }elseif($qianwei_in_BatchType==3){
                $sqlbox="CD_ClassID in ($qianwei_in_ClassID)";
        }
        //�������ؿ۳�����
        if($qianwei_in_ModifyPoints=="yes"){
                if($qianwei_in_Points==""){ShowMessage("�ύ�������ؿ۵㲻��Ϊ�գ�","?iframe=music","infotitle3",3000,1);}
                $db->query($sql="update ".tname('music')." set CD_Points=".$qianwei_in_Points." where ".$sqlbox);
        }

        //������������
        if($qianwei_in_ModifyHits=="yes"){
                if($qianwei_in_Hits==""){ShowMessage("�ύ����������������Ϊ�գ�","?iframe=music","infotitle3",3000,1);}
                $db->query($sql="update ".tname('music')." set CD_Hits=".$qianwei_in_Hits." where ".$sqlbox);
        }

        //������ӻ�Ա
        if($qianwei_in_ModifyUser=="yes"){
                if($qianwei_in_User==""){ShowMessage("�ύ����������Ա����Ϊ�գ�","?iframe=music","infotitle3",3000,1);}
		$sql="select cd_id,cd_nicheng from ".tname('user')." where cd_name='".$qianwei_in_User."'";
		$result=$db->query($sql);
		if($row=$db->fetch_array($result)){
			$db->query($sql="update ".tname('music')." set CD_UserID=".$row['cd_id'].",CD_User='".$qianwei_in_User."',CD_UserNicheng='".$row['cd_nicheng']."' where ".$sqlbox);
		}else{
			ShowMessage("�ύ����������Ա�����ڣ�","?iframe=music","infotitle3",3000,1);
		}
        }

        //������������
        if($qianwei_in_ModifySinger=="yes"){
                $db->query($sql="update ".tname('music')." set CD_SingerID=".$qianwei_in_SingerID." where ".$sqlbox);
        }

        //���±�����ɫ
        if($qianwei_in_ModifyColor=="yes"){
                $db->query($sql="update ".tname('music')." set CD_Color='".$qianwei_in_Color."' where ".$sqlbox);
        }

        //�������صȼ�
        if($qianwei_in_ModifyGrade=="yes"){
                $db->query($sql="update ".tname('music')." set CD_Grade=".$qianwei_in_Grade." where ".$sqlbox);
        }

        //���·�����
        if($qianwei_in_ModifyServer=="yes"){
                $db->query($sql="update ".tname('music')." set CD_Server=".$qianwei_in_Server." where ".$sqlbox);
        }

        //���������Ƽ�
        if($qianwei_in_ModifyIsBest=="yes"){
                $db->query($sql="update ".tname('music')." set CD_IsBest=".$qianwei_in_IsBest." where ".$sqlbox);
        }

        //���·��ģ��
        if($qianwei_in_ModifySkin=="yes"){
                if($qianwei_in_Skin==""){ShowMessage("�ύ��������ģ�岻��Ϊ�գ�","?iframe=music","infotitle3",3000,1);}
                $db->query($sql="update ".tname('music')." set CD_Skin='".$qianwei_in_Skin."' where ".$sqlbox);
        }

        //�������
        if($qianwei_in_ModifyPassed=="yes"){
		$result = $db->query("Select CD_ID,CD_Name,CD_UserID,CD_User from ".tname('music')." where ".$sqlbox);
		while ($row = $db ->fetch_array($result)){
			if($qianwei_in_Passed==0){
				$db->query("update ".tname('music')." set CD_Passed=0 where CD_ID=".$row['CD_ID']);
				$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuea.",cd_rank=cd_rank+".cd_pointsueb." where cd_id=".$row['CD_UserID']);
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
				$setarr = array(
					'cd_uid' => 0,
					'cd_uname' => 'ϵͳ��ʾ',
					'cd_uids' => $row['CD_UserID'],
					'cd_unames' => $row['CD_User'],
					'cd_icon' => 'dance',
					'cd_data' => '��ϲ�����ϴ������֡�'.$row['CD_Name'].'���Ѿ�ͨ����ˣ�',
					'cd_dataid' => $row['CD_ID'],
					'cd_state' => 1,
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('notice', $setarr, 1);
			}else{
				$db->query("update ".tname('music')." set CD_Deleted=1,CD_Passed=1 where CD_ID=".$row['CD_ID']);
				$setarr = array(
					'cd_uid' => 0,
					'cd_uname' => 'ϵͳ��ʾ',
					'cd_uids' => $row['CD_UserID'],
					'cd_unames' => $row['CD_User'],
					'cd_icon' => 'dance',
					'cd_data' => '��Ǹ�����ϴ������֡�'.$row['CD_Name'].'���򲻷��ϱ�վ��¼������δͨ����ˣ�',
					'cd_dataid' => $row['CD_ID'],
					'cd_state' => 1,
					'cd_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('notice', $setarr, 1);
			}
		}
        }

        //���·���
        if($qianwei_in_ModifyClass=="yes"){
                if($qianwei_in_Class==0){ShowMessage("�ύ����������Ŀ����Ϊ�գ�","?iframe=music","infotitle3",3000,1);}
                $db->query($sql="update ".tname('music')." set CD_ClassID=".$qianwei_in_Class." where ".$sqlbox);
        }

        //����ר��
        if($qianwei_in_ModifySpecial=="yes"){
                $db->query($sql="update ".tname('music')." set CD_SpecialID=".$qianwei_in_SpecialID." where ".$sqlbox);
        }

        //ɾ������
        if($qianwei_in_ModifyDeleted=="yes"){
                if($qianwei_in_Deleted==0){
                        $db->query($sql="update ".tname('music')." set CD_Deleted=1 where ".$sqlbox);
                }elseif($qianwei_in_Deleted==1){
                        $db->query($sql="update ".tname('music')." set CD_Deleted=0 where ".$sqlbox);
                }elseif($qianwei_in_Deleted==2){
                        $query = $db->query("select CD_ID,CD_Url,CD_Pic,CD_Lrc,CD_UserID,CD_User,CD_Passed from ".tname('music')." where ".$sqlbox);
                        while ($row = $db->fetch_array($query)) {
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
                        $db->query($sql="delete from ".tname('music')." where ".$sqlbox);
                }
        }
        ShowMessage("��ϲ���������������óɹ���","?iframe=music","infotitle2",2000,1);
}
?>