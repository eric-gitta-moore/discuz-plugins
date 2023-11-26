<?php
include "../source/global/global.php";
include "../source/global/global_function.php";

define('S_ROOT', dirname(__FILE__).'/../');
$step = empty($_GET['step']) ? 0 : intval($_GET['step']);
$charset = cd_charset;
$version = cd_version;
$build = cd_build;
$year = date('Y',time());

$lock = S_ROOT.'./data/install.xml';
if(file_exists($lock)) {
	show_msg('���棡���Ѿ���װ��QianWei Music��<br>Ϊ�˱�֤���ݰ�ȫ��������ɾ�� ../install/index.php �ļ���<br>����������°�װQianWei Music����ɾ�� ../data/install.xml �ļ���', 999);
}
$sql = S_ROOT.'./install/table.sql';
if(!file_exists($sql)) {
	show_msg('ȱ�� ../install/table.sql ���ݿ�ṹ�ļ������飡', 999);
}
$global = S_ROOT.'./source/global/global.php';
if(!@$fp = fopen($global, 'a')) {
	show_msg('�ļ� ../source/global/global.php ��дȨ�����ô�����������Ϊ��д��', 999);
} else {
	@fclose($fp);
}
$globalconfig = S_ROOT.'./source/global/global_config.php';
if(!@$fp = fopen($globalconfig, 'a')) {
	show_msg('�ļ� ../source/global/global_config.php ��дȨ�����ô�����������Ϊ��д��', 999);
} else {
	@fclose($fp);
}

