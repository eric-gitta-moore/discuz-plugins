<?php
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>ģ�嵥ҳ</title>
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
function CheckForm(){
	if(document.form.cd_name.value==""){
		asyncbox.tips("��ҳ���Ʋ���Ϊ�գ�����д��", "wait", 1000);
		document.form.cd_name.focus();
		return false;
        }
        else if(document.form.cd_type.value==""){
		asyncbox.tips("��ҳ���಻��Ϊ�գ�����д��", "wait", 1000);
		document.form.cd_type.focus();
		return false;
        }
        else if(document.form.cd_template.value==""){
		asyncbox.tips("��ҳģ�岻��Ϊ�գ�����д��", "wait", 1000);
		document.form.cd_template.focus();
		return false;
        }
        else {
		return true;
        }
}
function change(type){
	if (type==1){
		html.style.display='';
        }else{
		html.style.display='none';
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
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('page')." where cd_type like '%".$key."%' order by cd_id desc",20);
		break;
	default:
		main("select * from ".tname('page')." order by cd_id desc",30);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
	$cd_name = $Arr[0];
	$cd_type = $Arr[1];
	$cd_html = $Arr[2];
	$cd_url = $Arr[3];
	$cd_template = $Arr[4];
	if(!IsNul($cd_html)){$cd_html=0;}
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - ������ҳ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;������ҳ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������ҳ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - �༭��ҳ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;�༭��ҳ';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php echo $arrname; ?>��ҳ</h3><ul class="tab1">
<li><a href="?iframe=page"><span>ģ�嵥ҳ</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=page&action=add"><span>������ҳ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>��ҳ</th></tr>
<tr><td colspan="2" class="td27">��ҳ����:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_name; ?>" name="cd_name" id="cd_name"></td><td class="vtop tips2">�Զ���һ������</td></tr>
<tr><td colspan="2" class="td27">��ҳ����:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo $cd_type; ?>" id="cd_type" name="cd_type"></li>
<li><select onchange="cd_type.value=this.value;">
<option value=""><?php echo $arrname; ?>����</option>
<?php
global $db;
$sqlclass="select distinct (cd_type) from ".tname('page');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<option value=\"".$row3['cd_type']."\">".$row3['cd_type']."</option>";
}
}
?>
</select></li>
</ul>
</td><td class="vtop tips2">��û�з��࣬������һ��</td></tr>
<tr><td colspan="2" class="td27">��ҳ����:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if($cd_html==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_html" value="0" onclick="change(1);"<?php if($cd_html==0){echo " checked";} ?>>&nbsp;��̬</li>
<?php if($cd_html==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_html" value="1" onclick="change(2);"<?php if($cd_html==1){echo " checked";} ?>>&nbsp;��̬</li>
<?php if($cd_html==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_html" value="2" onclick="change(3);"<?php if($cd_html==2){echo " checked";} ?>>&nbsp;α��̬</li>
</ul>
</td><td class="vtop tips2">������ķ�������֧�� Rewrite����ѡ�񡰶�̬���򡰾�̬��</td></tr>
<tbody class="sub" id="html"<?php if($cd_html<>0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">��ҳ��ַ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_url; ?>" name="cd_url" id="cd_url"></td><td class="vtop tips2">���ɵ�ҳ�����·�����ļ���������Ϊ��̬</td></tr>
</tbody>
<tr><td colspan="2" class="td27">��ҳģ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $cd_template; ?>" name="cd_template" id="cd_template"></td><td class="vtop"><a href="javascript:void(0)" onclick="pop.up('ѡ��ģ��', '?iframe=template&f=form.cd_template', '500px', '400px', '40px');" class="addtr">ѡ��</a></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="hidden" name="cd_httpurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" /><input type="submit" name="form" class="btn" value="�ύ" onclick="return CheckForm();" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db,$action;
        $key=SafeRequest("key","get");
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - ģ�嵥ҳ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;ģ�嵥ҳ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=ģ�嵥ҳ&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ������ - ��ҳ����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='������&nbsp;&raquo;&nbsp;��ҳ����';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>ģ�嵥ҳ</h3><ul class="tab1">
<li class="current"><a href="?iframe=page"><span>ģ�嵥ҳ</span></a></li>
<li><a href="?iframe=page&action=add"><span>������ҳ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<div style="height:45px;line-height:45px;">
<a href="?iframe=page"><?php if($key==""){echo "<b>ȫ������</b>";}else{echo "ȫ������";} ?></a> | 
<?php
$sqlclass="select distinct (cd_type) from ".tname('page');
$results=$db->query($sqlclass);
if($results){
while ($row3=$db->fetch_array($results)){
echo "<a href=\"?iframe=page&action=keyword&key=".$row3['cd_type']."\">";
if($key==$row3['cd_type']){
echo "<b>".$row3['cd_type']."</b>";
} else {
echo $row3['cd_type'];
}
echo "</a> | ";
}
}
?>
</div>
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>��ҳ����</th>
<th>��ҳ��ַ</th>
<th>��ҳ����</th>
<th>��ҳ����</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û��ģ�嵥ҳ</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
?>
<tr class="hover">
<td><?php echo $row['cd_id']; ?></td>
<td><a href="?iframe=page&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act"><?php echo $row['cd_name']; ?></a></td>
<td><input type="button" class="btn" value="Ԥ��" onclick="window.open('<?php if($row['cd_html']==0){echo $row['cd_url'];}elseif($row['cd_html']==1){echo "index.php/page/".$row['cd_id']."/";}elseif($row['cd_html']==2){echo "page/".$row['cd_id']."/";} ?>')" /></td>
<td><a href="?iframe=page&action=keyword&key=<?php echo $row['cd_type']; ?>" class="act"><?php echo $row['cd_type']; ?></a></td>
<td><?php if($row['cd_html']==0){echo "��̬";}elseif($row['cd_html']==1){echo "��̬";}elseif($row['cd_html']==2){echo "α��̬";} ?></td>
<td><a href="?iframe=page&action=edit&cd_id=<?php echo $row['cd_id']; ?>" class="act">�༭</a><a href="?iframe=page&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
<?php echo $Arr[0]; ?>
</table>
</div>



<?php
}
	//ɾ��
	function Del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="delete from ".tname('page')." where cd_id=".$cd_id;
		if($db->query($sql)){
			ShowMessage("��ϲ����ģ�嵥ҳɾ���ɹ���",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//�༭
	function Edit(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select * from ".tname('page')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['cd_name'],$row['cd_type'],$row['cd_html'],$row['cd_url'],$row['cd_template']);
		}
		EditBoard($Arr,"?iframe=page&action=saveedit&cd_id=".$cd_id,"�༭");
	}

	//�������
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=page&action=saveadd","����");
	}

	//ִ�б���
	function SaveAdd(){
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_name = SafeRequest("cd_name","post");
		$cd_type = SafeRequest("cd_type","post");
		$cd_html = SafeRequest("cd_html","post");
		$cd_url = SafeRequest("cd_url","post");
		$cd_template = SafeRequest("cd_template","post");
		if($cd_html==0 && !IsNul($cd_url)){$cd_html=1;}
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_type' => $cd_type,
			'cd_html' => $cd_html,
			'cd_url' => $cd_url,
			'cd_template' => $cd_template
		);
		inserttable('page', $setarr, 1);
		ShowMessage("��ϲ����ģ�嵥ҳ�����ɹ���","?iframe=page","infotitle2",1000,1);
	}

	//����༭
	function SaveEdit(){
		if(!submitcheck('form')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = SafeRequest("cd_id","get");
		$cd_name = SafeRequest("cd_name","post");
		$cd_type = SafeRequest("cd_type","post");
		$cd_html = SafeRequest("cd_html","post");
		$cd_url = SafeRequest("cd_url","post");
		$cd_template = SafeRequest("cd_template","post");
		$cd_httpurl = SafeRequest("cd_httpurl","post");
		if($cd_html==0 && !IsNul($cd_url)){$cd_html=1;}
		$setarr = array(
			'cd_name' => $cd_name,
			'cd_type' => $cd_type,
			'cd_html' => $cd_html,
			'cd_url' => $cd_url,
			'cd_template' => $cd_template
		);
		updatetable('page', $setarr, array('cd_id'=>$cd_id));
		ShowMessage("��ϲ����ģ�嵥ҳ�༭�ɹ���",$cd_httpurl,"infotitle2",1000,1);
	}
?>