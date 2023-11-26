<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312" />
<title>会员登录</title>
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/passport.css" />
<link href="<?php echo cd_webpath; ?>source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/lib.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript">
var site_domain="<?php echo cd_webpath; ?>";
var zone_domain="<?php echo cd_upath; ?>";
var home_url="<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>";
$ = function(em) {
    if (document.getElementById){ return document.getElementById(em); }
    else if (document.all){ return document.all[em]; }
    else if (document.layers){ return document.layers[em]; }
    else{ return null; }
}
function seccode() {
	var img = zone_domain+'index.php?p=system&a=getVCode&rand='+Math.random();
	document.writeln('<img id="img_seccode" src="'+img+'" align="absmiddle" />');
}
function updateseccode() {
	var img = zone_domain+'index.php?p=system&a=getVCode&rand='+Math.random();
	if($('img_seccode')) {
		$('img_seccode').src = img;
	}
}
var childWindow;
function toQzoneLogin() {
        childWindow = window.open("<?php echo cd_webpath; ?>source/connect/login.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
}
function closeChildWindow() {
        childWindow.close();
        location.href='<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>';
}
</script>
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
	<div class="login_body">
		<div class="login_title">会员登录</div>
		<div class="login_box">
			<div class="login_box_left">
			        <form method="get" onsubmit="login();return false;">
				        <div class="center"><span id="Re_Msg"></span></div>
					<div class="site">
						<div class="info_list">
							<div class="username">
								<input type="text" id="ReI_1" class="input" />
							</div>
						</div>
						<div class="info_list">
							<div class="password">
								<input type="password" id="ReI_2" class="input" />
							</div>
						</div>
						<div class="info_list">
							<div class="input">
								<input type="text" id="ReI_3" style="width:60px;" maxlength="4" class="input_normal" autocomplete="off" />
							</div>
							<div class="vcode">
								<div class="noleft">
									<script type="text/javascript">seccode();</script>
								</div>
								<div class="reloadCode">
									<a href="javascript:updateseccode()">看不清？换一张</a>
								</div>
							</div>
						</div>
						<div class="info_list">
							<div class="right">
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=lostPassword'); ?>">忘记密码?</a>
							</div>
							<label><input class="check_box" type="checkbox">&nbsp;下次自动登录</label>
						</div>
						<div class="style"><input class="home_btn" type="submit" value="登 录"></div>
					</div>
			        </form>
			</div>
			<div  class="login_box_right">
				<div class="title">您还不是本站用户？</div>
				<div class="reg">
					<p>注册后，即可寻觅您的音乐知音、发现嗨友分享好的music音乐！</p>
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=register'); ?>" class="home_btn"></a>
				</div>
				<div class="partner">
					<p class="tit">通过合作网站登录</p>
					<a href="javascript:void(0)" onclick="toQzoneLogin()"></a>
				</div>
				<ul class="clearfix">
					<li>邂逅各个城市夜店中美丽的女孩</li>
					<li>和你身边的美女帅哥成为朋友</li>
					<li>用照片和说说记录生活，展示自我</li>
					<li>寻找音乐知音，了解他们的最新动态</li>
					<li>找到喜欢的专区，参加有趣的活动</li>
					<li>与大家分享好听的音乐</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="bottom">
		<div class="content"><?php include "source/module/system/footer.php"; ?></div>
	</div>
</body>
</html>