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
   <h2 class="mdBoxHdTit">�һ�����</h2>
  </div>
  <div class="mdBoxBd clearfix">
   <div class="form-box getPass-form">
<form method="get" onsubmit="lostpasswd();return false;">
<ul>
<li class="form-item clearfix"><label class="label">��¼�ʺţ�</label><input type="text" id="ReI_1" class="input" /><span id="Re_1" class="tips">���������ĵ�¼�ʺš�</span></li>
<li class="form-item clearfix"><label class="label">�ܱ����⣺</label><input type="text" id="ReI_2" class="input" /><span id="Re_2" class="tips">���������������õ��ܱ����⡣</span></li>
<li class="form-item clearfix"><label class="label">�ܱ��𰸣�</label><input type="password" id="ReI_3" class="input" /><span id="Re_3" class="tips">���������������õ��ܱ��𰸡�</span></li>
<li class="form-item clearfix"><label class="label">�������룺</label><input type="password" id="ReI_4" class="input" /><span id="Re_4" class="tips">����������6λ�����ַ���Ϊ���롣</span></li>
<li class="form-item clearfix"><label class="label">ȷ�����룺</label><input type="password" id="ReI_5" class="input" /><span id="Re_5" class="tips">�ٴ��������룬��ȷ��������������</span></li>
<li class="form-item clearfix"><label class="label">��֤�룺</label><input type="text" id="ReI_6" style="width:36px;" maxlength="4" class="input" autocomplete="off" />&nbsp;<script type="text/javascript">seccode();</script>&nbsp;<a href="javascript:updateseccode()">����</a><span id="Re_6" class="tips">�����������֤�룬�翴���������һ����</span></li>
</ul>
<div class="btn-group clearfix" style="padding:10px 0 0 150px;">
<input type="submit" value="�һ�����" class="btnGetPass" />
</div>
</form>
</div>
<div class="guess">
<h3>�������룺</h3>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=login'); ?>" style="color:#090;">ֱ�ӵ�¼&gt;&gt;</a></p>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=register'); ?>">����ע��</a></p>
<h4><strong>ͨ��������վ��¼</strong>��</h4>
<ul class="logoIcon clearfix">
<li><a class="qqlogin" href="javascript:void(0)" onclick="toQzoneLogin()"><span class="icon-logo icon-qq"></span><span class="icon-text">QQ�ʺ�</span></a></li>
</ul>
</div>
  </div>
 </div>
</div>