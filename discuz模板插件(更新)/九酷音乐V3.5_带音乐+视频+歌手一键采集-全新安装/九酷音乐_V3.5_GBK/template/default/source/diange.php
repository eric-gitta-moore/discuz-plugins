<?php
global $db;
$id=SafeRequest("id","get");
$sql="select CD_ID,CD_Name,CD_ClassID from ".tname('music')." where CD_ID=".$id;
if($row=$db->getrow($sql)){
include_once "source/plugin/mail/mail.php";
$smtp = cd_webmailsmtp;
$youremail = cd_webmail;
$password = cd_webmailpswd;
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = $smtp;
$mail->Username = $youremail;
$mail->Password = $password;
$mail->From = $youremail;
$mail->FromName = cd_webname;
if(isset($_POST['submit'])=='1'){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$friend = $_POST['friend'];
	$message = $_POST['message'];
	$ip = getonlineip();
	$mail->Subject = $row['CD_Name']." - ���̨ - ".cd_webname;
	$time = date('Y-m-d H:i:s');
	$mail->AddAddress($email,$name);
	$html = '<table width="100%" cellspacing="0" cellpadding="20" border="0" class="i" style="width: 100%; background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial;"><tbody><tr><td align="center"><table width="580" cellspacing="0" bgcolor="#f6f6f6" cellpadding="0" style="table-layout: fixed;border:1px solid #c9c9c9;" _moz_resizing="true"><tbody><tr><td valign="top" align="left" style="font-size: 14px;line-height:1.8;padding:15px 25px;">�ˣ�<font color="#FF6969">'.$name.'</font>����ĺ�����<font color="#FF6969">'.$friend.'</font>('.$ip.')Ϊ������һ�ס�<font color="#FF6969">'.$row['CD_Name'].'</font>�����Ͻ��������ɣ�http://'.$_SERVER['HTTP_HOST'].LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'<br><strong>TA�������˵��</strong><font color="#009966">'.$message.'</font><br>'.$time.'</td></tr><tr><td height="15" bgcolor="#ebebeb" title="bottom_left"></td></tr></tbody></table></td></tr></tbody></table>';
	$mail->MsgHTML($html);
	$mail->IsHTML(true);
	if(!$mail->Send()) {
		echo '<script type="text/javascript">asyncbox.tips("���ʧ�ܣ������ԣ�", "error", 1000);window.setTimeout("document.location.reload(location.href)", 1500);</script>';
	} else {
		$db->query("update ".tname('music')." set CD_DianGeHits=CD_DianGeHits+1 where CD_ID=".$id);
		echo '<script type="text/javascript">asyncbox.tips("���ɹ����Ժ�Է����յ�һ�ݾ�ϲร�", "success", 1500);window.setTimeout("document.location.reload(location.href)", 2000);</script>';
	}
}
?>
<div class="box bgWrite mt">
 <div class="diange">
  <div class="diangeHd clearfix">
   <h1 class="diangeLogo"><img src="<?php echo $TempImg; ?>css/diange.png">���̨</h1>
   <div class="diangeNav">
    <ul class="step-nav clearfix">
     <li><span class="stepnum stepnum01"></span><span class="t-t">ѡ�����</span><span class="arrow"></span></li>
     <li class="current"><span class="stepnum stepnum02"></span><span class="t-t">��д�����Ϣ</span><span class="arrow"></span></li>
     <li><span class="stepnum stepnum03"></span><span class="t-t">�ύ�ɹ�</span></li>
    </ul>
   </div>
  </div>
  
<form action="" method="post" onsubmit="return ck()">
<div class="diangeBd step02 clearfix">
<div class="diangeFrom diange-form">
<ul>
<li class="form-item clearfix"><label class="label">���㲥�ĸ�����</label><input type="text" class="input readOnly" readonly="readonly" value="<?php echo $row['CD_Name']; ?>"></li>
<li class="form-item clearfix"><label class="label">Ta�����֣�</label><input type="text" class="input" name="name" id="name"><span class="tips">����</span></li>
<li class="form-item clearfix"><label class="label">Ta�����䣺</label><input type="text" class="input" name="email" id="email"><span class="tips">����</span></li>
<li class="form-item clearfix"><label class="label">��Ta˵�Ļ���</label><textarea autocomplete="off" class="textarea" name="message" id="message" cols="20" rows="2"></textarea><span class="tips textarea-words">�������<strong>100</strong>��</span><p class="seeOther"><span class="tips"><a href="javascript:void(0)" class="chooseText eye2">�������-ѡ���õ�ף����</a></span></p></li>
<li class="form-item clearfix"><label class="label">������֣�</label><input type="text" class="input" name="friend" id="friend" value="<?php echo $qianwei_in_username; ?>"><span class="tips">����</span></li>
</ul>
</div>
</div>
<div class="diangeBd step03 clearfix">
<div class="btn-group clearfix" style="margin:20px 0 0 320px;">
<input name="submit" type="hidden" value="1" />
<button type="submit" class="sDian1" style="cursor:pointer;">�ύ���</button>
<button type="button" class="sDian2" style="cursor:pointer;" onclick="window.open('<?php echo LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']); ?>')">Ԥ��</button>
</div>
</div>
</form>
<script type="text/javascript">
function ck(){
    var name=$.trim($("#name").val());
    var email=$.trim($("#email").val());
    var friend=$.trim($("#friend").val());
    var message=$.trim($("#message").val());
    if(name.length<1){
    	asyncbox.tips("Ta�����ֲ���Ϊ�գ�", "error", 1000);
    	$('#name').focus();
	return false;
    }else if(email.length<1){
    	asyncbox.tips("Ta�����䲻��Ϊ�գ�", "error", 1000);
    	$('#email').focus();
    	return false;
    }else if(email.length>0 && isEmail(email)==false){
	asyncbox.tips("Ta�������ʽ����", "error", 1000);
    	$('#email').focus();
    	return false;
    }else if(message.length<10){
    	asyncbox.tips("��Ta˵�Ļ�����10���֣�", "error", 1000);
    	$('#message').focus();
   	return false;
    }else if(message.length>100){
    	asyncbox.tips("�������100���֣�", "error", 1000);
   	$('#message').focus();
	return false;
    }else if(friend.length<1){
    	asyncbox.tips("������ֲ���Ϊ�գ�", "error", 1000);
    	$('#friend').focus();
    	return false;
    }else{
    	return true;
    }
}
</script>
 </div>
</div>
<?php }else{
echo "<div class=\"box bgWrite mt\"><div class=\"diange\">";
echo "<div class=\"diangeHd clearfix\"><div class=\"diangeNav\"><ul class=\"step-nav clearfix\"><li class=\"current\"><span class=\"t-t\">��Ϣ��ʾ</span></li></ul></div></div>";
echo "<div class=\"diangeFrom diange-form\"><div class=\"notice\"><div class=\"error\">���ݲ����ڻ��ѱ�ɾ����</div></div></div>";
echo "<div class=\"diangeBd step03 clearfix\"><div class=\"btn-group clearfix\" style=\"margin:20px 0 0 320px;\">";
echo "<a href=\"javascript:history.go(-1);\" class=\"sDian1\">������һҳ</a>";
echo "<a href=\"".cd_webpath."\" class=\"sDian2\">������ҳ</a>";
echo "</div></div></div></div>";
} ?>