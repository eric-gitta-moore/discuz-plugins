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
<div class="box login clearfix user-login">
 <div class="login-left"> <a class="go-register" href="<?php echo cd_upath; ?>" target="_blank"></a>
  <p> <strong>ע�����</strong><br>
   �ղ��Լ�ϲ�������ֺ�����<br>
   �����Լ�������ѡ��<br>
   ������һ������Լ������� </p>
 </div>
 <div class="login-right">
  <div class="login-box bgWrite">
   <div class="hd clearfix">
    <h2 class="current clearfix"><span style="float:left; width:100px;">��Ա��¼</span></h2>
   </div>
   <form method="get" onsubmit="login();return false;">
    <div class="bd login-form userLogin-form">
     <div class="form-box">
      <ul>
       <li class="form-item clearfix">
        <label class="label">�û�����</label>
        <input type="text" id="ReI_1" class="input" />
       </li>
       <li class="form-item clearfix">
        <label class="label">���룺</label>
        <input type="password" id="ReI_2" class="input" />
       </li>
       <li class="form-item clearfix remember">
        <label class="label">&nbsp;</label>
        <a href="javascript:updateseccode()">����һ��</a>&nbsp;<script type="text/javascript">seccode();</script>&nbsp;<input type="text" id="ReI_3" style="width:36px;" maxlength="4" class="input" autocomplete="off" />&nbsp;&nbsp;&nbsp;<a class="no-pass" href="<?php echo cd_webpath.rewrite_url('user.php?do=lostpasswd'); ?>">��������</a></li>
      </ul>
      <div style="padding:0 0 20px 115px;" class="btn-group clearfix">
       <input type="submit" value="������¼" class="btnDenglu" />
      </div>
     </div>
    </div>
   </form>
   <div class="bt"><a href="<?php echo cd_webpath.rewrite_url('user.php?do=register'); ?>"></a></div>
  </div>
  <div class="other-login">
   <ul class="logoIcon clearfix">
   <li>ͨ��������վ��¼��</li>
   <li><a class="qqlogin" href="javascript:void(0)" onclick="toQzoneLogin()"><span class="icon-logo icon-qq"></span><span class="icon-text">QQ�ʺ�</span></a></li>
   <li id="Re_1"></li>
   <li id="Re_2"></li>
   <li id="Re_3"></li>
   </ul>
  </div>
 </div>
</div>