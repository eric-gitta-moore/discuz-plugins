<?php
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>˵˵����</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
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
	case 'del':
		del();
		break;
	case 'alldel':
		alldel();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('blog')." where cd_content like '%".$key."%' or cd_uname like '%".$key."%' order by cd_addtime desc",20);
		break;
	default:
		main("select * from ".tname('blog')." order by cd_addtime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$db->query($Arr[2]);
	$videonum=$db->num_rows($result);
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - �û����� - ����˵˵';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;����˵˵&nbsp;&nbsp;<a target="main" title="��ӵ����ò���" href="?iframe=menu&action=getadd&name=����˵˵&url=<?php echo $_SERVER['QUERY_STRING']; ?>">[+]</a>';</script>
<div class="floattop"><div class="itemtitle"><h3>����˵˵</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>����˵˵�����еı��鱻���ˣ��á�*����������ǡ���������˵˵���ݡ�������Ա�ȹؼ��ʽ�������</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="blog">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=blog&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>˵˵����</th>
<th>������Ա</th>
<th>����ʱ��</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û��˵˵</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
$cd_content = preg_replace('/\[em:(\d+)]/is', '*', $row['cd_content']);
$cd_content = getlen("len","25",$cd_content);
$cd_url = cd_upath."index.php?p=space&a=miniblog&uid=".$row['cd_uid']."&id=".$row['cd_id'];
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td><a href="<?php echo $cd_url; ?>" target="_blank" class="act"><?php echo ReplaceStr($cd_content,SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=blog&action=keyword&key=<?php echo $row['cd_uname']; ?>" class="act"><?php echo ReplaceStr($row['cd_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if(date("Y-m-d",$row['cd_addtime'])==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",$row['cd_addtime'])."</em>"; }else{ echo date("Y-m-d",$row['cd_addtime']); } ?></td>
<td><a href="?iframe=blog&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label> &nbsp;&nbsp; <input type="submit" name="alldel" class="btn" value="����ɾ��" onclick="{if(confirm('ȷ��Ҫɾ����ѡ����˵˵��')){this.document.form.submit();return true;}return false;}" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//����ɾ��
	function alldel(){
		global $db;
		if(!submitcheck('alldel')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
		$cd_id = RequestBox("cd_id");
		if($cd_id==0){
			ShowMessage("����ɾ��ʧ�ܣ����ȹ�ѡҪɾ����˵˵��","?iframe=blog","infotitle3",3000,1);
		}else{
			$query = $db->query("select cd_id,cd_uid,cd_uname from ".tname('blog')." where cd_id in($cd_id)");
			while ($row = $db->fetch_array($query)) {
				$db->query("delete from ".tname('blog')." where cd_id=".$row['cd_id']);
				$db->query("delete from ".tname('comment')." where cd_channel=0 and cd_dataid=".$row['cd_id']);
				$db->query("delete from ".tname('feed')." where cd_icon='miniblog' and cd_dataid=".$row['cd_id']);
				if(cd_pointsdaa >= 1){
					$setarr = array(
						'cd_type' => 0,
						'cd_uid' => $row['cd_uid'],
						'cd_uname' => $row['cd_uname'],
						'cd_icon' => 'miniblog',
						'cd_title' => '˵˵��ɾ��',
						'cd_points' => cd_pointsdaa,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdaa.",cd_rank=cd_rank-".cd_pointsdab." where cd_id=".$row['cd_uid']);
			}
			ShowMessage("��ϲ����˵˵����ɾ���ɹ���","?iframe=blog","infotitle2",3000,1);
		}
	}

	//ɾ��
	function del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$sql="select cd_id,cd_uid,cd_uname from ".tname('blog')." where cd_id=".$cd_id;
		if($row=$db->getrow($sql)){
			$db->query("delete from ".tname('blog')." where cd_id=".$row['cd_id']);
			$db->query("delete from ".tname('comment')." where cd_channel=0 and cd_dataid=".$row['cd_id']);
			$db->query("delete from ".tname('feed')." where cd_icon='miniblog' and cd_dataid=".$row['cd_id']);
			if(cd_pointsdaa >= 1){
				$setarr = array(
					'cd_type' => 0,
					'cd_uid' => $row['cd_uid'],
					'cd_uname' => $row['cd_uname'],
					'cd_icon' => 'miniblog',
					'cd_title' => '˵˵��ɾ��',
					'cd_points' => cd_pointsdaa,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdaa.",cd_rank=cd_rank-".cd_pointsdab." where cd_id=".$row['cd_uid']);
			ShowMessage("��ϲ����˵˵ɾ���ɹ���","?iframe=blog","infotitle2",1000,1);
		}
	}
?>