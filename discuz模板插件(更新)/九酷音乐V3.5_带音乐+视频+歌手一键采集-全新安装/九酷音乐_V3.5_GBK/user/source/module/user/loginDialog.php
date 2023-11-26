<script type="text/javascript">
var childWindow;
function toQzoneLogin() {
        childWindow = window.open("<?php echo cd_webpath; ?>source/connect/login.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
}
function closeChildWindow() {
        childWindow.close();
        location.href='<?php echo cd_upath.rewrite_url('index.php?p=system&a=home'); ?>';
}
</script>
<form>
<div class="user_dialog_login">
	<input type="hidden" id="refer" value="<?php if($_SERVER['HTTP_REFERER']){echo $_SERVER['HTTP_REFERER'];}else{echo cd_upath.rewrite_url('index.php?p=system&a=home');} ?>" />
	<div class="left">
		<div class="left_line">
			<div class="message">
				<span id="errMessage"></span>
			</div>
		</div>
		<div class="left_line">
			<div class="dl_loginName"><input type="text" name="loginName" id="loginName" class="input_normal"  maxlength="70"></div>
		</div>
		<div class="left_line">
			<div class="dl_password"><input type="password" name="password" id="password" class="input_normal" maxlength="30"></div>
		</div>
		<div class="left_line">
			<div id="loginName" class="input">
				<input id="vCode" class="input_normal" type="text" style="width:81px;" name="rvCode" maxlength="4" value="请输入验证码">
			</div>
			<div class="vcode">
				<div class="noleft">
					<img id="authCode" align="absmiddle" title="看不清？点击更换" src="<?php echo cd_upath; ?>index.php?p=system&a=getVCode">
				</div>
				<div class="reloadCode">
					<a id="changeAuthCode" href="javascript:;">看不清？换一张</a>
				</div>
			</div>
		</div>
		<div class="left_line">
			<div class="right">
				<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=lostPassword'); ?>">忘记密码?</a>
			</div>
			<label><input class="check_box" type="checkbox">&nbsp;下次自动登录</label>
		</div>
		<div class="style">
			<input class="home_btn" type="submit" id="submit2" value="登 录">
		</div>
	</div>
	<div class="right_line">
		<div class="title">还未开通？</div>
		<div class="reg">
			<p>赶快免费注册一个吧！</p>
			<a class="home_btn" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=register'); ?>"></a>
		</div>
		<div class="partner">
			<p class="tit">通过合作网站登录</p>
			<div class="qq"><img src="<?php echo cd_upath; ?>static/images/qqconnect.gif"><a href="javascript:void(0)" onclick="toQzoneLogin()">&nbsp;QQ帐号</a></div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">user.loginInit(1);</script>