if(empty($step)) {
	$phpos = PHP_OS;
	$phpversion = PHP_VERSION;
	$attachmentupload = @ini_get('file_uploads') ? '<td class="w pdleft1">'.ini_get('upload_max_filesize').'</td>' : '<td class="nw pdleft1">unknow</td>';
	if(function_exists('disk_free_space')) {
		$diskspace = '<td class="w pdleft1">'.floor(disk_free_space(S_ROOT) / (1024*1024)).'M</td>';
	} else {
		$diskspace = '<td class="nw pdleft1">unknow</td>';
	}
	$checkok = true;
	$perms = array();
	if(!checkfdperm(S_ROOT.'./source/global/global.php', 1)) {
		$perms['global'] = '<td class="nw pdleft1">����д</td>';
		$checkok = false;
	} else {
		$perms['global'] = '<td class="w pdleft1">��д</td>';
	}
	if(!checkfdperm(S_ROOT.'./source/global/global_config.php', 1)) {
		$perms['globalconfig'] = '<td class="nw pdleft1">����д</td>';
		$checkok = false;
	} else {
		$perms['globalconfig'] = '<td class="w pdleft1">��д</td>';
	}
	if(!checkfdperm(S_ROOT.'./client/ucenter.php', 1)) {
		$perms['ucenter'] = '<td class="nw pdleft1">����д</td>';
		$checkok = false;
	} else {
		$perms['ucenter'] = '<td class="w pdleft1">��д</td>';
	}
	if(!checkfdperm(S_ROOT.'./data/')) {
		$perms['data'] = '<td class="nw pdleft1">����д</td>';
		$checkok = false;
	} else {
		$perms['data'] = '<td class="w pdleft1">��д</td>';
	}
	if(!checkfdperm(S_ROOT.'./source/plugin/')) {
		$perms['plugin'] = '<td class="nw pdleft1">����д</td>';
		$checkok = false;
	} else {
		$perms['plugin'] = '<td class="w pdleft1">��д</td>';
	}
	if(!checkfdperm(S_ROOT.'./template/')) {
		$perms['template'] = '<td class="nw pdleft1">����д</td>';
		$checkok = false;
	} else {
		$perms['template'] = '<td class="w pdleft1">��д</td>';
	}
	$check_mysql_connect = (function_exists('mysql_connect') ? '<td class="w pdleft1">֧��</td>' : '<td class="nw pdleft1">��֧��</td>');
	$check_file_get_contents = (function_exists('file_get_contents') ? '<td class="w pdleft1">֧��</td>' : '<td class="nw pdleft1">��֧��</td>');
	$check_allow_url_fopen = (ini_get('allow_url_fopen') ? '<td class="w pdleft1">֧��</td>' : '<td class="nw pdleft1">��֧��</td>');
	show_header();
	print<<<END
	<div class="setup step1">
	<h2>��ʼ��װ</h2>
	<p>�����Լ��ļ�Ŀ¼Ȩ�޼��</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="current">��鰲װ����</li>
	<li class="unactivated">�������ݿ�</li>
	<li class="unactivated">���ú�̨����Ա</li>
	<li class="unactivated last">��װ</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<div class="licenseblock">
	<div class="license">
	<h1>��Ʒ��ȨЭ�� �����������û�</h1>

	<p>��Ȩ���� (c) 2008-$year ǰ�����ֱ�������Ȩ����</p>

	<p>��л��ѡ��QianWei Music��ϣ�����ǵ�Ŭ����Ϊ���ṩһ����Ч���١�ǿ�������ϵͳ���������ǰ��������ַΪ www.qianwei.in����Ʒ�ٷ���������ַΪ www.qianwe.com��</p>

	<p>�û���֪����Э��������ǰ������֮�������ʹ��ǰ�������ṩ�������Ʒ������ķ���Э�顣�������Ǹ��˻���֯��ӯ�������;��Σ�������ѧϰ���о�ΪĿ�ģ���������ϸ�Ķ���Э�飬���������������ǰ�����ֵ��������������Ȩ�����ơ��������Ĳ����ܻ򲻽��ܱ��������������ͬ�Ȿ�������/��ǰ��������ʱ������޸ģ���Ӧ��ʹ�û�����ȡ��ǰ�������ṩ�Ĳ�Ʒ�����������κζ�ǰ�����ֲ�Ʒ�е���ط����ע�ᡢ��½�����ء��鿴��ʹ����Ϊ������Ϊ���Ա���������ȫ������ȫ���ܣ���������ǰ�����ֶԷ���������ʱ�������κ��޸ġ�</p>

	<p>����������һ���������, ǰ�����ֽ�����ҳ�Ϲ����޸����ݡ��޸ĺ�ķ�������һ������վ�����̨�Ϲ�������Ч����ԭ���ķ������������ʱ��½ǰ�����ֹٷ���̳�������°������������ѡ����ܱ��������ʾ��ͬ�����Э�����������Լ�����������ͬ�Ȿ����������ܻ��ʹ�ñ������Ȩ����������Υ��������涨��ǰ��������Ȩ��ʱ��ֹ����ֹ����ǰ�����ֲ�Ʒ��ʹ���ʸ񲢱���׷����ط������ε�Ȩ����</p>

	<p>����⡢ͬ�⡢�����ر�Э���ȫ������󣬷��ɿ�ʼʹ��ǰ�����ֲ�Ʒ����������ǰ������ֱ��ǩ����һ����Э�飬�Բ������ȡ����Э���ȫ�������κβ��֡�</p>

	<p>ǰ������ӵ�б������ȫ��֪ʶ��Ȩ�������ֻ�����Э�飬���ǳ��ۡ�ǰ������ֻ�����������ر�Э��������������¸��ơ����ء���װ��ʹ�û�����������ʽ�����ڱ�����Ĺ��ܻ���֪ʶ��Ȩ��</p>

	<h3>I. Э����ɵ�Ȩ��</h3>
	<ol>
	&nbsp;  <li>����������ȫ���ر����Э��Ļ����ϣ��������Ӧ���ڷ���ҵ��;��������֧�������Ȩ��ɷ��á�</li>
	&nbsp;  <li>��������Э��涨��Լ�������Ʒ�Χ���޸�ǰ�����ֲ�ƷԴ����(������ṩ�Ļ�)�����������Ӧ������վҪ��</li>
	&nbsp;  <li>��ӵ��ʹ�ñ������������վ��ȫ����Ա���ϡ����¼������Ϣ������Ȩ���������е���ʹ�ñ������������վ���ݵ���ˡ�ע������ȷ���䲻�ַ��κ��˵ĺϷ�Ȩ�棬�����е���ʹ��ǰ����������ͷ��������ȫ�����Σ������ǰ�����ֻ��û���ʧ�ģ���Ӧ����ȫ���⳥��</li>
	&nbsp;  <li>�����轫ǰ���������������û���ҵ��;���������л��ǰ�����ֵ�������ɣ����ڻ����ҵ��Ȩ֮�������Խ������Ӧ������ҵ��;��ͬʱ�������������Ȩ������ȷ���ļ���֧�����ޡ�����֧�ַ�ʽ�ͼ���֧�����ݣ��Թ���ʱ�����ڼ���֧��������ӵ��ͨ��ָ���ķ�ʽ���ָ����Χ�ڵļ���֧�ַ�����ҵ��Ȩ�û����з�ӳ����������Ȩ����������������Ϊ��Ҫ���ǣ���û��һ�������ɵĳ�ŵ��֤��</li>
	&nbsp;  <li>�����Դ�ǰ�������ṩ��Ӧ�����ķ����������ʺ�����վ��Ӧ�ó��򣬵�Ӧ��Ӧ�ó��򿪷���/������֧����Ӧ�ķ��á�</li>
	</ol>

	<h3>II. Э��涨��Լ��������</h3>
	<ol>
	&nbsp;  <li>δ��ǰ������������ҵ��Ȩ֮ǰ�����ý������������ҵ��;����������������ҵ��վ����Ӫ����վ����Ӫ��ΪĿ��ʵ��ӯ������վ����������ҵ��Ȩ���½www.qianwe.com�ο����˵����Ҳ���Է����ʼ���web@qianwe.com�˽����顣</li>
	&nbsp;  <li>���öԱ��������֮��������ҵ��Ȩ���г��⡢���ۡ���Ѻ�򷢷������֤��</li>
	&nbsp;  <li>������Σ���������;��Ρ��Ƿ񾭹��޸Ļ��������޸ĳ̶���Σ�ֻҪʹ��ǰ�����ֲ�Ʒ��������κβ��֣�δ��������ɣ�ҳ��ҳ�Ŵ���ǰ�����ֲ�Ʒ���ƺ�ǰ������������վ��www.qianwe.com���� www.qianwei.in�� �����Ӷ����뱣����������������޸ġ�</li>
	&nbsp;  <li>��ֹ��ǰ�����ֲ�Ʒ��������κβ��ֻ������Է�չ�κ������汾���޸İ汾��������汾�������·ַ���</li>
	&nbsp;  <li>����Ӧ���������ص�Ӧ�ó���δ��Ӧ�ó��򿪷���/�����ߵ�������ɣ����ö�����з��򹤳̡������ࡢ�������ȣ��������Ը��ơ��޸ġ����ӡ�ת�ء���ࡢ�������桢��չ��֮�йص�������Ʒ����Ʒ�ȡ�</li>
	&nbsp;  <li>�����δ�����ر�Э������������Ȩ������ֹ������ɵ�Ȩ�������ջأ�ͬʱ��Ӧ�е���Ӧ�������Ρ�</li>
	</ol>

	<h3>III. ���޵�������������</h3>
	<ol>
	&nbsp;  <li>����������������ļ�����Ϊ���ṩ�κ���ȷ�Ļ��������⳥�򵣱�����ʽ�ṩ�ġ�</li>
	&nbsp;  <li>�û�������Ը��ʹ�ñ�������������˽�ʹ�ñ�����ķ��գ�����δ�����Ʒ��������֮ǰ�����ǲ���ŵ�ṩ�κ���ʽ�ļ���֧�֡�ʹ�õ�����Ҳ���е��κ���ʹ�ñ���������������������Ρ�</li>
	&nbsp;  <li>ǰ�����ֲ���ʹ�ñ������������վ�л�����̳�е����»���Ϣ�е����Σ�ȫ�������������ге���</li>
	&nbsp;  <li>ǰ�������޷�ȫ�����ɵ������ϴ���Ӧ�����ĵ�Ӧ�ó�����˲���֤Ӧ�ó���ĺϷ��ԡ���ȫ�ԡ������ԡ���ʵ�Ի�Ʒ�ʵȣ�����Ӧ����������Ӧ�ó���ʱ��ͬ�������жϲ��е����з��գ�����������ǰ�����֡������κ�����£�ǰ��������Ȩ����ֹͣӦ�����ķ��񲢲�ȡ��Ӧ�ж��������������ڶ������Ӧ�ó������ж�أ���ͣ�����ȫ���򲿷֣������йؼ�¼�������йػ��ر��档�ɴ˶����������˿�����ɵ���ʧ��ǰ�����ֲ��е��κ�ֱ�ӡ���ӻ������������Ρ�</li>
	&nbsp;  <li>ǰ�����ֶ����ṩ������ͷ���֮��ʱ�ԡ���ȫ�ԡ�׼ȷ�Բ������������ڲ��ɿ������ء�ǰ�������޷����Ƶ����أ������ڿ͹�����ͣ�ϵ�ȣ���������ʹ�úͷ�����ֹ����ֹ�������������ʧ�ģ���ͬ�����׷��ǰ���������ε�ȫ��Ȩ����</li>
	&nbsp;  <li>ǰ�������ر�������ע�⣬ǰ������Ϊ�˱��Ϲ�˾ҵ��չ�͵���������Ȩ��ǰ������ӵ����ʱ����δ������֪ͨ���޸ķ������ݡ���ֹ����ֹ���ֻ�ȫ�����ʹ�úͷ����Ȩ�����޸Ļṫ����ǰ��������վ���ҳ���ϣ�һ��������Ϊ֪ͨ�� ǰ��������ʹ�޸Ļ���ֹ����ֹ���ֻ�ȫ�����ʹ�úͷ����Ȩ���������ʧ�ģ�ǰ�����ֲ���������κε���������</li>
	</ol>

	<p>�й�ǰ�����ֲ�Ʒ�����û���ȨЭ�顢��ҵ��Ȩ�뼼���������ϸ���ݣ�����ǰ�����ֶ����ṩ��ǰ������ӵ���ڲ�����֪ͨ������£��޸���ȨЭ��ͷ����Ŀ���Ȩ�����޸ĺ��Э����Ŀ����Ըı�֮���������Ȩ�û���Ч��</p>

	<p>һ������ʼ��װǰ�����ֲ�Ʒ��������Ϊ��ȫ��Ⲣ���ܱ�Э��ĸ�������������������������Ȩ����ͬʱ���ܵ���ص�Լ�������ơ�Э����ɷ�Χ�������Ϊ����ֱ��Υ������ȨЭ�鲢������Ȩ��������Ȩ��ʱ��ֹ��Ȩ������ֹͣ�𺦣�������׷��������ε�Ȩ����</p>

	<p>�����Э������Ľ��ͣ�Ч�������׵Ľ�����������л����񹲺͹���½���ɡ�</p>

	<p>������ǰ������֮�䷢���κξ��׻����飬����Ӧ�Ѻ�Э�̽����Э�̲��ɵģ����ڴ���ȫͬ�⽫���׻������ύǰ���������ڵ�����Ժ��Ͻ��ǰ������ӵ�ж����ϸ����������ݵĽ���Ȩ���޸�Ȩ��</p>

	<p>�������꣩</p>

	<p align="right">ǰ������</p>
	</div>
	</div>
	<h2 class="title">�������</h2>
	<table class="tb" style="margin:20px 0 20px 55px;">
	<tr>
	<th>��Ŀ</th>
	<th class="padleft">��������</th>
	<th class="padleft">�������</th>
	<th class="padleft">��ǰ״̬</th>
	</tr>
	<tr>
	<td>����ϵͳ</td>
	<td class="padleft">������</td>
	<td class="padleft">��Unix</td>
	<td class="w pdleft1">$phpos</td>
	</tr>
	<tr>
	<td>PHP �汾</td>
	<td class="padleft">5.1</td>
	<td class="padleft">5.3</td>
	<td class="w pdleft1">$phpversion</td>
	</tr>
	<tr>
	<td>�����ϴ�</td>
	<td class="padleft">������</td>
	<td class="padleft">8M</td>
	$attachmentupload
	</tr>
	<tr>
	<td>���̿ռ�</td>
	<td class="padleft">12M</td>
	<td class="padleft">������</td>
	$diskspace
	</tr>
	</table>
	<h2 class="title">Ŀ¼���ļ�Ȩ�޼��</h2>
	<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
	<tr><th>Ŀ¼�ļ�</th><th class="padleft">����״̬</th><th class="padleft">��ǰ״̬</th></tr>
	<tr><td>../source/global/global.php</td><td class="w pdleft1">��д</td>$perms[global]</tr>
	<tr><td>../source/global/global_config.php</td><td class="w pdleft1">��д</td>$perms[globalconfig]</tr>
	<tr><td>../client/ucenter.php</td><td class="w pdleft1">��д</td>$perms[ucenter]</tr>
	<tr><td>../data/</td><td class="w pdleft1">��д</td>$perms[data]</tr>
	<tr><td>../source/plugin/</td><td class="w pdleft1">��д</td>$perms[plugin]</tr>
	<tr><td>../template/</td><td class="w pdleft1">��д</td>$perms[template]</tr>
	</table>
	<h2 class="title">���������Լ��</h2>
	<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
	<tr>
	<th>��������</th>
	<th class="padleft">�����</th>
	<th class="padleft">����</th>
	</tr>
	<tr>
	<td>mysql_connect()</td>
	$check_mysql_connect
	<td class="padleft">��</td>
	</tr>
	<tr>
	<td>file_get_contents()</td>
	$check_file_get_contents
	<td class="padleft">��</td>
	</tr>
	<tr>
	<td>allow_url_fopen</td>
	$check_allow_url_fopen
	<td class="padleft">��</td>
	</tr>
	</table>
END;
	if(!$checkok) {
		echo "<div class=\"btnbox marginbot\"><form method=\"post\" action=\"index.php?step=1\"><input type=\"submit\" value=\"ǿ�Ƽ���\"><input type=\"button\" value=\"�ر�\" onclick=\"windowclose();\"></form></div>";
	} else {
		print <<<END
		<div class="btnbox marginbot">
		<form method="post" action="index.php?step=1">
		<input type="submit" value="ͬ�Ⲣ��װ">
		<input type="button" value="��ͬ��" onclick="windowclose();">
		</form>
		</div>
END;
	}
	show_footer();

} elseif ($step == 1) {
	show_header();
	print<<<END
	<div class="setup step2">
	<h2>��װ���ݿ�</h2>
	<p>����ִ�����ݿⰲװ</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">��鰲װ����</li>
	<li class="current">�������ݿ�</li>
	<li class="unactivated">���ú�̨����Ա</li>
	<li class="unactivated last">��װ</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<form name="themysql" method="post" action="index.php?step=2">
	<div class="desc"><b>��д���ݿ���Ϣ</b></div>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;���ݿ�����:</th>
	<td><input type="text" name="dbhost" value="localhost" size="35" class="txt"></td>
	<td>���ݿ��������ַ��һ��Ϊ localhost</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;���ݿ�����:</th>
	<td><input type="text" name="dbname" value="test" size="35" class="txt"></td>
	<td>��������ڣ���᳢���Զ�����</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;���ݿ��û���:</th>
	<td><input type="text" name="dbuser" value="root" size="35" class="txt"></td>
	<td></td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;���ݿ�����:</th>
	<td><input type="password" name="dbpw" value="" size="35" class="txt"></td>
	<td></td>
	</tr>
	</table>
	<div class="desc"><b>������ѡ������</b></div>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;���ݿ��ǰ׺:</th>
	<td><input type="text" name="dbtablepre" value="prefix_" size="35" class="txt"></td>
	<td>����Ϊ�գ�Ĭ��Ϊprefix_</td>
	</tr>
	</table>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;</th>
	<td><input type="submit" name="submitmysql" value="�������ݿ�" onclick="return checkmysql();" class="btn"></td>
	<td></td>
	</tr>
	</table>
	</form>
END;
	show_footer();

} elseif ($step == 2) {
	if(!submitcheck('submitmysql')){show_msg('����֤�������޷��ύ��', 999);}
	$path=$_SERVER['PHP_SELF'];
	$path=ReplaceStr(strtolower($path),"install/index.php","");
	$host=SafeRequest("dbhost","post");
	$name=SafeRequest("dbname","post");
	$user=SafeRequest("dbuser","post");
	$pw=SafeRequest("dbpw","post");
	$tablepre=SafeRequest("dbtablepre","post");
	$havedata = false;
	if(!@mysql_connect($host, $user, $pw)) {
		show_msg('���ݿ���Ϣ��д��������ģ�');
	}
	$config=file_get_contents("../source/global/global.php");
	$config=preg_replace('/"cd_sqlservername","(.*?)"/', '"cd_sqlservername","'.$host.'"', $config);
	$config=preg_replace('/"cd_sqldbname","(.*?)"/', '"cd_sqldbname","'.$name.'"', $config);
	$config=preg_replace('/"cd_sqluserid","(.*?)"/', '"cd_sqluserid","'.$user.'"', $config);
	$config=preg_replace('/"cd_sqlpwd","(.*?)"/', '"cd_sqlpwd","'.$pw.'"', $config);
	$config=preg_replace('/"cd_webpath","(.*?)"/', '"cd_webpath","'.$path.'"', $config);
	$config=preg_replace('/"cd_upath","(.*?)"/', '"cd_upath","'.$path.'user/"', $config);
	$config=preg_replace('/"cd_tablename","(.*?)"/', '"cd_tablename","'.$tablepre.'"', $config);
	$config=preg_replace('/"cd_cookiepath","(.*?)"/', '"cd_cookiepath","'.$path.'"', $config);
	$ifile = new iFile('../source/global/global.php', 'w');
	$ifile->WriteFile($config, 3);
	if(mysql_select_db($name)) {
		if(mysql_query("SELECT COUNT(*) FROM ".$tablepre."admin")) {
			$havedata = true;
		}
	} else {
		if(!mysql_query("CREATE DATABASE `".$name."`")) {
			show_msg('�趨�����ݿ���Ȩ�޲����������ֹ��½�����ִ�а�װ����');
		}
	}
	if($havedata) {
		show_msg('Σ�գ�ָ�������ݿ��������ݣ���������������ԭ�����ݣ�', ($step+1));
	} else {
		show_msg('���ݿ���Ϣ���óɹ���������ʼ��װ����...', ($step+1), 1);
	}

} elseif ($step == 3) {
	$lnk=mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd) or show_msg('���ݿ������쳣���޷�ִ�У�', 999);
	mysql_select_db(cd_sqldbname, $lnk) or show_msg('���ݿ������쳣���޷�ִ�У�', 999);
	mysql_query("SET NAMES gb2312",$lnk);
	$table=file_get_contents("table.sql");
	$table=ReplaceStr($table,"prefix_",cd_tablename);
	$tablearr=explode(";",$table);
	$data=file_get_contents("data.sql");
	$data=ReplaceStr($data,"prefix_",cd_tablename);
	$dataarr=explode("--preset--",$data);
	$sqlarr=explode("�ṹ*/",$table);
	$str="<p>���ڰ�װ����...</p>{replace}";
	for($i=0;$i<count($tablearr)-1;$i++){
		mysql_query($tablearr[$i]);
	}
	for($i=0;$i<count($dataarr);$i++){
		mysql_query($dataarr[$i]);
	}
	for($i=0;$i<count($sqlarr)-1;$i++){
		$strsql=explode("/*����",$sqlarr[$i]);
		$str.=$strsql[1];
	}
	$str=ReplaceStr($str,"�� `","<p>�������ݱ� ");
	$str=ReplaceStr($str,"` ��"," ... �ɹ�</p>{replace}");
	$str=$str."<p>��װ�������� ... �ɹ�</p>{replace}";
	show_header();
	print<<<END
	<div class="setup step2">
	<h2>��װ���ݿ�</h2>
	<p>����ִ�����ݿⰲװ</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">��鰲װ����</li>
	<li class="current">�������ݿ�</li>
	<li class="unactivated">���ú�̨����Ա</li>
	<li class="unactivated last">��װ</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<div class="notice" id="log">
	<div class="license" id="loginner">
	</div>
	</div>
	<div class="btnbox margintop marginbot">
	<input type="button" value="���ڰ�װ..." disabled="disabled">
	</div>
	<script type="text/javascript">
	var log = "$str";
	var n = 0;
	var timer = 0;
	log = log.split('{replace}');
	function GoPlay() {
		if (n > log.length-1) {
		        n=-1;
		        clearIntervals();
		}
		if (n > -1) {
		        postcheck(n);
		        n++;
		}
	}
	function postcheck(n) {
		document.getElementById('loginner').innerHTML += log[n];
		document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
	}
	function setIntervals() {
		timer = setInterval('GoPlay()', 100);
	}
	function clearIntervals() {
		clearInterval(timer);
		window.location.href = "index.php?step=4";
	}
	setTimeout(setIntervals, 42);
	</script>
