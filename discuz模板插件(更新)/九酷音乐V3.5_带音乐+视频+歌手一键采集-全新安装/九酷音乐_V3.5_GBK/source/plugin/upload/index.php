<?php
close_browse(html_message("������Ϣ","���ʷ�ʽ����"));
if($_GET['to']=="admin"){
        if(empty($_COOKIE['CD_AdminID']) || empty($_COOKIE['CD_Login']) || $_COOKIE['CD_Login']!==md5($_COOKIE['CD_AdminID'].$_COOKIE['CD_AdminUserName'].$_COOKIE['CD_AdminPassWord'].$_COOKIE['CD_Permission'])){exit(iframe_message("δ��¼���¼�ѹ��ڣ������µ�¼�������ģ�"));}
        $uid=0;
        $uname="ϵͳ�û�";
}elseif($_GET['to']=="user"){
        global $userlogined,$qianwei_in_userid,$qianwei_in_username;
        if(!$userlogined){exit(iframe_message("��δ��¼û���ϴ�Ȩ�ޣ����ȵ�¼��վ��"));}elseif(cd_uptype==0){exit(iframe_message("��Ǹ���ϴ������ѹرգ�"));}
        $uid=$qianwei_in_userid;
        $uname=$qianwei_in_username;
}
$randdir=rand(2,pow(2,24));
$randnum=date('YmdHis',time());
switch($_GET['ac']){
	case 'song':
		$targetFiles="data/attachment/song/".$randdir;
		$fileexts=cd_upmext;
		$filesizes=cd_upsize;
		break;
	case 'video':
		$targetFiles="data/attachment/video/".$randdir;
		$fileexts=cd_upvext;
		$filesizes=cd_upsize;
		break;
	case 'lrc':
		$targetFiles="data/attachment/lrc/".$randdir;
		$fileexts="*.lrc";
		$filesizes="1";
		break;
	case 'pic':
		$targetFiles="data/attachment/pic/".$randdir;
		$fileexts="*.jpg;*.jpeg;*.gif;*.png";
		$filesizes="2";
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����ϴ�</title>
<link href="source/plugin/upload/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/upload/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="source/plugin/upload/swfobject.js"></script>
<script type="text/javascript" src="source/plugin/upload/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader' : 'source/plugin/upload/uploadify.swf',
		'script' : 'source/plugin/upload/uploads.php',
		'cancelImg' : 'source/plugin/upload/cancel.png',
		'folder' : 'UploadFile',
		'method' : 'GET',
		'scriptData' : {'is':'<?php echo $randdir; ?>','id':'<?php echo $randnum; ?>','to':'<?php echo $_GET['to']; ?>','ac':'<?php echo $_GET['ac']; ?>','uid':'<?php echo $uid; ?>','uname':'<?php echo base64_encode($uname); ?>'},
		'buttonText' : 'Upload',
		'buttonImg' : 'source/plugin/upload/up.png',
		'width' : '110',
		'height' : '30',
		'queueID' : 'fileQueue',
		'auto' : true,
		'multi' : false,
		'fileExt' : '<?php echo $fileexts; ?>',
		'fileDesc' : '��ѡ��<?php echo $fileexts; ?>�ļ�',
		'sizeLimit' : <?php echo ($filesizes*1024*1024); ?>,
		'onError' : function (a, b, c, d) {
			if (d.status == 404){
				ReturnError("�ϴ����������ԣ�");
			}else if (d.type === "HTTP"){
				ReturnError("error "+d.type+" : "+d.status);
			}else if (d.type === "File Size"){
				ReturnError("�ϴ�ʧ�ܣ���С���ܳ���<?php echo $filesizes; ?>MB��");
			}else{
				ReturnError("error "+d.type+" : "+d.text);
			}
		},
		'onComplete' : function (event, queueID, fileObj, response, data) {
			if (response == 1){
				ReturnError("�ϴ�ʧ�ܣ����ʲ��ܵ���<?php echo cd_upkbps; ?>kbps��");
			}else if (response == 2){
				ReturnError("�޷����� COM ��������ں�̨�ر����ʼ�⣡");
			}else if (response == 0){
				<?php if($_GET['ac']=="pic"){ ?>
				ReturnValue('<?php echo $targetFiles."/".$randnum; ?>'+fileObj.type);
				<?php }else{ ?>
				ReturnValue('<?php echo $targetFiles."/".$randnum; ?>'+fileObj.type+'.jpg');
				<?php } ?>
			}else{
				ReturnError(response);
			}
		}
	});
});
</script>
<script type="text/javascript">
function ReturnValue(reimg){
	this.parent.document.<?php echo $_GET['f']; ?>.value=reimg;
	<?php if($_GET['to']=="admin" && $_GET['ac']=="song"){ ?>
	this.parent.document.<?php echo $_GET['d']; ?>.value=reimg;
	this.parent.asyncbox.tips("��ϲ����Ƶ�ϴ��ɹ���", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="song"){ ?>
	this.parent.$.tipMessage('��ϲ����Ƶ�ϴ��ɹ���', 0, 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="video"){ ?>
	this.parent.asyncbox.tips("��ϲ����Ƶ�ϴ��ɹ���", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="video"){ ?>
	this.parent.$.tipMessage('��ϲ����Ƶ�ϴ��ɹ���', 0, 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="lrc"){ ?>
	this.parent.asyncbox.tips("��ϲ������ϴ��ɹ���", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="lrc"){ ?>
	this.parent.$.tipMessage('��ϲ������ϴ��ɹ���', 0, 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="pic"){ ?>
	this.parent.asyncbox.tips("��ϲ��ͼƬ�ϴ��ɹ���", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="pic"){ ?>
	this.parent.$.tipMessage('��ϲ��ͼƬ�ϴ��ɹ���', 0, 3000);
	<?php } ?>
	this.parent.layer.closeAll();
}
function ReturnError(msg){
	<?php if($_GET['to']=="admin"){ ?>
	this.parent.asyncbox.tips(msg, "error", 3000);
	<?php }elseif($_GET['to']=="user"){ ?>
	this.parent.$.tipMessage(msg, 2, 3000);
	<?php } ?>
	this.parent.layer.closeAll();
}
</script>
</head>
<body>
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
</body>
</html>