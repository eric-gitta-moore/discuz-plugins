<?php
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>���۹���</title>
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
		main("select * from ".tname('comment')." where cd_content like '%".$key."%' or cd_uname like '%".$key."%' order by cd_addtime desc",20);
		break;
	case 'blog':
		main("select * from ".tname('comment')." where cd_channel=0 order by cd_addtime desc",20);
		break;
	case 'pic':
		main("select * from ".tname('comment')." where cd_channel=1 order by cd_addtime desc",20);
		break;
	case 'song':
		main("select * from ".tname('comment')." where cd_channel=4 order by cd_addtime desc",20);
		break;
	default:
		main("select * from ".tname('comment')." order by cd_addtime desc",20);
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
<div class="container">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<?php if($action=="blog"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �������� - ˵˵����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;��������&nbsp;&raquo;&nbsp;˵˵����&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=˵˵����&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="pic"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �������� - ��Ƭ����';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;��������&nbsp;&raquo;&nbsp;��Ƭ����&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��Ƭ����&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<?php if($action=="song"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - �û����� - �������� - ��������';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='�û�����&nbsp;&raquo;&nbsp;��������&nbsp;&raquo;&nbsp;��������&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��������&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3><?php if($action=="blog"){echo "˵˵����";}else if($action=="pic"){echo "��Ƭ����";}else if($action=="song"){echo "��������";}else{echo "��������";} ?></h3><ul class="tab1">
<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=comment"><span>��������</span></a></li>
<?php if($action=="blog"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=comment&action=blog"><span>˵˵����</span></a></li>
<?php if($action=="pic"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=comment&action=pic"><span>��Ƭ����</span></a></li>
<?php if($action=="song"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=comment&action=song"><span>��������</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>�������������еı��鱻���ˣ��á�*����������ǡ����������������ݡ�������Ա�ȹؼ��ʽ�������</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="admin.php">
<tr><td>
<input type="hidden" name="iframe" value="comment">
<input type="hidden" name="action" value="keyword">
�ؼ��ʣ�<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="����" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=comment&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>���</th>
<th>����</th>
<th>��������</th>
<th>������Ա</th>
<th>����ʱ��</th>
<th>�༭����</th>
</tr>
<?php
if($videonum==0){
?>
<tr><td colspan="2" class="td27">û������</td></tr>
<?php
}
if($result){
while ($row = $db ->fetch_array($result)){
$cd_content = preg_replace('/\[em:(\d+)]/is', '*', $row['cd_content']);
$cd_content = getlen("len","25",$cd_content);
if($row['cd_channel']==0){
        $blog = $db->getrow("select cd_id,cd_uid from ".tname('blog')." where cd_id=".$row['cd_dataid']);
        $cd_url = cd_upath."index.php?p=space&a=miniblog&uid=".$blog['cd_uid']."&id=".$blog['cd_id'];
}elseif($row['cd_channel']==1){
        $pic = $db->getrow("select cd_id,cd_uid from ".tname('pic')." where cd_id=".$row['cd_dataid']);
        $cd_url = cd_upath."index.php?p=space&a=album&uid=".$pic['cd_uid']."&id=".$pic['cd_id'];
}elseif($row['cd_channel']==4){
        $music = $db->getrow("select CD_ID from ".tname('music')." where CD_ID=".$row['cd_dataid']);
        $cd_url = "index.php/song/".$music['CD_ID']."/";
}
?>
<tr class="hover">
<td class="td25"><input class="checkbox" type="checkbox" name="cd_id[]" id="cd_id" value="<?php echo $row['cd_id']; ?>"><?php echo $row['cd_id']; ?></td>
<td><?php if($row['cd_channel']==0){echo "˵˵";}else if($row['cd_channel']==1){echo "��Ƭ";}else if($row['cd_channel']==4){echo "����";} ?></td>
<td><a href="<?php echo $cd_url; ?>" target="_blank" class="act"><?php echo ReplaceStr($cd_content,SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="?iframe=comment&action=keyword&key=<?php echo $row['cd_uname']; ?>" class="act"><?php echo ReplaceStr($row['cd_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if(date("Y-m-d",strtotime($row['cd_addtime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['cd_addtime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['cd_addtime'])); } ?></td>
<td><a href="?iframe=comment&action=del&cd_id=<?php echo $row['cd_id']; ?>" class="act">ɾ��</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">ȫѡ</label> &nbsp;&nbsp; <input type="submit" name="alldel" class="btn" value="����ɾ��" onclick="{if(confirm('ȷ��Ҫɾ����ѡ����������')){this.document.form.submit();return true;}return false;}" /></td></tr>
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
			ShowMessage("����ɾ��ʧ�ܣ����ȹ�ѡҪɾ�������ۣ�","?iframe=comment","infotitle3",3000,1);
		}else{
			$query = $db->query("select * from ".tname('comment')." where cd_id in ($cd_id)");
        		while ($comment = $db->fetch_array($query)) {
				$db->query("delete from ".tname('comment')." where cd_id=".$comment['cd_id']);
				$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdda.",cd_rank=cd_rank-".cd_pointsddb." where cd_id=".$comment['cd_uid']);
				if($comment['cd_channel']==0){
					$db->query("update ".tname('blog')." set cd_commentnum=cd_commentnum-1 where cd_id=".$comment['cd_dataid']);
				}elseif($comment['cd_channel']==1){
					$db->query("update ".tname('pic')." set cd_replynum=cd_replynum-1 where cd_id=".$comment['cd_dataid']);
				}
				if(cd_pointsdda >= 1){
					$setarr = array(
						'cd_type' => 0,
						'cd_uid' => $comment['cd_uid'],
						'cd_uname' => $comment['cd_uname'],
						'cd_icon' => 'comment',
						'cd_title' => '���۱�ɾ��',
						'cd_points' => cd_pointsdda,
						'cd_state' => 0,
						'cd_addtime' => date('Y-m-d H:i:s'),
						'cd_endtime' => getendtime()
					);
					inserttable('bill', $setarr, 1);
				}
        		}
			ShowMessage("��ϲ������������ɾ���ɹ���","?iframe=comment","infotitle2",3000,1);
		}
	}

	//ɾ��
	function del(){
		global $db;
		$cd_id=SafeRequest("cd_id","get");
		$row=$db->getrow("select * from ".tname('comment')." where cd_id=".$cd_id);
		if($row){
			$db->query("delete from ".tname('comment')." where cd_id=".$row['cd_id']);
			$db->query("update ".tname('user')." set cd_points=cd_points-".cd_pointsdda.",cd_rank=cd_rank-".cd_pointsddb." where cd_id=".$row['cd_uid']);
			if($row['cd_channel']==0){
				$db->query("update ".tname('blog')." set cd_commentnum=cd_commentnum-1 where cd_id=".$row['cd_dataid']);
			}elseif($row['cd_channel']==1){
				$db->query("update ".tname('pic')." set cd_replynum=cd_replynum-1 where cd_id=".$row['cd_dataid']);
			}
			if(cd_pointsdda >= 1){
				$setarr = array(
					'cd_type' => 0,
					'cd_uid' => $row['cd_uid'],
					'cd_uname' => $row['cd_uname'],
					'cd_icon' => 'comment',
					'cd_title' => '���۱�ɾ��',
					'cd_points' => cd_pointsdda,
					'cd_state' => 0,
					'cd_addtime' => date('Y-m-d H:i:s'),
					'cd_endtime' => getendtime()
				);
				inserttable('bill', $setarr, 1);
			}
			ShowMessage("��ϲ��������ɾ���ɹ���","?iframe=comment","infotitle2",1000,1);
		}
	}
?>