END;
	show_footer();

} elseif ($step == 4) {
	show_header();
	print<<<END
	<div class="setup step3">
	<h2>��������Ա</h2>
	<p>�������ú�̨�����ʺ�</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">��鰲װ����</li>
	<li class="unactivated">�������ݿ�</li>
	<li class="current">���ú�̨����Ա</li>
	<li class="unactivated last">��װ</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<form name="theuser" method="post" action="index.php?step=5">
	<div class="desc"><b>��д����Ա��Ϣ</b></div>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;����Ա�ʺ�:</th>
	<td><input type="text" name="uname" value="" size="35" class="txt" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
	<td>���������������ַ�</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;����Ա����:</th>
	<td><input type="password" name="upw" value="" size="35" class="txt"></td>
	<td>��������Խ���ӣ���ȫ����Խ��</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;�ظ�����:</th>
	<td><input type="password" name="upw1" value="" size="35" class="txt"></td>
	<td></td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;��֤��:</th>
	<td><input type="text" name="ucode" value="" size="35" class="txt"></td>
	<td>���ú󣬿����ں�̨ѡ������ر�</td>
	</tr>
	</table>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;</th>
	<td><input type="submit" name="submituser" value="��������Ա" onclick="return checkuser();" class="btn"></td>
	<td></td>
	</tr>
	</table>
	</form>
END;
	show_footer();

} elseif ($step == 5) {
	if(!submitcheck('submituser')){show_msg('����֤�������޷��ύ��', 999);}
	$lnk=mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd) or show_msg('���ݿ������쳣���޷�ִ�У�', 999);
	mysql_select_db(cd_sqldbname, $lnk) or show_msg('���ݿ������쳣���޷�ִ�У�', 999);
	mysql_query("SET NAMES gb2312",$lnk);
	$name=SafeRequest("uname","post");
	$pw=SafeRequest("upw","post");
	$pw1=SafeRequest("upw1","post");
	$code=SafeRequest("ucode","post");
	$config=file_get_contents("../source/global/global_config.php");
	$config=preg_replace('/"cd_weburl","(.*?)"/', '"cd_weburl","'.$_SERVER['HTTP_HOST'].'"', $config);
	$config=preg_replace('/"cd_webcodeb","(.*?)"/', '"cd_webcodeb","'.$code.'"', $config);
	fwrite(fopen("../source/global/global_config.php","wb"),$config);
	$sqla="insert into `".tname('admin')."` (CD_AdminUserName,CD_AdminPassWord,CD_Permission,CD_LoginNum,CD_IsLock) values ('".$name."','".md5($pw1)."','1,2,3,4,5,6,7,8,9','0','0')";
	$sqlu="insert into `".tname('user')."` (cd_name,cd_nicheng,cd_password,cd_email,cd_regdate,cd_loginnum,cd_grade,cd_lock,cd_points,cd_hits,cd_isbest,cd_friendnum,cd_rank,cd_uhits,cd_weekhits,cd_musicnum,cd_fansnum,cd_idolnum,cd_favnum,cd_qqprivacy,cd_groupnum,cd_checkmm,cd_checkmusic,cd_review,cd_sign,cd_signcumu,cd_ucenter,cd_skinid,cd_vipgrade,cd_viprank,cd_ulevel) values ('".$name."','����Ա','".substr(md5($pw1),8,16)."','web@qianwe.com','".date('Y-m-d H:i:s')."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')";
	$sqls="insert into `".tname('server')."` (CD_Name,CD_Url,CD_DownUrl,CD_Yes) values ('��Ա�ϴ�','http://".$_SERVER['HTTP_HOST'].cd_webpath."','http://".$_SERVER['HTTP_HOST'].cd_webpath."','0')";
	if(mysql_query($sqla) && mysql_query($sqlu) && mysql_query($sqls)) {
		fwrite(fopen("../data/install.xml","wb+"),date('Y-m-d H:i:s'));
		show_msg('��ϲ��QianWei Music ˳����װ��ɣ�<br>Ϊ�˱�֤���ݰ�ȫ�����ֶ�ɾ��installĿ¼��<br><br>���ĺ�̨����Ա�ʺ���ǰ̨��Ա�ʺ��Ѿ��ɹ��������������������ԣ�<br><br><a href="../index.php" target="_blank">������վ��ҳ</a><br>�� <a href="../admin.php" target="_blank">��������̨</a> �Թ���Ա��ݶ�վ������������ã�', 999);
	} else {
		show_msg(mysql_error(), 999);
	}
}

