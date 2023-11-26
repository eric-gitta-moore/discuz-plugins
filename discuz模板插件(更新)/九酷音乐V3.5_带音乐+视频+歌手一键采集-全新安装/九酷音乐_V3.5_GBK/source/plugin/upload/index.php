<?php
close_browse(html_message("错误信息","访问方式错误"));
if($_GET['to']=="admin"){
        if(empty($_COOKIE['CD_AdminID']) || empty($_COOKIE['CD_Login']) || $_COOKIE['CD_Login']!==md5($_COOKIE['CD_AdminID'].$_COOKIE['CD_AdminUserName'].$_COOKIE['CD_AdminPassWord'].$_COOKIE['CD_Permission'])){exit(iframe_message("未登录或登录已过期，请重新登录管理中心！"));}
        $uid=0;
        $uname="系统用户";
}elseif($_GET['to']=="user"){
        global $userlogined,$qianwei_in_userid,$qianwei_in_username;
        if(!$userlogined){exit(iframe_message("您未登录没有上传权限，请先登录本站！"));}elseif(cd_uptype==0){exit(iframe_message("抱歉，上传功能已关闭！"));}
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
<title>本地上传</title>
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
		'fileDesc' : '请选择<?php echo $fileexts; ?>文件',
		'sizeLimit' : <?php echo ($filesizes*1024*1024); ?>,
		'onError' : function (a, b, c, d) {
			if (d.status == 404){
				ReturnError("上传出错，请重试！");
			}else if (d.type === "HTTP"){
				ReturnError("error "+d.type+" : "+d.status);
			}else if (d.type === "File Size"){
				ReturnError("上传失败，大小不能超过<?php echo $filesizes; ?>MB！");
			}else{
				ReturnError("error "+d.type+" : "+d.text);
			}
		},
		'onComplete' : function (event, queueID, fileObj, response, data) {
			if (response == 1){
				ReturnError("上传失败，音质不能低于<?php echo cd_upkbps; ?>kbps！");
			}else if (response == 2){
				ReturnError("无法加载 COM 组件，请在后台关闭音质检测！");
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
	this.parent.asyncbox.tips("恭喜，音频上传成功！", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="song"){ ?>
	this.parent.$.tipMessage('恭喜，音频上传成功！', 0, 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="video"){ ?>
	this.parent.asyncbox.tips("恭喜，视频上传成功！", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="video"){ ?>
	this.parent.$.tipMessage('恭喜，视频上传成功！', 0, 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="lrc"){ ?>
	this.parent.asyncbox.tips("恭喜，歌词上传成功！", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="lrc"){ ?>
	this.parent.$.tipMessage('恭喜，歌词上传成功！', 0, 3000);
	<?php }elseif($_GET['to']=="admin" && $_GET['ac']=="pic"){ ?>
	this.parent.asyncbox.tips("恭喜，图片上传成功！", "success", 3000);
	<?php }elseif($_GET['to']=="user" && $_GET['ac']=="pic"){ ?>
	this.parent.$.tipMessage('恭喜，图片上传成功！', 0, 3000);
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