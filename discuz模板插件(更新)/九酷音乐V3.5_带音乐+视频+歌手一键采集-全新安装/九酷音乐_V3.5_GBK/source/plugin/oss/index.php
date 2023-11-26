<?php
close_browse(html_message("错误信息","访问方式错误"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>远程上传</title>
<link href="source/plugin/oss/css/bootstrap-1.2.0.min.css" rel="stylesheet" type="text/css" />
<link href="source/plugin/oss/css/app.styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/oss/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="source/plugin/oss/js/swfupload.js"></script>
<script type="text/javascript" src="source/plugin/oss/js/fileprogress.js"></script>
<script type="text/javascript" src="source/plugin/oss/js/handlers.js"></script>
<script type="text/javascript" src="source/plugin/oss/js/application.js"></script>
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
</script>
</head>
<body>
	<div style="position: relative; top: auto; left: auto; margin: 0 auto; z-index: 1" class="modal">
		<form name="s3_upload_form" id="s3_upload_form" method="get">
		<div class="modal-body">
			<div class="clearfix">
				<div class="input">
					<button class="btn primary" id="s3_upload" type="submit">上传文件</button>
					<input type="text" size="30" name="FileInput" id="FileInput" class="xlarge" disabled="disabled" value="未选择文件" />
					<span id="spanButtonPlaceholder"></span>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div id="fsUploadProgress"><div class="progressWrapper" id="singlefile" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div class="progressName" id="up_file">文件名</div><div class="progressBarStatus" id="up_status">状态</div><div class="progressBarComplete" style=""></div></div></div></div>
		</div>
		</form>
	</div>
</body>
</html>