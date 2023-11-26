<?php
close_browse(html_message("错误信息","访问方式错误"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>远程上传</title>
<link href="source/plugin/qiniu/api/default.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/qiniu/api/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/qiniu/api/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="source/plugin/qiniu/api/swfobject.js"></script>
<script type="text/javascript" src="source/plugin/qiniu/api/jquery.uploadify.v2.1.0.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader': 'source/plugin/qiniu/api/uploadify.swf',
		'script': 'source/plugin/qiniu/api/uploads.php',
		'cancelImg': 'source/plugin/qiniu/api/cancel.png',
		'folder': 'upload',
		'method': 'GET',
		'queueID': 'fileQueue',
		'auto': true,
		'multi': false,
		'simUploadLimit': 1,
		'queueSizeLimit': 1,
		'removeCompleted': true,
		'buttonImg': 'source/plugin/qiniu/api/up.png',
		'width': '75',
		'height': '28',
		'wmode': 'transparent',
		'displayData': 'percentage',
		'fileTypeDesc': 'Image Files',
		'fileDesc': 'All Files',
		'fileExt': '*.*',
		'sizeLimit': 209715200,
		'onError' : function (a, b, c, d) {
			if (d.status == 404){
				ReturnError("上传出错，请重试！");
			}else if (d.type === "HTTP"){
				ReturnError("error "+d.type+" : "+d.status);
			}else if (d.type === "File Size"){
				ReturnError("上传失败，大小不能超过200MB！");
			}else{
				ReturnError("error "+d.type+" : "+d.text);
			}
		},
		'onComplete': function(event, queueID, fileObj, response, data) {
			ReturnValue(response);
		}
	});
});
function uploadFile() {
	jQuery('#uploadify').uploadifyUpload();
}
</script>
<script type="text/javascript">
function ReturnValue(reimg){
	<?php if($_GET['to']=="admin" && $_GET['ac']=="song"){ ?>
	this.parent.document.form.CD_Url.value=reimg;
	this.parent.document.form.CD_DownUrl.value=reimg;
	this.parent.document.form.CD_Server.value=0;
	this.parent.asyncbox.tips("恭喜，文件上传成功！", "success", 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="video"){ ?>
	this.parent.document.form2.CD_Play.value=reimg;
	this.parent.asyncbox.tips("恭喜，文件上传成功！", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="song"){ ?>
	this.parent.document.form.rUrl.value=reimg;
	this.parent.document.form.rServer.value=0;
	this.parent.$.tipMessage('恭喜，文件上传成功！', 0, 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="video"){ ?>
	this.parent.document.form.rPlay.value=reimg;
	this.parent.$.tipMessage('恭喜，文件上传成功！', 0, 3000);
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
<div class="uploadbox" style="width:595px; margin:20px auto;padding: 3px !important;border: 0px;!important;height:30px !important;position:relative;overflow:hide;background-image: url(source/plugin/qiniu/api/bg.jpg);">
	<div class="blue" id="swfupload" style="float:left;width:434px;height:26px;line-height:26px;">
		<ul class="attachment-list" id="fileQueue"></ul>
	</div>
	<div class="addnew" id="addnew" style="float:left;">
		<input type="file" name="uploadify" id="uploadify"/>
	</div>
	<div style="float:left;">
		<input type="button" id="btupload" value="开始上传" onclick="uploadFile()" />
		<div id="btnCancel"></div>
	</div>
</div>