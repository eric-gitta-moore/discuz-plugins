<?php
$action=SafeRequest("ac","get");
switch($action){
	case 'song':
		$fileexts=cd_upext;
		break;
	case 'video':
		$fileexts="*.flv;*.f4v;*.mp4";
		break;
}
if(empty($_COOKIE['CD_AdminID']) || empty($_COOKIE['CD_Login']) || $_COOKIE['CD_Login']!==md5($_COOKIE['CD_AdminID'].$_COOKIE['CD_AdminUserName'].$_COOKIE['CD_AdminPassWord'].$_COOKIE['CD_Permission'])){exit(iframe_message("δ��¼���¼�ѹ��ڣ������µ�¼�������ģ�"));}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Զ���ϴ�</title>
<link href="source/plugin/ftp/default.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/ftp/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/ftp/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="source/plugin/ftp/swfobject.js"></script>
<script type="text/javascript" src="source/plugin/ftp/jquery.uploadify.v2.1.0.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader': 'source/plugin/ftp/uploadify.swf',
		'script': 'source/plugin/ftp/uploads.php',
		'cancelImg': 'source/plugin/ftp/cancel.png',
		'folder': 'upload',
		'method': 'GET',
		'queueID': 'fileQueue',
		'auto': true,
		'multi': false,
		'simUploadLimit': 1,
		'queueSizeLimit': 1,
		'removeCompleted': true,
		'buttonImg': 'source/plugin/ftp/up.png',
		'width': '75',
		'height': '28',
		'wmode': 'transparent',
		'displayData': 'percentage',
		'fileTypeDesc': 'Image Files',
		'fileDesc': '��ѡ��<?php echo $fileexts; ?>�ļ�',
		'fileExt': '<?php echo $fileexts; ?>',
		'sizeLimit': 209715200,
		'onError' : function (a, b, c, d) {
			if (d.status == 404){
				ReturnError("�ϴ����������ԣ�");
			}else if (d.type === "HTTP"){
				ReturnError("error "+d.type+" : "+d.status);
			}else if (d.type === "File Size"){
				ReturnError("�ϴ�ʧ�ܣ���С���ܳ���200MB��");
			}else{
				ReturnError("error "+d.type+" : "+d.text);
			}
		},
		'onComplete': function(event, queueID, fileObj, response, data) {
			if (response == 1){
				ReturnError("FTP����������ʧ�ܣ�");
			}else if (response == 2){
				ReturnError("FTP��������¼ʧ�ܣ�");
			}else if (response == 3){
				ReturnError("�ļ��ϴ�ʧ�ܣ�����Ȩ�޼�·���Ƿ���ȷ��");
			}else if (response == 4){
				ReturnError("Ŀ¼����ʧ�ܣ�����Ȩ�޼�·���Ƿ���ȷ��");
			}else{
				ReturnValue(response);
			}
		}
	});
});
function uploadFile() {
	jQuery('#uploadify').uploadifyUpload();
}
</script>
<script type="text/javascript">
function ReturnValue(reimg){
	<?php if($_GET['ac']=="song"){ ?>
	this.parent.document.form.CD_Url.value=reimg;
	this.parent.document.form.CD_DownUrl.value=reimg;
	this.parent.document.form.CD_Server.value=0;
	this.parent.asyncbox.tips("��ϲ����Ƶ�ϴ��ɹ���", "success", 3000);
	<?php }elseif($_GET['ac']=="video"){ ?>
	this.parent.document.form2.CD_Play.value=reimg;
	this.parent.asyncbox.tips("��ϲ����Ƶ�ϴ��ɹ���", "success", 3000);
	<?php } ?>
	this.parent.layer.closeAll();
}
function ReturnError(msg){
	this.parent.asyncbox.tips(msg, "error", 3000);
	this.parent.layer.closeAll();
}
</script>
<div class="uploadbox" style="width:595px; margin:20px auto;padding: 3px !important;border: 0px;!important;height:30px !important;position:relative;overflow:hide;background-image: url(source/plugin/ftp/bg.jpg);">
	<div class="blue" id="swfupload" style="float:left;width:434px;height:26px;line-height:26px;">
		<ul class="attachment-list" id="fileQueue"></ul>
	</div>
	<div class="addnew" id="addnew" style="float:left;">
		<input type="file" name="uploadify" id="uploadify"/>
	</div>
	<div style="float:left;">
		<input type="button" id="btupload" value="��ʼ�ϴ�" onclick="uploadFile()" />
		<div id="btnCancel"></div>
	</div>
</div>