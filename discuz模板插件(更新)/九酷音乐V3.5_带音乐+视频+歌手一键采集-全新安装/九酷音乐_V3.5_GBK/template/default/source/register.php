<?php if(cd_usery=="no"){
echo "<div class=\"box bgWrite mt\"><div class=\"diange\">";
echo "<div class=\"diangeHd clearfix\"><div class=\"diangeNav\"><ul class=\"step-nav clearfix\"><li class=\"current\"><span class=\"t-t\">��Ϣ��ʾ</span></li></ul></div></div>";
echo "<div class=\"diangeFrom diange-form\"><div class=\"notice\"><div class=\"error\">��Ǹ����վ�ݲ������»�Աע�ᣡ</div></div></div>";
echo "<div class=\"diangeBd step03 clearfix\"><div class=\"btn-group clearfix\" style=\"margin:20px 0 0 320px;\">";
echo "<a href=\"javascript:history.go(-1);\" class=\"sDian1\">������һҳ</a>";
echo "<a href=\"".cd_webpath."\" class=\"sDian2\">������ҳ</a>";
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
   <h2 class="mdBoxHdTit">����ע��</h2>
  </div>
  <div class="mdBoxBd clearfix">
   <div class="form-box register-form">
<form method="get" onsubmit="register();return false;">
<ul>
<li class="form-item clearfix"><label class="label">�����ʺţ�</label><input type="text" id="ReI_1" class="input" /><span id="Re_1" class="tips">����3��15���ַ�֮�䣬�����пո�� < > ' " / \ ���ַ���</span></li>
<li class="form-item clearfix"><label class="label">�������룺</label><input type="password" id="ReI_2" class="input" /><span id="Re_2" class="tips">������6λ�����ַ���Ϊ���롣</span></li>
<li class="form-item clearfix"><label class="label">ȷ�����룺</label><input type="password" id="ReI_3" class="input" /><span id="Re_3" class="tips">�ٴ��������룬��ȷ����������</span></li>
<li class="form-item clearfix"><label class="label">���֣�</label><input type="text" id="ReI_4" class="input" /><span id="Re_4" class="tips">����2��12���ַ�֮�䣬�����пո����ֻ� < > ' " / \ ���ַ���</span></li>
<li class="form-item clearfix"><label class="label">�Ա�</label>
<select id="ReI_5">
<option value="">ѡ</option>
<option value="1">˧��</option>
<option value="0">��Ů</option>
</select>
<span id="Re_5" class="tips"></span></li>
<li class="form-item clearfix"><label class="label">���գ�</label>
<select id="ReI_year">
<option value="">��</option>
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
<option value="">��</option>
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
<option value="">��</option>
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
<li class="form-item clearfix"><label class="label">���У�</label>
<select onchange="javascript:gettown(this.options[this.selectedIndex].value,&quot;&quot;,&quot;ReI_shi&quot;)" id="ReI_sheng">
<option value="">ʡ</option>
</select>
<select id="ReI_shi">
<option value="">��</option>
</select>
<span id="Re_city" class="tips"></span></li>
<li class="form-item clearfix"><label class="label">���䣺</label><input type="text" id="ReI_11" class="input" /><span id="Re_11" class="tips">�����������õ�Email�������䡣</span></li>
<li class="form-item clearfix"><label class="label">Q Q��</label><input type="text" id="ReI_12" class="input" /><span id="Re_12" class="tips">����������QQ���롣</span></li>
<li class="form-item clearfix"><label class="label">��֤�룺</label><input type="text" id="ReI_13" style="width:36px;" maxlength="4" class="input" autocomplete="off" />&nbsp;<script type="text/javascript">seccode();</script>&nbsp;<a href="javascript:updateseccode()">����</a><span id="Re_13" class="tips">�����������֤�룬�翴���������һ����</span></li>
</ul>
<div class="btn-group clearfix" style="padding:10px 0 0 120px;">
<input type="submit" class="btnZhuce" value="����ע��" />
</div>
</form>
</div>
<div class="guess">
<h3>�������룺</h3>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=login'); ?>" style="color:#090;">ֱ�ӵ�¼&gt;&gt;</a></p>
<p><a href="<?php echo cd_webpath.rewrite_url('user.php?do=lostpasswd'); ?>">�һ�����</a></p>
<h4><strong>ͨ��������վ��¼</strong>��</h4>
<ul class="logoIcon clearfix">
<li><a class="qqlogin" href="javascript:void(0)" onclick="toQzoneLogin()"><span class="icon-logo icon-qq"></span><span class="icon-text">QQ�ʺ�</span></a></li>
</ul>
</div>
  </div>
 </div>
</div>
<script type="text/javascript">
getcity('','ReI_sheng','','ReI_shi');
</script>
<?php } ?>