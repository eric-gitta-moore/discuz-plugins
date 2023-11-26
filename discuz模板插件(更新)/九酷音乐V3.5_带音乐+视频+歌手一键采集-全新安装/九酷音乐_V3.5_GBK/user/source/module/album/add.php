<?php
	include "../source/global/global_inc.php";
	global $qianwei_in_userid,$qianwei_in_username;
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>上传新照片 - <?php echo cd_webname; ?></title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
		var _userid = '<?php echo $qianwei_in_userid; ?>'; _username = '<?php echo base64_encode($qianwei_in_username); ?>';
	</script>
	<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/user.css" rel="stylesheet" media="all" />
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="user">
	<div class="user_center">
		<div class="user_menu" id="albumm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="me">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">我的照片</a>
						</li>
						<li class="fond">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=praise'); ?>">喜欢的照片</a>
						</li>
						<li class="friend">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=following'); ?>">好友的照片</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=add'); ?>">上传照片</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="imageUp_Title">上传照片</div>
					<div class="imageUpNote">禁止上传违法图片，您上传的每张图片都会审核，一旦发现将封号处理，谢谢合作！</div>
					<div class="imageUp_uploadWrap">
						<div id="upButton" class="btn-upload">
							<input id="file_upload" width="100" type="file" height="32" name="file_upload" style="display: none;">
						</div>
						<div id="uploadfileQueue" class="uploadifyQueue"></div>
						<div id="uploadInfo">请选择您要上传的图片，支持批量上传！</div>
						<div class="btn-group">
							<a href="javascript:$('#file_upload').uploadify('upload','*')" class="btn">上传</a>
							<a href="javascript:$('#file_upload').uploadify('cancel','*')" class="btn">取消上传</a>
							<a href="javascript:$('#file_upload').uploadify('stop','*')" class="btn">暂停上传</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="user_copyright"><?php include "source/module/system/footer.php"; ?></div>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/common.js"></script>
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/album.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/jquery/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript">nav.helpNoticeInit();albumLib.imageAddInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/jquery/uploadify/swfobject.js"></script>
</body>
</html>