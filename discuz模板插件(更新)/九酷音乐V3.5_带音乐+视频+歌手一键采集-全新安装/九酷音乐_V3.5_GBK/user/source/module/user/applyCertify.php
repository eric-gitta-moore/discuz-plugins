<?php
	include "../source/global/global_inc.php";
        global $db;
	VerifyLogin($qianwei_in_userid);
	$step = SafeRequest("step","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>申请美女认证 - <?php echo cd_webname; ?></title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
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
		<div class="user_menu" id="profilem">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="modify">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=profileModify'); ?>">个人资料</a>
						</li>
						<li class="skin">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=skin'); ?>" target="_blank">空间换肤</a>
						</li>	
						<li class="certify">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=applyCertify'); ?>">美女认证</a>
						</li>
					</ul>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<?php if($qianwei_in_sex == "1"){ ?>
					<div class="nothing">您不是女性，无法参加美女认证！</div>
					<?php }elseif($qianwei_in_checkmm == "1"){ ?>
					<div class="nothing">您已通过认证，无需再参加美女认证！</div>
					<?php }else{ ?>
					<div id="modifyAvatar" class="profile">
						<div class="title"><div class="name">申请认证</div></div>
						<div class="avatar_box">
							<div class="state">认证状态：<?php if($qianwei_in_checkmm == "1"){ echo '<font color="#FF0000">已通过认证！</font>'; }elseif($qianwei_in_checkmm == "2"){ echo '<font color="#FF0000">已提交审核！</font>'; }else{ echo '未申请认证！'; }?></div>
							<?php if($step == "2"){ ?>
								<div class="avatarTitle">摄像头拍照</div>
								<div id="camera" class="camera">
									<div id="cam" class="cam">
										<div id="webcam" class="webcam"></div>
									</div>
									<div id="buttons" class="buttons">
										<div class="button_pane" id="shoot"><a id="btn_shoot" href="javascript:;" class="btn_camera">拍照</a></div>
										<div class="button_pane hidden" id="upload"><a id="btn_upload" href="" class="btn_green">申请认证</a><a id="btn_cancel" href="javascript:;" class="btn_cancel">取消</a></div>
										<div class="button_pane hidden" id="loading" style="display:none;"><a href="javascript:;" class="btn_cancel">上传中...</a></div>
									</div>
								</div>
								<ul class="process">
									<li class="pro">认证流程</li>
									<li>1.请通过照相设备进行拍照，将拍好的视频照片上传至网站。</li>
									<li>2.我们会在最多不超过10小时内审核您的申请。</li>
									<li>3.审核通过后，您就可以成为认证用户点亮认证用户图标，并获得 <?php echo cd_mmpoints; ?> 金币奖励。</li>
									<li style='color:#ff0000'>注：您的头像和认证照片必须是本人真实面貌，否则无法通过审核。</li>
									<li style='color:#ff0000'>如果在本页面中无法打开您的摄像头，您可以联系管理员QQ：<?php echo cd_webqq?>进行认证。</li>
								</ul>
							<?php }else{ ?>
								<div class="avatarTitle">您的个人头像</div>
								<div id="camera" class="camera">
									<div id="cam" class="cam"><img width="220" height="220" src="<?php echo cd_webpath.$qianwei_in_verified; ?>" onerror="this.src='<?php echo cd_upath; ?>static/images/noface_200x200.gif'" /></div>
									<div id="buttons" class="buttons"><div class="button_pane"><a id="next" href="<?php echo cd_upath; ?>index.php?p=user&a=applyCertify&step=2" class="btn_next">下一步</a></div></div>
								</div>
								<ul class="process">
									<li class="pro">认证流程</li>
									<li>1.请确认您的头像是您本人的真实照片。</li>
									<li>2.如果确认头像为本人真实照片，请点击下一步进行视频拍照认证。</li>
									<li>3.如果头像不是您本人照片，请先修改头像为您的照片后再进行认证申请。</li>
									<li style='color:#ff0000'>注：您的头像必须是本人真实照片，否则无法通过审核。</li>
								</ul>
							<?php } ?>
							<div class="cannot_clear">
								<div class="alert">类似这样的头像，不会被审核通过<i class="arrow"></i></div>
								<ul>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo4.jpg"><p>遮住五官</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo5.jpg"><p>照片模糊</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo6.jpg"><p>裸露、纹身、吸烟</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo1.jpg"><p>非正面照</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo3.jpg"><p>表情过分夸张</p></li>
									<li><img src="<?php echo cd_upath; ?>static/space/images/bad_photo/bad_photo7.jpg"><p>照片与本人形象差别过大</p></li>
								</ul>
							</div>
						</div>
					</div>
					<?php } ?>
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/profile.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/camera/webcam.js"></script>
<?php if($step == "2"){ ?>
<script type="text/javascript">profile.certifyInit();</script>
<?php } ?>
</body>
</html>