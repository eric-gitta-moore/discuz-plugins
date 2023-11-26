<?php
Administrator(1);
$serverip = GetHostByName($_SERVER['SERVER_NAME']);
$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
$serversoft = $_SERVER['SERVER_SOFTWARE'];
$servermysql = @mysql_get_server_info();
$diskspace = function_exists('disk_free_space') ? floor(disk_free_space(_qianwei_root_) / (1024*1024)).'M' : '<font color="red">unknow</font>';
$attachmentupload = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">unknow</font>';
$check_file_get_contents = (function_exists('file_get_contents') ? '<font color="green">[��]</font>' : '<font color="red">[��]</font>');
$check_allow_url_fopen = (ini_get('allow_url_fopen') ? '<font color="green">[��]</font>' : '<font color="red">[��]</font>');
$check_curl_init = (function_exists('curl_init') ? '<font color="green">[��]</font>' : '<font color="red">[��]</font>');
global $db;
$user=$db->num_rows($db->query("select * from ".tname('user')));
$Checkmm=$db->num_rows($db->query("select * from ".tname('user')." where cd_checkmm=2"));
$music=$db->num_rows($db->query("select * from ".tname('music')." where CD_Deleted=0"));
$Passed_m=$db->num_rows($db->query("select * from ".tname('music')." where CD_Passed=1 and CD_Deleted=0"));
$Error=$db->num_rows($db->query("select * from ".tname('music')." where CD_Error<>0 and CD_Deleted=0"));
$Deleted=$db->num_rows($db->query("select * from ".tname('music')." where CD_Deleted=1"));
$special=$db->num_rows($db->query("select * from ".tname('special')));
$Passed_s=$db->num_rows($db->query("select * from ".tname('special')." where CD_Passed=1"));
$singer=$db->num_rows($db->query("select * from ".tname('singer')));
$Passed_g=$db->num_rows($db->query("select * from ".tname('singer')." where CD_Passed=1"));
$video=$db->num_rows($db->query("select * from ".tname('video')));
$Passed_v=$db->num_rows($db->query("select * from ".tname('video')." where CD_IsIndex=1"));
$comment=$db->num_rows($db->query("select * from ".tname('comment')));
$wall=$db->num_rows($db->query("select * from ".tname('wall')));
$blog=$db->num_rows($db->query("select * from ".tname('blog')));
$pic=$db->num_rows($db->query("select * from ".tname('pic')));
if(isset($_POST['submit'])=='1'){
	$content=SafeRequest("content","post");
	if(!IsNul($content)){ShowMessage("����ʧ�ܣ��������������ݣ�","?iframe=body","infotitle3",3000,0);}
	$query = $db->query("select cd_id,cd_name from ".tname('user')." where cd_lock=0");
	while ($row = $db->fetch_array($query)) {
		$setarr = array(
			'cd_uid' => 0,
			'cd_uname' => 'ϵͳ��ʾ',
			'cd_uids' => $row['cd_id'],
			'cd_unames' => $row['cd_name'],
			'cd_icon' => 'wall',
			'cd_data' => $content,
			'cd_dataid' => 0,
			'cd_state' => 1,
			'cd_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('notice', $setarr, 1);
	}
	ShowMessage("��ϲ�����������Ѿ����͸������û���","?iframe=body","infotitle2",3000,0);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>��ҳ</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<div class="container"><script type="text/javascript">parent.document.title = 'QianWei Music Board �������� - ��ҳ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='��ҳ';</script><div class="itemtitle"><h3>QianWei Music Board ��������</h3></div>
<table class="tb tb2 fixpadding">
<form method="post">
<tr><th colspan="3" class="partition">�û�����</th></tr>
<tr><td><input type="text" name="content" class="txt" style="width:300px;"><input name="submit" type="hidden" value="1"><input value="����" type="submit" class="btn"></td></tr>
</form>
</table>
<?php if($Passed_v>0 || $Passed_g>0 || $Passed_s>0 || $Passed_m>0 || $Error>0 || $Deleted>0 || $Checkmm>0){ ?>
<table class="tb tb2 nobdb fixpadding">
<tr><td><h3 class="left margintop">����������:</h3>
<?php if($Passed_v>0){ ?>
<p class="left difflink"><a href="?iframe=video&action=isindex">������Ƶ</a>(<em class="lightnum"><?php echo $Passed_v; ?></em>)</p>
<?php }if($Passed_g>0){ ?>
<p class="left difflink"><a href="?iframe=singer&action=pass">�������</a>(<em class="lightnum"><?php echo $Passed_g; ?></em>)</p>
<?php }if($Passed_s>0){ ?>
<p class="left difflink"><a href="?iframe=album&action=pass">����ר��</a>(<em class="lightnum"><?php echo $Passed_s; ?></em>)</p>
<?php }if($Passed_m>0){ ?>
<p class="left difflink"><a href="?iframe=song&action=pass">��������</a>(<em class="lightnum"><?php echo $Passed_m; ?></em>)</p>
<?php }if($Error>0){ ?>
<p class="left difflink"><a href="?iframe=song&action=error">��������</a>(<em class="lightnum"><?php echo $Error; ?></em>)</p>
<?php }if($Deleted>0){ ?>
<p class="left difflink"><a href="?iframe=song&action=deleted">����վ</a>(<em class="lightnum"><?php echo $Deleted; ?></em>)</p>
<?php }if($Checkmm>0){ ?>
<p class="left difflink"><a href="?iframe=user&action=verifiedmm">������Ů</a>(<em class="lightnum"><?php echo $Checkmm; ?></em>)</p>
<?php } ?>
<div class="clear"></div></td></tr>
</table>
<?php } ?>
<table class="tb tb2 nobdb fixpadding">
<tr><th colspan="15" class="partition">����ͳ��</th></tr>
<tr>
<td><a href="?iframe=user">�û�</a>(<em class="lightnum"><?php echo $user; ?></em>)</td>
<td><a href="?iframe=song">����</a>(<em class="lightnum"><?php echo $music; ?></em>)</td>
<td><a href="?iframe=album">ר��</a>(<em class="lightnum"><?php echo $special; ?></em>)</td>
<td><a href="?iframe=singer">����</a>(<em class="lightnum"><?php echo $singer; ?></em>)</td>
<td><a href="?iframe=video">��Ƶ</a>(<em class="lightnum"><?php echo $video; ?></em>)</td>
<td><a href="?iframe=comment">����</a>(<em class="lightnum"><?php echo $comment; ?></em>)</td>
<td><a href="?iframe=wall">����</a>(<em class="lightnum"><?php echo $wall; ?></em>)</td>
<td><a href="?iframe=blog">˵˵</a>(<em class="lightnum"><?php echo $blog; ?></em>)</td>
<td><a href="?iframe=pic">��Ƭ</a>(<em class="lightnum"><?php echo $pic; ?></em>)</td>
</tr>
</table>
<table class="tb tb2 fixpadding">
<tr><th colspan="15" class="partition">ϵͳ��Ϣ</th></tr>
<tr><td class="vtop td24 lineheight">����汾</td><td class="lineheight smallfont">QianWei Music <?php echo cd_version; ?> ��������<?php echo cd_charset; ?> <?php echo cd_build; ?></td></tr>
<tr><td class="vtop td24 lineheight">������IP��ַ</td><td class="lineheight smallfont"><?php echo $serverip; ?></td></tr>
<tr><td class="vtop td24 lineheight">������ϵͳ�� PHP</td><td class="lineheight smallfont"><?php echo $serverinfo; ?></td></tr>
<tr><td class="vtop td24 lineheight">���������</td><td class="lineheight smallfont"><?php echo $serversoft; ?></td></tr>
<tr><td class="vtop td24 lineheight">������ MySQL �汾</td><td class="lineheight smallfont"><?php echo $servermysql; ?></td></tr>
<tr><td class="vtop td24 lineheight">���̿ռ�</td><td class="lineheight smallfont"><?php echo $diskspace; ?></td></tr>
<tr><td class="vtop td24 lineheight">�����ϴ�</td><td class="lineheight smallfont"><?php echo $attachmentupload; ?></td></tr>
<tr><td class="vtop td24 lineheight">file_get_contents()</td><td class="lineheight smallfont"><?php echo $check_file_get_contents; ?></td></tr>
<tr><td class="vtop td24 lineheight">allow_url_fopen</td><td class="lineheight smallfont"><?php echo $check_allow_url_fopen; ?></td></tr>
<tr><td class="vtop td24 lineheight">curl_init()</td><td class="lineheight smallfont"><?php echo $check_curl_init; ?></td></tr>
</table>
<table class="tb tb2 fixpadding">
<tr><th colspan="15" class="partition">�����Ŷ�</th></tr>
<tr><td class="vtop td24 lineheight">��Ȩ����</td><td><span class="bold"><a href="http://www.qianwe.com" class="lightlink2" target="_blank">ǰ������</a></span></td></tr>
<tr><td class="vtop td24 lineheight">�Ŷӳ�Ա</td><td class="lineheight smallfont team"><a href="http://wpa.qq.com/msgrd?v=3&uin=2245000500&site=ǰ������&menu=yes" target="_blank" class="lightlink2 smallfont">ǰ��</a></td></tr>
<tr><td class="vtop td24 lineheight">�ٷ�΢��</td><td class="lineheight"><a href="http://weibo.com/2604641951" target="_blank" class="lightlink2 smallfont">����΢��</a>, <a href="http://t.qq.com/jk2245000500" target="_blank" class="lightlink2 smallfont">��Ѷ΢��</a></td></tr>
<tr><td class="vtop td24 lineheight">��������</td><td class="lineheight"><a href="mailto:web@qianwe.com" class="lightlink2 smallfont">web@qianwe.com</a>, <a href="mailto:pay@qianwe.com" class="lightlink2 smallfont">pay@qianwe.com</a></td></tr>
<tr><td class="vtop td24 lineheight">��������</td><td class="lineheight"><a href="http://www.qianwe.com/" class="lightlink2" target="_blank">www.qianwe.com</a>, <a href="http://www.qianwe.net/" class="lightlink2" target="_blank">www.qianwe.net</a>, <a href="http://www.qianwe.cn/" class="lightlink2" target="_blank">www.qianwe.cn</a>, <a href="http://www.qianwei.in/" class="lightlink2" target="_blank">www.qianwei.in</a></td></tr>
</table>
</div>
</body>
</html>