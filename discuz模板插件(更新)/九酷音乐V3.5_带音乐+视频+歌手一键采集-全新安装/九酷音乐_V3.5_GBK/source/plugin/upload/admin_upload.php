<?php
$f=SafeRequest("f","get");
$d=SafeRequest("d","get");
$action=SafeRequest("ac","get");
$randdir=rand(2,pow(2,24));
$randnum=date('YmdHis',time());
switch($action){
	case 'song':
		$targetFiles="data/attachment/song/".$randdir;
		$fileexts=cd_upext;
		$filesizes=cd_upsize;
		break;
	case 'video':
		$targetFiles="data/attachment/video/".$randdir;
		$fileexts="*.flv;*.f4v;*.mp4";
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
if(empty($_COOKIE['CD_AdminID']) || empty($_COOKIE['CD_Login']) || $_COOKIE['CD_Login']!==md5($_COOKIE['CD_AdminID'].$_COOKIE['CD_AdminUserName'].$_COOKIE['CD_AdminPassWord'].$_COOKIE['CD_Permission'])){exit(iframe_message("未登录或登录已过期，请重新登录管理中心！"));}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>本地上传</title>
<link href="source/plugin/upload/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="source/plugin/upload/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="source/plugin/upload/swfobject.js"></script>
<script type="text/javascript" src="source/plugin/upload/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader' : 'source/plugin/upload/uploadify.swf',
		'script' : 'source/plugin/upload/admin_uplog.php',
		'cancelImg' : 'source/plugin/upload/cancel.png',
		'folder' : '<?php echo $targetFiles; ?>',
		'method' : 'GET',
		'scriptData' : {'is':'<?php echo $randdir; ?>','id':'<?php echo $randnum; ?>','ac':'<?php echo $action; ?>'},
		'width' : '110',
		'height' : '30',
		'buttonText' : 'Upload',
		'buttonImg' : 'source/plugin/upload/up.png',
		'queueID' : 'fileQueue',
		'auto' : true,
		'fileExt' : '<?php echo $fileexts; ?>',
		'fileDesc' : '请选择<?php echo $fileexts; ?>文件',
		'multi' : false,
		'sizeLimit' : <?php echo ($filesizes*1024*1024); ?>,
		'onError' : function (a, b, c, d) {
			if (d.status == 404){
				parent.asyncbox.tips("上传出错，请重试！", "error", 3000);
				parent.layer.closeAll();
			}else if (d.type === "HTTP"){
				parent.asyncbox.tips("error "+d.type+" : "+d.status, "error", 3000);
				parent.layer.closeAll();
			}else if (d.type === "File Size"){
				parent.asyncbox.tips("上传失败，大小不能超过<?php echo $filesizes; ?>MB！", "error", 3000);
				parent.layer.closeAll();
			}else{
				parent.asyncbox.tips("error "+d.type+" : "+d.text, "error", 3000);
				parent.layer.closeAll();
			}
		},
		'onComplete' : function (event, queueID, fileObj, response, data) {
			if (response == 0){
				<?php if($_GET['ac']=="pic"){ ?>
				ReturnValue('<?php echo $targetFiles."/".$randnum; ?>'+fileObj.type);
				<?php }else{ ?>
				ReturnValue('<?php echo $targetFiles."/".$randnum; ?>'+fileObj.type+'.jpg');
				<?php } ?>
			}
		}
	});
});
</script>
<script type="text/javascript">
function ReturnValue(reimg){
	this.parent.document.<?php echo $f; ?>.value=reimg;
	<?php if($_GET['ac']=="song"){ ?>
	this.parent.document.<?php echo $d; ?>.value=reimg;
	this.parent.asyncbox.tips("恭喜，音频上传成功！", "success", 3000);
	<?php }elseif($_GET['ac']=="video"){ ?>
	this.parent.asyncbox.tips("恭喜，视频上传成功！", "success", 3000);
	<?php }elseif($_GET['ac']=="lrc"){ ?>
	this.parent.asyncbox.tips("恭喜，歌词上传成功！", "success", 3000);
	<?php }elseif($_GET['ac']=="pic"){ ?>
	this.parent.asyncbox.tips("恭喜，图片上传成功！", "success", 3000);
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