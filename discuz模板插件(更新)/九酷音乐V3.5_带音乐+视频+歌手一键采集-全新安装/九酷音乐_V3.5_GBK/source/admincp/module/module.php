<?php
Administrator(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>����Ӧ��</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<?php
$action=SafeRequest("ac","get");
if($action=="uninst"){del_plugin($_GET['id'],$_GET['dir']);}elseif($action=="status"){cut_plugin($_GET['id'],$_GET['is']);}
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ��ƽ̨';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='��ƽ̨';</script>
<div class="floattop"><div class="itemtitle"><h3>����Ӧ��</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">������ʾ</th></tr>
<tr><td class="tipsblock"><ul>
<li>��ͼƬ����Ϊ��preview.jpg�������ڲ��Ŀ¼�£�����Զ�ȡ����</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">Ӧ���б�</th></tr>
<?php
global $db;
$query = $db->query("select * from ".tname('plugin')." order by CD_AddTime desc");
$plugincount=$db->num_rows($query);
if($plugincount==0){
        echo "<tr><td colspan=\"2\" class=\"td27\">����Ӧ��</td></tr>";
}else{
        while ($row = $db->fetch_array($query)) {
                if($row['CD_IsIndex']==1){
                        $CD_IsIndex="<img src=\"static/admincp/images/ishide_yes.gif\" style=\"cursor:pointer\" onclick=\"location.href='?iframe=module&ac=status&id=".$row['CD_ID']."&is=0';\" title=\"ǰ̨����\" />";
                }else{
                        $CD_IsIndex="<img src=\"static/admincp/images/ishide_no.gif\" style=\"cursor:pointer\" onclick=\"location.href='?iframe=module&ac=status&id=".$row['CD_ID']."&is=1';\" title=\"ǰ̨��ʾ\" />";
                }
                echo "<tr class=\"hover hover\">";
                echo "<td valign=\"top\" style=\"width:45px\"><img src=\"source/plugin/".$row['CD_Dir']."/preview.jpg\" onerror=\"this.src='static/admincp/images/stylepreview.gif'\" style=\"cursor:pointer\" onclick=\"location.href='plugin.php?open=".$row['CD_Dir']."&opens=".$row['CD_File']."';\" width=\"40\" height=\"40\" align=\"left\" /></td>";
                echo "<td class=\"light\" valign=\"top\" style=\"width:200px\">".$row['CD_Name']."<br /><span class=\"sml\">".$row['CD_Dir']."</span><br /></td>";
                echo "<td valign=\"bottom\"><span class=\"light\">����: ".$row['CD_Author']."</span><div class=\"psetting\"><a href=\"http://".$row['CD_Address']."\" target=\"_blank\">�鿴</a></div></td>";
                echo "<td align=\"right\" valign=\"bottom\" style=\"width:160px\">"; if(date("Y-m-d",strtotime($row['CD_AddTime']))==date('Y-m-d')){ echo "<em class=\"lightnum\">".date("Y-m-d",strtotime($row['CD_AddTime']))."</em>"; }else{ echo date("Y-m-d",strtotime($row['CD_AddTime'])); } echo "<br /><br />".$CD_IsIndex."&nbsp;&nbsp;<a href=\"?iframe=module&ac=uninst&id=".$row['CD_ID']."&dir=".$row['CD_Dir']."\" onclick=\"return confirm('ɾ��Ӧ�ý�ͬʱ�Ƴ���Ӧ���µ������ļ���ȷ��ɾ����');\">ɾ��</a>&nbsp;&nbsp;</td>";
                echo "</tr>";
        }
}
?>
<tr><td colspan="15"><div class="fixsel"><a href="http://www.qianwe.com/?P=<?php echo base64_encode($_SERVER['HTTP_HOST']); ?>&V=<?php echo base64_encode(cd_version); ?>&C=<?php echo base64_encode(cd_charset); ?>&N=<?php echo base64_encode(cd_webname); ?>&R=<?php echo base64_encode(cd_webpath); ?>">��ȡ������</a></div></td></tr>
</table>
</div>
</body>
</html>
<?php
function del_plugin($id,$dir){
	destroyDir('source/plugin/'.$dir.'/');
	global $db;
	$sql="delete from ".tname('plugin')." where CD_ID=".$id;
	if($db->query($sql)){
		echo "<script type=\"text/javascript\">parent.$('menu_app').innerHTML='".Menu_App()."';</script>";
		ShowMessage("��ϲ����Ӧ��ɾ���ɹ���","?iframe=module","infotitle2",3000,1);
	}
}
function cut_plugin($id,$is){
	global $db;
	$sql="update ".tname('plugin')." set CD_IsIndex=".$is." where CD_ID=".$id;
	if($db->query($sql)){
		ShowMessage("��ϲ����״̬�л��ɹ���","?iframe=module","infotitle2",1000,1);
	}
}
?>