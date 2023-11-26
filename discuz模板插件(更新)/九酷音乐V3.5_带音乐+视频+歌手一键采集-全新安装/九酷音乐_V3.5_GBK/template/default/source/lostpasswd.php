<script type="text/javascript">
var login_url="<?php echo cd_webpath.rewrite_url('user.php?do=login'); ?>";
$ = function(em) {
    if (document.getElementById){ return document.getElementById(em); }
    else if (document.all){ return document.all[em]; }
    else if (document.layers){ return document.layers[em]; }
    else{ return null; }
}
function seccode() {
	var img = temp_url+'source/ajax.php?ac=seccode&rand='+Math.random();
	document.writeln('<img id="img_seccode" src="'+img+'" align="absmiddle" />');
}
function updateseccode() {
	var img = temp_url+'source/ajax.php?ac=seccode&rand='+Math.random();
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
<div class="box getPass">
 <div class="mdBox bgWrite">
  <div class="mdBoxHd mdBangHd">
   <h2 class="mdBoxHdTit">找回密码</h2>
  </div>
  <div class="mdBoxBd clearfix">
   <div class="form-box getPass-form">
<form method="get" onsubmit="lostpasswd();return false;">
<ul>
<li class="form-item clearfix"><label class="label">登录帐号：</label><input type="text" id="ReI_1" class="input" /><span id="Re_1" class="tips">请输入您的登录帐号。</span></li>
<li class="form-item clearfix"><label class="label">密保问题：</label><input type="text" id="ReI_2" class="input" /><span id="Re_2" class="tips">请输入您曾经设置的密保问题。</span></li>
<li class="form-item clearfix"><label class="label">密保答案：</label><input type="password" id="ReI_3" class="input" /><span id="Re_3" class="tips">请输入您曾经设置的密保答案。</span></li>
<li class="form-item clearfix"><label class="label">重设密码：</label><input type="password" id="ReI_4" class="input" /><span id="Re_4" class="tips">请重新设置6位以上字符做为密码。</span></li>
<li class="form-item clearfix"><label class="label">确认密码：</label><input type="password" id="ReI_5" class="input" /><span id="Re_5" class="tips">再次输入密码，以确认重设密码无误。</span></li>
<li class="form-item clearfix"><label class="label">验证码：</label><input type="text" id="ReI_6" style="width:36px;" maxlength="4" class="input" autocomplete="off" />&nbsp;<script type="text/javascript">seccode();</script>&nbsp;<a href="javascript:updateseccode()">更换</a><span id="Re_6" class="tips">输入上面的验证码，如看不清请更换一个。</span></li>
</ul>
<div class="btn-group clearfix" style="padding:10px 0 0 150px;">
<input type="submit" value="找回密码" class="btnGetPass" />
</div>
</form>
</div>
<div class="guess">
<h3>或者您想：</h3>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=login'); ?>" style="color:#090;">直接登录&gt;&gt;</a></p>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=register'); ?>">重新注册</a></p>
<h4><strong>通过合作网站登录</strong>：</h4>
<ul class="logoIcon clearfix">
<li><a class="qqlogin" href="javascript:void(0)" onclick="toQzoneLogin()"><span class="icon-logo icon-qq"></span><span class="icon-text">QQ帐号</span></a></li>
</ul>
</div>
  </div>
 </div>
</div>