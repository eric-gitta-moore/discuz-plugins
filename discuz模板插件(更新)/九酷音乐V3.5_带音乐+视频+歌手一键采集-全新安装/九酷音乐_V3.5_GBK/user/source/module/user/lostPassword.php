<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312" />
<title>�һ�����</title>
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/space/css/passport.css" />
<link href="<?php echo cd_webpath; ?>source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/lib.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript">
var site_domain="<?php echo cd_webpath; ?>";
var zone_domain="<?php echo cd_upath; ?>";
var login_url="<?php echo cd_upath.rewrite_url('index.php?p=user&a=login'); ?>";
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
</script>
</head>
<body>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<div class="header">
	<div class="header_con">
		<div class="logo"> </div>
		<div class="right">
				<a class="home" href="<?php echo cd_webpath; ?>">��վ��ҳ</a>
				<p>|</p>
				<a class="help"href="<?php echo cd_upath; ?>">��Ա����</a>
		</div>
	</div>
</div>
<div class="retrieve_body">
	<div class="retrieve_title">�һ�����</div>
	<div class="retrieve_box">
		<div class="register_box_left">
			<form method="get" onsubmit="lostpasswd();return false;">
			<ul>
				<li>
					<div class="rM_title">��¼�ʺ�</div>
					<div class="rM_input"><input type="text" id="ReI_1" class="input_normal" /></div>
					<div id="Re_1"><div class="err_message"><span class="icon">���������ĵ�¼�ʺš�</span></div></div>
				</li>
				<li>
					<div class="rM_title">�ܱ�����</div>
					<div class="rM_input"><input type="text" id="ReI_2" class="input_normal" /></div>
					<div id="Re_2"><div class="err_message"><span class="icon">���������������õ��ܱ����⡣</span></div></div>
				</li>
				<li>
					<div class="rM_title">�ܱ���</div>
					<div class="rM_input"><input type="text" id="ReI_3" class="input_normal" /></div>
					<div id="Re_3"><div class="err_message"><span class="icon">���������������õ��ܱ��𰸡�</span></div></div>
				</li>
				<li>
					<div class="rM_title">��������</div>
					<div class="rM_input"><input type="text" id="ReI_4" class="input_normal" /></div>
					<div id="Re_4"><div class="err_message"><span class="icon">����������6λ�����ַ���Ϊ���롣</span></div></div>
				</li>
				<li>
					<div class="rM_title">ȷ������</div>
					<div class="rM_input"><input type="text" id="ReI_5" class="input_normal" /></div>
					<div id="Re_5"><div class="err_message"><span class="icon">�ٴ��������룬��ȷ��������������</span></div></div>
				</li>
				<li>
					<div class="title">��֤��</div>
					<div class="input">
						<input id="ReI_6" class="input_normal" type="text" maxlength="4" autocomplete="off" style="width:70px;" />
					</div>
					<div class="vcode">
						<div class="noleft">
							<script type="text/javascript">seccode();</script>
						</div>
						<div class="reloadCode">
							<a href="javascript:updateseccode()">�����壿��һ��</a>
						</div>
					</div>
					<div id="Re_6"></div>
				</li>
				<li><div class="rM_noleft"><input class="submit" type="submit" value="�һ�����" /></div></li>
			</ul>
			</form>
		</div>
	</div>
</div>
<div class="bottom">
	<div class="content"><?php include "source/module/system/footer.php"; ?></div>
</div>
</body>
</html>