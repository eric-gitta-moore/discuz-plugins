<?php
Administrator(2);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>ȫ������</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
function change(type){
        if (type==1){
            lockmail.style.display='';
        }
        if (type==2){
            lockmail.style.display='none';
        }
        if (type==3){
            webcodea.style.display='';
        }
        if (type==4){
            webcodea.style.display='none';
        }
        if (type==5){
            weboffa.style.display='none';
        }
        if (type==6){
            weboffa.style.display='';
        }
        if (type==7){
            webhtml.style.display='none';
        }
        if (type==8){
            webhtml.style.display='';
        }
        if (type==9){
            webhtml.style.display='none';
        }
        if (type==10){
            uptype.style.display='';
        }
        if (type==11){
            uptype.style.display='none';
        }
        if (type==12){
            cd_remoteftp.style.display='';
            cd_remoteqiniu.style.display='none';
            cd_remotebaidu.style.display='none';
            cd_remoteoss.style.display='none';
        }
        if (type==13){
            cd_remoteqiniu.style.display='';
            cd_remoteftp.style.display='none';
            cd_remotebaidu.style.display='none';
            cd_remoteoss.style.display='none';
        }
        if (type==14){
            cd_remotebaidu.style.display='';
            cd_remoteftp.style.display='none';
            cd_remoteqiniu.style.display='none';
            cd_remoteoss.style.display='none';
        }
        if (type==15){
            cd_remoteoss.style.display='';
            cd_remoteftp.style.display='none';
            cd_remoteqiniu.style.display='none';
            cd_remotebaidu.style.display='none';
        }
        if (type==16){
            fsmessage.style.display='';
        }
        if (type==17){
            fsmessage.style.display='none';
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'save':
		save();
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php function main(){
global $action;
?>
<form method="post" action="?iframe=config&action=save">
<div class="container" style="<?php if($action==""){echo "display:";}else{echo "display:none";} ?>;">
<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ȫ�� - վ����Ϣ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ȫ��&nbsp;&raquo;&nbsp;վ����Ϣ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=վ����Ϣ&url=".$_SERVER['QUERY_STRING']."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>վ����Ϣ</h3><ul class="tab1">
<li class="current"><a href="?iframe=config"><span>վ����Ϣ</span></a></li>
<li><a href="?iframe=config&action=html"><span>������Ϣ</span></a></li>
<li><a href="?iframe=config&action=upload"><span>�ϴ���Ϣ</span></a></li>
<li><a href="?iframe=config&action=pay"><span>֧����Ϣ</span></a></li>
<li><a href="?iframe=config&action=user"><span>��Ա��Ϣ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">��������</th></tr>
<tr><td colspan="2" class="td27">վ������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webname; ?>" name="cd_webname"></td><td class="vtop tips2">վ�����ƣ�����ʾ����������ڱ����λ��</td></tr>
<tr><td colspan="2" class="td27">վ������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_weburl; ?>" name="cd_weburl"></td><td class="vtop tips2">վ������������Ϊ������ʾ��ģ���ҳ��ĵײ�</td></tr>
<tr><td colspan="2" class="td27">�ؼ��ִ�:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_keywords; ?>" name="cd_keywords"></td><td class="vtop tips2">�ؼ��ִʣ���������ģ���ҳ���ͷ��</td></tr>
<tr><td colspan="2" class="td27">վ������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_description; ?>" name="cd_description"></td><td class="vtop tips2">վ����������������ģ���ҳ���ͷ��</td></tr>
<tr><td colspan="2" class="td27">�ͷ� QQ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webqq; ?>" name="cd_webqq" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">�ͷ� QQ������ʾ��ģ���ҳ��ĵײ���ͷ��</td></tr>
<tr><td colspan="2" class="td27">������Ϣ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webicp; ?>" name="cd_webicp"></td><td class="vtop tips2">������Ϣ������ʾ��ģ���ҳ��ĵײ�</td></tr>
<tr><td colspan="2" class="td27">�ͷ� E-mail:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webmail; ?>" name="cd_webmail"></td><td class="vtop tips2">�ͷ� E-mail������Ϊϵͳ���ʼ�ʱ�ķ����˵�ַ</td></tr>
<tr><td colspan="2" class="td27">�ʼ����񿪹�:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_lockmail==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_lockmail" value="0" onclick="change(1);"<?php if(cd_lockmail==0){echo " checked";} ?>>&nbsp;����</li>
<?php if(cd_lockmail==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_lockmail" value="1" onclick="change(2);"<?php if(cd_lockmail==1){echo " checked";} ?>>&nbsp;�ر�</li>
</ul>
</td><td class="vtop lightnum">ע�⣺�ڿ���������£���� ������Ϣ �������󣬽�Ӱ��ǰ̨ע����ʼ�����</td></tr>
<tbody class="sub" id="lockmail"<?php if(cd_lockmail<>0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">SMTP ������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webmailsmtp; ?>" name="cd_webmailsmtp"></td><td class="vtop tips2">ͨ��SMTPЭ�鷢�ʼ�ʱ��ָ���ķ�����</td></tr>
<tr><td colspan="2" class="td27">E-mail ����:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webmailpswd; ?>" name="cd_webmailpswd"></td><td class="vtop tips2">ͨ��SMTPЭ�鷢�ʼ�ʱ��Ҫ��֤������</td></tr>
</tbody>
<tr><td colspan="2" class="td27">��̨���ʿ���:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_webcodea==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_webcodea" value="0" onclick="change(3);"<?php if(cd_webcodea==0){echo " checked";} ?>>&nbsp;����</li>
<?php if(cd_webcodea==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_webcodea" value="1" onclick="change(4);"<?php if(cd_webcodea==1){echo " checked";} ?>>&nbsp;�ر�</li>
</ul>
</td><td class="vtop tips2">Ϊ��վ�㰲ȫ��������鿪��</td></tr>
<tbody class="sub" id="webcodea"<?php if(cd_webcodea<>0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">��֤��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webcodeb; ?>" name="cd_webcodeb"></td><td class="vtop tips2">����Ա��¼��̨ʱ�İ�ȫ����</td></tr>
</tbody>
<tr><td colspan="2" class="td27">ͳ�ƴ���:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="cd_webstat" cols="50" class="tarea"><?php echo stripslashes(cd_webstat); ?></textarea></td><td class="vtop tips2">ҳ��ײ���ʾ�ĵ�����ͳ��</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">�ر�վ��</th></tr>
<tr><td colspan="2" class="td27">վ��ά������:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_weboffa==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_weboffa" value="0" onclick="change(5);"<?php if(cd_weboffa==0){echo " checked";} ?>>&nbsp;����</li>
<?php if(cd_weboffa==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_weboffa" value="1" onclick="change(6);"<?php if(cd_weboffa==1){echo " checked";} ?>>&nbsp;ά��</li>
</ul>
</td><td class="vtop tips2">��ʱ��վ��رգ�ǰ̨�޷����ʣ�����Ӱ���̨����</td></tr>
<tbody class="sub" id="weboffa"<?php if(cd_weboffa<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">ά��˵��:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="cd_weboffb" cols="50" class="tarea"><?php echo cd_weboffb; ?></textarea></td><td class="vtop tips2">ǰ̨��ʾ��ά����Ϣ</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="�ύ" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="html"){echo "display:";}else{echo "display:none";} ?>;">
<?php if($action=="html"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ȫ�� - ������Ϣ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ȫ��&nbsp;&raquo;&nbsp;������Ϣ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=������Ϣ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>������Ϣ</h3><ul class="tab1">
<li><a href="?iframe=config"><span>վ����Ϣ</span></a></li>
<li class="current"><a href="?iframe=config&action=html"><span>������Ϣ</span></a></li>
<li><a href="?iframe=config&action=upload"><span>�ϴ���Ϣ</span></a></li>
<li><a href="?iframe=config&action=pay"><span>֧����Ϣ</span></a></li>
<li><a href="?iframe=config&action=user"><span>��Ա��Ϣ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">��������</th></tr>
<tr><td colspan="2" class="td27">վ�㻺�濪��:</td></tr>
<tr><td class="vtop rowform">
<select name="cd_iscache">
<option value="1"<?php if(cd_iscache==1){echo " selected";} ?>>����</option>
<option value="0"<?php if(cd_iscache==0){echo " selected";} ?>>�ر�</option>
</select>
</td><td class="vtop tips2">�����ܼ����ڴ����ģ��Ӷ������վ����Ч��</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">����ģʽ</th></tr>
<tr><td colspan="2" class="td27">��Ա����:</td></tr>
<tr><td class="vtop rowform">
<select name="cd_userhtml">
<option value="0"<?php if(cd_userhtml==0){echo " selected";} ?>>��̬</option>
<option value="1"<?php if(cd_userhtml==1){echo " selected";} ?>>α��̬</option>
</select>
</td><td class="vtop tips2">������ķ�������֧�� Rewrite����ѡ�񡰶�̬��</td></tr>
<tr><td colspan="2" class="td27">ģ��ҳ��:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_webhtml==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_webhtml" value="1" onclick="change(7);"<?php if(cd_webhtml==1){echo " checked";} ?>>&nbsp;��̬</li>
<?php if(cd_webhtml==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_webhtml" value="2" onclick="change(8);"<?php if(cd_webhtml==2){echo " checked";} ?>>&nbsp;��̬</li>
<?php if(cd_webhtml==3){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_webhtml" value="3" onclick="change(9);"<?php if(cd_webhtml==3){echo " checked";} ?>>&nbsp;α��̬</li>
</ul>
<input type="hidden" name="cd_templatedir" value="<?php echo cd_templatedir; ?>">
<input type="hidden" name="cd_ucenter" value="<?php echo cd_ucenter; ?>">
</td><td class="vtop tips2">������ķ�������֧�� Rewrite����ѡ�񡰶�̬���򡰾�̬��</td></tr>
<tbody class="sub" id="webhtml"<?php if(cd_webhtml<>2){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">��Ŀҳ����·��:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo cd_calistfolder; ?>" name="cd_calistfolder"></li>
<li><select onchange="cd_calistfolder.value=this.value;">
<option value="[ϵͳĿ¼]list/[��Ŀ���]/[��ҳ���].html">ϵͳ��ʽ</option>
<option value="[ϵͳĿ¼]list/[Ӣ�ı���]/[��ҳ���].html">��ʽһ</option>
</select></li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ��ϵͳ��ʽ��</td></tr>
<tr><td colspan="2" class="td27">����ҳ����·��:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo cd_caplayfolder; ?>" name="cd_caplayfolder"></li>
<li><select onchange="cd_caplayfolder.value=this.value;">
<option value="[ϵͳĿ¼]song/[���ֱ��].html">ϵͳ��ʽ</option>
<option value="[ϵͳĿ¼]song/[��ĸ���].html">��ʽһ</option>
<option value="[ϵͳĿ¼]song/[���ܱ��].html">��ʽ��</option>
</select></li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ��ϵͳ��ʽ��</td></tr>
<tr><td colspan="2" class="td27">ר��ҳ����·��:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo cd_caspecialfolder; ?>" name="cd_caspecialfolder"></li>
<li><select onchange="cd_caspecialfolder.value=this.value;">
<option value="[ϵͳĿ¼]album/[���ֱ��].html">ϵͳ��ʽ</option>
<option value="[ϵͳĿ¼]album/[��ĸ���].html">��ʽһ</option>
<option value="[ϵͳĿ¼]album/[���ܱ��].html">��ʽ��</option>
</select></li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ��ϵͳ��ʽ��</td></tr>
<tr><td colspan="2" class="td27">����ҳ����·��:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo cd_casingerfolder; ?>" name="cd_casingerfolder"></li>
<li><select onchange="cd_casingerfolder.value=this.value;">
<option value="[ϵͳĿ¼]singer/[���ֱ��].html">ϵͳ��ʽ</option>
<option value="[ϵͳĿ¼]singer/[��ĸ���].html">��ʽһ</option>
<option value="[ϵͳĿ¼]singer/[���ܱ��].html">��ʽ��</option>
</select></li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ��ϵͳ��ʽ��</td></tr>
<tr><td colspan="2" class="td27">��Ƶ��Ŀҳ����·��:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo cd_cavideocfolder; ?>" name="cd_cavideocfolder"></li>
<li><select onchange="cd_cavideocfolder.value=this.value;">
<option value="[ϵͳĿ¼]class/[��Ŀ���]/[��ҳ���].html">ϵͳ��ʽ</option>
<option value="[ϵͳĿ¼]video/[��Ŀ���]/[��ҳ���].html">��ʽһ</option>
</select></li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ��ϵͳ��ʽ��</td></tr>
<tr><td colspan="2" class="td27">��Ƶҳ����·��:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo cd_cavideofolder; ?>" name="cd_cavideofolder"></li>
<li><select onchange="cd_cavideofolder.value=this.value;">
<option value="[ϵͳĿ¼]video/[���ֱ��].html">ϵͳ��ʽ</option>
<option value="[ϵͳĿ¼]video/[��ĸ���].html">��ʽһ</option>
<option value="[ϵͳĿ¼]video/[���ܱ��].html">��ʽ��</option>
</select></li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ��ϵͳ��ʽ��</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="�ύ" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="upload"){echo "display:";}else{echo "display:none";} ?>;">
<?php if($action=="upload"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ȫ�� - �ϴ���Ϣ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ȫ��&nbsp;&raquo;&nbsp;�ϴ���Ϣ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=�ϴ���Ϣ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>�ϴ���Ϣ</h3><ul class="tab1">
<li><a href="?iframe=config"><span>վ����Ϣ</span></a></li>
<li><a href="?iframe=config&action=html"><span>������Ϣ</span></a></li>
<li class="current"><a href="?iframe=config&action=upload"><span>�ϴ���Ϣ</span></a></li>
<li><a href="?iframe=config&action=pay"><span>֧����Ϣ</span></a></li>
<li><a href="?iframe=config&action=user"><span>��Ա��Ϣ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">��������</th></tr>
<tr><td colspan="2" class="td27">�ϴ�����:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_uptype==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_uptype" value="1" onclick="change(10);"<?php if(cd_uptype==1){echo " checked";} ?>>&nbsp;����</li>
<?php if(cd_uptype==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_uptype" value="0" onclick="change(11);"<?php if(cd_uptype==0){echo " checked";} ?>>&nbsp;�ر�</li>
</ul>
</td><td class="vtop tips2">�رպ��û����޷��ϴ������ļ�</td></tr>
<tbody class="sub" id="uptype"<?php if(cd_uptype<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">��Ƶ����ĸ�ʽ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_upmext; ?>" name="cd_upmext"></td><td class="vtop tips2">�������ͼ��á�;������</td></tr>
<tr><td colspan="2" class="td27">��Ƶ����ĸ�ʽ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_upvext; ?>" name="cd_upvext"></td><td class="vtop tips2">�������ͼ��á�;������</td></tr>
<tr><td colspan="2" class="td27">��Ƶ����������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_upkbps; ?>" name="cd_upkbps" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����Ϊ0ʱ���ر����ʼ�⣬��λ��kbps</td></tr>
<tr><td colspan="2" class="td27">�ϴ��ļ��Ĵ�С:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_upsize; ?>" name="cd_upsize" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">MB</td></tr>
</tbody>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">Զ������</th></tr>
<tr><td colspan="2" class="td27">�ϴ���ʽ:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_remoteup==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_remoteup" value="1" onclick="change(12);"<?php if(cd_remoteup==1){echo " checked";} ?>>&nbsp;FTP</li>
<?php if(cd_remoteup==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_remoteup" value="2" onclick="change(13);"<?php if(cd_remoteup==2){echo " checked";} ?>>&nbsp;QINIU</li>
<?php if(cd_remoteup==3){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_remoteup" value="3" onclick="change(14);"<?php if(cd_remoteup==3){echo " checked";} ?>>&nbsp;BAIDU</li>
<?php if(cd_remoteup==4){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_remoteup" value="4" onclick="change(15);"<?php if(cd_remoteup==4){echo " checked";} ?>>&nbsp;OSS</li>
</ul>
</td><td class="vtop tips2">���ַ�ʽ�ܡ����ط������ϴ���ɡ���Լ��</td></tr>
<tbody class="sub" id="cd_remoteftp"<?php if(cd_remoteup>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">FTP��ַ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftphost; ?>" name="cd_ftphost"></td><td class="vtop tips2">Զ�̵�¼�ĵ�ַ��һ��Ϊip��url��ַ</td></tr>
<tr><td colspan="2" class="td27">FTP�û���:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftpuser; ?>" name="cd_ftpuser"></td><td class="vtop tips2">Զ�̵�¼���ʺ�</td></tr>
<tr><td colspan="2" class="td27">FTP����:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftppass; ?>" name="cd_ftppass"></td><td class="vtop tips2">Զ�̵�¼������</td></tr>
<tr><td colspan="2" class="td27">FTP������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftpdomain; ?>" name="cd_ftpdomain"></td><td class="vtop tips2">ͨ�������������ʻ�����FTP�е��ļ�����ǰ����Ҫ�ӡ�http://�������������ӡ�/��</td></tr>
<tr><td colspan="2" class="td27">FTP�˿�:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftpport; ?>" name="cd_ftpport" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">Ĭ��Ϊ��21��</td></tr>
<tr><td colspan="2" class="td27">FTP�ؽ�Ŀ¼:</td></tr>
<tr><td class="vtop rowform">
<select name="cd_ftptype">
<option value="1"<?php if(cd_ftptype==1){echo " selected";} ?>>����</option>
<option value="0"<?php if(cd_ftptype==0){echo " selected";} ?>>�ر�</option>
</select>
</td><td class="vtop tips2">����ϴ�������·�����������Զ��½�������ǰ����ȷ���Ƿ��н���Ȩ��</td></tr>
<tr><td colspan="2" class="td27">FTP��Ŀ¼:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftproot; ?>" name="cd_ftproot"></td><td class="vtop tips2">һ��Ϊ wwwroot|web|home���� wwwroot/music�����������ӡ�/��</td></tr>
<tr><td colspan="2" class="td27">FTP��·��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ftpdir; ?>" name="cd_ftpdir"></td><td class="vtop tips2">�ļ����·������ /data/attachment/��ǰ����Ҫ�ӡ�/��</td></tr>
</tbody>
<tbody class="sub" id="cd_remoteqiniu"<?php if(cd_remoteup<>2){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">BucketName:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_qiniubucket; ?>" name="cd_qiniubucket"></td><td class="vtop tips2">��ţ���ƴ洢Bucket</td></tr>
<tr><td colspan="2" class="td27">Access Key ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_qiniukeyid; ?>" name="cd_qiniukeyid"></td><td class="vtop tips2">��ţ���ƴ洢KeyID</td></tr>
<tr><td colspan="2" class="td27">Access Key Secret:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_qiniukeysecret; ?>" name="cd_qiniukeysecret"></td><td class="vtop tips2">��ţ���ƴ洢KeySecret</td></tr>
</tbody>
<tbody class="sub" id="cd_remotebaidu"<?php if(cd_remoteup<>3){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">BucketName:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_baidubucket; ?>" name="cd_baidubucket"></td><td class="vtop tips2">�ٶȵ��ƴ洢Bucket</td></tr>
<tr><td colspan="2" class="td27">Access Key ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_baidukeyid; ?>" name="cd_baidukeyid"></td><td class="vtop tips2">�ٶȵ��ƴ洢KeyID</td></tr>
<tr><td colspan="2" class="td27">Access Key Secret:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_baidukeysecret; ?>" name="cd_baidukeysecret"></td><td class="vtop tips2">�ٶȵ��ƴ洢KeySecret</td></tr>
</tbody>
<tbody class="sub" id="cd_remoteoss"<?php if(cd_remoteup<4){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">BucketName:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_ossbucket; ?>" name="cd_ossbucket"></td><td class="vtop tips2">�����ƵĿ��Ŵ洢����Bucket</td></tr>
<tr><td colspan="2" class="td27">Access Key ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_osskeyid; ?>" name="cd_osskeyid"></td><td class="vtop tips2">�����ƵĿ��Ŵ洢����KeyID</td></tr>
<tr><td colspan="2" class="td27">Access Key Secret:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_osskeysecret; ?>" name="cd_osskeysecret"></td><td class="vtop tips2">�����ƵĿ��Ŵ洢����KeySecret</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="�ύ" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="pay"){echo "display:";}else{echo "display:none";} ?>;">
<?php if($action=="pay"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ȫ�� - ֧����Ϣ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ȫ��&nbsp;&raquo;&nbsp;֧����Ϣ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=֧����Ϣ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>֧����Ϣ</h3><ul class="tab1">
<li><a href="?iframe=config"><span>վ����Ϣ</span></a></li>
<li><a href="?iframe=config&action=html"><span>������Ϣ</span></a></li>
<li><a href="?iframe=config&action=upload"><span>�ϴ���Ϣ</span></a></li>
<li class="current"><a href="?iframe=config&action=pay"><span>֧����Ϣ</span></a></li>
<li><a href="?iframe=config&action=user"><span>��Ա��Ϣ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">֧����</th></tr>
<tr><td colspan="2" class="td27">���������ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_alipayid; ?>" name="cd_alipayid"></td><td class="vtop tips2">��2088��ͷ��16λ������</td></tr>
<tr><td colspan="2" class="td27">��ȫ������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_alipaykey; ?>" name="cd_alipaykey"></td><td class="vtop tips2">�����ֺ���ĸ��ɵ�32λ�ַ�</td></tr>
<tr><td colspan="2" class="td27">֧�����˺�:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_alipayuid; ?>" name="cd_alipayuid"></td><td class="vtop tips2">ǩԼ֧�����˺Ż�����֧�����ʻ�</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="�ύ" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="user"){echo "display:";}else{echo "display:none";} ?>;">
<?php if($action=="user"){echo "<script type=\"text/javascript\">parent.document.title = 'QianWei Music Board �������� - ȫ�� - ��Ա��Ϣ';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='ȫ��&nbsp;&raquo;&nbsp;��Ա��Ϣ&nbsp;&nbsp;<a target=\"main\" title=\"��ӵ����ò���\" href=\"?iframe=menu&action=getadd&name=��Ա��Ϣ&url=".ReplaceStr($_SERVER['QUERY_STRING'],"&","%26")."\">[+]</a>';</script>";} ?>
<div class="floattop"><div class="itemtitle"><h3>��Ա��Ϣ</h3><ul class="tab1">
<li><a href="?iframe=config"><span>վ����Ϣ</span></a></li>
<li><a href="?iframe=config&action=html"><span>������Ϣ</span></a></li>
<li><a href="?iframe=config&action=upload"><span>�ϴ���Ϣ</span></a></li>
<li><a href="?iframe=config&action=pay"><span>֧����Ϣ</span></a></li>
<li class="current"><a href="?iframe=config&action=user"><span>��Ա��Ϣ</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">QQ��¼</th></tr>
<tr><td colspan="2" class="td27">APP ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_qqappid; ?>" name="cd_qqappid"></td><td class="vtop tips2">QQ������վ��APPID</td></tr>
<tr><td colspan="2" class="td27">APP KEY:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_qqappkey; ?>" name="cd_qqappkey"></td><td class="vtop tips2">QQ������վ��APPKEY</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">��������</th></tr>
<tr><td colspan="2" class="td27">��Աע�Ὺ��:</td></tr>
<tr><td class="vtop rowform">
<select name="cd_usery">
<option value="yes"<?php if(cd_usery=="yes"){echo " selected";} ?>>����</option>
<option value="no"<?php if(cd_usery=="no"){echo " selected";} ?>>�ر�</option>
</select>
</td><td class="vtop tips2">Ĭ��Ϊ�����š�</td></tr>
<tr><td colspan="2" class="td27">ע���Ƿ��Ͷ���Ϣ:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(cd_fsmessage=="yes"){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_fsmessage" value="yes" onclick="change(16);"<?php if(cd_fsmessage=="yes"){echo " checked";} ?>>&nbsp;��</li>
<?php if(cd_fsmessage=="no"){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="cd_fsmessage" value="no" onclick="change(17);"<?php if(cd_fsmessage=="no"){echo " checked";} ?>>&nbsp;��</li>
</ul>
</td><td class="vtop tips2">Ĭ��Ϊ���ǡ�</td></tr>
<tbody class="sub" id="fsmessage"<?php if(cd_fsmessage!=="yes"){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2" class="td27">ע�ᷢ�Ͷ���Ϣ����:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="cd_bodymessage" cols="50" class="tarea"><?php echo cd_bodymessage; ?></textarea></td><td class="vtop tips2">�û���¼��Ա����ʱ�յ��Ķ���Ϣ</td></tr>
</tbody>
<tr><td colspan="2" class="td27">��Ա�������ֿ���:</td></tr>
<tr><td class="vtop rowform">
<select name="cd_usermusic">
<option value="yes"<?php if(cd_usermusic=="yes"){echo " selected";} ?>>����</option>
<option value="no"<?php if(cd_usermusic=="no"){echo " selected";} ?>>�ر�</option>
</select>
</td><td class="vtop tips2">Ĭ��Ϊ��������</td></tr>
<tr><td colspan="2" class="td27">��¼��½����ʱ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_onlinehold; ?>" name="cd_onlinehold" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">��</td></tr>
<tr><td colspan="2" class="td27">���˶�̬��������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_feedday; ?>" name="cd_feedday" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">��</td></tr>
<tr><td colspan="2" class="td27">������¼��������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_listenday; ?>" name="cd_listenday" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">��</td></tr>
<tr><td colspan="2" class="td27">֪ͨ��Ϣ��������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_notificationday; ?>" name="cd_notificationday" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">��</td></tr>
<tr><td colspan="2" class="td27">��Ա�ռ�Ƥ���۱�:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_webpoints; ?>" name="cd_webpoints" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td colspan="2" class="td27">ͨ����Ů��֤�������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_mmpoints; ?>" name="cd_mmpoints" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td colspan="2" class="td27">���������Զ�����������֤:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_checkmusicnum; ?>" name="cd_checkmusicnum" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����Ϊ0ʱ���ر��Զ�ģʽ����λ����</td></tr>
<tr><td colspan="2" class="td27">�û��ȼ�ÿ��һ���������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_upgradepoints; ?>" name="cd_upgradepoints" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">�㷨Ϊ���õ�ֵ�����û��ȼ�</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">������������</th></tr>
<tr><td colspan="2" class="td27">��ע���Ա��ʼ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_points; ?>" name="cd_points" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_userrank; ?>" name="cd_userrank" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">ÿ���½:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuaa; ?>" name="cd_pointsuaa" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuab; ?>" name="cd_pointsuab" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">���ʱ��˿ռ�:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuba; ?>" name="cd_pointsuba" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsubb; ?>" name="cd_pointsubb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsubc; ?>" name="cd_pointsubc" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���/����=ÿ������</td></tr>
<tr><td colspan="2" class="td27">����΢��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuca; ?>" name="cd_pointsuca" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsucb; ?>" name="cd_pointsucb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsucc; ?>" name="cd_pointsucc" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���/����=ÿ������</td></tr>
<tr><td colspan="2" class="td27">�ϴ���Ƭ:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuda; ?>" name="cd_pointsuda" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsudb; ?>" name="cd_pointsudb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsudc; ?>" name="cd_pointsudc" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���/����=ÿ������</td></tr>
<tr><td colspan="2" class="td27">�ϴ�����:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuea; ?>" name="cd_pointsuea" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsueb; ?>" name="cd_pointsueb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">�����˱���:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsufa; ?>" name="cd_pointsufa" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsufb; ?>" name="cd_pointsufb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsufc; ?>" name="cd_pointsufc" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���/����=ÿ������</td></tr>
<tr><td colspan="2" class="td27">����������:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsuga; ?>" name="cd_pointsuga" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsugb; ?>" name="cd_pointsugb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsugc; ?>" name="cd_pointsugc" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���/����=ÿ������</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">�ͷ���������</th></tr>
<tr><td colspan="2" class="td27">΢����ɾ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdaa; ?>" name="cd_pointsdaa" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdab; ?>" name="cd_pointsdab" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">��Ƭ��ɾ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdba; ?>" name="cd_pointsdba" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdbb; ?>" name="cd_pointsdbb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">���ֱ�ɾ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdca; ?>" name="cd_pointsdca" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdcb; ?>" name="cd_pointsdcb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">���۱�ɾ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdda; ?>" name="cd_pointsdda" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsddb; ?>" name="cd_pointsddb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="2" class="td27">���Ա�ɾ��:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdea; ?>" name="cd_pointsdea" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">���</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo cd_pointsdeb; ?>" name="cd_pointsdeb" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">����</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="�ύ" /></div></td></tr>
</table>
</div>
</form>
<?php
}
function save(){
if(!submitcheck('submit')){ShowMessage("����֤�������޷��ύ��","admin.php","infotitle3",3000,1);}
$cd_webname = SafeRequest("cd_webname","post");
$cd_weburl = SafeRequest("cd_weburl","post");
$cd_keywords = SafeRequest("cd_keywords","post");
$cd_description = SafeRequest("cd_description","post");
$cd_webqq = SafeRequest("cd_webqq","post");
$cd_webicp = SafeRequest("cd_webicp","post");
$cd_webmail = SafeRequest("cd_webmail","post");
$cd_lockmail = SafeRequest("cd_lockmail","post");
$cd_webmailsmtp = SafeRequest("cd_webmailsmtp","post");
$cd_webmailpswd = SafeRequest("cd_webmailpswd","post");
$cd_webcodea = SafeRequest("cd_webcodea","post");
$cd_webcodeb = SafeRequest("cd_webcodeb","post");
$cd_webstat = htmlspecialchars_decode(SafeRequest("cd_webstat","post"),ENT_QUOTES);
$cd_weboffa = SafeRequest("cd_weboffa","post");
$cd_weboffb = SafeRequest("cd_weboffb","post");
$cd_iscache = SafeRequest("cd_iscache","post");
$cd_userhtml = SafeRequest("cd_userhtml","post");
$cd_webhtml = SafeRequest("cd_webhtml","post");
$cd_templatedir = SafeRequest("cd_templatedir","post");
$cd_ucenter = SafeRequest("cd_ucenter","post");
$cd_calistfolder = SafeRequest("cd_calistfolder","post");
$cd_caplayfolder = SafeRequest("cd_caplayfolder","post");
$cd_caspecialfolder = SafeRequest("cd_caspecialfolder","post");
$cd_casingerfolder = SafeRequest("cd_casingerfolder","post");
$cd_cavideocfolder = SafeRequest("cd_cavideocfolder","post");
$cd_cavideofolder = SafeRequest("cd_cavideofolder","post");
$cd_uptype = SafeRequest("cd_uptype","post");
$cd_upmext = SafeRequest("cd_upmext","post");
$cd_upvext = SafeRequest("cd_upvext","post");
$cd_upkbps = SafeRequest("cd_upkbps","post");
$cd_upsize = SafeRequest("cd_upsize","post");
$cd_remoteup = SafeRequest("cd_remoteup","post");
$cd_ftphost = SafeRequest("cd_ftphost","post");
$cd_ftpuser = SafeRequest("cd_ftpuser","post");
$cd_ftppass = SafeRequest("cd_ftppass","post");
$cd_ftpdomain = SafeRequest("cd_ftpdomain","post");
$cd_ftpport = SafeRequest("cd_ftpport","post");
$cd_ftptype = SafeRequest("cd_ftptype","post");
$cd_ftproot = SafeRequest("cd_ftproot","post");
$cd_ftpdir = SafeRequest("cd_ftpdir","post");
$cd_qiniubucket = SafeRequest("cd_qiniubucket","post");
$cd_qiniukeyid = SafeRequest("cd_qiniukeyid","post");
$cd_qiniukeysecret = SafeRequest("cd_qiniukeysecret","post");
$cd_baidubucket = SafeRequest("cd_baidubucket","post");
$cd_baidukeyid = SafeRequest("cd_baidukeyid","post");
$cd_baidukeysecret = SafeRequest("cd_baidukeysecret","post");
$cd_ossbucket = SafeRequest("cd_ossbucket","post");
$cd_osskeyid = SafeRequest("cd_osskeyid","post");
$cd_osskeysecret = SafeRequest("cd_osskeysecret","post");
$cd_alipayid = SafeRequest("cd_alipayid","post");
$cd_alipaykey = SafeRequest("cd_alipaykey","post");
$cd_alipayuid = SafeRequest("cd_alipayuid","post");
$cd_qqappid = SafeRequest("cd_qqappid","post");
$cd_qqappkey = SafeRequest("cd_qqappkey","post");
$cd_usery = SafeRequest("cd_usery","post");
$cd_fsmessage = SafeRequest("cd_fsmessage","post");
$cd_bodymessage = SafeRequest("cd_bodymessage","post");
$cd_usermusic = SafeRequest("cd_usermusic","post");
$cd_onlinehold = SafeRequest("cd_onlinehold","post");
$cd_feedday = SafeRequest("cd_feedday","post");
$cd_listenday = SafeRequest("cd_listenday","post");
$cd_notificationday = SafeRequest("cd_notificationday","post");
$cd_webpoints = SafeRequest("cd_webpoints","post");
$cd_mmpoints = SafeRequest("cd_mmpoints","post");
$cd_checkmusicnum = SafeRequest("cd_checkmusicnum","post");
$cd_upgradepoints = SafeRequest("cd_upgradepoints","post");
$cd_points = SafeRequest("cd_points","post");
$cd_userrank = SafeRequest("cd_userrank","post");
$cd_pointsuaa = SafeRequest("cd_pointsuaa","post");
$cd_pointsuab = SafeRequest("cd_pointsuab","post");
$cd_pointsuba = SafeRequest("cd_pointsuba","post");
$cd_pointsubb = SafeRequest("cd_pointsubb","post");
$cd_pointsubc = SafeRequest("cd_pointsubc","post");
$cd_pointsuca = SafeRequest("cd_pointsuca","post");
$cd_pointsucb = SafeRequest("cd_pointsucb","post");
$cd_pointsucc = SafeRequest("cd_pointsucc","post");
$cd_pointsuda = SafeRequest("cd_pointsuda","post");
$cd_pointsudb = SafeRequest("cd_pointsudb","post");
$cd_pointsudc = SafeRequest("cd_pointsudc","post");
$cd_pointsuea = SafeRequest("cd_pointsuea","post");
$cd_pointsueb = SafeRequest("cd_pointsueb","post");
$cd_pointsufa = SafeRequest("cd_pointsufa","post");
$cd_pointsufb = SafeRequest("cd_pointsufb","post");
$cd_pointsufc = SafeRequest("cd_pointsufc","post");
$cd_pointsuga = SafeRequest("cd_pointsuga","post");
$cd_pointsugb = SafeRequest("cd_pointsugb","post");
$cd_pointsugc = SafeRequest("cd_pointsugc","post");
$cd_pointsdaa = SafeRequest("cd_pointsdaa","post");
$cd_pointsdab = SafeRequest("cd_pointsdab","post");
$cd_pointsdba = SafeRequest("cd_pointsdba","post");
$cd_pointsdbb = SafeRequest("cd_pointsdbb","post");
$cd_pointsdca = SafeRequest("cd_pointsdca","post");
$cd_pointsdcb = SafeRequest("cd_pointsdcb","post");
$cd_pointsdda = SafeRequest("cd_pointsdda","post");
$cd_pointsddb = SafeRequest("cd_pointsddb","post");
$cd_pointsdea = SafeRequest("cd_pointsdea","post");
$cd_pointsdeb = SafeRequest("cd_pointsdeb","post");

$strs="<?php"."\r\n";
$strs=$strs."define(\"cd_webname\",\"".$cd_webname."\");\r\n";
$strs=$strs."define(\"cd_weburl\",\"".$cd_weburl."\");\r\n";
$strs=$strs."define(\"cd_keywords\",\"".$cd_keywords."\");\r\n";
$strs=$strs."define(\"cd_description\",\"".$cd_description."\");\r\n";
$strs=$strs."define(\"cd_webqq\",\"".$cd_webqq."\");\r\n";
$strs=$strs."define(\"cd_webicp\",\"".$cd_webicp."\");\r\n";
$strs=$strs."define(\"cd_webmail\",\"".$cd_webmail."\");\r\n";
$strs=$strs."define(\"cd_lockmail\",\"".$cd_lockmail."\");\r\n";
$strs=$strs."define(\"cd_webmailsmtp\",\"".$cd_webmailsmtp."\");\r\n";
$strs=$strs."define(\"cd_webmailpswd\",\"".$cd_webmailpswd."\");\r\n";
$strs=$strs."define(\"cd_webcodea\",\"".$cd_webcodea."\");\r\n";
$strs=$strs."define(\"cd_webcodeb\",\"".$cd_webcodeb."\");\r\n";
$strs=$strs."define(\"cd_webstat\",\"".$cd_webstat."\");\r\n";
$strs=$strs."define(\"cd_weboffa\",\"".$cd_weboffa."\");\r\n";
$strs=$strs."define(\"cd_weboffb\",\"".$cd_weboffb."\");\r\n";
$strs=$strs."define(\"cd_iscache\",\"".$cd_iscache."\");\r\n";
$strs=$strs."define(\"cd_userhtml\",\"".$cd_userhtml."\");\r\n";
$strs=$strs."define(\"cd_webhtml\",\"".$cd_webhtml."\");\r\n";
$strs=$strs."define(\"cd_templatedir\",\"".$cd_templatedir."\");\r\n";
$strs=$strs."define(\"cd_ucenter\",\"".$cd_ucenter."\");\r\n";
$strs=$strs."define(\"cd_calistfolder\",\"".$cd_calistfolder."\");\r\n";
$strs=$strs."define(\"cd_caplayfolder\",\"".$cd_caplayfolder."\");\r\n";
$strs=$strs."define(\"cd_caspecialfolder\",\"".$cd_caspecialfolder."\");\r\n";
$strs=$strs."define(\"cd_casingerfolder\",\"".$cd_casingerfolder."\");\r\n";
$strs=$strs."define(\"cd_cavideocfolder\",\"".$cd_cavideocfolder."\");\r\n";
$strs=$strs."define(\"cd_cavideofolder\",\"".$cd_cavideofolder."\");\r\n";
$strs=$strs."define(\"cd_uptype\",\"".$cd_uptype."\");\r\n";
$strs=$strs."define(\"cd_upmext\",\"".$cd_upmext."\");\r\n";
$strs=$strs."define(\"cd_upvext\",\"".$cd_upvext."\");\r\n";
$strs=$strs."define(\"cd_upkbps\",\"".$cd_upkbps."\");\r\n";
$strs=$strs."define(\"cd_upsize\",\"".$cd_upsize."\");\r\n";
$strs=$strs."define(\"cd_remoteup\",\"".$cd_remoteup."\");\r\n";
$strs=$strs."define(\"cd_ftphost\",\"".$cd_ftphost."\");\r\n";
$strs=$strs."define(\"cd_ftpuser\",\"".$cd_ftpuser."\");\r\n";
$strs=$strs."define(\"cd_ftppass\",\"".$cd_ftppass."\");\r\n";
$strs=$strs."define(\"cd_ftpdomain\",\"".$cd_ftpdomain."\");\r\n";
$strs=$strs."define(\"cd_ftpport\",\"".$cd_ftpport."\");\r\n";
$strs=$strs."define(\"cd_ftptype\",\"".$cd_ftptype."\");\r\n";
$strs=$strs."define(\"cd_ftproot\",\"".$cd_ftproot."\");\r\n";
$strs=$strs."define(\"cd_ftpdir\",\"".$cd_ftpdir."\");\r\n";
$strs=$strs."define(\"cd_qiniubucket\",\"".$cd_qiniubucket."\");\r\n";
$strs=$strs."define(\"cd_qiniukeyid\",\"".$cd_qiniukeyid."\");\r\n";
$strs=$strs."define(\"cd_qiniukeysecret\",\"".$cd_qiniukeysecret."\");\r\n";
$strs=$strs."define(\"cd_baidubucket\",\"".$cd_baidubucket."\");\r\n";
$strs=$strs."define(\"cd_baidukeyid\",\"".$cd_baidukeyid."\");\r\n";
$strs=$strs."define(\"cd_baidukeysecret\",\"".$cd_baidukeysecret."\");\r\n";
$strs=$strs."define(\"cd_ossbucket\",\"".$cd_ossbucket."\");\r\n";
$strs=$strs."define(\"cd_osskeyid\",\"".$cd_osskeyid."\");\r\n";
$strs=$strs."define(\"cd_osskeysecret\",\"".$cd_osskeysecret."\");\r\n";
$strs=$strs."define(\"cd_alipayid\",\"".$cd_alipayid."\");\r\n";
$strs=$strs."define(\"cd_alipaykey\",\"".$cd_alipaykey."\");\r\n";
$strs=$strs."define(\"cd_alipayuid\",\"".$cd_alipayuid."\");\r\n";
$strs=$strs."define(\"cd_qqappid\",\"".$cd_qqappid."\");\r\n";
$strs=$strs."define(\"cd_qqappkey\",\"".$cd_qqappkey."\");\r\n";
$strs=$strs."define(\"cd_usery\",\"".$cd_usery."\");\r\n";
$strs=$strs."define(\"cd_fsmessage\",\"".$cd_fsmessage."\");\r\n";
$strs=$strs."define(\"cd_bodymessage\",\"".$cd_bodymessage."\");\r\n";
$strs=$strs."define(\"cd_usermusic\",\"".$cd_usermusic."\");\r\n";
$strs=$strs."define(\"cd_onlinehold\",\"".$cd_onlinehold."\");\r\n";
$strs=$strs."define(\"cd_feedday\",\"".$cd_feedday."\");\r\n";
$strs=$strs."define(\"cd_listenday\",\"".$cd_listenday."\");\r\n";
$strs=$strs."define(\"cd_notificationday\",\"".$cd_notificationday."\");\r\n";
$strs=$strs."define(\"cd_webpoints\",\"".$cd_webpoints."\");\r\n";
$strs=$strs."define(\"cd_mmpoints\",\"".$cd_mmpoints."\");\r\n";
$strs=$strs."define(\"cd_checkmusicnum\",\"".$cd_checkmusicnum."\");\r\n";
$strs=$strs."define(\"cd_upgradepoints\",\"".$cd_upgradepoints."\");\r\n";
$strs=$strs."define(\"cd_points\",\"".$cd_points."\");\r\n";
$strs=$strs."define(\"cd_userrank\",\"".$cd_userrank."\");\r\n";
$strs=$strs."define(\"cd_pointsuaa\",\"".$cd_pointsuaa."\");\r\n";
$strs=$strs."define(\"cd_pointsuab\",\"".$cd_pointsuab."\");\r\n";
$strs=$strs."define(\"cd_pointsuba\",\"".$cd_pointsuba."\");\r\n";
$strs=$strs."define(\"cd_pointsubb\",\"".$cd_pointsubb."\");\r\n";
$strs=$strs."define(\"cd_pointsubc\",\"".$cd_pointsubc."\");\r\n";
$strs=$strs."define(\"cd_pointsuca\",\"".$cd_pointsuca."\");\r\n";
$strs=$strs."define(\"cd_pointsucb\",\"".$cd_pointsucb."\");\r\n";
$strs=$strs."define(\"cd_pointsucc\",\"".$cd_pointsucc."\");\r\n";
$strs=$strs."define(\"cd_pointsuda\",\"".$cd_pointsuda."\");\r\n";
$strs=$strs."define(\"cd_pointsudb\",\"".$cd_pointsudb."\");\r\n";
$strs=$strs."define(\"cd_pointsudc\",\"".$cd_pointsudc."\");\r\n";
$strs=$strs."define(\"cd_pointsuea\",\"".$cd_pointsuea."\");\r\n";
$strs=$strs."define(\"cd_pointsueb\",\"".$cd_pointsueb."\");\r\n";
$strs=$strs."define(\"cd_pointsufa\",\"".$cd_pointsufa."\");\r\n";
$strs=$strs."define(\"cd_pointsufb\",\"".$cd_pointsufb."\");\r\n";
$strs=$strs."define(\"cd_pointsufc\",\"".$cd_pointsufc."\");\r\n";
$strs=$strs."define(\"cd_pointsuga\",\"".$cd_pointsuga."\");\r\n";
$strs=$strs."define(\"cd_pointsugb\",\"".$cd_pointsugb."\");\r\n";
$strs=$strs."define(\"cd_pointsugc\",\"".$cd_pointsugc."\");\r\n";
$strs=$strs."define(\"cd_pointsdaa\",\"".$cd_pointsdaa."\");\r\n";
$strs=$strs."define(\"cd_pointsdab\",\"".$cd_pointsdab."\");\r\n";
$strs=$strs."define(\"cd_pointsdba\",\"".$cd_pointsdba."\");\r\n";
$strs=$strs."define(\"cd_pointsdbb\",\"".$cd_pointsdbb."\");\r\n";
$strs=$strs."define(\"cd_pointsdca\",\"".$cd_pointsdca."\");\r\n";
$strs=$strs."define(\"cd_pointsdcb\",\"".$cd_pointsdcb."\");\r\n";
$strs=$strs."define(\"cd_pointsdda\",\"".$cd_pointsdda."\");\r\n";
$strs=$strs."define(\"cd_pointsddb\",\"".$cd_pointsddb."\");\r\n";
$strs=$strs."define(\"cd_pointsdea\",\"".$cd_pointsdea."\");\r\n";
$strs=$strs."define(\"cd_pointsdeb\",\"".$cd_pointsdeb."\");\r\n";
$strs=$strs."?>";

if(!$fp = fopen('source/global/global_config.php', 'w')) {
	ShowMessage("����ʧ�ܣ��ļ�{source/global/global_config.php}û��д��Ȩ�ޣ�","history.back(1);","infotitle3",3000,2);
	}
	if($cd_webhtml<>2 && file_exists("index.html")){unlink("index.html");}
	$ifile = new iFile('source/global/global_config.php','w');
	$ifile->WriteFile($strs,3);
	ShowMessage("��ϲ�������ñ���ɹ���","history.back(1);","infotitle2",1000,2);
}
?>