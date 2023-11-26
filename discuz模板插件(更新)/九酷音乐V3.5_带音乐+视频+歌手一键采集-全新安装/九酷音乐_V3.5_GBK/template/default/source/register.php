<?php if(cd_usery=="no"){
echo "<div class=\"box bgWrite mt\"><div class=\"diange\">";
echo "<div class=\"diangeHd clearfix\"><div class=\"diangeNav\"><ul class=\"step-nav clearfix\"><li class=\"current\"><span class=\"t-t\">信息提示</span></li></ul></div></div>";
echo "<div class=\"diangeFrom diange-form\"><div class=\"notice\"><div class=\"error\">抱歉，本站暂不开放新会员注册！</div></div></div>";
echo "<div class=\"diangeBd step03 clearfix\"><div class=\"btn-group clearfix\" style=\"margin:20px 0 0 320px;\">";
echo "<a href=\"javascript:history.go(-1);\" class=\"sDian1\">返回上一页</a>";
echo "<a href=\"".cd_webpath."\" class=\"sDian2\">返回首页</a>";
echo "</div></div></div></div>";
}else{ ?>
<script type="text/javascript" src="<?php echo $TempImg; ?>js/city.js"></script>
<script type="text/javascript">
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
<div class="box register register-step01">
 <div class="mdBox bgWrite">
  <div class="mdBoxHd mdBangHd">
   <h2 class="mdBoxHdTit">快速注册</h2>
  </div>
  <div class="mdBoxBd clearfix">
   <div class="form-box register-form">
<form method="get" onsubmit="register();return false;">
<ul>
<li class="form-item clearfix"><label class="label">创建帐号：</label><input type="text" id="ReI_1" class="input" /><span id="Re_1" class="tips">介于3到15个字符之间，不能有空格或 < > ' " / \ 等字符。</span></li>
<li class="form-item clearfix"><label class="label">设置密码：</label><input type="password" id="ReI_2" class="input" /><span id="Re_2" class="tips">请输入6位以上字符做为密码。</span></li>
<li class="form-item clearfix"><label class="label">确认密码：</label><input type="password" id="ReI_3" class="input" /><span id="Re_3" class="tips">再次输入密码，以确认密码无误。</span></li>
<li class="form-item clearfix"><label class="label">名字：</label><input type="text" id="ReI_4" class="input" /><span id="Re_4" class="tips">介于2到12个字符之间，不能有空格、数字或 < > ' " / \ 等字符。</span></li>
<li class="form-item clearfix"><label class="label">性别：</label>
<select id="ReI_5">
<option value="">选</option>
<option value="1">帅哥</option>
<option value="0">靓女</option>
</select>
<span id="Re_5" class="tips"></span></li>
<li class="form-item clearfix"><label class="label">生日：</label>
<select id="ReI_year">
<option value="">年</option>
<?php
for ($i=0; $i<100; $i++) {
$they = date('Y') - $i;
if($they >= "1970"){
echo "<option value=\"$they\">$they</option>";
}
}
?>
</select>
<select id="ReI_month">
<option value="">月</option>
<?php
for ($i=1; $i<13; $i++) {
if($i <= 9){
$im="0".$i;
}else{
$im=$i;
}
echo "<option value=\"$im\">$im</option>";
}
?>
</select>
<select id="ReI_day">
<option value="">日</option>
<?php
for ($i=1; $i<32; $i++) {
if($i <= 9){
$iday="0".$i;
}else{
$iday=$i;
}
echo "<option value=\"$iday\">$iday</option>";
}
?>
</select>
<span id="Re_birthday" class="tips"></span></li>
<li class="form-item clearfix"><label class="label">城市：</label>
<select onchange="javascript:gettown(this.options[this.selectedIndex].value,&quot;&quot;,&quot;ReI_shi&quot;)" id="ReI_sheng">
<option value="">省</option>
</select>
<select id="ReI_shi">
<option value="">市</option>
</select>
<span id="Re_city" class="tips"></span></li>
<li class="form-item clearfix"><label class="label">邮箱：</label><input type="text" id="ReI_11" class="input" /><span id="Re_11" class="tips">请输入您常用的Email电子邮箱。</span></li>
<li class="form-item clearfix"><label class="label">Q Q：</label><input type="text" id="ReI_12" class="input" /><span id="Re_12" class="tips">请输入您的QQ号码。</span></li>
<li class="form-item clearfix"><label class="label">验证码：</label><input type="text" id="ReI_13" style="width:36px;" maxlength="4" class="input" autocomplete="off" />&nbsp;<script type="text/javascript">seccode();</script>&nbsp;<a href="javascript:updateseccode()">更换</a><span id="Re_13" class="tips">输入上面的验证码，如看不清请更换一个。</span></li>
</ul>
<div class="btn-group clearfix" style="padding:10px 0 0 120px;">
<input type="submit" class="btnZhuce" value="立即注册" />
</div>
</form>
</div>
<div class="guess">
<h3>或者您想：</h3>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=login'); ?>" style="color:#090;">直接登录&gt;&gt;</a></p>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=lostpasswd'); ?>">找回密码</a></p>
<h4><strong>通过合作网站登录</strong>：</h4>
<ul class="logoIcon clearfix">
<li><a class="qqlogin" href="javascript:void(0)" onclick="toQzoneLogin()"><span class="icon-logo icon-qq"></span><span class="icon-text">QQ帐号</span></a></li>
</ul>
</div>
  </div>
 </div>
</div>
<script type="text/javascript">
getcity('','ReI_sheng','','ReI_shi');
</script>
<?php } ?>