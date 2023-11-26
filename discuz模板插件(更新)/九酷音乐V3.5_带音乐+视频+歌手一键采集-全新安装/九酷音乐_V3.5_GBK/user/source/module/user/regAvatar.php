<?php
	include "../source/global/global_inc.php";
	global $db,$qianwei_in_userid,$qianwei_in_password;
	VerifyLogin($qianwei_in_userid);
	$avatar=cd_webpath."data/attachment/avatar/".$qianwei_in_userid."_200x200.jpg";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312" />
<title>添加头像</title>
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/passport.css" />
<link href="<?php echo cd_webpath; ?>source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/jquery.min.js"></script>
</head>
<body>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
	<div class="header">
		<div class="header_con">
			<div class="logo"> </div>
			<div class="right">
				<a class="home" href="<?php echo cd_webpath; ?>">网站首页</a>
				<p>|</p>
				<a class="help"href="<?php echo cd_upath; ?>">会员中心</a>
			</div>
		</div>
	</div>
	<div id="modifyAvatar" class="profile" style="float: none;">
		<div class="title">添加头像</div>
		<div class="avatar_box">
			<div class="avatarTitle">当前头像<span>设置头像</span></div>
			<div class="myAvatar" id="avatar"><img class="avatar-160" width="160" height="160" src="<?php echo getavatar(0,200); ?>"></div>
							<div class="myAvatarUpload">
							<?php
							        if(cd_ucenter==1){
							                require_once _qianwei_root_.'./client/ucenter.php';
							                require_once _qianwei_root_.'./client/client.php';
							                global $qianwei_in_username,$qianwei_in_ucenter;
							                $ucid = uc_get_user($qianwei_in_username);
							                if($qianwei_in_ucenter>0 && $qianwei_in_ucenter==$ucid[0]){
							                        $avatar=getavatar($qianwei_in_userid,200);
							                        echo uc_avatar($ucid[0]);
							                }else{
							?>
								<?php echo "<embed src=\"http://".$_SERVER['HTTP_HOST'].cd_upath."static/swf/camera.swf?ucapi=".urlencode("http://".$_SERVER['HTTP_HOST'].cd_webpath."avatar.php")."&input=".urlencode("uid=").base64_encode($qianwei_in_userid."|".$qianwei_in_password)."&uploadSize=2048\" width=\"450\" height=\"253\" wmode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>"; ?>
							<?php } ?>
							<?php }else{ ?>
								<?php echo "<embed src=\"http://".$_SERVER['HTTP_HOST'].cd_upath."static/swf/camera.swf?ucapi=".urlencode("http://".$_SERVER['HTTP_HOST'].cd_webpath."avatar.php")."&input=".urlencode("uid=").base64_encode($qianwei_in_userid."|".$qianwei_in_password)."&uploadSize=2048\" width=\"450\" height=\"253\" wmode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>"; ?>
							<?php } ?>
							</div>
			<div class="style" id="next"><a href="javascript:;" onclick="asyncbox.tips('请先上传头像！', 'wait', 1000);">下一步</a></div>
		</div>
	</div>
	<div class="bottom">
		<div class="content"><?php include "source/module/system/footer.php"; ?></div>
	</div>
	<script type="text/javascript">
	function updateavatar() {
		$("#avatar").html('<img class="avatar-160" width="160" height="160" src="<?php echo $avatar; ?>">');
		$("#next").html('<a href="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>">下一步</a>');
		asyncbox.tips('头像保存成功！', 'success', 1000);
	}
	</script>
</body>
</html>