function show_header() {
	global $charset, $version, $build;
	print<<<END
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>QianWei Music ��װ��</title>
	<link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
	<link href="../source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../source/plugin/asynctips/jquery.min.js"></script>
	<script type="text/javascript" src="../source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
	<script type="text/javascript">
	function windowclose() {
		var browserName = navigator.appName;
		if (browserName=="Netscape") {
        		window.open('', '_self', '');
        		window.close();
        	} else {
        		if (browserName=="Microsoft Internet Explorer") {
        		        window.opener = "whocares";
        		        window.opener = null;
        		        window.open('', '_top');
        		        window.close();
        		}
        	}
        }
	function checkmysql() {
        	if (this.themysql.dbhost.value=="") {
        		asyncbox.tips("���ݿ���������Ϊ�գ�����д��", "wait", 1000);
        		this.themysql.dbhost.focus();
        		return false;
        	} else if (this.themysql.dbname.value=="") {
        		asyncbox.tips("���ݿ����Ʋ���Ϊ�գ�����д��", "wait", 1000);
        		this.themysql.dbname.focus();
        		return false;
        	} else if (this.themysql.dbuser.value=="") {
        		asyncbox.tips("���ݿ��û�������Ϊ�գ�����д��", "wait", 1000);
        		this.themysql.dbuser.focus();
        		return false;
        	} else if (this.themysql.dbpw.value=="") {
        		asyncbox.tips("���ݿ����벻��Ϊ�գ�����д��", "wait", 1000);
        		this.themysql.dbpw.focus();
        		return false;
        	} else if (this.themysql.dbtablepre.value=="") {
        		asyncbox.tips("���ݿ��ǰ׺����Ϊ�գ�����д��", "wait", 1000);
        		this.themysql.dbtablepre.focus();
        		return false;
        	} else {
        		return true;
        	}
	}
	function checkuser() {
        	if (this.theuser.uname.value=="") {
        		asyncbox.tips("����Ա�ʺŲ���Ϊ�գ�����д��", "wait", 1000);
        		this.theuser.uname.focus();
        		return false;
        	} else if (this.theuser.upw.value=="") {
        		asyncbox.tips("����Ա���벻��Ϊ�գ�����д��", "wait", 1000);
        		this.theuser.upw.focus();
        		return false;
        	} else if (this.theuser.upw1.value=="") {
        		asyncbox.tips("�ظ����벻��Ϊ�գ�����д��", "wait", 1000);
        		this.theuser.upw1.focus();
        		return false;
        	} else if (this.theuser.upw1.value!==this.theuser.upw.value) {
        		asyncbox.tips("�����������벻һ�£�����ģ�", "error", 1000);
        		this.theuser.upw1.focus();
        		return false;
        	} else if (this.theuser.ucode.value=="") {
        		asyncbox.tips("��֤�벻��Ϊ�գ�����д��", "wait", 1000);
        		this.theuser.ucode.focus();
        		return false;
        	} else {
        		return true;
        	}
	}
	</script>
	</head>
	<body>
	<div class="container">
	<div class="header">
	<h1>QianWei Music ��װ��</h1>
	<span>QianWei Music $version ��������$charset $build</span>
END;
}

