<?php
include "source/global/global_inc.php";
$f=SafeRequest("f","get");
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
global $db,$userlogined,$qianwei_in_userid,$qianwei_in_username;
if(!$userlogined){exit(iframe_message("您未登录没有上传权限，请先登录本站！"));}
if(cd_uptype==0){exit(iframe_message("抱歉，上传功能已关闭！"));}
$timea = date('Y',time());
$timeb = date('m',time());
$timec = date('d',time());
$timed = mktime(0,0,0,$timeb,$timec,$timea);
$numa = $db -> num_rows($db -> query("select * from ".tname('upload')." where cd_filetype='音频文件' and cd_userid=".$qianwei_in_userid." and cd_filetime >= '".$timed."'"));
$numb = cd_upnum-$numa;
if($_GET['ac']=="song" && $numb<=0){exit(iframe_message("您今日的上传次数到达上限！"));}
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
		'script' : 'source/plugin/upload/user_uplog.php',
		'cancelImg' : 'source/plugin/upload/cancel.png',
		'folder' : '<?php echo $targetFiles; ?>',
		'method' : 'GET',
		'scriptData' : {'is':'<?php echo $randdir; ?>','id':'<?php echo $randnum; ?>','ac':'<?php echo $action; ?>','uid':'<?php echo $qianwei_in_userid; ?>','uname':'<?php echo base64_encode($qianwei_in_username); ?>'},
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
				parent.$.tipMessage('上传出错，请重试！', 2, 3000);
				parent.layer.closeAll();
			}else if (d.type === "HTTP"){
				parent.$.tipMessage('error '+d.type+' : '+d.status, 2, 3000);
				parent.layer.closeAll();
			}else if (d.type === "File Size"){
				parent.$.tipMessage('上传失败，大小不能超过<?php echo $filesizes; ?>MB！', 2, 3000);
				parent.layer.closeAll();
			}else{
				parent.$.tipMessage('error '+d.type+' : '+d.text, 2, 3000);
				parent.layer.closeAll();
			}
		},
		'onComplete' : function (event, queueID, fileObj, response, data) {
			if (response == 1){
				parent.$.tipMessage('上传失败，音质不能低于<?php echo cd_upkbps; ?>kbps！', 2, 3000);
				parent.layer.closeAll();
			}else if (response == 2){
				parent.$.tipMessage('无法加载 COM 组件，请在后台关闭音质检测！', 2, 3000);
				parent.layer.closeAll();
			}else if (response == 0){
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
	this.parent.$.tipMessage('恭喜，音频上传成功！', 0, 3000);
	<?php }elseif($_GET['ac']=="video"){ ?>
	this.parent.$.tipMessage('恭喜，视频上传成功！', 0, 3000);
	<?php }elseif($_GET['ac']=="lrc"){ ?>
	this.parent.$.tipMessage('恭喜，歌词上传成功！', 0, 3000);
	<?php }elseif($_GET['ac']=="pic"){ ?>
	this.parent.$.tipMessage('恭喜，图片上传成功！', 0, 3000);
	<?php } ?>
	this.parent.layer.closeAll();
}
</script>
</head>
<body>
<?php if($_GET['ac']=="song"){echo "<div style=\"color:#2D9AF6;height:25px;\">您今日已上传文件 ".$numa." 个，还可以上传 ".$numb." 个！</div>";} ?>
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
</body>
</html>