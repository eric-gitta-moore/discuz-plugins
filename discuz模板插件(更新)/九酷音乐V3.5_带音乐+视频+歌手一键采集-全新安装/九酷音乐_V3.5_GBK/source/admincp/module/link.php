<?php
Administrator(8);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>��������</title>
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
function exchange_type(theForm){
	if (theForm.cd_classid.value =='2'){
		document.form1.cd_pic.focus();
		return false;
	}
}
function CheckForm(){
        if(document.form1.cd_name.value==""){
            asyncbox.tips("վ�����Ʋ���Ϊ�գ�����д��", "wait", 1000);
            document.form1.cd_name.focus();
            return false;
        }
        else if(document.form1.cd_url.value==""){
            asyncbox.tips("���ӵ�ַ����Ϊ�գ�����д��", "wait", 1000);
            document.form1.cd_url.focus();
            return false;
        }
        else {
            return true;
        }
}
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
	case 'editisindex':
		editisindex();
		break;
	case 'alleditsave':
		alleditsave();
		break;
	default:
		main("select * from ".tname('link')." order by cd_theorder asc",30);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
	$cd_name = $Arr[0];
	$cd_url = $Arr[1];
	$cd_pic = $Arr[2];
	$cd_classid = $Arr[3];
	$cd_isindex = $Arr[4];
	$cd_input = $Arr[5];
	if(!IsNul($cd_classid)){$cd_classid=1;}
	if(!IsNul($cd_isindex)){$cd_isindex=0;}
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ϵͳ - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ϵͳ - �༭����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;�༭����';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>����</h3><ul class="tab1">
<li><a href="?iframe=link"><span>��������</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=link&action=add"><span>��������</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form1">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>����</th></tr>
<tr><td colspan="2" class="td27">վ������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_name; ?>" name="cd_name" id="cd_name"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">���ӵ�ַ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_url; ?>" name="cd_url" id="cd_url"></td><td class="vtop tips2">�����ԡ�http://����ͷ</td></tr>
<tr><td colspan="2" class="td27">��������:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_classid" id="cd_classid" onchange="exchange_type(form1)" class="ps">
<option value="1"<?php if($cd_classid==1){echo " selected";} ?>>����</option>
<option value="2"<?php if($cd_classid==2){echo " selected";} ?>>ͼƬ</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">����ͼƬ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_pic; ?>" name="cd_pic" id="cd_pic"></td><td class="vtop"><a href="javascript:void(0)" onclick="pop.up('�ϴ�ͼƬ', 'plugin.php?open=upload&opens=index&to=admin&ac=pic&f=form1.cd_pic', '406px', '180px', '100px');" class="addtr">�����ϴ�</a></td></tr>
<tr><td colspan="2" class="td27">����״̬:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="cd_isindex" class="ps">
<option value="0"<?php if($cd_isindex==0){echo " selected";} ?>>��ʾ</option>
<option value="1"<?php if($cd_isindex==1){echo " selected";} ?>>����</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2" class="td27">վ����:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea name="cd_input" id="cd_input" class="pt" rows="3" cols="40"><?php echo $cd_input; ?></textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="link" onclick="return CheckForm();" value="�ύ" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ϵͳ - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ϵͳ&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=��������&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>��������</h3><ul class="tab1">
<li class="current"><a href="?iframe=link"><span>��������</span></a></li>
<li><a href="?iframe=link&action=add"><span>��������</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<form name="form" method="post" action="?iframe=link&action=alleditsave">
<table class="tb tb2">
<tr><th class="partition">�����б�</th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>վ������</th>
<th>���ӵ�ַ</th>
<th>����</th>
<th>����</th>
<th>״̬</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û����������</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td><input type="text" class="txt" name="cd_name<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_name']; ?>"></td>
<td class="td26"><input type="text" class="txt" name="cd_url<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_url']; ?>"></td>
<td class="td28"><input type="text" class="txt" name="cd_theorder<?php echo $row['cd_id']; ?>" value="<?php echo $row['cd_theorder']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td><?php if($row['cd_classid']==1){echo "����";}else{echo "<em class=\"lightnum\">ͼƬ</em>";} ?></td>
<td><?php if($row['cd_isindex']==1){ ?><a href="?iframe=link&action=editisindex&cd_isindex=0&cd_id=<?php echo $row['cd_id']; ?>"><img src="static/admincp/images/ishide_no.gif" /></a><?php }else{ ?><a href="?iframe=link&action=editisindex&cd_isindex=1&cd_id=<?php echo $row['cd_id']; ?>"><img src="static/admincp/images/ishide_yes.gif" /></a><?php } ?></td>
<td><a href="?iframe=link&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">�༭</a><a href="?iframe=link&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="�ύ�޸�" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//ɾ��
	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('link')." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("��ϲ������������ɾ���ɹ���","?iframe=link","infotitle2",1000,1);
		}
	}

	//�༭
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('link')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_url'],$row['cd_pic'],$row['cd_classid'],$row['cd_isindex'],$row['cd_input']);
		}
		EditBoard($Arr,"?iframe=link&action=saveedit&cd_id=".$cd_id,"�༭");
	}

	//�������
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=link&action=saveadd","����");
	}

	//ִ�б���
	function SaveAdd(){
		global $db;
		if(!submitcheck('link')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_name = SafeRequest("cd_name","post");
		$cd_url = SafeRequest("cd_url","post");
		$cd_pic = SafeRequest("cd_pic","post");
		$cd_classid = SafeRequest("cd_classid","post");
		$cd_input = SafeRequest("cd_input","post");
		$cd_isindex = SafeRequest("cd_isindex","post");
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_url' => $cd_url,
			'cd_pic' => $cd_pic,
			'cd_classid' => $cd_classid,
			'cd_input' => $cd_input,
			'cd_isverify' => 0,
			'cd_isindex' => $cd_isindex,
			'cd_theorder' => 0
		);
		inserttable('link', $setarr, 1);
		ShowMessage("��ϲ�����������������ɹ���","?iframe=link","infotitle2",1000,1);
	}

	//����༭
	function SaveEdit(){
		global $db;
		if(!submitcheck('link')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = SafeRequest("cd_id","get");
		$cd_name = SafeRequest("cd_name","post");
		$cd_url = SafeRequest("cd_url","post");
		$cd_pic = SafeRequest("cd_pic","post");
		$cd_classid = SafeRequest("cd_classid","post");
		$cd_input = SafeRequest("cd_input","post");
		$cd_isindex = SafeRequest("cd_isindex","post");
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_url' => $cd_url,
			'cd_pic' => $cd_pic,
			'cd_classid' => $cd_classid,
			'cd_input' => $cd_input,
			'cd_isindex' => $cd_isindex
		);
		updatetable('link', $setarr, array('cd_id'=>$cd_id));
		ShowMessage("��ϲ�����������ӱ༭�ɹ���","?iframe=link","infotitle2",1000,1);
	}

	function editisindex(){
		global $db;
		$cd_id = SafeRequest("cd_id","get");
		$cd_isindex = SafeRequest("cd_isindex","get");
		$sql="update ".tname('link')." set cd_isindex=".$cd_isindex." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("��ϲ����״̬�л��ɹ���","?iframe=link","infotitle2",1000,1);
		}
	}

	function alleditsave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		if($cd_id==0){
			ShowMessage("�޸�ʧ�ܣ����ȹ�ѡҪ�༭���������ӣ�","?iframe=link","infotitle3",3000,1);
		}else{
			$ID=explode(",",$cd_id);
			for($i=0;$i<count($ID);$i++){
				$cd_name=SafeRequest("cd_name".$ID[$i],"post");
				$cd_url=SafeRequest("cd_url".$ID[$i],"post");
				$cd_theorder=SafeRequest("cd_theorder".$ID[$i],"post");
				if(!IsNul($cd_name)){ShowMessage("�޸ĳ���վ�����Ʋ���Ϊ�գ�","?iframe=link","infotitle3",1000,1);}
				if(!IsNul($cd_url)){ShowMessage("�޸ĳ������ӵ�ַ����Ϊ�գ�","?iframe=link","infotitle3",1000,1);}
				if(!IsNum($cd_theorder)){ShowMessage("�޸ĳ���������Ϊ�գ�","?iframe=link","infotitle3",1000,1);}
				$setarr = array(
					'cd_name' => $cd_name,
					'cd_url' => $cd_url,
					'cd_theorder' => $cd_theorder
				);
				updatetable('link', $setarr, array('cd_id'=>$ID[$i]));
			}
			ShowMessage("��ϲ�������������޸ĳɹ���","?iframe=link","infotitle2",1000,1);
		}
	}
?>