function show_footer() {
	global $year;
	print<<<END
	<div class="footer">&copy;2008 - $year <a href="http://www.qianwe.com/" target="_blank">QianWe</a> Inc.</div>
	</div>
	</div>
	</body>
	</html>
END;
}

function show_msg($message, $next=0, $jump=0) {
	$nextstr = '';
	$backstr = '';
	if(empty($next)) {
		$backstr .= "<a href=\"index.php?step=1\">������һ��</a>";
	} elseif ($next == 999) {
	} else {
		$url_forward = "index.php?step=$next";
		if($jump) {
			$nextstr .= "<a href=\"$url_forward\">���Ե�...</a><script>setTimeout(\"window.location.href ='$url_forward';\", 1000);</script>";
		} else {
			$nextstr .= "<a href=\"$url_forward\">������һ��</a>";
			$backstr .= "<a href=\"index.php?step=1\">������һ��</a>";
		}
	}
	show_header();
	print<<<END
	<div class="setup">
	<h2>��װ��ʾ</h2>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">��鰲װ����</li>
	<li class="unactivated">�������ݿ�</li>
	<li class="unactivated">���ú�̨����Ա</li>
	<li class="current last">��װ</li>
	</ul>
	<div class="stepstatbg"></div>
	</div>
	</div>
	<div class="main">
	<div class="desc" align="center"><b>��ʾ��Ϣ</b></div>
	<table class="tb2">
	<tr><td class="desc" align="center">$message</td>
	</tr>
	</table>
	<div class="btnbox marginbot">$backstr $nextstr</div>
END;
	show_footer();
	exit();
}

function checkfdperm($path, $isfile=0) {
	if($isfile) {
		$file = $path;
		$mod = 'a';
	} else {
		$file = $path.'./install_tmptest.data';
		$mod = 'w';
	}
	if(!@$fp = fopen($file, $mod)) {
		return false;
	}
	if(!$isfile) {
		fwrite($fp, ' ');
		fclose($fp);
		if(!@unlink($file)) {
			return false;
		}
		if(is_dir($path.'./install_tmpdir')) {
			if(!@rmdir($path.'./install_tmpdir')) {
				return false;
			}
		}
		if(!@mkdir($path.'./install_tmpdir')) {
			return false;
		}
		if(!@rmdir($path.'./install_tmpdir')) {
			return false;
		}
	} else {
		fclose($fp);
	}
	return true;
}
?>