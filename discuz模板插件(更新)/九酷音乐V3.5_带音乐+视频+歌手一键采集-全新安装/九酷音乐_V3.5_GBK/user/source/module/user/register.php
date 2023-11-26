<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312" />
<title>注册账号</title>
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/passport.css" />
<link href="<?php echo cd_webpath; ?>source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/lib.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript">
var site_domain="<?php echo cd_webpath; ?>";
var zone_domain="<?php echo cd_upath; ?>";
var avatar_url="<?php echo cd_upath.rewrite_url('index.php?p=user&a=regAvatar'); ?>";
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/city.js"></script>
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
	<?php if(cd_usery=="no"){?>
	<div class="succeed_body">
		<div class="succeed_title">信息提示</div>
		<div class="succeed_box">
			<div class="info"><div align="center"><font color="red" size="5">本站暂不开放新会员注册。</font></div></div>
		</div>
	</div>
	<?php }else{ ?>
	<div class="register_body">
		<div class="register_title">注册账号</div>
		<div class="register_box">
			<div class="register_box_left">
				<form method="get" onsubmit="register();return false;">
				<ul>
					<li>
						<div class="title">创建帐号</div>
						<div class="input">
							<input type="text" id="ReI_1" class="input_normal" />
						</div>
						<div id="Re_1"><div class="err_message"><span class="icon">3-15字符，禁止空格或< > ' " / \</span></div></div>
					</li>
					<li>
						<div class="title">设置密码</div>
						<div class="input">
							<input type="password" id="ReI_2" class="input_normal" />
						</div>
						<div id="Re_2"><div class="err_message"><span class="icon">请输入6位以上字符做为密码。</span></div></div>
					</li>
					<li>
						<div class="title">确认密码</div>
						<div class="input">
							<input type="password" id="ReI_3" class="input_normal" />
						</div>
						<div id="Re_3"><div class="err_message"><span class="icon">再次输入密码，以确认密码无误。</span></div></div>
					</li>
					<li>
						<div class="title">名字</div>
						<div class="input">
							<input type="text" id="ReI_4" class="input_normal" />
						</div>
						<div id="Re_4"><div class="err_message"><span class="icon">2-12字符，禁止空格数字或< > ' " / \</span></div></div>
					</li>
					<li>
						<div class="title">性别</div>
						<div class="input">
							<select id="ReI_5" class="select_normal" style="width:70px;">
							<option value="">选</option>
							<option value="1">帅哥</option>
							<option value="0">靓女</option>
							</select>
						</div>
						<div id="Re_5"></div>
					</li>
					<li>
						<div class="title">生日</div>
						<div class="input">
							<select id="ReI_year" class="select_normal">
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
							<select id="ReI_month" class="select_normal">
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
							<select id="ReI_day" class="select_normal">
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
						</div>
						<div id="Re_birthday"></div>
					</li>
					<li>
						<div class="title">城市</div>
						<div class="input">
							<select onchange="javascript:gettown(this.options[this.selectedIndex].value,&quot;&quot;,&quot;ReI_shi&quot;)" id="ReI_sheng" class="select_normal">
							<option value="">省</option>
							</select>
							<select id="ReI_shi" class="select_normal">
							<option value="">市</option>
							</select>
						</div>
						<div id="Re_city"></div>
					</li>
					<li>
						<div class="title">邮箱</div>
						<div class="input">
							<input type="text" id="ReI_11" class="input_normal" />
						</div>
						<div id="Re_11"><div class="err_message"><span class="icon">请输入您常用的Email电子邮箱。</span></div></div>
					</li>
					<li>
						<div class="title">Q Q</div>
						<div class="input">
							<input type="text" id="ReI_12" class="input_normal" />
						</div>
						<div id="Re_12"><div class="err_message"><span class="icon">请输入您的QQ号码。</span></div></div>
					</li>
					<li>
						<div class="title">验证码</div>
						<div class="input">
							<input id="ReI_13" class="input_normal" type="text" maxlength="4" autocomplete="off" style="width:70px;" />
						</div>
						<div class="vcode">
							<div class="noleft">
								<script type="text/javascript">seccode();</script>
							</div>
							<div class="reloadCode">
								<a href="javascript:updateseccode()">看不清？换一张</a>
							</div>
						</div>
						<div id="Re_13"></div>
					</li>
					<li>
						<div class="noleft">
							<input class="input_register" type="submit" value="立即注册" />
						</div>
					</li>
				</ul>
				</form>
			</div>
			<div  class="register_box_right">
				<div class="title">已有账号？</div>
				<div class="reg">
					<a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=login'); ?>">赶快登录吧>></a>
				</div>
				<div class="qq">
					<div class="or">通过合作网站登录</div>
					<a href="javascript:void(0)" onclick="toQzoneLogin()"></a>
				</div>
				<div class="current">
					当前有<p><?php global $db; echo $db->num_rows($db->query("select cd_id from ".tname('session')." ")); ?></p>个帅哥美女在线！
				</div>
				<ul class="clearfix">
					<?php
						global $db;
        					$query = $db->query("select cd_uid,cd_uname from ".tname('session')." order by cd_logintime desc LIMIT 0,8");
        					while ($row = $db->fetch_array($query)) {
							echo '<li><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank"><img src="'.getavatar($row['cd_uid'],48).'" /></a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	getcity('','ReI_sheng','','ReI_shi');
	</script>
	<?php } ?>
	<div class="bottom">
		<div class="content"><?php include "source/module/system/footer.php"; ?></div>
	</div>
</body>
</html>